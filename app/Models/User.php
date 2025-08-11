<?php

namespace App\Models;

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
        'role', // Allows mass assignment of role
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
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

    // Relationships

    /**
     * Get the wallet associated with the user (driver).
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Get the driver profile associated with the user (driver).
     */
    public function driverProfile()
    {
        return $this->hasOne(DriverProfile::class);
    }

    /**
     * Get rides where the user is a rider.
     */
    public function ridesAsRider()
    {
        return $this->hasMany(Ride::class, 'rider_id');
    }

    /**
     * Get rides where the user is a driver.
     */
    public function ridesAsDriver()
    {
        return $this->hasMany(Ride::class, 'driver_id');
    }
}
