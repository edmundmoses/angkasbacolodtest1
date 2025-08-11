<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'ride_id',
        'percentage',
        'amount',
    ];

    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }
}
