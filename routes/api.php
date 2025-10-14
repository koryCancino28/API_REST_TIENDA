<?php

use Illuminate\Support\Facades\Route;

use Src\Auth\Controllers\AuthController;
use Src\Product\Controllers\ProductController;
use Src\Inventory\Controllers\InventoryController;

Route::prefix('v1')->group(function () {

    // Público
    Route::post('auth/login', [AuthController::class, 'login']);

    // Protegido (token Sanctum)
    Route::middleware('auth:sanctum')->group(function () {

        Route::get('auth/me', [AuthController::class, 'me']);
        Route::post('auth/logout', [AuthController::class, 'logout']);

        // Productos CRUD
        Route::get('products', [ProductController::class, 'index']);
        Route::post('products', [ProductController::class, 'store']);
        Route::get('products/{id}', [ProductController::class, 'show']);
        Route::match(['put', 'patch'], 'products/{id}', [ProductController::class, 'update']);
        Route::delete('products/{id}', [ProductController::class, 'destroy']);

        // Inventario (movimientos IN/OUT)
        Route::get('inventory', [InventoryController::class, 'index']);
        Route::post('inventory', [InventoryController::class, 'store']);
    });
});
