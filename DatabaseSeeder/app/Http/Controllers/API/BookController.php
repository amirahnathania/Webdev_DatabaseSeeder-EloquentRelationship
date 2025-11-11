<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the books.
     */
    public function index()
    {
        try {
            $books = Book::with('category')->get();
            
            return response()->json([
                'success' => true,
                'data' => $books,
                'message' => 'Daftar buku berhasil diambil',
                'count' => $books->count()
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified book.
     */
    public function show($id)
    {
        try {
            $book = Book::with(['category', 'transactions.user'])->find($id);
            
            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $book,
                'message' => 'Detail buku berhasil diambil'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search books by keyword.
     */
    public function search($keyword)
    {
        try {
            $books = Book::with('category')
                ->where('title', 'like', "%{$keyword}%")
                ->orWhere('author', 'like', "%{$keyword}%")
                ->orWhere('isbn', 'like', "%{$keyword}%")
                ->orWhere('publisher', 'like', "%{$keyword}%")
                ->get();

            return response()->json([
                'success' => true,
                'data' => $books,
                'message' => 'Hasil pencarian buku',
                'count' => $books->count(),
                'keyword' => $keyword
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan pencarian',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created book (Admin only).
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'isbn' => 'required|string|unique:books,isbn',
                'published_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
                'publisher' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'stock' => 'required|integer|min:0',
                'description' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $book = Book::create($request->all());

            return response()->json([
                'success' => true,
                'data' => $book->load('category'),
                'message' => 'Buku berhasil ditambahkan'
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified book (Admin only).
     */
    public function update(Request $request, $id)
    {
        try {
            $book = Book::find($id);
            
            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'title' => 'sometimes|required|string|max:255',
                'author' => 'sometimes|required|string|max:255',
                'isbn' => 'sometimes|required|string|unique:books,isbn,' . $id,
                'published_year' => 'sometimes|required|integer|min:1900|max:' . (date('Y') + 1),
                'publisher' => 'sometimes|required|string|max:255',
                'category_id' => 'sometimes|required|exists:categories,id',
                'stock' => 'sometimes|required|integer|min:0',
                'description' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $book->update($request->all());

            return response()->json([
                'success' => true,
                'data' => $book->load('category'),
                'message' => 'Buku berhasil diperbarui'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified book (Admin only).
     */
    public function destroy($id)
    {
        try {
            $book = Book::find($id);
            
            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan'
                ], 404);
            }

            // Cek apakah buku sedang dipinjam
            $activeTransactions = $book->transactions()->where('status', 'borrowed')->count();
            if ($activeTransactions > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus buku yang sedang dipinjam'
                ], 400);
            }

            $book->delete();

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil dihapus'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restock book (Admin only).
     */
    public function restock(Request $request, $id)
    {
        try {
            $book = Book::find($id);
            
            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $book->increment('stock', $request->quantity);

            return response()->json([
                'success' => true,
                'data' => $book->fresh(),
                'message' => 'Stok buku berhasil ditambahkan'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambah stok buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get books by category.
     */
    public function byCategory($categoryId)
    {
        try {
            $category = Category::find($categoryId);
            
            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak ditemukan'
                ], 404);
            }

            $books = Book::where('category_id', $categoryId)->with('category')->get();

            return response()->json([
                'success' => true,
                'data' => $books,
                'category' => $category->name,
                'message' => 'Daftar buku berdasarkan kategori',
                'count' => $books->count()
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil buku berdasarkan kategori',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}