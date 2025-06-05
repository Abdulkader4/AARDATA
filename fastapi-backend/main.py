from typing import List
from fastapi import FastAPI, Depends, HTTPException, Query
from sqlalchemy.orm import Session
import models, schema, crud
from database import SessionLocal, engine
from fastapi.middleware.cors import CORSMiddleware

# Maak de database tabellen aan (indien nog niet aanwezig)
models.Base.metadata.create_all(bind=engine)

# Initieer FastAPI-app
app = FastAPI()

# CORS instellingen (voor development)
app.add_middleware(
    CORSMiddleware,
    allow_origins=["http://localhost:8000"],  # Pas aan indien je frontend elders draait
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Dependency voor database sessie
def get_db():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()


# -------------------
# Algemene routes
# -------------------

@app.get("/")
def read_root():
    return {"message": "API draait correct"}


# -------------------
# Studenten endpoints
# -------------------

# Alle studenten ophalen
@app.get("/studenten/", response_model=List[schema.StudentResponse])
def read_students(db: Session = Depends(get_db)):
    return crud.get_all_students(db)

# Één student ophalen
@app.get("/studenten/{student_id}", response_model=schema.StudentResponse)
def read_student(student_id: int, db: Session = Depends(get_db)):
    student = crud.get_student_by_id(db, student_id)
    if not student:
        raise HTTPException(status_code=404, detail="Student niet gevonden")
    return student

# Student aanmaken
@app.post("/studenten/", response_model=schema.StudentResponse)
def create_student(student: schema.StudentCreate, db: Session = Depends(get_db)):
    return crud.create_student(db, student)

# Aanwezigheidsoverzicht voor een student
@app.get("/students/{student_id}/attendance", response_model=schema.StudentAttendanceOverview)
def get_student_attendance(student_id: int, db: Session = Depends(get_db)):
    return crud.get_student_attendance_overview(db, student_id)


# -------------------
# Docent endpoints
# -------------------

@app.post("/docenten/", response_model=schema.DocentRead)
def create_docent(docent: schema.DocentCreate, db: Session = Depends(get_db)):
    docent_data = docent.dict(exclude={"password"})
    try:
        return crud.create_docent(db, docent_data)
    except Exception as e:
        raise HTTPException(status_code=400, detail=str(e))

@app.post("/docent/login", response_model=schema.DocentResponse)
def docent_login(data: schema.DocentLoginRequest, db: Session = Depends(get_db)):
    docent = crud.get_docent_by_code(db, docent_code=data.docent_code)
    if not docent:
        raise HTTPException(status_code=401, detail="Ongeldige docentcode")
    return docent


# -------------------
# Klassen endpoints
# -------------------

@app.post("/klassen/", response_model=schema.KlasResponse)
def create_klas(klas: schema.KlasCreate, db: Session = Depends(get_db)):
    return crud.create_klas(db, klas)


# -------------------
# Aanwezigheid endpoint
# -------------------

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

