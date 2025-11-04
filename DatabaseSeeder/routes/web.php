<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\TransactionController;
use App\Models\Book;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Redirect ke dashboard
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    $stats = [
        'total_books' => Book::count(),
        'total_users' => User::count(),
        'total_categories' => Category::count(),
        'total_transactions' => Transaction::count(),
        'borrowed_books' => Transaction::where('status', 'borrowed')->count(),
        'returned_books' => Transaction::where('status', 'returned')->count(),
    ];

    // Ambil data terbaru untuk ditampilkan
    $recent_books = Book::with('category')->latest()->take(5)->get();
    $recent_transactions = Transaction::with(['user', 'book'])->latest()->take(5)->get();

    return view('dashboard', compact('stats', 'recent_books', 'recent_transactions'));
});

// Routes untuk Books
Route::get('/books', function () {
    $books = Book::with('category')->get();
    return view('books.index', compact('books'));
});

Route::get('/books/{id}', function ($id) {
    $book = Book::with('category', 'transactions.user')->findOrFail($id);
    return view('books.show', compact('book'));
});

// Routes untuk Transactions
Route::get('/transactions', function () {
    $transactions = Transaction::with(['user', 'book'])->get();
    return view('transactions.index', compact('transactions'));
});