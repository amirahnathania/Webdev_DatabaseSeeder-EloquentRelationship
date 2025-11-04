<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run()
    {
        $books = [
            // Teknologi
            [
                'title' => 'Laravel: From Beginner to Pro',
                'author' => 'John Doe',
                'isbn' => '978-1234567890',
                'published_year' => 2023,
                'publisher' => 'Tech Publisher',
                'category_id' => 1,
                'stock' => 5,
                'description' => 'Panduan lengkap belajar Laravel dari dasar hingga mahir'
            ],
            [
                'title' => 'PHP Modern Development',
                'author' => 'Sarah Johnson',
                'isbn' => '978-1234567891',
                'published_year' => 2022,
                'publisher' => 'Code Masters',
                'category_id' => 1,
                'stock' => 3,
                'description' => 'Pengembangan aplikasi web modern dengan PHP'
            ],

            // Fiksi
            [
                'title' => 'The Great Adventure',
                'author' => 'Jane Smith',
                'isbn' => '978-0987654321',
                'published_year' => 2022,
                'publisher' => 'Fiction House',
                'category_id' => 2,
                'stock' => 7,
                'description' => 'Novel petualangan epik yang menegangkan'
            ],
            [
                'title' => 'Moonlight Dreams',
                'author' => 'Michael Brown',
                'isbn' => '978-0987654322',
                'published_year' => 2021,
                'publisher' => 'Dream Publishing',
                'category_id' => 2,
                'stock' => 4,
                'description' => 'Kumpulan cerita pendek tentang mimpi dan harapan'
            ],

            // Sains
            [
                'title' => 'Quantum Physics for Beginners',
                'author' => 'Dr. Robert Chen',
                'isbn' => '978-1122334455',
                'published_year' => 2023,
                'publisher' => 'Science Press',
                'category_id' => 3,
                'stock' => 6,
                'description' => 'Pengantar fisika kuantum untuk pemula'
            ],
            [
                'title' => 'The Universe Explained',
                'author' => 'Prof. Amanda Wilson',
                'isbn' => '978-1122334456',
                'published_year' => 2022,
                'publisher' => 'Cosmic Books',
                'category_id' => 3,
                'stock' => 2,
                'description' => 'Penjelasan tentang alam semesta dan misterinya'
            ],

            // Sejarah
            [
                'title' => 'Ancient Civilizations',
                'author' => 'Dr. James Miller',
                'isbn' => '978-5544332211',
                'published_year' => 2021,
                'publisher' => 'History Publishers',
                'category_id' => 4,
                'stock' => 8,
                'description' => 'Sejarah peradaban kuno dunia'
            ],
            [
                'title' => 'World War II Chronicles',
                'author' => 'Thomas Anderson',
                'isbn' => '978-5544332212',
                'published_year' => 2020,
                'publisher' => 'Historical Press',
                'category_id' => 4,
                'stock' => 3,
                'description' => 'Kronologi lengkap Perang Dunia II'
            ],

            // Bisnis
            [
                'title' => 'Startup Success Guide',
                'author' => 'Lisa Wang',
                'isbn' => '978-6677889900',
                'published_year' => 2023,
                'publisher' => 'Business Books',
                'category_id' => 5,
                'stock' => 5,
                'description' => 'Panduan membangun startup dari nol'
            ],
            [
                'title' => 'Digital Marketing Strategies',
                'author' => 'Kevin Martinez',
                'isbn' => '978-6677889901',
                'published_year' => 2022,
                'publisher' => 'Marketing Pro',
                'category_id' => 5,
                'stock' => 4,
                'description' => 'Strategi pemasaran digital untuk bisnis modern'
            ],

            // Pendidikan
            [
                'title' => 'Teaching Methods 21st Century',
                'author' => 'Dr. Susan Lee',
                'isbn' => '978-7788990011',
                'published_year' => 2023,
                'publisher' => 'Education First',
                'category_id' => 6,
                'stock' => 6,
                'description' => 'Metode pengajaran untuk abad 21'
            ],
            [
                'title' => 'Child Psychology Development',
                'author' => 'Dr. Mark Thompson',
                'isbn' => '978-7788990012',
                'published_year' => 2022,
                'publisher' => 'Learn Publishing',
                'category_id' => 6,
                'stock' => 3,
                'description' => 'Psikologi perkembangan anak dan remaja'
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}