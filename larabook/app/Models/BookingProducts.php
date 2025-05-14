<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingProducts extends Model
{
    protected $table = 'booking_products';

    protected $fillable = [
        'bookings_id',
        'product_id',
    ];

    public function BookingP()
    {
        return $this->belongsTo(Bookings::class, 'id');
    }
}
