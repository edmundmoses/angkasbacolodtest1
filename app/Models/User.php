<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * User has one wallet
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * User has many rides as driver
     */
    public function driverRides()
    {
        return $this->hasMany(Ride::class, 'driver_id');
    }

    /**
     * User has many rides as rider
     */
    public function riderRides()
    {
        return $this->hasMany(Ride::class, 'rider_id');
    }

    /**
     * Driver wallet transactions
     */
    public function driverWalletTransactions()
    {
        return $this->hasMany(DriverWalletTransaction::class, 'driver_id');
    }

    /**
     * Driver profile
     */
    public function driverProfile()
    {
        return $this->hasOne(DriverProfile::class, 'driver_id');
    }
}
