<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'client',
            'email' =>'client@outlook.nl',
            'password' => bcrypt('client123'),
            'role' => 'client',
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@outlook.nl',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);
    }
}
