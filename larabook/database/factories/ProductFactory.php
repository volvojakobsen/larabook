<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $adjectives = ['Small', 'Ergonomic', 'Rustic', 'Smart', 'Incredible'];
        $items = ['Chair', 'Car', 'Computer', 'Keyboard', 'Mouse', 'staff', 'catering', 'security', 'ticketing-staff'];
        $prices = ['4500', '1000', '240', '300', '1500', '100', '20', '10', '1999', '1'];

        return [
            'user_id' => User::factory(),
            'title' => fake()->randomElement($adjectives) . ' ' . fake()->randomElement($items), // e.g. "Smart Keyboard",
            'price' => fake()->randomElement($prices),
            'description' => fake()->paragraph($nbSentences = 3),
        ];
    }
}
