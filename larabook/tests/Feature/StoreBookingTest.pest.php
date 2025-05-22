<?php

use App\Models\User;
use App\Models\Venue;
use App\Models\Product;
use App\Models\Bookings;
use App\Models\BookingProducts;

it('stores a booking and its products', function () {
    $user = User::factory()->create();
    $venue = Venue::factory()->create();
    $products = Product::factory()->count(3)->create();

    $this->actingAs($user);

    $response = $this->post('/bookings/store', [
        'venue_id' => $venue->id,
        'dateFrom' => '2025-06-01',
        'dateTo' => '2025-06-03',
        'products' => $products->pluck('id')->toArray(),
        'totalPrice' => 199.99,
    ]);

    $response->assertRedirect('/');

    $this->assertDatabaseHas('bookings', [
        'user_id' => $user->id,
        'venue_id' => $venue->id,
        'totalPrice' => 200,
    ]);

    $booking = Bookings::first();

    foreach ($products as $product) {
        $this->assertDatabaseHas('booking_products', [
            'bookings_id' => $booking->id,
            'product_id' => $product->id,
        ]);
    }
});
