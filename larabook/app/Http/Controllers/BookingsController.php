<?php

namespace App\Http\Controllers;

use App\Models\BookingProducts;
use App\Models\Bookings;
use Illuminate\Http\Request;
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
        'products' => ['required', 'array'],
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
}
