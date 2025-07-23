<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $table = 'bookings';

    protected $casts = [
        'products' => 'array',
    ];

    protected $fillable = [
        'user_id',
        'venue_id',
        'dateFrom',
        'dateTo',
        'products',
        'totalPrice',
    ];

    public function venueOwner()
    {
        return $this->belongsTo(\App\Models\User::class, 'id');
    }

    public function customer()
    {
        return $this->belongsTo(\App\Models\User::class, 'id');
    }

    public function productsOrdered()
     {
        return $this->hasMany(Product::class, 'id');
     }

     public function bookedVenue()
     {
        return $this->belongsTo(Venue::class, 'id');
     }

     public function bookedProducts()
     {
        return $this->hasMany(BookingProducts::class, 'id');
     }


}
