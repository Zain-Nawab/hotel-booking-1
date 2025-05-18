<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'type',
        'price_per_night',
        'description',
        'image',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }
}
