from datetime import datetime, date
from pydantic import BaseModel, EmailStr, Field
from typing import Literal, Optional, List

#------------------------------DOCENTEN-----------------------------#

#docent schema
class Docent(BaseModel):
    id: int
    naam: str = Field(..., max_length=100)
    email: EmailStr
    docent_code: str
    role: Optional[str] = "docent"
    created_at: datetime
    updated_at: datetime

    class Config:
        from_attributes = True

#docent create schema
class DocentCreate(BaseModel):
    naam: str = Field(..., max_length=100)
    email: EmailStr
    role: str = "docent"

# Schema for reading a docent (output)
class DocentRead(Docent):
    id: int
    token: str
    cookie: str
    created_at: datetime
    updated_at: datetime

    class Config:
        from_attributes = True

class DocentResponse(BaseModel):
    id: int
    naam: str
    email: str
    docent_code: str

    class Config:
        from_attributes = True

class DocentLoginRequest(BaseModel):
    docent_code: str

class DocentUpdate(BaseModel):
    naam: Optional[str]
    email: Optional[EmailStr]
    docent_code: Optional[str]
    role: Optional[str]

    class Config:
        from_attributes = True

#---------------------------------STUDENT-------------------------------#

class Student(BaseModel):
    id: int
    name: str = Field(..., max_length=100)
    email: EmailStr
    studentnummer: str = Field(..., max_length=20)
    token: str
    cookie: str
    klas: str | None = None
    gemiddeld_aanwezigheid: int | None = Field(default=0, ge=0, le=100)
    status: Literal["bezig", "gestopt"] | None = "bezig"

    class Config:
        from_attributes = True

class StudentCreate(BaseModel):
    naam: str
    email: EmailStr
    klas: Optional[str] = None
    role: Optional[str] = "student"

class StudentResponse(BaseModel):
    id: int
    naam: str
    email: EmailStr
    studentnummer: str
    token: str
    cookie: str
    role: str
    klas: Optional[str]
    gemiddeld_aanwezigheid: int
    status: Literal["bezig", "gestopt"]
    created_at: datetime
    updated_at: datetime

    class Config:
        from_attributes = True

class StudentUpdate(BaseModel):
    naam: str | None = Field(max_length=100)
    email: EmailStr | None
    studentnummer: str | None = Field(max_length=20)
    token: str | None
    cookie: str | None
    klas: str | None
    gemiddeld_aanwezigheid: int | None = Field(default=0, ge=0, le=100)
    status: Literal["bezig", "gestopt"] | None = "bezig"

#------------------------DOCUMENTEN---------------------------------#

class DocumentCreate(BaseModel):
    naam: str = Field(..., max_length=100)
    type: str = Field(..., max_length=50)
    url: str
    klas: str

#------------------------KLAS---------------------------------#

class Klas(BaseModel):
    id: int
    naam: str = Field(..., max_length=100)
    niveau: str = Field(..., max_length=50)
    created_at: datetime
    updated_at: datetime

    class Config:
        from_attributes = True

class KlasCreate(BaseModel):
    naam: str = Field(..., max_length=100)
    niveau: str = Field(..., max_length=50)

class KlasResponse(BaseModel):
    id: int
    naam: str
    niveau: str
    created_at: datetime
    updated_at: datetime

    class Config:
        from_attributes = True

#---------------------------DOCUMENT----------------------------#

class Document(BaseModel):
    id: int
    naam: str = Field(..., max_length=100)
    type: str = Field(..., max_length=50)
    url: str
    klas_id: int

    class Config:
        from_attributes = True

#----------------------------ATTENDANCE----------------------------#

class DailyAttendanceCreate(BaseModel):
    student_id: int
    date: date
    status: Literal["aanwezig", "afwezig"]

class DailyAttendanceResponse(BaseModel):
    id: int
    student_id: int
    date: date
    status: str
    created_at: datetime

    class Config:
        from_attributes = True

class WeeklyAttendance(BaseModel):
    week: int
    jaar: int
    minuten: int
    percentage: int

class StudentAttendanceOverview(BaseModel):
    weekly: List[WeeklyAttendance]
    gemiddeld_aanwezigheid: int
