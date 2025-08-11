<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RideController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Home page
Route::get('/', function () {
    return view('welcome');
});

// Driver dashboard
Route::get('/driver/dashboard', function () {
    return view('driver.dashboard');
})->middleware(['auth', 'verified', 'role:driver'])->name('driver.dashboard');

// Rider dashboard
Route::get('/rider/dashboard', function () {
    return view('rider.dashboard');
})->middleware(['auth', 'verified', 'role:rider'])->name('rider.dashboard');

// Common dashboard redirect
Route::get('/dashboard', function () {
    $user = Auth::user();

    return match ($user->role) {
        'driver' => redirect()->route('driver.dashboard'),
        'rider'  => redirect()->route('rider.dashboard'),
        default  => view('dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (for all authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rider-only ride routes
Route::middleware(['auth', 'verified', 'role:rider'])->group(function () {
    Route::get('/rides/create', [RideController::class, 'create'])->name('rides.create');
    Route::post('/rides', [RideController::class, 'store'])->name('rides.store');
    Route::get('/rides/{ride}', [RideController::class, 'show'])->name('rides.show');
});

// Driver-only ride routes
Route::middleware(['auth', 'verified', 'role:driver'])->group(function () {
    Route::get('/rides/pending', [RideController::class, 'indexPending'])->name('rides.pending');
    Route::post('/rides/{ride}/accept', [RideController::class, 'accept'])->name('rides.accept');
});

require __DIR__.'/auth.php';
