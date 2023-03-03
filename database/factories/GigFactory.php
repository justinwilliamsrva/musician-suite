<?php

namespace Database\Factories;

use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gig>
 */
class GigFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $start_time = fake()->dateTimeBetween('now', '+1 year');
        $end_time = new DateTime($start_time->format('Y-m-d H:i:s'));
        $end_time->modify('+3 hours');

        return [
            'event_type' => fake()->randomElement(['Wedding', 'Concert', 'Party']),
            'street_address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'zip_code' => fake()->postcode(),
            'start_time' => $start_time,
            'end_time' => $end_time,
            'description' => fake()->optional()->text,
            'user_id' => User::inRandomOrder()->first(['id']),
        ];
    }
}
