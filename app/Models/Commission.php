<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = [
        'ride_id',
        'amount',
    ];

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }
}
