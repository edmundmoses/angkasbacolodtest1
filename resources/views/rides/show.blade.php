@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ride Details</h1>

    <p><strong>Pickup:</strong> {{ $ride->pickup_location }}</p>
    <p><strong>Dropoff:</strong> {{ $ride->dropoff_location }}</p>
    <p><strong>Fare:</strong> ₱{{ number_format($ride->fare, 2) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($ride->status) }}</p>

    @if($ride->driver)
        <p><strong>Driver:</strong> {{ $ride->driver->name }}</p>
    @else
        <p><em>No driver assigned yet</em></p>
    @endif
</div>
@endsection
