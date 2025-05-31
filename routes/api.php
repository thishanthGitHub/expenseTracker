<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

// Protected Routes - Require authentication via Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Get current authenticated user info
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    // Expense routes - POST only
    Route::post('/expenses', [ExpenseController::class, 'store']);

    // Product routes - POST only
    Route::post('/products', [ProductController::class, 'store']);

    // ProductType routes - POST only
    Route::post('/product-types', [ProductTypeController::class, 'store']);

    // User Management Routes
    Route::patch('/users/{id}/status', [UserController::class, 'toggleActive']); // Toggle active/inactive status
    Route::delete('/users/{id}', [UserController::class, 'softDeleteUser']);     // Soft delete user
    Route::post('/users/{id}/restore', [UserController::class, 'restoreUser']);  // Restore soft-deleted user
});