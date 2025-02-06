<?php

use App\Models\Venue;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\RegisteredUserController;

Route::get('/', function () {
    return view('home');
});

//venues
Route::get('/venue/getList', [VenueController::class, 'index']);
Route::get('/venue/getUsersVenues', [VenueController::class, 'getUsersVenues']);
Route::get('/venue/create', [VenueController::class, 'create']);
Route::post('/venue/store', [VenueController::class, 'store']);
Route::get('/venue/edit/{id}', [VenueController::class, 'edit']);
Route::patch('/venue/{id}', [VenueController::class, 'update']);
Route::delete('/venue/{id}', [VenueController::class, 'destroy']);
Route::get('/venue/{id}', [VenueController::class, 'show']);
Route::get('/venueRequest/{id}', [VenueController::class, 'findRequest']);

//my venues page
Route::get('/myVenues/index', function () {
    return view('myVenues.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});
//auth
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/profile', [RegisteredUserController::class, 'show']);

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);