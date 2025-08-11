<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'driver_id',
        'balance',
    ];

    /**
     * Wallet belongs to a driver (User)
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    /**
     * Wallet has many transactions
     */
    public function transactions()
    {
        return $this->hasMany(DriverWalletTransaction::class, 'wallet_id');
    }
}
