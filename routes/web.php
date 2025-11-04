<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicationController;

// Авторизация и регистрация
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Главная одобренные заявки
Route::get('/', [ApplicationController::class, 'approvedList'])->name('home');

// Заявки пользователя (auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/applications', [ApplicationController::class, 'adminIndex'])->name('admin.applications.index');
    Route::post('/admin/applications/{id}/approve', [ApplicationController::class, 'approve'])->name('admin.applications.approve');
    Route::delete('/admin/applications/{id}/decline', [ApplicationController::class, 'decline'])->name('admin.applications.decline');
});

Route::middleware('throttle:5,1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// 60 запросов мин
Route::middleware('throttle:60,1')->group(function () {
    Route::get('/', [ApplicationController::class, 'approvedList'])->name('home');
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    // остальные маршруты...
});

Route::middleware(['auth', 'throttle:30,1'])->group(function () {
    Route::get('/admin/applications', [ApplicationController::class, 'adminIndex'])->name('admin.applications.index');
    Route::post('/admin/applications/{id}/approve', [ApplicationController::class, 'approve'])->name('admin.applications.approve');
    Route::delete('/admin/applications/{id}/decline', [ApplicationController::class, 'decline'])->name('admin.applications.decline');
});
