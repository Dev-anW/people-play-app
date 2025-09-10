<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordCreationController;
use App\Http\Controllers\AdminChangeRequestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes ---
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/developer', function() {
    return view('developer');
})->name('developer');

// --- Authentication Routes (Login, Register, etc.) ---
Auth::routes(['register' => false]);

// --- Admin-Only Routes ---
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::get('/admin/guide', function() { return view('admin.guide');})->name('admin.guide');
    Route::get('/admin/requests', [AdminChangeRequestController::class, 'index'])->name('admin.requests.index');
    Route::post('/admin/requests/{request}/approve', [AdminChangeRequestController::class, 'approve'])->name('admin.requests.approve');
    Route::post('/admin/requests/{request}/reject', [AdminChangeRequestController::class, 'reject'])->name('admin.requests.reject');
});

// --- General Authenticated User Routes ---
Route::middleware(['auth'])->group(function () {

    // Routes that MUST have a verified password
    Route::middleware(['force_password_change'])->group(function() {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });

    
    Route::get('/password/create', [PasswordCreationController::class, 'create'])->name('password.create');
    Route::post('/password/store', [PasswordCreationController::class, 'store'])->name('password.store');

});

