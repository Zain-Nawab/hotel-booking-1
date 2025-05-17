@extends('admin.layout')

@section('content')

 
    <div class="content">
        <h1 class="mb-4"><i class="bi bi-speedometer2"></i>  Dashboard</h1>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Rooms</h5>
                        <p class="card-text display-6">{{ $totalRooms }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Bookings</h5>
                        <p class="card-text display-6">{{ $totalBookings }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Costumer</h5>
                        <p class="card-text display-6">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Revenue</h5>
                        <p class="card-text display-6">${{ number_format($totalRevenue, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <h3>Recent Bookings</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Room</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recentBookings as $booking)
                    <tr>
                        <td>{{ $booking->customer_name }}</td>
                        <td>{{ $booking->room->number ?? 'N/A' }}</td>
                        <td>{{ $booking->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection