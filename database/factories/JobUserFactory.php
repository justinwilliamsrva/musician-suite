<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first(['id']),
            'job_id' => Job::inRandomOrder()->first(['id']),
            'status' => Arr::random(['Pending', 'Booked']),
        ];
    }
}
