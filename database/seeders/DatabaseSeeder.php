<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Gig;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Factories\JobUserFactory;
use Database\Factories\UserJobFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)->create();
        Gig::factory(10)->create();
        Job::factory(20)->create();
        User::all()->each(function ($user) {
            $jobs = Job::inRandomOrder()->take(40)->get();
            foreach ($jobs as $job) {
                JobUserFactory::new()->create([
                    'user_id' => $user->id,
                    'job_id' => $job->id,
                ]);
            }
        });
    }
}
