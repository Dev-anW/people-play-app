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

Route::get('/setup-initial-data', function() {
    // Prevent this from running if an admin already exists
    if (\App\Models\User::where('is_admin', true)->exists()) {
        return 'Setup has already been run. This route is disabled.';
    }

    // 1. Create the Admin User
    \App\Models\User::create([
    'name' => 'Admin',
    'surname' => 'User',
    'sa_id_number' => '0000000000000', 
    'mobile_number' => '0820000000', 
    'email' => 'admin@example.com',
    'birth_date' => '1997-01-01', 
    'language' => 'English', 
    'password' => Hash::make('ProPay#Revo6BacoZAP@Ha'), 
    'is_admin' => true,
    'email_verified_at' => now()
]);

    // 2. Create the Interests
    \App\Models\Interest::firstOrCreate(['name' => 'Technology']);
    \App\Models\Interest::firstOrCreate(['name' => 'Reading']);
    \App\Models\Interest::firstOrCreate(['name' => 'Learning']);
    \App\Models\Interest::firstOrCreate(['name' => 'Coding']);
    \App\Models\Interest::firstOrCreate(['name' => 'Plants']);
    \App\Models\Interest::firstOrCreate(['name' => 'Piano']);
    \App\Models\Interest::firstOrCreate(['name' => 'Music']);
    \App\Models\Interest::firstOrCreate(['name' => 'The Moon']);
    \App\Models\Interest::firstOrCreate(['name' => 'Physics']);
    \App\Models\Interest::firstOrCreate(['name' => 'History']);
    \App\Models\Interest::firstOrCreate(['name' => 'Knowledge']);

   

    return '<h1>Setup Complete!</h1><p>The Admin user and Interests have been created. <strong>Please remove the /setup-initial-data route from your web.php file immediately.</strong></p>';
});
