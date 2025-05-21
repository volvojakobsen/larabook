<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Venue;

class UserWithRelationsSeeder extends Seeder
{
    public function run()
    {
        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                Venue::factory()->count(3)->create([
                    'user_id' => $user->id,
                ]);

                Product::factory()->count(3)->create([
                    'user_id' => $user->id,
                ]);
            });
    }
}