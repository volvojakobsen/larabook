<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingsController extends Controller
{
    public function index() 
    {
        //return  Product::all();
    }

    public function create() 
    {
        //return view('products.create');
    }

    public function store(Request $request) 
    {

        //dd($request);
        $bookingAttributes = $request->validate([
            // 'user_id' => ['required'],
            'venue_id' => ['required'],
            'dateFrom' => ['required'],
            'dateTo' => ['required'],
            'products' => [],
            'totalPrice' => ['required'],
            
            
        ]);

        Bookings::create([
            'user_id' => Auth::id(),
            'venue_id' => request('venue_id'),
            'dateFrom' => request('dateFrom'),
            'dateTo' => request('dateTo'),
            'products' => request('products'),
            'totalPrice' => request('totalPrice')
        ]);


        return redirect('/');
    }
}
