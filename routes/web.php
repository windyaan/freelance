<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //route
    // Route::resource('client', UserController::class)->except(['show']);
    Route::get('/client', action: [UserController::class, 'index'])->name('client.index');
    // Route::get('/freelancer', action: [UserController::class, 'index'])->name('freelancer.index');
    // Route::get('/admin', action: [UserController::class, 'index'])->name('admin.index');


});
// 
require __DIR__.'/auth.php';
