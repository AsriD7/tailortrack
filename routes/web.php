<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminPriceListController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminTailorController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\Customer\CustomerPaymentController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Public\LandingController;
use App\Http\Controllers\Public\PublicPriceListController;
use App\Http\Controllers\Public\PublicTailorController;
use App\Http\Controllers\Tailor\TailorDashboardController;
use App\Http\Controllers\Tailor\TailorOrderController;
use App\Http\Controllers\Tailor\TailorPortfolioController;
use App\Http\Controllers\Tailor\TailorProfileController;
use Illuminate\Support\Facades\Route;

// =============================================
// Public Routes (tanpa login)
// =============================================

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/tailors', [PublicTailorController::class, 'index'])->name('tailors.index');
Route::get('/tailors/{tailor}', [PublicTailorController::class, 'show'])->name('tailors.show');
Route::get('/price-lists', [PublicPriceListController::class, 'index'])->name('price-lists.index');

// =============================================
// Auth Routes
// =============================================

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// =============================================
// Customer Routes
// =============================================

Route::prefix('customer')
    ->name('customer.')
    ->middleware(['auth', 'customer'])
    ->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

        // Profil
        Route::get('/profile/edit', [CustomerProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');

        // Order
        Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders.index');
        Route::get('/tailors/{tailor}/orders/create', [CustomerOrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [CustomerOrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/cancel', [CustomerOrderController::class, 'cancel'])->name('orders.cancel');

        // Payment
        Route::post('/orders/{order}/payment', [CustomerPaymentController::class, 'store'])->name('orders.payment');

        // Review
        Route::post('/orders/{order}/review', [ReviewController::class, 'store'])->name('orders.review.store');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    });

// =============================================
// Tailor Routes
// =============================================

Route::prefix('tailor')
    ->name('tailor.')
    ->middleware(['auth', 'tailor'])
    ->group(function () {
        Route::get('/dashboard', [TailorDashboardController::class, 'index'])->name('dashboard');

        // Profil
        Route::get('/profile/edit', [TailorProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [TailorProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/unavailable-dates', [TailorProfileController::class, 'storeUnavailableDate'])->name('profile.unavailable-dates.store');
        Route::delete('/profile/unavailable-dates/{unavailableDate}', [TailorProfileController::class, 'destroyUnavailableDate'])->name('profile.unavailable-dates.destroy');

        // Portfolio
        Route::resource('portfolios', TailorPortfolioController::class);

        // Order
        Route::get('/orders', [TailorOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [TailorOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/confirm-price', [TailorOrderController::class, 'confirmPrice'])->name('orders.confirm-price');
        Route::patch('/orders/{order}/status', [TailorOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::patch('/orders/{order}/cancel', [TailorOrderController::class, 'cancel'])->name('orders.cancel');
    });

// =============================================
// Admin Routes
// =============================================

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Penjahit
        Route::resource('tailors', AdminTailorController::class);
        Route::patch('/tailors/{tailor}/verify', [AdminTailorController::class, 'verify'])->name('tailors.verify');

        // Daftar Harga
        Route::resource('price-lists', AdminPriceListController::class);

        // User / Customer
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // Order
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');

        // Payment
        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
        Route::patch('/payments/{payment}/verify', [AdminPaymentController::class, 'verify'])->name('payments.verify');
        Route::patch('/payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');

        // Review
        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
    });
