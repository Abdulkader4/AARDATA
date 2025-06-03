<?php

use App\Http\Controllers\DocentController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\StudentDashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('Welkome',HomeController::class);
<<<<<<< HEAD
Route::get('/AAR_[JAAR]W[WEEK][CODE].EXTENSIE/docent',[DocentController::class,'index'])->name('docent.pagina');
Route::get('/upload', [UploadController::class, 'show'])->name('upload.show');
Route::post('/upload', [UploadController::class, 'upload'])->name('upload.store');

=======


Route::get('/upload', [UploadController::class, 'show'])->name('upload.show');
Route::post('/upload', [UploadController::class, 'upload'])->name('upload.store');


Route::get('/student', [StudentDashboardController::class, 'index'])->name('student.dashboard');
>>>>>>> a4e0af5 (Student page gemaakt)
