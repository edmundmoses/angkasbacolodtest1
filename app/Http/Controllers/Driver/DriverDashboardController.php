<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Ride;
use App\Models\Wallet;

class DriverDashboardController extends Controller
{
    public function index()
    {
        $driver = Auth::user();

        // Total rides (any status)
        $totalRides = Ride::where('driver_id', $driver->id)->count();

        // Total earnings (sum of completed rides' fare)
        $totalEarnings = Ride::where('driver_id', $driver->id)
                             ->where('status', 'completed')
                             ->sum('fare');

        // Wallet balance
        $walletBalance = Wallet::where('user_id', $driver->id)
                               ->value('balance') ?? 0;

        return view('driver.dashboard', [
            'driver' => $driver,
            'totalRides' => $totalRides,
            'walletBalance' => $walletBalance,
            'totalEarnings' => $totalEarnings,
        ]);
    }
}
