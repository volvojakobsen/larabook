<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Bookings;
use Illuminate\Http\Request;
use App\Models\BookingProducts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingsController extends Controller
{
    public function index($id)
    {
        $bookings =  Bookings::where('venue_id', $id)->get()->toArray();

        return response()->json($bookings);
    }

    public function create()
    {
        //return view('products.create');
    }

    public function store(Request $request)
{
    // Validate input
    $bookingAttributes = $request->validate([
        'venue_id' => ['required', 'integer'],
        'dateFrom' => ['required', 'date'],
        'dateTo' => ['required', 'date', 'after_or_equal:dateFrom'],
        'products' => ['array'],
        'products.*' => ['integer'],
        'totalPrice' => ['required', 'numeric'],
    ]);

    // Create the booking and get the model instance
    $booking = Bookings::create([
        'user_id' => Auth::id(),
        'venue_id' => $bookingAttributes['venue_id'],
        'dateFrom' => $bookingAttributes['dateFrom'],
        'dateTo' => $bookingAttributes['dateTo'],
        'products' => json_encode($bookingAttributes['products']),
        'totalPrice' => $bookingAttributes['totalPrice'],
    ]);

    // Create a BookingProducts entry for each product
    foreach ($bookingAttributes['products'] as $productId) {
        BookingProducts::create([
            'bookings_id' => $booking->id,
            'product_id' => $productId,
        ]);
    }

    return redirect('/');
}

public function myBookings() {
    return view('/myBookings.index');
}

public function getUsersBookings()
{
    $userId = Auth::id(); // Get currently logged-in user's ID

    // Fetch bookings for this user
    $bookings = Bookings::where('user_id', $userId)->get();

    return response()->json($bookings);
}

public function getUsersBookingProducts($bookingId)
{
    // Step 1: Get product IDs from the pivot table
    $productIds = BookingProducts::
        where('bookings_id', $bookingId)
        ->pluck('product_id');

    // Step 2: Fetch the products by their IDs
    $products = Product::whereIn('id', $productIds)->get();

    // Step 3: Return the products (as JSON if it's for an API)
    return response()->json($products);
}

}
