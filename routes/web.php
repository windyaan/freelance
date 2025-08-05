<?php

use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FreelancerController;

// Landing page redirect
Route::get('/', function () {
    return redirect()->route('login');
});



// ROUTE LOGOUT MANUAL - TAMBAHAN BARU
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

    // Route yang sudah ada
    // Route::get('/client', [UserController::class, 'index'])->name('client.index');

    // Tambahkan route baru ini
    Route::get('/client-dashboard', [UserController::class, 'index'])->name('client.dashboard');
    Route::get('/freelancer-dashboard', [FreelancerController::class, 'index'])->name('freelancer.dashboard');


    Route::get('ini-untuk-client',function(){
    return "Ini client";
})->name('ini.client')->middleware('role:client');

Route::get('ini-freelancer',function(){
    return "ini freelancer";
})->name('ini.freelancer')->middleware('role:freelancer');
});


    // // Tambahkan route ini untuk /dashboard
    // Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    Route::get('/', function () {
    return redirect()->route('login');
    })->name('landing');



});

//


require __DIR__.'/auth.php';
