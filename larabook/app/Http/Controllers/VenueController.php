<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;

class VenueController extends Controller
{
    public function index()
    {
        return  Venue::all();
         
    }

    public function create()
    {
        return view('venues.create');
    }

    public function show($id)
    {
        dd(Venue::find($id));
    }

    public function store(Request $request)
    {
        $venueAttributes = $request->validate([
            'name' => ['required'],
            'address' => ['required'],
            'city' => ['required'],
            'postal' => ['required'],
            'price' => ['required'],
            'image' => ['required', File::types(['png', 'jpg', 'jpeg', 'webp'])],
            'description' => ['required'],
            
            
        ]);

        $venueImagePath = $request->image->store('venueImages');

        //dd($venueImagePath);

        // dd([
        //     'name' => request('name'),
        //     'address' => request('address'),
        //     'city' => request('city'),
        //     'postal' => request('postal'),
        //     'price' => request('price'),
        //     'image' => $venueImagePath,
        //     'description' => request('description'),
        //     'user_id' => Auth::id()
        // ]);
        Venue::create([
            'name' => request('name'),
            'address' => request('address'),
            'city' => request('city'),
            'postal' => request('postal'),
            'price' => request('price'),
            'image' => $venueImagePath,
            'description' => request('description'),
            'user_id' => Auth::id()
        ]);


        return redirect('/');
    }

    public function edit()
    {
        return view('venues.edit');
    }

    public function update()
    {
        
    }

    public function destroy()
    {
        
    }
}
