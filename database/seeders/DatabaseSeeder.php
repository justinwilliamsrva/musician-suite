<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Gig;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create(['name'=> 'Filled Outside CRRVA', 'email' => 'filledoutsideCRRVA@gmail.com', 'admin' => true]);
        User::factory()->create(['name'=> 'TestingAdmin', 'email' => 'testingadmin@testing.com', 'admin' => true]);
        User::factory()->create(['name'=> 'Testing', 'email' => 'testing@testing.com', 'admin' => false]);
        User::factory()->create(['name'=> 'Justin Williams', 'email' => 'justinwdev@gmail.com', 'admin' => true]);
        User::factory()->create(['name'=> 'Classical Revolution', 'email' => 'info@classicalrevolutionrva.com', 'admin' => true]);
        User::factory(7)->create();

        User::all()->each(function ($user){
            Gig::factory(2)->create([
                'user_id' => $user->id,
            ]);

        });

        Gig::all()->each(function ($gig){
            $randomNumber = rand(1, 4);
            Job::factory($randomNumber)->create([
                'gig_id' => $gig->id
            ]);
        });

        Job::all()->each(function ($job){
            $randomNumber = rand(1, 2);
            if ($randomNumber == 1) {
                $gigId = $job->gig_id;
                $restrictedUserId[] = Gig::find($gigId)->user_id;
                for ($i = 0;$i < 2; $i++) {
                    $userId = User::whereNotIn('id', $restrictedUserId)->inRandomOrder()->value('id');
                    $job->users()->attach($userId, ['status' => 'Applied']);
                    $restrictedUserId[] = $userId;
                }
                $userId = User::whereNotIn('id', $restrictedUserId)->inRandomOrder()->value('id');
                $job->users()->attach($userId, ['status' => Arr::Random(['Applied', 'Booked'])]);
            }
        });

    }
}
