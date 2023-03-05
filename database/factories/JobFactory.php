<?php

namespace Database\Factories;

use App\Models\Gig;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'instruments' => json_encode(Arr::random(config('gigs.instruments'), 1)),
            'payment' => fake()->numberBetween(50, 200),
            'extra_info' => fake()->paragraph(),
            'gig_id' => Gig::inRandomOrder()->first(['id']),
        ];
    }
}
