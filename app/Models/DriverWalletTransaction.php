<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverWalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'driver_id',
        'type',
        'amount',
        'description',
    ];

    /**
     * Each transaction belongs to a wallet.
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Each transaction is linked to a driver (user).
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
