<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'nama' => 'Admin User',
            'username' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        // Atau jika ingin membuat multiple users
        User::factory()->create([
            'nama' => 'double User',
            'username' => 'double',
            'password' => Hash::make('password123'),
        ]);

        // Atau jika ingin membuat triple users
        User::factory()->create([
            'nama' => 'triple User',
            'username' => 'triple',
            'password' => Hash::make('password123'),
        ]);
    }
}