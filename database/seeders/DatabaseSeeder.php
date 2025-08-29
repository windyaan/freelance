<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Job;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Milestone;
use App\Models\Chat;
use App\Models\Message;

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
            'name' => 'Admin Skillmatch',
            'email' => 'admin@gmail.com',
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

        //seeder category
         $this->call([
            CategorySeeder::class,
        ]);

        // membuat 2 job per freelancer
        User::where('role', 'freelancer')->get()->each(function ($freelancer) {
        Job::factory()->count(2)->create([
        'freelancer_id' => $freelancer->id
        ]);
    });

     // Buat offer dari setiap client ke setiap job yang ada
        $clients = User::where('role', 'client')->get();
        $jobs = Job::all();

        foreach ($clients as $client) {
            foreach ($jobs as $job) {
                $offerStatus = fake()->randomElement(['pending', 'accepted', 'declined']);

        $offer = Offer::factory()->create([
            'client_id' => $client->id,
            'freelancer_id' => $job->freelancer_id,
            'job_id' => $job->id,
            'status' => $offerStatus, // supaya bisa langsung dibuat order dan milestone
        ]);

                // Jika offer diterima, buat order + milestones
                if ($offerStatus === 'accepted') {
                    $amount      = $offer->final_price;
                    $orderStatus = fake()->randomElement(['pending', 'dp', 'paid', 'failed']);

                    // Sinkronisasi amount_paid dengan status
                    $amountPaid = match ($orderStatus) {
                        'pending' => 0,
                        'dp'      => fake()->numberBetween(1, $amount - 1),
                        'paid'    => $amount,
                        'failed'  => 0,
                    };

                    Order::factory()->create([
                        'offer_id'    => $offer->id,
                        'amount'      => $amount,
                        'amount_paid' => $amountPaid,
                        'status'      => $orderStatus,
                    ]);

        // Buat milestone dari offer
         for ($i = 0; $i < 2; $i++) {
                        $milestoneStatus = fake()->randomElement(['Start', 'Progress', 'Done', 'revisi_request', 'approved']);

                        Milestone::factory()->create([
                            'offer_id' => $offer->id,
                            'status' => $milestoneStatus,
                            'completed_at' => $milestoneStatus === 'Done' ? now() : null,
                        ]);
                        }
                     }
                }
            }

           /**
         * Chat & Message Seeder
         */
        // $freelancers = User::where('role', 'freelancer')->get();
        $clients = User::where('role', 'client')->get();
        // $jobs = Job::all();
        $jobs    = Job::with('freelancer')->get();

        foreach ($clients as $client) {
             $job = $jobs->random();
            $freelancer = $job->freelancer;

            $chat = Chat::create([
                'client_id' => $client->id,
                'freelancer_id' => $freelancer->id,
                'job_id' => $job->id, // 👈 isi job_id biar konsisten
            ]);

            Message::create([
                'chat_id' => $chat->id,
                'sender_id' => $client->id,
                'content' => "Halo, saya tertarik dengan layanan Anda.",
            ]);

            Message::create([
                'chat_id' => $chat->id,
                'sender_id' => $freelancer->id,
                'content' => "Halo juga, silakan ceritakan kebutuhan Anda.",
            ]);
        }
        }
}
