<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// Asosiy route
Route::get('/', function () {
    return view('welcome');
});

// Foydalanuvchilarni autentifikatsiya qilish va tekshirish
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Admin route'lari
    Route::prefix('admin')->middleware(['role:Admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.manageUsers');

        // Qo'shimcha admin sahifalari uchun routelar
        // Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        // Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    });
});
