<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\SavingsGoalController;
use App\Http\Controllers\SavingsContributionController;

// Public routes
Route::get('/', fn() => view('welcome'))->name('welcome');

// Static pages
Route::get('/terms', [StaticPagesController::class, 'terms'])->name('terms');
Route::get('/privacy', [StaticPagesController::class, 'privacy'])->name('privacy');

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
        Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('finances.transactions.edit');
        Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('finances.transactions.update');

        // Categories
        Route::get('/categories', [CategoryController::class, 'index'])->name('finances.categories');
        Route::post('/categories', [CategoryController::class, 'store'])->name('finances.categories.store');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('finances.categories.destroy');

        // Budget
        Route::get('/budget', [HomeController::class, 'budget'])->name('finances.budget');
        Route::post('/budget', [HomeController::class, 'saveBudget'])->name('finances.budget.save');

        // Analytics
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('finances.analytics');
        Route::get('/analytics/data', [AnalyticsController::class, 'getAnalyticsData'])->name('finances.analytics.data');

        // Savings Goals
        Route::get('/savings', [SavingsGoalController::class, 'index'])->name('finances.savings');
        Route::get('/savings/create', [SavingsGoalController::class, 'create'])->name('finances.savings.create');
        Route::post('/savings', [SavingsGoalController::class, 'store'])->name('finances.savings.store');
        Route::get('/savings/{savingsGoal}', [SavingsGoalController::class, 'show'])->name('finances.savings.show');
        Route::get('/savings/{savingsGoal}/edit', [SavingsGoalController::class, 'edit'])->name('finances.savings.edit');
        Route::put('/savings/{savingsGoal}', [SavingsGoalController::class, 'update'])->name('finances.savings.update');
        Route::delete('/savings/{savingsGoal}', [SavingsGoalController::class, 'destroy'])->name('finances.savings.destroy');
        Route::put('/savings/{savingsGoal}/complete', [SavingsGoalController::class, 'complete'])->name('finances.savings.complete');
        Route::put('/savings/{savingsGoal}/status', [SavingsGoalController::class, 'changeStatus'])->name('finances.savings.status');

        // Savings Contributions
        Route::post('/savings/{savingsGoal}/contributions', [SavingsContributionController::class, 'store'])->name('finances.contributions.store');
        Route::delete('/contributions/{contribution}', [SavingsContributionController::class, 'destroy'])->name('finances.contributions.destroy');
    });

    // User profile and settings
    Route::get('/profile', fn() => view('profile'))->name('profile');
    Route::put('/profile', [HomeController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [HomeController::class, 'updatePassword'])->name('profile.password.update');
});
