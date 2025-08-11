<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RideController extends Controller
{
    // Show form for rider to book a ride
    public function create()
    {
        return view('rides.create');
    }

    // Store new ride request
    public function store(Request $request)
    {
        $request->validate([
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
        ]);

        $rider = Auth::user();

        $ride = Ride::create([
            'rider_id' => $rider->id,
            'pickup_location' => $request->pickup_location,
            'dropoff_location' => $request->dropoff_location,
            'fare' => 0, // Will calculate later
            'status' => 'pending',
        ]);

        return redirect()->route('rides.show', $ride)->with('success', 'Ride requested! Waiting for driver acceptance.');
    }

    // List all pending rides for driver to see
    public function indexPending()
    {
        $rides = Ride::where('status', 'pending')->get();

        return view('rides.pending', compact('rides'));
    }

    // Driver accepts a ride
    public function accept(Ride $ride)
    {
        $driver = Auth::user();

        if ($ride->status !== 'pending') {
            return back()->withErrors('Ride already accepted or not available.');
        }

        // Calculate fare here using your formula
        // For now, we will set a dummy fare; you can replace with real calculation logic
        $baseFare = 50;
        $additionalPerKm = 10;
        $distanceKm = 10; // Replace with real distance calculation
        $fare = $baseFare;
        if ($distanceKm > 7) {
            $fare += ($distanceKm - 7) * $additionalPerKm;
        }

        $commissionPercent = 10;
        $commissionAmount = $fare * ($commissionPercent / 100);

        // Transactional operation: update ride, create commission, deduct driver wallet
        DB::transaction(function () use ($ride, $driver, $fare, $commissionAmount) {

            $ride->update([
                'driver_id' => $driver->id,
                'fare' => $fare,
                'status' => 'accepted',
            ]);

            Commission::create([
                'ride_id' => $ride->id,
                'percentage' => 10.0,
                'amount' => $commissionAmount,
            ]);

            $wallet = $driver->wallet()->firstOrCreate(['user_id' => $driver->id]);

            // Deduct commission from wallet
            if ($wallet->balance < $commissionAmount) {
                abort(403, 'Insufficient wallet balance for commission.');
            }

            $wallet->balance -= $commissionAmount;
            $wallet->save();

            // Record wallet transaction
            $wallet->transactions()->create([
                'type' => 'debit',
                'amount' => $commissionAmount,
                'description' => "Commission deduction for ride ID {$ride->id}",
            ]);
        });

        return redirect()->route('driver.dashboard')->with('success', 'Ride accepted and commission deducted.');
    }

    // Show ride details
    public function show(Ride $ride)
    {
        $user = Auth::user();

        // Only involved rider or driver can see ride details
        if ($user->id !== $ride->rider_id && $user->id !== $ride->driver_id) {
            abort(403);
        }

        return view('rides.show', compact('ride'));
    }
}
