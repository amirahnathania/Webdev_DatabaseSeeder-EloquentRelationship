<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@perpus.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Member users - juga gunakan firstOrCreate
        $members = [
            [
                'name' => 'John Member',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'role' => 'member',
            ],
            [
                'name' => 'Jane Member', 
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'role' => 'member',
            ],
            [
                'name' => 'Bob Member',
                'email' => 'bob@example.com', 
                'password' => Hash::make('password'),
                'role' => 'member',
            ],
        ];

        foreach ($members as $member) {
            User::firstOrCreate(
                ['email' => $member['email']],
                $member
            );
        }
    }
}