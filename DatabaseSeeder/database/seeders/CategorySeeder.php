<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Teknologi', 'description' => 'Buku tentang teknologi dan pemrograman'],
            ['name' => 'Fiksi', 'description' => 'Buku fiksi, novel, dan cerita'],
            ['name' => 'Sains', 'description' => 'Buku ilmu pengetahuan dan sains'],
            ['name' => 'Sejarah', 'description' => 'Buku sejarah dan budaya'],
            ['name' => 'Bisnis', 'description' => 'Buku bisnis, ekonomi, dan manajemen'],
            ['name' => 'Pendidikan', 'description' => 'Buku pendidikan dan pembelajaran'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}