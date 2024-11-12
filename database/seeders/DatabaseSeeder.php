<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tambahkan pengguna admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => ('password123'),
            'role' => 'admin'
        ]);

        // Tambahkan pengguna operator
        User::create([
            'name' => 'Operator User',
            'email' => 'operator@example.com',
            'password' => ('password123'),
            'role' => 'operator'
        ]);

        // Jika ada seeders lain, panggil di sini
        // $this->call(SeederLain::class);
    }
}
