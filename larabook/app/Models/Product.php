<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'title',
        'price',
        'user_id',
        'description',
    ];

    public function venueOwner()
    {
        return $this->belongsTo(\App\Models\User::class, 'id');
    }
}
