<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\DocentDashboardController;
use App\Http\Controllers\StudentController;

// Homepage
Route::get('/', function () {
    return view('home.Welkome');
});


Route::resource('Welkome', HomeController::class);

Route::get('/upload', [UploadController::class, 'show'])->name('upload.show');
Route::post('/upload', [UploadController::class, 'upload'])->name('upload.store');



Route::get('/upload', [UploadController::class, 'show'])->name('upload.show');
Route::post('/upload', [UploadController::class, 'upload'])->name('upload.store');


Route::get('/student', [StudentDashboardController::class, 'index'])->name('student.dashboard');

// Welkom pagina via resource controller
Route::resource('Welkome', HomeController::class);


// Uploadpagina
Route::get('/upload', [UploadController::class, 'show'])->name('upload.show');
Route::post('/upload', [UploadController::class, 'upload'])->name('upload.store');

// Studentformulier (nummer invoeren), redirect en dashboard
Route::post('/student/dashboard', [StudentDashboardController::class, 'redirectToDashboard'])->name('student.redirect');
Route::get('/student/dashboard/{studentNumber}', [StudentDashboardController::class, 'index'])->name('student.dashboard');
Route::get('/student', [StudentDashboardController::class, 'showForm'])->name('student.form');

//Docentformulier (UnnikeNummer invoeren), redirect en dashboard
Route::get('/docent', [DocentDashboardController::class, 'showForm'])->name('docent.form');
Route::post('/docent/dashboard', [DocentDashboardController::class, 'redirectToDashboard'])->name('docent.redirect');



// 

// docent dashboard
Route::get('/docent/dashboard/{docentNumber}', [DocentDashboardController::class, 'index'])->name('docent.dashboard');

Route::get('/studenten/{student_id}', [DocentDashboardController::class,'showstudent'])->name('student.show');
