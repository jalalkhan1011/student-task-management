<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeletionRequestController;
use App\Http\Controllers\Headmaster\AnnouncementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\TaskSubmissionController;
use App\Http\Controllers\StudentDeleteController;
use App\Http\Controllers\StudentTaskController;
use App\Http\Controllers\TaskApproveController;
use App\Http\Controllers\Teacher\FeedbackController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    //profile route
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //profile route end

    //password chage route
    Route::get('/password', [ProfileController::class, 'changePassword'])->name('password.change');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    //password chage route end

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/students', StudentController::class)->middleware(['auth', 'role:Headmaster|Teacher']);

    //Headmaster Route start
    Route::middleware(['role:Headmaster'])->group(function () {
        Route::post('student-delete/{id}', [StudentDeleteController::class, 'deleteStudent'])->name('student.delete');
        Route::post('student-delete-request-reject/{id}', [StudentDeleteController::class, 'studentDeleteReject'])->name('student.delete.reject');
        Route::get('pending-task-list', [TaskApproveController::class, 'index'])->name('task.pending');
        Route::post('pending-task-approve/{id}', [TaskApproveController::class, 'taskApprove'])->name('task.approve');
        Route::resource('announcements', AnnouncementController::class);
    });
    //Headmaster Route end

    //Teacher Route start
    Route::middleware(['role:Teacher'])->group(function () {
        Route::post('student-delte-request/{student}', [DeletionRequestController::class, 'deleteRequest'])->name('student.delete.request');
        Route::resource('/tasks', TaskController::class);
        Route::get('/feedback-form/{id}', [FeedbackController::class, 'create'])->name('feedback.form');
        Route::post('/submissions/{submission}/feedback', [FeedbackController::class, 'store'])->name('submissions.feedback');
    });
    //Teacher Route end

    //Student Route start
    Route::middleware(['role:Student'])->group(function () {
        Route::get('/assign-task', [StudentTaskController::class, 'index'])->name('assign.task');
        Route::get('/task-form/{id}', [TaskSubmissionController::class, 'create'])->name('tasks.form');
        Route::post('/tasks/{task}/submit', [TaskSubmissionController::class, 'store'])->name('tasks.submit');
    });
    //Student Route end
});
