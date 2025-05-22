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
        $prices = ['420', '1000', '240', '300', '1500', '100', '20', '10', '1999', '1'];
        return [
            'user_id' => User::factory(),
            'name' => fake()->company(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'postal' => '8400',
            'price' => fake()->randomElement($prices),
            'image' => 'venueImages/5NMGT96KYsvDYE23j8hbGJxwLSaogBfmad2VKiOX.jpg',
            'description' => fake()->paragraph($nbSentences = 2),
        ];
    }
}
