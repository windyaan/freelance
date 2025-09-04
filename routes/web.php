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
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OfferController;

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

    // GLOBAL CHAT ROUTES (accessible by both client and freelancer)
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('index');
        Route::get('/{chat}', [ChatController::class, 'show'])->name('show');
        Route::post('/', [ChatController::class, 'store'])->name('store');
        Route::post('/{chat}/messages', [ChatController::class, 'storeMessage'])->name('message.store');
        Route::patch('/messages/{message}/read', [ChatController::class, 'markAsRead'])->name('message.read');
        Route::post('/{chat}/send', [ChatController::class, 'sendMessage'])->name('send');
        Route::get('/start/{job}', [JobController::class, 'startChat'])->name('start');
    });

    // GLOBAL OFFER ROUTES (accessible by both client and freelancer)
    Route::prefix('offers')->name('offers.')->group(function () {
        Route::get('/', [OfferController::class, 'index'])->name('index');
        Route::post('/', [OfferController::class, 'store'])->name('store');
        Route::get('/{offer}', [OfferController::class, 'show'])->name('show');
        Route::get('/{offer}/edit', [OfferController::class, 'edit'])->name('edit');
        Route::put('/{offer}', [OfferController::class, 'update'])->name('update');

        // Offer actions
        Route::patch('/{offer}/accept', [OfferController::class, 'accept'])->name('accept');
        Route::patch('/{offer}/reject', [OfferController::class, 'reject'])->name('reject');

        // Payment routes
        Route::get('/{offer}/payment', [OfferController::class, 'payment'])->name('payment');
        Route::post('/{offer}/pay', [OfferController::class, 'pay'])->name('pay');
    });

    // GLOBAL MILESTONE ROUTES (accessible by both client and freelancer)
    Route::prefix('milestones')->name('milestones.')->group(function () {
        // Route untuk milestone berdasarkan offer ID
        Route::get('/offer/{offerId}', [MilestoneController::class, 'index'])->name('index');
        Route::post('/offer/{offerId}', [MilestoneController::class, 'store'])->name('store');
        
        // Route untuk milestone berdasarkan order ID (untuk client dari order page)
        Route::get('/order/{orderId}', [MilestoneController::class, 'showByOrder'])->name('showByOrder');
        
        // Individual milestone actions
        Route::put('/{milestone}', [MilestoneController::class, 'update'])->name('update');
        Route::delete('/{milestone}', [MilestoneController::class, 'destroy'])->name('destroy');
    });

    // GLOBAL ORDER ROUTES (accessible by both client and freelancer)
    Route::prefix('order')->name('order.')->group(function () {
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/create/{job}', [OrderController::class, 'create'])->name('create');
        Route::get('/{order}/payment', [OrderController::class, 'showPayment'])->name('showPayment');
    });

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
        Route::get('/chat/{chat}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
        Route::post('/chat/{chat}/messages', [ChatController::class, 'storeMessage'])->name('chat.message.store');
        Route::patch('/messages/{message}/read', [ChatController::class, 'markAsRead'])->name('message.read');

        // Client order routes
        Route::get('/order', [OrderController::class, 'clientIndex'])->name('order');
        Route::get('/order/{order}', [OrderController::class, 'show'])->name('order.show');
        Route::post('/order/{order}/pay', [OrderController::class, 'makePayment'])->name('order.pay');
        Route::patch('/order/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
        Route::get('/order/{order}/invoice', [OrderController::class, 'downloadInvoice'])->name('order.invoice');

        // Route untuk client kirim laporan
        Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
        Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    });

    // Freelancer routes group
    Route::prefix('freelancer')->name('freelancer.')->middleware('role:freelancer')->group(function () {
        // Freelancer dashboard
        Route::get('/dashboard', function(){return view('dashboard.freelancer.index');})->name('dashboard');

        // Freelancer chat routes
        Route::get('/chat', [ChatController::class, 'index'])->name('chat');
        Route::get('/chat/{chat}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
        Route::post('/chat/{chat}/messages', [ChatController::class, 'storeMessage'])->name('chat.message.store');
        Route::patch('/messages/{message}/read', [ChatController::class, 'markAsRead'])->name('message.read');

        // Freelancer order routes
        Route::get('/order', [OrderController::class, 'freelancerIndex'])->name('order');
        Route::get('/order/{order}', [OrderController::class, 'show'])->name('order.show');
        Route::patch('/order/{order}/accept', [OrderController::class, 'accept'])->name('order.accept');
        Route::patch('/order/{order}/reject', [OrderController::class, 'reject'])->name('order.reject');
        Route::patch('/order/{order}/complete', [OrderController::class, 'complete'])->name('order.complete');
        Route::post('/order/{order}/upload-deliverable', [OrderController::class, 'uploadDeliverable'])->name('order.upload');

        // Freelancer services routes
        Route::get('/services', [JobController::class, 'index'])->name('services');
        Route::get('/services/create', [JobController::class, 'create'])->name('services.create');
        Route::post('/services', [JobController::class, 'store'])->name('services.store');
        Route::get('/services/{job}', [JobController::class, 'show'])->name('services.show');
        Route::get('/services/{job}/edit', [JobController::class, 'edit'])->name('services.edit');
        Route::put('/services/{job}', [JobController::class, 'update'])->name('services.update');
        Route::delete('/services/{job}', [JobController::class, 'destroy'])->name('services.destroy');
    });

    // Legacy routes untuk backward compatibility
    Route::get('/client-dashboard', [JobController::class, 'dashboardIndex'])->name('client.dashboard.legacy')->middleware('role:client');
    Route::get('/freelancer-dashboard', function(){return view('dashboard.freelancer.index');})->name('freelancer.dashboard.legacy')->middleware('role:freelancer');

    // Global services routes (fallback for general access)
    Route::get('/services', [JobController::class, 'index'])->name('services');
    Route::get('/services/{job}', [JobController::class, 'show'])->name('services.show');
});

// Admin routes
Route::middleware('auth')->group(function () {
    Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/export-users-profit', [AdminController::class, 'exportUsersProfitPdf'])->name('admin.exportUsersProfitPdf');

    // Search route for admin dashboard
    Route::get('/search', [AdminController::class, 'search'])->name('search');

    // Route admin kelola laporan
    Route::get('/admin/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/{id}', [AdminReportController::class, 'show'])->name('admin.reports.show');
    Route::post('/admin/reports/{id}/ban', [AdminReportController::class, 'banFreelancer'])->name('admin.reports.ban');

    // Admin orders management routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/orders', [OrderController::class, 'adminIndex'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'adminShow'])->name('orders.show');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::delete('/orders/{order}', [OrderController::class, 'adminDestroy'])->name('orders.destroy');

        // Admin orders export
        Route::get('/orders/export/pdf', [OrderController::class, 'exportPdf'])->name('orders.export.pdf');
        Route::get('/orders/export/excel', [OrderController::class, 'exportExcel'])->name('orders.export.excel');
    });
});

require __DIR__.'/auth.php';