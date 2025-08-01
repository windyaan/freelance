<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});
// Auth Routes
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



// TAMBAH ROUTE INI SAJA - UNTUK DASHBOARD CLIENT
Route::get('/client-dashboard', function () {
    return view('dashboard.client.client-dashboard');
})->name('client.dashboard');

Route::get('/freelance-dashboard', function () {
    return view('dashboard.freelance.freelance-dashboard');
})->name('freelance.dashboard');

// Tambahkan di web.php
Route::get('/landing', function () {
    return view('landing'); // pastikan view landing.blade.php ada
})->name('landing');

//Admin Dashboard Route
Route::get('/admin-dashboard', function () {
    return view('dashboard.admin.admin-dashboard');
})->name('admin.dashboard');


// Route untuk profile admin (jika diperlukan)
Route::get('/admin/profile', function () {
    return view('admin.profile');
})->name('admin.profile');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
