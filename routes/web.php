<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FreelancerController;

// Landing page redirect
Route::get('/', function () {
    return redirect()->route('login');
})->name('landing');

// Manual logout route
Route::get('/keluar', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login')->with('status', 'Berhasil logout!');
});

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes that require authentication
Route::middleware('auth')->group(function () {

    // === Profile Routes ===
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');

    // === Client Dashboard ===
    Route::get('/client-dashboard', [UserController::class, 'index'])->name('client.dashboard');

    // === Freelancer Dashboard ===
    Route::get('/freelancer-dashboard', [FreelancerController::class, 'index'])->name('freelancer.dashboard');

    // === Role-based Routes ===
    Route::get('/ini-untuk-client', function () {
        return "Ini client";
    })->middleware('role:client')->name('ini.client');

    Route::get('/ini-freelancer', function () {
        return "Ini freelancer";
    })->middleware('role:freelancer')->name('ini.freelancer');

    // === Client Profile View Page ===
    Route::get('/client-dashboard/profile', function () {
        return view('dashboard.client.profile', [
            'profileName' => 'Nadia Ima',
            'profileEmail' => 'namira@gmail.com',
            'profileImage' => 'https://images.unsplash.com/photo-1494790108755-2616b612b47c?w=200&h=200&fit=crop&crop=face',
            'profileBio' => "I'm a third-year IT student at Airlangga University passionate about software development, UI design, and data analytics.",
            'profileAchievement' => "Top 200 Finalist in the 2023 National UI Design Competition"
        ]);
    })->name('client.profile');
});

require __DIR__ . '/auth.php';
