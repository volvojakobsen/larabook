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
        $venue = Venue::find($id);

        return view('venues.show', ['Venue' => $venue]);
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

    public function edit($id)
    {
        $venue = Venue::find($id);

        return view('venues.edit', ['Venue' => $venue]);
    }

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

    public function destroy($id)
    {
        $venue = Venue::findOrFail($id);
        $venue->delete();

        return redirect('/');
    }
}
