@extends('admin.layout')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">All Rooms</h2>
        <a href="{{ route('room.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Create New Room
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($rooms as $room)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    @if($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}" class="card-img-top" alt="Room Image" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/400x200?text=No+Image" class="card-img-top" alt="No Image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">Room #{{ $room->room_number }}</h5>
                        <p class="card-text"><strong>Type:</strong> {{ ucfirst($room->type) }}</p>
                        <p class="card-text"><strong>Price/Night:</strong> ${{ number_format($room->price_per_night, 2) }}</p>
                        <p class="card-text">{{ $room->description }}</p>
                    </div>
                    <div class="card-footer text-end">
                        <a href="#" class="btn btn-primary btn-sm">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($rooms->isEmpty())
        <div class="text-center text-muted mt-5">
            <h5>No rooms available.</h5>
        </div>
    @endif
</div>
@endsection
