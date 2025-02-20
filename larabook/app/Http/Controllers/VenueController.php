<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;

class VenueController extends Controller
{
    //home
    public function index()
    {
        return  Venue::all();
         
    }

    public function getUsersVenues()
    {
        return Auth::user()->venue;
    }
    // create view
    public function create()
    {
        return view('venues.create');
    }

    // spesific venue
    public function show($id)
    {
        $venue = Venue::findOrFail($id);

        return view('venues.show', ['Venue' => $venue]);
    }
    
    // axios request for specific venue page
    public function findRequest($id)
    {

        return Venue::findOrFail($id);
    }

    // store new venue
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

    // edit venue
    public function edit($id)
    {
        $venue = Venue::find($id);

        return view('venues.edit', ['Venue' => $venue]);
    }

    // update venue
    public function update(Request $request, $id)
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

        $venue = Venue::findOrFail($id);

        $venue->update([
            'name' => request('name'),
            'address' => request('address'),
            'city' => request('city'),
            'postal' => request('postal'),
            'price' => request('price'),
            'image' => $venueImagePath,
            'description' => request('description'),
           // 'user_id' => Auth::id()
        ]);

        return redirect('/');
    }

    public function myVenues() 
    {
        return view('myVenues.index');
    }

    // delete venue
    public function destroy($id)
    {
        $venue = Venue::findOrFail($id);
        $venue->delete();

        return redirect('/');
    }
}
