<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        $validatedAttributes = request()->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'address' => ['required'],
            'city' => ['required'],
            'postal' => ['required'],
            'company' => ['required'],
            'phone' => ['required'],
            'password' => ['required', Password::min(6), 'confirmed'],
            'password_confirmation' => ['required'],
            'isVenueAdmin' => ['required'],
        ]);


        $user = User::create($validatedAttributes);

        Auth::login($user);

        return redirect('/');
    }

    public function show()
    {
        $user= Auth::user();
        return view('auth.profile', ['user' => $user]);
    }
}
