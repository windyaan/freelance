<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/home', [HomeController::class, 'redirect'])
//     ->middleware(['auth'])
//     ->name('home');

// // Auth Routes
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //route
    // Route::resource('client', UserController::class)->except(['show']);
    Route::get('/client', action: [UserController::class, 'index'])->name('client.index');
    // Route::get('/freelancer', action: [UserController::class, 'index'])->name('freelancer.index');
    // Route::get('/admin', action: [UserController::class, 'index'])->name('admin.index');

    //BARU
    Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route yang sudah ada
    // Route::get('/client', [UserController::class, 'index'])->name('client.index');

    // Tambahkan route baru ini
    Route::get('/client-dashboard', [UserController::class, 'index'])->name('client.dashboard');

    Route::get('ini-untuk-client',function(){
    return "Ini client";
})->name('ini.client')->middleware('role:client');

Route::get('ini-untuk-freelancer',function(){
    return "Ini freelancer";
})->name('ini.freelancer')->middleware('role:freelancer');
});


    // Tambahkan route ini untuk /dashboard
    Route::get('/dashboardtu', [UserController::class, 'index'])->name('user.dashboard');

    Route::get('/', function () {
    return redirect()->route('login');
    })->name('landing');



});

//
require __DIR__.'/auth.php';
