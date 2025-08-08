<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\JobController; 
use App\Http\Controllers\ChatController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return redirect()->route('login');
})->name('landing');

// Logout route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Protected routes
Route::middleware('auth')->group(function () {
    
    // Profile routes - TANPA PARAMETER (untuk user yang sedang login)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Profile routes - DENGAN PARAMETER (untuk melihat/edit profile orang lain)
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'editWithId'])->name('profile.edit.id');
    Route::put('/profile/{id}', [ProfileController::class, 'updateWithId'])->name('profile.update.id');
    Route::patch('/profile/{id}', [ProfileController::class, 'updateWithId'])->name('profile.update.patch.id');

    // Client routes group
    Route::prefix('client')->name('client.')->middleware('role:client')->group(function () {
        // Client dashboard
        Route::get('/dashboard', [JobController::class, 'dashboardIndex'])->name('dashboard');
        
        // Client chat routes
        Route::get('/chat', [ChatController::class, 'index'])->name('chat');
        Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/{user}/send', [ChatController::class, 'send'])->name('chat.send');
        Route::get('/chat/{user}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
        
        // Client orders routes - FIXED
        Route::get('/orders', [OrderController::class, 'clientIndex'])->name('orders');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/pay', [OrderController::class, 'makePayment'])->name('orders.pay');
        Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
        Route::get('/orders/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');
    });

    // Freelancer routes group
    Route::prefix('freelancer')->name('freelancer.')->middleware('role:freelancer')->group(function () {
        // Freelancer dashboard
        Route::get('/dashboard', function(){
            return view('dashboard.freelancer.index');
        })->name('dashboard');
        
        // Freelancer chat routes
        Route::get('/chat', [ChatController::class, 'index'])->name('chat');
        Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/{user}/send', [ChatController::class, 'send'])->name('chat.send');
        Route::get('/chat/{user}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
        
        // Freelancer orders routes
        Route::get('/orders', [OrderController::class, 'freelancerIndex'])->name('orders');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/accept', [OrderController::class, 'accept'])->name('orders.accept');
        Route::patch('/orders/{order}/reject', [OrderController::class, 'reject'])->name('orders.reject');
        Route::patch('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
        Route::post('/orders/{order}/upload-deliverable', [OrderController::class, 'uploadDeliverable'])->name('orders.upload');
    });

    // General order creation routes (accessible by both roles)
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/create/{job}', [OrderController::class, 'create'])->name('orders.create');

    // Legacy routes untuk backward compatibility
    Route::get('/client-dashboard', [JobController::class, 'dashboardIndex'])->name('client.dashboard.legacy')->middleware('role:client');
    Route::get('/freelancer-dashboard', function(){
        return view('dashboard.freelancer.index');
    })->name('freelancer.dashboard.legacy')->middleware('role:freelancer');
});

require __DIR__.'/auth.php';