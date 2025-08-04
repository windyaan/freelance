<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Job;

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

        // 5 Freelancer data dummy+profil
        User::factory()->count(3)->create([
        'role' => 'freelancer',
        'password' => Hash::make('freelancer123'),
        ])->each(function ($user) {
            $user->profile()->create(Profile::factory()->make()->toArray());
        });

        // 5 Client data dummy+profil
        User::factory()->count(3)->create([
        'role' => 'client',
        'password' => Hash::make('client123'),
        ])->each(function ($user) {
            $user->profile()->create(Profile::factory()->make()->toArray());
        });

         $this->call([
            CategorySeeder::class,
        ]);

        // Tambahkan setelah seeding client
        User::where('role', 'freelancer')->get()->each(function ($freelancer) {
        Job::factory()->count(2)->create([
        'freelancer_id' => $freelancer->id
        ]);
    });
    }
}
