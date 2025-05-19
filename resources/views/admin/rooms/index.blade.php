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

      <div class="table-responsive">
    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>Image</th>
                <th>Room #</th>
                <th>Type</th>
                <th>Price/Night</th>
                <th>Description</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rooms as $room)
                <tr>
                    <td style="width: 150px;">
                        @if($room->image)
                            <img src="{{ asset('storage/' . $room->image) }}" alt="Room Image" class="img-thumbnail" style="height: 80px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/150x80?text=No+Image" alt="No Image" class="img-thumbnail">
                        @endif
                    </td>
                    <td>Room #{{ $room->room_number }}</td>
                    <td>{{ ucfirst($room->type) }}</td>
                    <td>${{ number_format($room->price_per_night, 2) }}</td>
                    <td>{{ Str::limit($room->description, 80) }}</td>
                    <td class="text-end">
                        <a href="{{ route('room.edit', $room->id) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="{{ route('room.destroy', $room->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    @if($rooms->isEmpty())
        <div class="text-center text-muted mt-5">
            <h5>No rooms available.</h5>
        </div>
    @endif
</div>
@endsection
