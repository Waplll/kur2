<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;

// Авторизация
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Главная
Route::get('/', [ApplicationController::class, 'approvedList'])->name('home');

// Отзывы (публичные)
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

// Отзывы создание (auth) - ПЕРЕД show!
Route::middleware(['auth'])->group(function () {
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Отзывы просмотр (публичные) - ПОСЛЕ create!
Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('reviews.show');

// Заявки (auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
});

// Профиль (auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile/name', [ProfileController::class, 'updateName'])->name('profile.updateName');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::post('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.uploadAvatar');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.deleteAvatar');
});

// Админ (auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/applications', [ApplicationController::class, 'adminIndex'])->name('admin.applications.index');
    Route::post('/admin/applications/{id}/approve', [ApplicationController::class, 'approve'])->name('admin.applications.approve');
    Route::delete('/admin/applications/{id}/decline', [ApplicationController::class, 'decline'])->name('admin.applications.decline');
});
