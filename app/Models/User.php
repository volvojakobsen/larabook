<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     public function venue()
     {
        return $this->hasMany(Venue::class, 'user_id');
     }

     public function product()
     {
        return $this->hasMany(Product::class, 'user_id');
     }

     public function bookings()
     {
        return $this->hasMany(Bookings::class, 'id');
     }

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'address',
        'city',
        'postal',
        'company',
        'phone',
        'password',
        'isVenueAdmin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
