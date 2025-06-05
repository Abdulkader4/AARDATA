from sqlalchemy import Column, Date, Integer, String, ForeignKey, DateTime, Boolean
from database import Base
from datetime import datetime

class Student(Base):
    __tablename__ = "studenten"

    id = Column(Integer, primary_key=True, index=True)
    naam = Column(String(100), nullable=False)
    email = Column(String(255), unique=True, index=True, nullable=False)
    studentnummer = Column(String(50), unique=True, index=True, nullable=False)
    token = Column(String(255), unique=True, index=True, nullable=False)
    cookie = Column(String(255), unique=True, index=True, nullable=False)
    role = Column(String(50), default="student", nullable=False)
    klas = Column(String(100), nullable=True)
    gemiddeld_aanwezigheid = Column(Integer, default=0, nullable=False)
    status = Column(String(20), default="bezig", nullable=False)
    created_at = Column(DateTime, default=datetime.utcnow)
    updated_at = Column(DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)

class Docent(Base):
    __tablename__ = "docenten"

    id = Column(Integer, primary_key=True, index=True)
    naam = Column(String(100), nullable=False)
    email = Column(String(255), unique=True, index=True, nullable=False)
    token = Column(String(255), unique=True, index=True, nullable=False)
    cookie = Column(String(255), unique=True, index=True, nullable=False)
    docent_code = Column(String(50), unique=True, index=True, nullable=False)
    role = Column(String(50), default="docent", nullable=False)
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
    type = Column(String(50), nullable=False)
    url = Column(String(255), nullable=False)
    klas_id = Column(Integer, ForeignKey("klassen.id"), nullable=False)
    created_at = Column(DateTime, default=datetime.utcnow)
    updated_at = Column(DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)

class Aanwezigheid(Base):
    __tablename__ = "aanwezigheden"

    id = Column(Integer, primary_key=True, index=True)
    student_id = Column(Integer, ForeignKey("studenten.id"), nullable=False)
    date = Column(Date, nullable=False)
    status = Column(String(20), nullable=False)
    created_at = Column(DateTime, default=datetime.utcnow)
