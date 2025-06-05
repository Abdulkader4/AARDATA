from typing import List
from fastapi import FastAPI, Depends, HTTPException, Query
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

@app.post("/docent/login", response_model=schema.DocentResponse)
def docent_login(data: schema.DocentLoginRequest, db: Session = Depends(get_db)):
    docent = crud.get_docent_by_code(db, docent_code=data.docent_code)
    if not docent:
        raise HTTPException(status_code=401, detail="Ongeldige docentcode")
    return docent


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


#-------------------
#Attendance Endpoints
#-------------------
@app.get("/students/filter", response_model=List[schema.StudentResponse])
def filter_students(
    meer_dan: int = Query(None, alias="meer dan", description="Filter studenten met percentage boven deze waarde"),
    minder_dan: int = Query(None, alias="minder dan", description="Filter studenten met percentage onder deze waarde"),
    db: Session = Depends(get_db)
):
    if meer_dan is not None and minder_dan is not None:
        raise HTTPException(status_code=400, detail="Gebruik alleen 'meer dan' of 'minder dan', niet allebei tegelijk.")
    elif meer_dan is not None:
        return crud.filter_studenten_by_attendance_percentage(db, threshold=meer_dan, mode="meer")
    elif minder_dan is not None:
        return crud.filter_studenten_by_attendance_percentage(db, threshold=minder_dan, mode="minder")
    else:
        raise HTTPException(status_code=400, detail="Geef 'meer dan' of 'minder dan' op als queryparameter.")

