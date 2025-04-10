<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;


Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('incomes', IncomeController::class);
Route::post('/incomes', [IncomeController::class, 'store'])->name('incomes.store');
Route::delete('/incomes/{income}', [IncomeController::class, 'destroy'])->name('incomes.destroy');

Route::resource('expenses', ExpenseController::class);
Route::get('/dashboard/expenses', [ExpenseController::class, 'dashboardData']);
Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

Route::resource('categories', CategoryController::class);

