<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeletionRequestController;
use App\Http\Controllers\StudentDeleteController;
use App\Http\Controllers\Teacher\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/students', StudentController::class)->middleware(['auth', 'role:Headmaster|Teacher']);

    //Headmaster Route start
    Route::middleware(['role:Headmaster'])->group(function(){
        Route::post('student-delete/{id}',[StudentDeleteController::class,'deleteStudent'])->name('student.delete');
    });
    //Headmaster Route end

    //Teacher Route start
    Route::middleware(['role:Teacher'])->group(function () {
        Route::post('student-delte-request/{student}', [DeletionRequestController::class, 'deleteRequest'])->name('student.delete.request');
    });
    //Teacher Route end
});
