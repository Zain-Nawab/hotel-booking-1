<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['user_id','room_id', 'check_in', 'check_out','status', 'amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
