@extends('master')

@push('styles')
    
@endpush
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('storage/'.$room->image) }}" class="img-fluid rounded shadow-sm w-100" alt="Room Image">
        </div>
        <div class="col-md-6">
            <h2 class="mb-3">
                <i class="bi bi-door-open-fill me-2"></i>Room Number {{ $room->room_number }}
            </h2>

            <p class="mb-2">
                <i class="bi bi-tag-fill me-2 text-primary"></i>
                <strong>Type:</strong> {{ $room->type }}
            </p>

            <p class="mb-2">
                <i class="bi bi-circle-fill me-2 {{ $room->status === 'Available' ? 'text-success' : 'text-danger' }}"></i>
                <strong>Status:</strong> {{ $room->status }}
            </p>

            <p class="mb-2">
                <i class="bi bi-currency-dollar me-2 text-warning"></i>
                <strong>Price per night:</strong> ${{ $room->price_per_night }}
            </p>

            <div class="mt-4">
                <h5>
                    <i class="bi bi-file-text me-2 text-info"></i>
                    Description
                </h5>
                <p>{{ $room->description }}</p>
            </div>

            <a href="{{ route('room.booking', $room->id) }}" class="btn btn-primary mt-4">
                <i class="bi bi-calendar-check me-2"></i>Book This Room
            </a>
        </div>
    </div>
</div>
@endsection
