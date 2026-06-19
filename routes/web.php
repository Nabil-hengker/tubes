<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScholarshipController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('student.dashboard');
    }

    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ScholarshipController::class, 'index'])->name('student.dashboard');
    Route::put('/dashboard/profile', [ScholarshipController::class, 'updateProfile'])->name('student.profile.update');
    Route::get('/scholarships/{scholarship}/apply', [ScholarshipController::class, 'showApplyForm'])->name('student.apply');
    Route::post('/scholarships/{scholarship}/apply', [ScholarshipController::class, 'storeApplication'])->name('student.store');
    Route::post('/bookmarks/{scholarship}/toggle', [ScholarshipController::class, 'toggleBookmark'])->name('student.bookmark.toggle');

    Route::get('/admin', [ScholarshipController::class, 'adminIndex'])->name('admin.dashboard');
    Route::put('/admin/profile', [ScholarshipController::class, 'updateAdminProfile'])->name('admin.profile.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
