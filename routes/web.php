<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApiDocumentationController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminTopupController;
use App\Http\Controllers\LandingController;

// User Routes (Public) - DEFINED FIRST
Route::get('/user/login', [UserAuthController::class, 'showLogin'])->name('user.login');
Route::post('/user/login', [UserAuthController::class, 'login'])->name('user.login.store');
Route::get('/user/register', [UserAuthController::class, 'showRegister'])->name('user.register');
Route::post('/user/register', [UserAuthController::class, 'register'])->name('user.register.store');

// Landing Page
Route::middleware('web')->get('/', [LandingController::class, 'index'])->name('landing');

// Auth Routes
Route::middleware('web')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin Routes
Route::middleware(['web', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('user', UserController::class);
    Route::resource('transaction', TransactionController::class)->only(['index', 'show', 'edit', 'update']);

    // Topup Management
    Route::get('/admin/topup/pending', [AdminTopupController::class, 'showPending'])->name('admin.topup-pending');
    Route::post('/admin/topup/{topupId}/approve', [AdminTopupController::class, 'approve'])->name('admin.topup-approve');
    Route::post('/admin/topup/{topupId}/reject', [AdminTopupController::class, 'reject'])->name('admin.topup-reject');
    Route::get('/admin/topup/settings', [AdminTopupController::class, 'showSettings'])->name('admin.topup-settings');
    Route::post('/admin/topup/settings/update', [AdminTopupController::class, 'updateSettings'])->name('admin.topup-settings-update');

    // Balance Verification Management
    Route::get('/admin/balance-verification', [AdminTopupController::class, 'showBalanceVerification'])->name('admin.balance-verification');
    Route::get('/admin/balance-verification/user/{userId}', [AdminTopupController::class, 'getUserBalance'])->name('admin.balance-get-user');
    Route::post('/admin/balance-verification/adjust', [AdminTopupController::class, 'adjustBalance'])->name('admin.balance-adjust');
});

// API Documentation (Public)
Route::middleware('web')->get('/api-docs', [ApiDocumentationController::class, 'index'])->name('api-docs');

// User Routes (Protected with user.auth middleware)
Route::middleware(['web', 'user.auth'])->group(function () {
    Route::post('/user/logout', [UserAuthController::class, 'logout'])->name('user.logout');

    Route::get('/app/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/app/wallet', [UserDashboardController::class, 'wallet'])->name('user.wallet');
    Route::get('/app/transactions', [UserDashboardController::class, 'transactions'])->name('user.transactions');
    Route::get('/app/transactions/{transactionId}', [UserDashboardController::class, 'showTransactionDetail'])->name('user.transaction-detail');
    Route::get('/app/profile', [UserDashboardController::class, 'profile'])->name('user.profile');

    // Topup routes
    Route::get('/app/topup', [UserDashboardController::class, 'showTopup'])->name('user.topup');
    Route::post('/app/topup', [UserDashboardController::class, 'processTopup'])->name('user.topup.store');

    Route::get('/app/payment/create', [UserDashboardController::class, 'showPaymentCreate'])->name('user.payment-create');
    Route::post('/app/payment/create', [UserDashboardController::class, 'createQRCode'])->name('user.payment-create.store');
    Route::get('/app/payment/input', [UserDashboardController::class, 'showPaymentInput'])->name('user.payment-input');
    Route::get('/app/payment/qr/{qrCode}', [UserDashboardController::class, 'showQRCode'])->name('user.payment-show');

    Route::get('/app/payment/confirm/{qrCode}', [UserDashboardController::class, 'showPaymentConfirm'])->name('user.payment-confirm');
    Route::post('/app/payment/process', [UserDashboardController::class, 'processPayment'])->name('user.payment-process');
});

