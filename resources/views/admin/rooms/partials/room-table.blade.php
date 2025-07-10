<!-- filepath: c:\xampp\htdocs\1\hotel-booking\resources\views\admin\rooms\partials\room-table.blade.php -->
@forelse ($rooms as $room)
    <tr class="room-row" 
        data-room-number="{{ strtolower($room->room_number) }}" 
        data-room-type="{{ strtolower($room->type) }}" 
        data-description="{{ strtolower(strip_tags($room->description)) }}">
        
        <td class="align-middle">
            <div class="d-flex align-items-center">
                <img src="{{ asset('storage/'.$room->image) }}" 
                     class="rounded me-3" 
                     style="width: 50px; height: 50px; object-fit: cover;" 
                     alt="Room Image">
                <div>
                    <h6 class="mb-1">Room {{ $room->room_number }}</h6>
                    <small class="text-muted">{{ $room->type }}</small>
                </div>
            </div>
        </td>
        
        <td class="align-middle">
            <span class="badge bg-{{ $room->status === 'available' ? 'success' : ($room->status === 'booked' ? 'warning' : 'danger') }}">
                {{ ucfirst($room->status) }}
            </span>
        </td>
        
        <td class="align-middle">
            <strong>${{ number_format($room->price_per_night, 2) }}</strong>
        </td>
        
        <td class="align-middle">
            <p class="mb-0 text-muted">{{ Str::limit(strip_tags($room->description), 60) }}</p>
        </td>
        
        <td class="align-middle">
            <div class="btn-group" role="group">

                <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="View Room">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('room.edit', $room->id) }}" 
                   class="btn btn-sm btn-outline-warning"
                   data-bs-toggle="tooltip" title="Edit Room">
                    <i class="bi bi-pencil"></i>
                </a>
                <button type="button" class="btn btn-sm btn-outline-danger" 
                        data-bs-toggle="tooltip" title="Delete Room"
                        onclick="confirmDelete({{ $room->id }})">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center py-4">
            <div class="text-muted">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-2">No rooms found</p>
            </div>
        </td>
    </tr>
@endforelse