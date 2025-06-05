from sqlalchemy import Column, Date, Integer, String, ForeignKey, DateTime, Boolean
from database import Base
from datetime import datetime


class Student(Base):
    __tablename__ = "studenten"

    id = Column(Integer, primary_key=True, index=True)
    naam = Column(String(100), nullable=False)
    email = Column(String, unique=True, index=True, nullable=False)
    studentnummer = Column(String(20), unique=True, index=True, nullable=False)
    token = Column(String, unique=True, index=True, nullable=False)
    cookie = Column(String, unique=True, index=True, nullable=False)
    role = Column(String, default="student", nullable=False)  # Default role is 'student'
    klas = Column(String(100), nullable=True)
    gemiddeld_aanwezigheid = Column(Integer, default=0, nullable=False)
    status = Column(String(10), default="bezig", nullable=False)
    created_at = Column(DateTime, default=datetime.utcnow)
    updated_at = Column(DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)



class Docent(Base):
    __tablename__ = "docenten"

    id = Column(Integer, primary_key=True, index=True)
    naam = Column(String(100), nullable=False)
    email = Column(String, unique=True, index=True, nullable=False)
    token = Column(String, unique=True, index=True, nullable=False)
    cookie = Column(String, unique=True, index=True, nullable=False)
    docent_code = Column(String, unique=True, index=True, nullable=False)  # New field
    role = Column(String, default="docent", nullable=False)
    created_at = Column(DateTime, default=datetime.utcnow)
    updated_at = Column(DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)


class Klas(Base):
    __tablename__ = "klassen"

    id = Column(Integer, primary_key=True, index=True)
    naam = Column(String(100), nullable=False)
    niveau = Column(String(50), nullable=False)
    created_at = Column(DateTime, default=datetime.utcnow)
    updated_at = Column(DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)


class Document(Base):
    __tablename__ = "documenten"

    id = Column(Integer, primary_key=True, index=True)
    naam = Column(String(100), nullable=False)
    type = Column(String(50), nullable=False)  # e.g., 'pdf', 'docx'
    url = Column(String, nullable=False)  # URL to the document
    klas_id = Column(Integer, ForeignKey("klassen.id"), nullable=False)
    created_at = Column(DateTime, default=datetime.utcnow)
    updated_at = Column(DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)


class Aanwezigheid(Base):
    __tablename__ = "aanwezigheden"

    id = Column(Integer, primary_key=True, index=True)
    student_id = Column(Integer, ForeignKey("studenten.id"), nullable=False)
    date = Column(Date, nullable=False)
    status = Column(String(10), nullable=False)  # "aanwezig" or "afwezig"
    created_at = Column(DateTime, default=datetime.utcnow)