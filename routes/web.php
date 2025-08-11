<?php

use App\Http\Middleware\DriverMiddleware;
use App\Http\Middleware\RiderMiddleware;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RideController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Role-specific dashboards
Route::get('/driver/dashboard', function () {
    return view('driver.dashboard');
})->middleware(['auth', 'verified', DriverMiddleware::class])->name('driver.dashboard');

Route::get('/rider/dashboard', function () {
    return view('rider.dashboard');
})->middleware(['auth', 'verified', RiderMiddleware::class])->name('rider.dashboard');

// Common dashboard redirect logic
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'driver') {
        return redirect()->route('driver.dashboard');
    } elseif ($user->role === 'rider') {
        return redirect()->route('rider.dashboard');
    }

    return view('dashboard'); // fallback for admin or unknown roles
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ride routes for Riders only
Route::middleware(['auth', 'verified', 'role:rider'])->group(function () {
    Route::get('/rides/create', [RideController::class, 'create'])->name('rides.create');
    Route::post('/rides', [RideController::class, 'store'])->name('rides.store');
    Route::get('/rides/{ride}', [RideController::class, 'show'])->name('rides.show');
});

// Ride routes for Drivers only
Route::middleware(['auth', 'verified', 'role:driver'])->group(function () {
    Route::get('/rides/pending', [RideController::class, 'indexPending'])->name('rides.pending');
    Route::post('/rides/{ride}/accept', [RideController::class, 'accept'])->name('rides.accept');
});

require __DIR__.'/auth.php';
