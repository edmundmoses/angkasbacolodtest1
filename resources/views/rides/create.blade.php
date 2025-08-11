@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Request a Ride</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('rides.store') }}">
        @csrf

        <div class="mb-3">
            <label for="pickup_location" class="form-label">Pickup Location</label>
            <input type="text" name="pickup_location" id="pickup_location" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="dropoff_location" class="form-label">Dropoff Location</label>
            <input type="text" name="dropoff_location" id="dropoff_location" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Request Ride</button>
    </form>
</div>
@endsection
