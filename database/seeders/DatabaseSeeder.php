<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(100)->create();

        // Create super user
        User::factory()->create([
            'first_name' => 'Super',
            'last_name' => 'User',
            'username' => 'Super User',
            'gender' => 'male',
            'email' => 'super@mail.com',
        ]);

        // Create admin user
        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'Admin User',
            'gender' => 'male',
            'email' => 'admin@mail.com',
        ]);

        // Create customer user
        User::factory()->create([
            'first_name' => 'Customer',
            'last_name' => 'User',
            'username' => 'Customer User',
            'gender' => 'male',
            'email' => 'customer@mail.com',
        ]);
    }
}
