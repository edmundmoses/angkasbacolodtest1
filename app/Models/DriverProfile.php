<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverProfile extends Model
{
    protected $fillable = [
        'driver_id',
        'license_number',
        'vehicle_info',
        'status', // active/inactive
    ];

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
