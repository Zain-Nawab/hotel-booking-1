@extends('master')

@section('title', 'Booking Success')
@section('content')
    <div class="container">
        <h1>Booking Successful</h1>
        <p>Your Room Number {{ $booking->room_id }} booking has been successfully processed.</p>
    </div>
@endsection
