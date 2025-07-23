<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function index() 
    {
        return  Auth::user()->product;
    }

    public function show($id) 
    {
        return  Product::where('user_id', $id)->get();
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

    public function edit($id) 
    {
        $product = Product::find($id);

        //dd($product);

        return view('products.edit', ['product' => $product]);
    }

    public function update(Request $request, $id) 
    {
        $productAttributes = $request->validate([
            'title' => ['required'],
            'price' => ['required'],
            'description' => ['required'],
        ]);


        $product = Product::findOrFail($id);

        $product->update([
            'title' => request('title'),
            'price' => request('price'),
            'description' => request('description'),
           // 'user_id' => Auth::id()
        ]);

        return redirect('/myVenues/index');
    }

    public function destroy($id) 
    {
        //dd('hello');
        $product = Product::findOrFail($id);
        //dd($product);
        $product->delete();

        return redirect('/myVenues/index');
    }
}
