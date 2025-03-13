<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function index() 
    {
        return  Product::all();
    }

    public function create() 
    {
        return view('products.create');
    }

    public function store(Request $request) 
    {
        $productAttributes = $request->validate([
            'title' => ['required'],
            'price' => ['required'],
            'description' => ['required'],
            
            
        ]);

        Product::create([
            'title' => request('title'),
            'price' => request('price'),
            'description' => request('description'),
            'user_id' => Auth::id()
        ]);


        return redirect('/myVenues/index');
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
