<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VerificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = User::role('admin')->get();

        foreach ($admins as $admin) {
            $admin->email_verified_at = now();
            $admin->save();
        }
    }
}
