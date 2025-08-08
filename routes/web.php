<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

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
    Route::get('/profile/{id}', [UserController::class, 'showProfile'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('client-dashboard',function(){
    return view('dashboard.client.index');
    })->name('client.dashboard')->middleware('role:client');

    // Route::middleware('role:client')->prefix('client')->group(function () {
    //     Route::get('/client-dashboard', [UserController::class, 'index'])->name('client.dashboard');
    //     Route::get('/freelancer/{id}/profile', [UserController::class, 'showFreelancerProfile'])->name('client.freelancer.profile');

    Route::get('freelancer-dashboard',function(){
    return view('dashboard.freelancer.index');
    })->name('freelancer.dashboard')->middleware('role:freelancer');

    // Route::get('/dashboard', [FreelancerController::class, 'index'])->name('freelancer.dashboard');

//     Route::middleware('role:freelancer')->prefix('freelancer')->group(function () {
//         Route::get('/freelancer-dashboard', [FreelancerController::class, 'index'])->name('freelancer.dashboard');
//         Route::get('/offer/{offer}', [FreelancerController::class, 'showOrderDetail'])->name('freelancer.offer.detail');
//         Route::post('/offer/{offer}/milestone', [FreelancerController::class, 'storeMilestone'])->name('freelancer.milestone.store');
//         Route::put('/milestone/{milestone}', [FreelancerController::class, 'updateMilestone'])->name('freelancer.milestone.update');
//     });
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

// });
    // Route::get('admin-dashboard',function(){
    // return view('dashboard.admin.index');
    // })->name('admin.dashboard')->middleware('role:admin');
});

    // // Tambahkan route ini untuk /dashboard
    // Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    // Route::get('/landing', function () {
    // return redirect()->route('login');
    // })->name('landing');



});

//


require __DIR__.'/auth.php';
