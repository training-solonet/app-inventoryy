<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['username' => 'Depon', 'role' => 'operator', 'password' => bcrypt('123456')],
            ['username' => 'admin', 'role' => 'admin', 'password' => bcrypt('123456')],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
