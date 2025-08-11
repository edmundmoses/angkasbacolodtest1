@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pending Rides</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($rides->isEmpty())
        <p>No pending rides at the moment.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Pickup</th>
                    <th>Dropoff</th>
                    <th>Fare</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rides as $ride)
                <tr>
                    <td>{{ $ride->pickup_location }}</td>
                    <td>{{ $ride->dropoff_location }}</td>
                    <td>{{ $ride->fare ? '₱' . number_format($ride->fare, 2) : '-' }}</td>
                    <td>
                        <form method="POST" action="{{ route('rides.accept', $ride) }}">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Accept</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
