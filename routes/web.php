<?php

use Illuminate\Support\Facades\Route;
use Src\Web\Controllers\AuthSessionController;
use Src\Web\Controllers\WebProductController;
use Src\Web\Controllers\WebInventoryController;

Route::get('/', fn() => redirect()->route('web.login'));

# Auth (web session)
Route::get('/login', [AuthSessionController::class, 'showLoginForm'])->name('web.login');
Route::post('/login', [AuthSessionController::class, 'login'])->name('web.login.post');
Route::post('/logout', [AuthSessionController::class, 'logout'])->name('web.logout');

# Área protegida
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('web.dashboard');

    # Productos
    Route::get('/products', [WebProductController::class, 'index'])->name('web.products.index');
    Route::get('/products/create', [WebProductController::class, 'create'])->name('web.products.create');
    Route::get('/products/{id}/edit', [WebProductController::class, 'edit'])->name('web.products.edit');

    # Inventario
    Route::get('/inventory', [WebInventoryController::class, 'index'])->name('web.inventory.index');
});
