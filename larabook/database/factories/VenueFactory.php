<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venue>
 */
class VenueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->company(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'postal' => '8400',
            'price' => fake()->numberBetween($int1 = 100, $int2 = 1000000),
            'image' => 'venueImages/5NMGT96KYsvDYE23j8hbGJxwLSaogBfmad2VKiOX.jpg',
            'description' => fake()->paragraph($nbSentences = 2),
        ];
    }
}
