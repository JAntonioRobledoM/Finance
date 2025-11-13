<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;

// Public routes
Route::get('/', fn() => view('welcome'))->name('welcome');

// Authentication routes (apply guest middleware to prevent logged-in users from accessing)
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');

    // Registration Routes
    Route::get('register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'App\Http\Controllers\Auth\RegisterController@register');

    // Password Reset Routes
    Route::get('password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');
});

// Routes for both guests and authenticated users
Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // Redirect /home to /dashboard for compatibility
    Route::redirect('/home', '/dashboard');

    // Financial management routes
    Route::prefix('finances')->group(function () {
        // Transactions
        Route::get('/transactions', [TransactionController::class, 'index'])->name('finances.transactions');
        Route::post('/transactions/income', [TransactionController::class, 'storeIncome'])->name('finances.income.store');
        Route::post('/transactions/expense', [TransactionController::class, 'storeExpense'])->name('finances.expense.store');
        Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('finances.transactions.destroy');

        // Categories
        Route::get('/categories', [CategoryController::class, 'index'])->name('finances.categories');
        Route::post('/categories', [CategoryController::class, 'store'])->name('finances.categories.store');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('finances.categories.destroy');

        // Budget
        Route::get('/budget', [HomeController::class, 'budget'])->name('finances.budget');
        Route::post('/budget', [HomeController::class, 'saveBudget'])->name('finances.budget.save');

        // Analytics
        Route::get('/analytics', fn() => view('finances.analytics'))->name('finances.analytics');

        // Savings
        Route::get('/savings', fn() => view('finances.savings'))->name('finances.savings');
    });

    // User profile and settings
    Route::get('/profile', fn() => view('profile'))->name('profile');
});
