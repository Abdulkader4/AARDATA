import random
import string
from fastapi import HTTPException
from sqlalchemy import extract, func
from sqlalchemy.orm import Session
import models, schema, auth
from datetime import timedelta, datetime
import secrets
from models import Docent, Aanwezigheid, Student, Klas, Document

# CRUD operations for Docent model
def generate_token(length: int = 32) -> str:
    return secrets.token_hex(length)

def generate_cookie(length: int = 32) -> str:
    return secrets.token_hex(length)


#----------------------------------------DOCENT---------------------------------#

def generate_unique_docent_code(db: Session, length: int = 8) -> str:
    while True:
        # Example: uppercase letters and digits
        code = ''.join(random.choices(string.ascii_uppercase + string.digits, k=length))
        existing = db.query(Docent).filter(Docent.docent_code == code).first()
        if not existing:
            return code

def create_docent(db: Session, docent_data: dict) -> Docent:
    # Generate a unique docent_code
    docent_code = generate_unique_docent_code(db)
    token = generate_token(16)   # 32 hex chars = 16 bytes
    cookie = generate_cookie(16)

    docent = Docent(
        naam=docent_data['naam'],
        email=docent_data['email'],
        token=token,
        cookie=cookie,
        role=docent_data.get('role', 'docent'),
        docent_code=docent_code,
    )
    db.add(docent)
    db.commit()
    db.refresh(docent)
    return docent

#Login using docent-code
def get_docent_by_code(db: Session, docent_code: str):
    return db.query(Docent).filter(Docent.docent_code == docent_code).first()

#--------------------------------STUDENT---------------------------------#

def generate_unique_studentnummer(db: Session, max_attempts=10) -> str:
    for _ in range(max_attempts):
        nummer = str(random.randint(10000000, 99999999))  # 8-digit number
        exists = db.query(models.Student).filter(models.Student.studentnummer == nummer).first()
        if not exists:
            return nummer
    raise Exception("Could not generate unique studentnummer after several attempts")

def create_student(db: Session, student: schema.StudentCreate):
    token = generate_token()
    cookie = generate_cookie()
    studentnummer = generate_unique_studentnummer(db)

    db_student = models.Student(
        naam=student.naam,
        email=student.email,
        studentnummer=studentnummer,
        token=token,
        cookie=cookie,
        role=student.role if student.role else "student",
        klas=student.klas,
        gemiddeld_aanwezigheid=0,  
        created_at=datetime.utcnow(),
        updated_at=datetime.utcnow(),
    )

    db.add(db_student)
    db.commit()
    db.refresh(db_student)
    return db_student

#get student information by id
def get_student_by_id(db: Session, student_id: int):
    db_student = db.query(models.Student).filter(models.Student.id == student_id).first()
    if not db_student:
        raise HTTPException(status_code=404, detail="Student not found")
    return db_student

# Get all students
def get_all_students(db: Session):
    return db.query(models.Student).all()



#--------------------------------------KLAS---------------------------------#

def create_klas(db: Session, klas: schema.KlasCreate):
    db_klas = models.Klas(
        naam=klas.naam,
        niveau=klas.niveau,
        created_at=datetime.utcnow(),
        updated_at=datetime.utcnow(),
    )
    db.add(db_klas)
    db.commit()
    db.refresh(db_klas)
    return db_klas



#--------------------------------------DOCUMENT---------------------------------#
#upload excel and libreoffice documents
def upload_document(db: Session, document: schema.DocumentCreate):
    db_document = models.Document(**document.dict())
    db.add(db_document)
    db.commit()
    db.refresh(db_document)
    return db_document

# Get student by studentnummer
def get_student_by_studentnummer(db: Session, studentnummer: str):
    db_student = db.query(models.Student).filter(models.Student.studentnummer == studentnummer).first()
    if not db_student:
        raise HTTPException(status_code=404, detail="Student not found")
    return db_student




#--------------------------------------AANWEZIGHEID---------------------------------#

