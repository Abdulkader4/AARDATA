from typing import List
from fastapi import FastAPI, Depends, HTTPException
from sqlalchemy.orm import Session
import models, schema, crud
from database import SessionLocal, engine
from fastapi.middleware.cors import CORSMiddleware

# Create DB tables
models.Base.metadata.create_all(bind=engine)

# Init FastAPI
app = FastAPI()

# Allow all CORS (for development)
app.add_middleware(
    CORSMiddleware,
    allow_origins=["http://localhost:8000"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Dependency
def get_db():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()

# Home page
@app.get("/")
def read_root():
    return {"Hello": "World"}

# Dashboards
@app.get("/docent-dashboard")
def read_docent_dashboard(db: Session = Depends(get_db)):
    return {"message": "Welcome to the Docent Dashboard"}

@app.get("/student-dashboard")
def read_student_dashboard(db: Session = Depends(get_db)):
    return {"message": "Welcome to the Student Dashboard"}

# -------------------
# Student Endpoints
# -------------------
# Create student
@app.post("/studenten/", response_model=schema.StudentResponse)
def create_new_student(student: schema.StudentCreate, db: Session = Depends(get_db)):
    existing = db.query(models.Student).filter(models.Student.email == student.email).first()
    if existing:
        raise HTTPException(status_code=400, detail="Email already registered")
    return crud.create_student(db=db, student=student)

# Get single student
@app.get("/studenten/{student_id}", response_model=schema.StudentResponse)
def read_student(student_id: int, db: Session = Depends(get_db)):
    return crud.get_student_by_id(db, student_id)

# Get all students — this was the missing route!
@app.get("/studenten/", response_model=List[schema.StudentResponse])
def read_students(db: Session = Depends(get_db)):
    return crud.get_all_students(db)

# student attendance
@app.get("/students/{student_id}/attendance", response_model=schema.StudentAttendanceOverview)
def get_student_attendance(student_id: int, db: Session = Depends(get_db)):
    return crud.get_student_attendance_overview(db, student_id)

# -------------------
# Docent Endpoints
# -------------------
@app.post("/docenten/", response_model=schema.DocentRead)
def create_docent_route(docent: schema.DocentCreate, db: Session = Depends(get_db)):
    docent_data = docent.dict(exclude={"password"})
    try:
        new_docent = crud.create_docent(db, docent_data)
    except Exception as e:
        raise HTTPException(status_code=400, detail=str(e))
    return new_docent


# -------------------
# Klassen Endpoints
# -------------------
@app.post("/klassen/", response_model=schema.KlasResponse)
def create_klas(klas: schema.KlasCreate, db: Session = Depends(get_db)):
    return crud.create_klas(db=db, klas=klas)


#-------------------
#attachments Endpoints
#-------------------
@app.post("/attendance/", response_model=schema.DailyAttendanceResponse)
def submit_attendance(data: schema.DailyAttendanceCreate, db: Session = Depends(get_db)):
    return crud.record_daily_attendance(db, data)

