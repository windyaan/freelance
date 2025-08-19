<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ChatController; // Import ChatController
use App\Http\Controllers\OrderController; // Import OrderController
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\ReportController;



Route::get('/', function () {
    return redirect()->route('login');
})->name('');

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
    // Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
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

        // Chat routes
        // Route::get('/chats', [ChatController::class, 'index'])->name('chat.index');
        // Route::get('/chats/{chat}', [ChatController::class, 'show'])->name('chat.show');
        // Route::post('/chats', [ChatController::class, 'store'])->name('chat.store');  // buat chat baru
        // Route::post('/chats/{chat}/messages', [ChatController::class, 'storeMessage'])->name('chat.storeMessage'); // kirim pesan
        // Route::post('/messages/{message}/read', [ChatController::class, 'markAsRead'])->name('messages.markAsRead'); // tandai baca
        Route::get('/chat', [ChatController::class, 'index'])->name('chat');
        Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/{user}/send', [ChatController::class, 'send'])->name('chat.send');
        Route::get('/chat/{user}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');

        // Client order routes (changed from orders to order)
        Route::get('/order', [OrderController::class, 'clientIndex'])->name('order');
        Route::get('/order/{order}', [OrderController::class, 'show'])->name('order.show');
        Route::post('/order/{order}/pay', [OrderController::class, 'makePayment'])->name('order.pay');
        Route::patch('/order/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
        Route::get('/order/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('order.invoice');

        //route untuk client kirim laporan
        Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
        Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

    });

    // Freelancer routes group
    Route::prefix('freelancer')->name('freelancer.')->middleware('role:freelancer')->group(function () {
    Route::get('/dashboard', function(){return view('dashboard.freelancer.index');})->name('dashboard');

        // Job routes untuk freelancer (CRUD penuh)


        // Freelancer chat routes
        Route::get('/chat', [ChatController::class, 'index'])->name('chat');
        Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/{user}/send', [ChatController::class, 'send'])->name('chat.send');
        Route::get('/chat/{user}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');

        // Freelancer order routes (changed from orders to order)
        Route::get('/order', [OrderController::class, 'freelancerIndex'])->name('order');
        Route::get('/order/{order}', [OrderController::class, 'show'])->name('order.show');
        Route::patch('/order/{order}/accept', [OrderController::class, 'accept'])->name('order.accept');
        Route::patch('/order/{order}/reject', [OrderController::class, 'reject'])->name('order.reject');
        Route::patch('/order/{order}/complete', [OrderController::class, 'complete'])->name('order.complete');
        Route::post('/order/{order}/upload-deliverable', [OrderController::class, 'uploadDeliverable'])->name('order.upload');

    });

    // General order creation routes (accessible by both roles)
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/create/{job}', [OrderController::class, 'create'])->name('order.create');

    // Legacy routes untuk backward compatibility
    Route::get('/client-dashboard', [JobController::class, 'dashboardIndex'])->name('client.dashboard.legacy')->middleware('role:client');
    Route::get('/freelancer-dashboard', function(){return view('dashboard.freelancer.index');})->name('freelancer.dashboard.legacy')->middleware('role:freelancer');
});

    // Admin routes
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/export-users-profit', [AdminController::class, 'exportUsersProfitPdf'])->name('admin.exportUsersProfitPdf');

    // Search route for admin dashboard
    Route::get('/search', [AdminController::class, 'search'])->name('search')->middleware('auth');

    //route admin kelola laporan
    Route::get('/admin/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/{id}', [AdminReportController::class, 'show'])->name('admin.reports.show');
    Route::post('/admin/reports/{id}/ban', [AdminReportController::class, 'banFreelancer'])->name('admin.reports.ban');

require __DIR__.'/auth.php';
