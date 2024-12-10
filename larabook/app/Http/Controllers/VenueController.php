<?php

namespace App\Http\Controllers;

use App\Models\venue;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;

class venueController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        return view('venues.create');
    }

    public function show()
    {
        
    }

    public function store(Request $request)
    {
        $venueAttributes = $request->validate([
            'name' => ['required'],
            'address' => ['required'],
            'city' => ['required'],
            'postal' => ['required'],
            'price' => ['required'],
            'image' => ['required', File::types(['png', 'jpg', 'jpeg'])],
            'description' => ['required'],
        ]);

        $venueImagePath = $request->image->store('venueImages');

        //dd($venueImagePath);

        venue::create([
            'name' => request('name'),
            'address' => request('address'),
            'city' => request('city'),
            'postal' => request('postal'),
            'price' => request('price'),
            'image' => $venueImagePath,
            'description' => request('description'),
        ]);


        return redirect('/');
    }

    public function edit()
    {
        
    }

    public function update()
    {
        
    }

    public function destroy()
    {
        
    }
}
