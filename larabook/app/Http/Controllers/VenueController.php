<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Venue;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;

class VenueController extends Controller
{
    //home
    public function index(Request $request)
    {
        $sortField = $request->get('sortField', 'created_at');
        $sortDirection = $request->get('sortDirection', 'asc');
        $search = $request->get('search', '');

        $allowedFields = ['name', 'price', 'created_at'];
        $allowedDirections = ['asc', 'desc'];

        if (!in_array($sortField, $allowedFields)) {
            $sortField = 'created_at';
        }

        if (!in_array($sortDirection, $allowedDirections)) {
            $sortDirection = 'asc';
        }

        $query = Venue::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        return $query->orderBy($sortField, $sortDirection)->paginate(12);
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

        $venue = Venue::findOrFail($id)->toArray();

        return response()->json($venue);
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
        ]);

        return redirect('/');
    }

    public function myVenues()
    {
        $allVenues = Venue::all();
        $allproducts = Product::all();

        return view('myVenues.index', ['venues' => $allVenues, 'products' => $allproducts]);
    }

    // delete venue
    public function destroy($id)
    {
        $venue = Venue::findOrFail($id);
        $venue->delete();

        return redirect('/');
    }
}
