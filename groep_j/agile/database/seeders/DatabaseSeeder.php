<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use phpseclib3\Crypt\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'user']);
        Role::create(['name' => 'admin']);

        $user = new User;
        $user->name = 'admin';
        $user->major = 'SO';
        $user->email = 'admin@agile.nl';
        $user->phone = '0612345678';
        $user->password = hash('sha256', "password");
        $user->save();
        $user->assignRole('admin');

        if (app()->environment('local')) {
            $this->call(TestDataSeeder::class);
        }
    }
}
