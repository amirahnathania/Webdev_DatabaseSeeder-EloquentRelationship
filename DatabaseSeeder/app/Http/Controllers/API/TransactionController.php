<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Display a listing of the transactions.
     */
    public function index()
    {
        try {
            $transactions = Transaction::with(['user', 'book.category'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $transactions,
                'message' => 'Daftar transaksi berhasil diambil',
                'count' => $transactions->count()
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified transaction.
     */
    public function show($id)
    {
        try {
            $transaction = Transaction::with(['user', 'book.category'])->find($id);
            
            if (!$transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $transaction,
                'message' => 'Detail transaksi berhasil diambil'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current user's transactions.
     */
    public function myTransactions()
    {
        try {
            $user = auth()->user();
            $transactions = Transaction::with(['book.category'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $transactions,
                'message' => 'Riwayat transaksi Anda berhasil diambil',
                'count' => $transactions->count()
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil riwayat transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current user's borrowed books.
     */
    public function myBorrowedBooks()
    {
        try {
            $user = auth()->user();
            $borrowedBooks = Transaction::with(['book.category'])
                ->where('user_id', $user->id)
                ->where('status', 'borrowed')
                ->orderBy('return_date', 'asc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $borrowedBooks,
                'message' => 'Buku yang sedang dipinjam berhasil diambil',
                'count' => $borrowedBooks->count()
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil buku yang dipinjam',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Borrow a book.
     */
    public function borrow(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'book_id' => 'required|exists:books,id',
                'return_date' => 'required|date|after:today'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $book = Book::find($request->book_id);
            $user = auth()->user();

            // Cek stok buku
            if ($book->stock < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak tersedia untuk dipinjam (stok habis)'
                ], 400);
            }

            // Cek apakah user sudah meminjam buku yang sama dan belum dikembalikan
            $existingBorrow = Transaction::where('user_id', $user->id)
                ->where('book_id', $request->book_id)
                ->where('status', 'borrowed')
                ->exists();

            if ($existingBorrow) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah meminjam buku ini dan belum mengembalikannya'
                ], 400);
            }

            // Kurangi stok buku
            $book->decrement('stock');

            // Buat transaksi
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'book_id' => $request->book_id,
                'borrow_date' => Carbon::now(),
                'return_date' => $request->return_date,
                'status' => 'borrowed',
                'fine' => 0
            ]);

            return response()->json([
                'success' => true,
                'data' => $transaction->load(['user', 'book.category']),
                'message' => 'Buku berhasil dipinjam'
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal meminjam buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Return a borrowed book.
     */
    public function returnBook($id)
    {
        try {
            $transaction = Transaction::with(['book'])->find($id);
            
            if (!$transaction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi tidak ditemukan'
                ], 404);
            }

            if ($transaction->status !== 'borrowed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku sudah dikembalikan sebelumnya'
                ], 400);
            }

            $user = auth()->user();
            if ($transaction->user_id !== $user->id && $user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk mengembalikan buku ini'
                ], 403);
            }

            // Hitung denda jika terlambat
            $fine = 0;
            $actualReturnDate = Carbon::now();
            $returnDate = Carbon::parse($transaction->return_date);

            if ($actualReturnDate->gt($returnDate)) {
                $daysLate = $actualReturnDate->diffInDays($returnDate);
                $fine = $daysLate * 5000; // Denda Rp 5.000 per hari
            }

            // Update transaksi
            $transaction->update([
                'actual_return_date' => $actualReturnDate,
                'status' => 'returned',
                'fine' => $fine
            ]);

            // Tambah stok buku
            $transaction->book->increment('stock');

            return response()->json([
                'success' => true,
                'data' => $transaction->load(['user', 'book.category']),
                'message' => $fine > 0 ? 
                    "Buku berhasil dikembalikan dengan denda Rp " . number_format($fine, 0, ',', '.') : 
                    "Buku berhasil dikembalikan tepat waktu"
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengembalikan buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get transactions by status.
     */
    public function byStatus($status)
    {
        try {
            $validStatuses = ['borrowed', 'returned', 'overdue'];
            
            if (!in_array($status, $validStatuses)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status tidak valid. Pilih: borrowed, returned, atau overdue'
                ], 400);
            }

            $transactions = Transaction::with(['user', 'book.category'])
                ->where('status', $status)
                ->orderBy('created_at', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $transactions,
                'status' => $status,
                'message' => "Daftar transaksi dengan status {$status}",
                'count' => $transactions->count()
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil transaksi berdasarkan status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}