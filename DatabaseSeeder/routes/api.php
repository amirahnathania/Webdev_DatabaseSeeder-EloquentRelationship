<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;

// Public routes (tanpa authentication)
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('/categories/{id}/books', [CategoryController::class, 'books']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/books/search/{keyword}', [BookController::class, 'search']);
Route::get('/books/category/{categoryId}', [BookController::class, 'byCategory']);

// Statistics
Route::get('/stats', function () {
    return response()->json([
        'total_books' => \App\Models\Book::count(),
        'total_categories' => \App\Models\Category::count(),
        'total_users' => \App\Models\User::count(),
        'total_transactions' => \App\Models\Transaction::count(),
        'borrowed_books' => \App\Models\Transaction::where('status', 'borrowed')->count(),
        'available_books' => \App\Models\Book::where('stock', '>', 0)->count(),
    ]);
});

// Health check
Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'timestamp' => now(),
        'version' => '1.0.0',
        'service' => 'Library Management System API'
    ]);
});

// Protected routes (perlu authentication)
Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
            'message' => 'User data retrieved successfully'
        ]);
    });
    
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile', [UserController::class, 'updateProfile']);

    // Transaction routes
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    Route::get('/transactions/status/{status}', [TransactionController::class, 'byStatus']);
    Route::post('/transactions/borrow', [TransactionController::class, 'borrow']);
    Route::post('/transactions/{id}/return', [TransactionController::class, 'returnBook']);
    
    // User's transactions
    Route::get('/my-transactions', [TransactionController::class, 'myTransactions']);
    Route::get('/my-borrowed-books', [TransactionController::class, 'myBorrowedBooks']);

    // Admin only routes
    Route::middleware('admin')->group(function () {
        // Book management
        Route::post('/books', [BookController::class, 'store']);
        Route::put('/books/{id}', [BookController::class, 'update']);
        Route::delete('/books/{id}', [BookController::class, 'destroy']);
        Route::post('/books/{id}/restock', [BookController::class, 'restock']);

        // Category management
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::put('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

        // User management
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/statistics', [UserController::class, 'statistics']);
    });
});