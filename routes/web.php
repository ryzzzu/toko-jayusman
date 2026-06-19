<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ROUTE PROFILE INI YANG KURANG
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::middleware(['role:owner'])->group(function () {
        Route::resource('/branches', BranchController::class)->except(['show']);
    });

    Route::middleware(['role:owner,manager'])->group(function () {
        Route::resource('/categories', CategoryController::class)->except(['show']);
        Route::resource('/products', ProductController::class)->except(['show']);
    });

    Route::middleware(['role:owner,manager,supervisor,warehouse'])->group(function () {
        Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    });

    Route::middleware(['role:cashier'])->group(function () {
        Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    });

    Route::middleware(['role:owner,manager,supervisor,cashier'])->group(function () {
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    });

    Route::middleware(['role:warehouse'])->group(function () {
        Route::get('/stock-movements/create', [StockMovementController::class, 'create'])->name('stock-movements.create');
        Route::post('/stock-movements', [StockMovementController::class, 'store'])->name('stock-movements.store');
    });

    Route::middleware(['role:owner,manager,supervisor,warehouse'])->group(function () {
        Route::get('/stock-movements', [StockMovementController::class, 'index'])->name('stock-movements.index');
    });

    Route::middleware(['role:owner,manager'])->group(function () {
        Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');
        Route::get('/reports/stocks', [ReportController::class, 'stocks'])->name('reports.stocks');
    });
});

require __DIR__.'/auth.php';