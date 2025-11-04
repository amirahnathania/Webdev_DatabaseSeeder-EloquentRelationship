<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $members = User::where('role', 'member')->get();
        $books = Book::all();

        // Pastikan ada member dan buku
        if ($members->isEmpty() || $books->isEmpty()) {
            return;
        }

        $statuses = ['borrowed', 'returned', 'overdue'];

        foreach ($members as $member) {
            // Setiap member meminjam 2-4 buku
            $borrowCount = rand(2, 4);
            $borrowedBooks = $books->random($borrowCount);

            foreach ($borrowedBooks as $book) {
                $borrowDate = now()->subDays(rand(1, 60));
                $returnDate = $borrowDate->copy()->addDays(14);
                $status = $statuses[array_rand($statuses)];
                
                $actualReturnDate = null;
                $fine = 0;

                if ($status === 'returned') {
                    $actualReturnDate = $returnDate->copy()->subDays(rand(0, 5));
                } elseif ($status === 'overdue') {
                    $actualReturnDate = $returnDate->copy()->addDays(rand(1, 10));
                    $fine = rand(5000, 50000);
                }

                Transaction::create([
                    'user_id' => $member->id,
                    'book_id' => $book->id,
                    'borrow_date' => $borrowDate,
                    'return_date' => $returnDate,
                    'actual_return_date' => $actualReturnDate,
                    'status' => $status,
                    'fine' => $fine,
                ]);
            }
        }
    }
}