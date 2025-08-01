<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',

        // Admin manual
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@skillmatch.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // 5 Freelancer data dummy
        User::factory()->count(3)->create([
        'role' => 'freelancer',
        'password' => Hash::make('freelancer123'),
        ]);

        // 5 Client data dummy
        User::factory()->count(3)->create([
        'role' => 'client',
        'password' => Hash::make('client123'),
        ]);
    }
}
