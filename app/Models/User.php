<?php

namespace App\Models;

use Carbon\Carbon;
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
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'github_id',
        'github_token',
        'github_refresh_token', 
        'phone',
        'email_verification_token',
        'email_verification_expires_at',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_token',
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
            'email_verification_expires_at' => 'datetime',
            'is_verified' => 'boolean',
            'password' => 'hashed',
        ];
    }

    // Generate OTP for email verification
    public function generateEmailVerificationToken()
    {
        $this->email_verification_token = sprintf('%06d', mt_rand(100000, 999999));
        $this->email_verification_expires_at = Carbon::now()->addMinutes(15); // 15 minutes expiry
        $this->save();
        
        return $this->email_verification_token;
    }

    // Check if email verification token is valid
    public function isValidVerificationToken($token)
    {
        return $this->email_verification_token === $token && 
               $this->email_verification_expires_at > Carbon::now();
    }

    // Mark email as verified
    public function markEmailAsVerified()
    {
        $this->email_verified_at = Carbon::now();
        $this->is_verified = true;
        $this->email_verification_token = null;
        $this->email_verification_expires_at = null;
        $this->save();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
