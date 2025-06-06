<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\DocentDashboardController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\StudentOverviewController;

// Homepage
Route::get('/', fn() => view('home.Welkome'));


Route::resource('Welkome', HomeController::class);

// Uploadpagina
Route::get('/upload', [UploadController::class, 'show'])->name('upload.show');
Route::post('/upload', [UploadController::class, 'upload'])->name('upload.store');
Route::get('/uploads', [UploadController::class, 'fetchUploads'])->name('uploads.list');


// Student dashboard + formulier
Route::get('/student', [StudentDashboardController::class, 'showForm'])->name('student.form');

Route::post('/student/dashboard', [StudentDashboardController::class, 'redirectToDashboard'])->name('student.redirect');
Route::get('/student/dashboard/{studentNumber}', [StudentDashboardController::class, 'index'])->name('student.dashboard');
Route::get('/student', [StudentDashboardController::class, 'showForm'])->name('student.form');


// docent dashboard
Route::get('/docent/dashboard', [DocentDashboardController::class, 'index'])->name('docent.dashboard');
Route::get('/studenten/{student_id}', [DocentDashboardController::class,'showstudent'])->name('student.show');
Route::get('/docent', [DocentDashboardController::class, 'showForm'])->name('docent.form');
Route::post('/docent/dashboard', [DocentDashboardController::class, 'redirectToDashboard'])->name('docent.redirect');

//help page
Route::get('/hulp',[InfoController::class,'info'])->name('info.page');
