<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    protected $fillable = [
        'rider_id',
        'driver_id',
        'pickup_location',
        'dropoff_location',
        'fare',
        'status',
        'pickup_time',
        'dropoff_time',
    ];

    // Rider user
    public function rider()
    {
        return $this->belongsTo(User::class, 'rider_id');
    }

    // Driver user
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    // Commission for this ride
    public function commission()
    {
        return $this->hasOne(Commission::class);
    }
}
