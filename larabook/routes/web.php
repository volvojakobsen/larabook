<?php
use App\Http\Middleware\Admin;
use App\Http\Middleware\LoggedIn;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RegisteredUserController;

Route::get('/', function () {
    return view('home');
});

//venues
Route::get('/venue/getList', [VenueController::class, 'index']);
Route::get('/venue/getUsersVenues', [VenueController::class, 'getUsersVenues'])->middleware(Admin::class);
Route::get('/venue/create', [VenueController::class, 'create'])->middleware(Admin::class);
Route::post('/venue/store', [VenueController::class, 'store'])->middleware(Admin::class);
Route::get('/venue/edit/{id}', [VenueController::class, 'edit'])->middleware(Admin::class);
Route::patch('/venue/{id}', [VenueController::class, 'update'])->middleware(Admin::class);
Route::delete('/venue/{id}', [VenueController::class, 'destroy'])->middleware(Admin::class);
Route::get('/venue/{id}', [VenueController::class, 'show']);
Route::get('/venueRequest/{id}', [VenueController::class, 'findRequest']);
Route::get('/myVenues/index', [VenueController::class, 'myVenues'])->middleware(Admin::class);

//bookings
Route::get('/bookings/{id}', [BookingsController::class, 'index']);
Route::post('/bookings/store', [BookingsController::class, 'store']);

//products
Route::get('/products/index', [ProductsController::class, 'index'])->middleware(Admin::class);
Route::get('/products/show/{id}', [ProductsController::class, 'show'])->middleware(Admin::class);
Route::get('/products/create', [ProductsController::class, 'create'])->middleware(Admin::class);
Route::post('/products/store', [productsController::class, 'store'])->middleware(Admin::class);
Route::get('/products/edit/{id}', [productsController::class, 'edit'])->middleware(Admin::class);
Route::patch('/products/{id}', [productsController::class, 'update'])->middleware(Admin::class);
Route::delete('/products/{id}', [productsController::class, 'destroy'])->middleware(Admin::class);


Route::get('/dashboard', function () {
    return view('dashboard');
});
//auth
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/profile', [RegisteredUserController::class, 'show'])->middleware(LoggedIn::class);


Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);