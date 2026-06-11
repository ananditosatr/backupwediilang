<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QrisController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\MenuManagerController;
use App\Http\Controllers\HistoryController;

// Customer Routes (Public)
Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/order', [CustomerController::class, 'index'])->name('customer.order');
Route::get('/menus/category', [CustomerController::class, 'getMenusByCategory'])->name('menus.by-category');

// Order Routes (Public)
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::post('/orders/check-expired', [OrderController::class, 'checkExpired'])->name('orders.check-expired');
Route::get('/orders/{orderNumber}', [OrderController::class, 'show'])->name('orders.show');

// QRIS Routes (Public)
Route::get('/qris/dynamic', [QrisController::class, 'png'])->name('qris.dynamic');

// Payment Routes (Public)
Route::post('/payments/upload', [PaymentController::class, 'upload'])->name('payments.upload');

// Kasir Routes
Route::prefix('kasir')->group(function () {
    Route::get('/login', [KasirController::class, 'loginForm'])->name('kasir.login');
    Route::post('/login', [KasirController::class, 'login'])->name('kasir.login.submit');

    // Password reset for kasir (admin)
    Route::get('/password/forgot', [KasirController::class, 'forgotForm'])->name('kasir.password.request');
    Route::post('/password/email', [KasirController::class, 'sendResetLink'])->name('kasir.password.email');
    Route::get('/password/reset/{token}', [KasirController::class, 'showResetForm'])->name('kasir.password.reset');
    Route::post('/password/reset', [KasirController::class, 'resetPassword'])->name('kasir.password.update');

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [KasirController::class, 'dashboard'])->name('kasir.dashboard');
        Route::get('/dashboard/poll', [KasirController::class, 'pollDashboard'])->name('kasir.dashboard.poll');
        Route::post('/orders/{orderId}/approve', [KasirController::class, 'approvePayment'])->name('kasir.approve');
        Route::post('/orders/{orderId}/flag', [KasirController::class, 'flagPayment'])->name('kasir.flag');
        Route::post('/orders/{orderId}/reject', [KasirController::class, 'rejectPayment'])->name('kasir.reject');
        Route::post('/orders/{orderId}/update-status', [KasirController::class, 'updateStatus'])->name('kasir.update-status');
        Route::post('/logout', [KasirController::class, 'logout'])->name('kasir.logout');

        // Menu Management
        Route::get('/menu', [MenuManagerController::class, 'index'])->name('kasir.menu.index');
        Route::get('/menu/create', [MenuManagerController::class, 'createMenu'])->name('kasir.menu.create');
        Route::post('/menu', [MenuManagerController::class, 'storeMenu'])->name('kasir.menu.store');
        Route::get('/menu/{menu}/edit', [MenuManagerController::class, 'editMenu'])->name('kasir.menu.edit');
        Route::put('/menu/{menu}', [MenuManagerController::class, 'updateMenu'])->name('kasir.menu.update');
        Route::delete('/menu/{menu}', [MenuManagerController::class, 'destroyMenu'])->name('kasir.menu.destroy');
        Route::patch('/menu/{menu}/toggle', [MenuManagerController::class, 'toggleAvailable'])->name('kasir.menu.toggle');

        // Invoice / Delivery Note
        Route::get('/invoice/{orderNumber}', [KasirController::class, 'invoice'])->name('kasir.invoice');
        Route::get('/delivery-note/{orderNumber}', [KasirController::class, 'deliveryNote'])->name('kasir.delivery.note');
        Route::post('/orders/{orderId}/cash-pay', [KasirController::class, 'processCashPayment'])->name('kasir.cash.pay');
        Route::get('/struk/{orderNumber}', [KasirController::class, 'printReceipt'])->name('kasir.print.receipt');

        // History
        Route::get('/history', [HistoryController::class, 'index'])->name('kasir.history');
        Route::get('/history/export', [HistoryController::class, 'export'])->name('kasir.history.export');

        // Category Management
        Route::get('/category/create', [MenuManagerController::class, 'createCategory'])->name('kasir.category.create');
        Route::post('/category', [MenuManagerController::class, 'storeCategory'])->name('kasir.category.store');
        Route::get('/category/{category}/edit', [MenuManagerController::class, 'editCategory'])->name('kasir.category.edit');
        Route::put('/category/{category}', [MenuManagerController::class, 'updateCategory'])->name('kasir.category.update');
        Route::delete('/category/{category}', [MenuManagerController::class, 'destroyCategory'])->name('kasir.category.destroy');
    Route::post('/order/{id}/bayar-tunai', [KasirController::class, 'bayarTunai'])->name('kasir.bayarTunai');
    Route::get('/order/{id}/cetak-struk', [KasirController::class, 'cetakStruk'])->name('kasir.cetakStruk');

    });
});
