<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{

    protected $table = 'venues';

    protected $fillable = [
        'name',
        'address',
        'city',
        'postal',
        'price',
        'image',
        'description',
    ];

    public function getImageAttribute()
    {
        return url('storage/'.$this->attributes['image']);
    }

    public function getImageUrlAttribute() //image_url
    {
        return url('storage/'.$this->image);
    }


}