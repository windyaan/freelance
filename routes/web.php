<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

// ROUTE LOGOUT MANUAL - TAMBAHAN BARU
// Route::post('/logout', function () {
//     Auth::logout();
//     request()->session()->invalidate();
//     request()->session()->regenerateToken();
//     return redirect()->route('login')->with('status', 'Berhasil logout!');
// });

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //BARU
    Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route yang sudah ada
    // Route::get('/client', [UserController::class, 'index'])->name('client.index');

    // Tambahkan route baru ini
    // Route::get('/client-dashboard', [UserController::class, 'index'])->name('client.dashboard');
    // Route::get('/freelancer-dashboard', [FreelancerController::class, 'index'])->name('freelancer.dashboard');


    Route::get('client-dashboard',function(){
    return view('dashboard.client.index');
})->name('client.dashboard')->middleware('role:client');

Route::get('freelancer-dashboard',function(){
    return view('dashboard.freelancer.index');
})->name('freelancer.dashboard')->middleware('role:freelancer');
});


    // // Tambahkan route ini untuk /dashboard
    // Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    Route::get('/', function () {
    return redirect()->route('login');
    })->name('landing');



});

//


require __DIR__.'/auth.php';
