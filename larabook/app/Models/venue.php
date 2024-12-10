<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class venue extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'postal',
        'price',
        'image',
        'description',
    ];
}