def get_attendance_category(percentage: int) -> str:
    if 95 <= percentage <= 100:
        return "Perfect"
    elif 85 <= percentage <= 94:
        return "Excellent"
    elif 70 <= percentage <= 84:
        return "Goed"
    elif 55 <= percentage <= 69:
        return "Redelijk"
    elif 40 <= percentage <= 54:
        return "Onvoldoende"
    elif 25 <= percentage <= 39:
        return "Kritisch"
    else:
        return "Fail"
    
# create attendance record
def record_daily_attendance(db: Session, data: schema.DailyAttendanceCreate):
    # Prevent duplicates (e.g., already marked for today)
    existing = db.query(Aanwezigheid).filter_by(student_id=data.student_id, date=data.date).first()
    if existing:
        existing.status = data.status
        db.commit()
        db.refresh(existing)
        return existing

    attendance = Aanwezigheid(
        student_id=data.student_id,
        date=data.date,
        status=data.status,
        created_at=datetime.utcnow()
    )
    db.add(attendance)
    db.commit()
    db.refresh(attendance)
    return attendance


# Update the average attendance for a student
def update_gemiddeld_aanwezigheid(db: Session, student_id: int):
    records = db.query(Aanwezigheid).filter_by(student_id=student_id).all()
    if not records:
        return

    avg_percentage = int(sum(r.percentage for r in records) / len(records))
    student = db.query(Student).filter_by(id=student_id).first()
    if student:
        student.gemiddeld_aanwezigheid = avg_percentage
        db.commit()

# Calculate weekly attendance percentage for a student
def calculate_weekly_attendance(db: Session, student_id: int, year: int, week: int):
    records = db.query(Aanwezigheid).filter(
        Aanwezigheid.student_id == student_id,
        extract("year", Aanwezigheid.date) == year,
        extract("week", Aanwezigheid.date) == week
    ).all()

    total = len(records)
    aanwezig = sum(1 for r in records if r.status == "aanwezig")
    percentage = int((aanwezig / total) * 100) if total else 0
    return percentage

def get_student_attendance_overview(db: Session, student_id: int):
    # Group daily attendance by week/year
    weekly_data = db.query(
        extract("week", Aanwezigheid.date).label("week"),
        extract("year", Aanwezigheid.date).label("jaar"),
        func.count().label("total_days"),
        func.sum(func.case([(Aanwezigheid.status == "aanwezig", 1)], else_=0)).label("aanwezig_days")
    ).filter(
        Aanwezigheid.student_id == student_id
    ).group_by(
        extract("year", Aanwezigheid.date),
        extract("week", Aanwezigheid.date)
    ).order_by("jaar", "week").all()

    # Build result
    result = []
    for entry in weekly_data:
        percentage = int((entry.aanwezig_days / entry.total_days) * 100) if entry.total_days > 0 else 0
        minuten = entry.aanwezig_days * 6 * 60  # assuming 6 hours per day
        result.append({
            "week": int(entry.week),
            "jaar": int(entry.jaar),
            "minuten": minuten,
            "percentage": percentage
        })

    # Calculate gemiddeld aanwezigheid
    total_percentages = [r["percentage"] for r in result]
    gemiddeld = int(sum(total_percentages) / len(total_percentages)) if total_percentages else 0

    return {
        "weekly": result,
        "gemiddeld_aanwezigheid": gemiddeld
    }

# Filter attendance records by attendance
def filter_studenten_by_attendance_percentage(db: Session, threshold: int, mode: str = "meer"):
    """
    Filter students by gemiddeld_aanwezigheid percentage.

    Args:
        db (Session): SQLAlchemy session
        threshold (int): The percentage threshold to filter against
        mode (str): 'meer' for greater than, 'minder' for less than

    Returns:
        List[Student]: Students matching the criteria
    """
    if mode == "meer":
        return db.query(Student).filter(Student.gemiddeld_aanwezigheid > threshold).all()
    elif mode == "minder":
        return db.query(Student).filter(Student.gemiddeld_aanwezigheid < threshold).all()
    else:
        raise ValueError("Invalid mode. Use 'meer' or 'minder'.")
