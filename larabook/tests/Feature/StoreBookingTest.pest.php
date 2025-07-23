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

it('fails to store booking if dateFrom is after dateTo', function () {
    $user = User::factory()->create();
    $venue = Venue::factory()->create();
    $products = Product::factory()->count(2)->create();

    $this->actingAs($user);

    $response = $this->from('/venue')->post('/bookings/store', [
        'venue_id' => $venue->id,
        'dateFrom' => '2025-06-05', // 👈 after dateTo
        'dateTo' => '2025-06-01',
        'products' => $products->pluck('id')->toArray(),
        'totalPrice' => 100,
    ]);

    $response
        ->assertRedirect('/venue') // 👈 wherever you redirect on validation failure
        ->assertSessionHasErrors(['dateTo']); // 👈 expect validation error for dateTo

    $this->assertDatabaseMissing('bookings', [
        'user_id' => $user->id,
        'venue_id' => $venue->id,
    ]);
});


it('fails to store booking if dateFrom or dateTo is missing', function () {
    $user = User::factory()->create();
    $venue = Venue::factory()->create();
    $products = Product::factory()->count(2)->create();

    $this->actingAs($user);

    // Missing dateFrom
    $response1 = $this->from('/venue')->post('/bookings/store', [
        'venue_id' => $venue->id,
        // 'dateFrom' => '2025-06-01', // 👈 Missing
        'dateTo' => '2025-06-03',
        'products' => $products->pluck('id')->toArray(),
        'totalPrice' => 150,
    ]);

    $response1->assertRedirect('/venue')->assertSessionHasErrors(['dateFrom']);

    // Missing dateTo
    $response2 = $this->from('/venue')->post('/bookings/store', [
        'venue_id' => $venue->id,
        'dateFrom' => '2025-06-01',
        // 'dateTo' => '2025-06-03', // 👈 Missing
        'products' => $products->pluck('id')->toArray(),
        'totalPrice' => 150,
    ]);

    $response2->assertRedirect('/venue')->assertSessionHasErrors(['dateTo']);
});


it('fails to store booking if totalPrice is missing', function () {
    $user = User::factory()->create();
    $venue = Venue::factory()->create();
    $products = Product::factory()->count(2)->create();

    $this->actingAs($user);

    $response = $this->from('/venue')->post('/bookings/store', [
        'venue_id' => $venue->id,
        'dateFrom' => '2025-06-01',
        'dateTo' => '2025-06-03',
        'products' => $products->pluck('id')->toArray(),
        // 'totalPrice' => 150, // 👈 Missing
    ]);

    $response->assertRedirect('/venue')->assertSessionHasErrors(['totalPrice']);
});

