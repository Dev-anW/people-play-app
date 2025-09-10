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

    // Routes for creating the initial password (must NOT have the middleware above)
    Route::get('/password/create', [PasswordCreationController::class, 'create'])->name('password.create');
    Route::post('/password/store', [PasswordCreationController::class, 'store'])->name('password.store');

});

// --- TEMPORARY ROUTE TO ADD A NEW ADMIN - REMOVE AFTER USE! ---
Route::get('/create-second-admin-account', function() {
    // Check if the new admin already exists to prevent duplicates
    if (\App\Models\User::where('email', 'new.admin.email@example.com')->exists()) {
        return 'This specific admin user has already been created.';
    }

    \App\Models\User::create([
        'name' => 'Admin', // IMPORTANT: Set the name for the new admin
        'surname' => 'Test', // IMPORTANT: Set the surname
        'sa_id_number' => '1111111111111', // Use a unique placeholder
        'language' => 'English',
        'email' => 'admin@example.com', // IMPORTANT: Set the new admin's email!
        'password' => Illuminate\Support\Facades\Hash::make('Another-Very-Strong-Password!'), // IMPORTANT: Set a new strong password!
        'is_admin' => true,
        'email_verified_at' => now(),
    ]);

    return '<h1>New Admin Created Successfully!</h1><p><strong>SECURITY WARNING:</strong> Please remove the /create-second-admin-account route from your web.php file and deploy the change immediately.</p>';
});
