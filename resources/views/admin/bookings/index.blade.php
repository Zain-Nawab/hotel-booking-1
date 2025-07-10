@extends('admin.layout')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-5 fw-bold text-primary">Bookings Management</h1>
            <p class="text-muted">Manage and track all hotel reservations in one place</p>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="btn-group">
                <button type="button" class="btn btn-success">
                    <i class="bi bi-plus-lg me-1"></i> New Booking
                </button>
                <button type="button" class="btn btn-outline-secondary">
                    <i class="bi bi-download me-1"></i> Export
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="bi bi-calendar-check fs-4 text-primary"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Total Bookings</h6>
                            <h3 class="fw-bold mb-0">{{ $bookings->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                            <i class="bi bi-check-circle fs-4 text-success"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Confirmed</h6>
                            <h3 class="fw-bold mb-0">{{ $bookings->where('status', 'confirmed')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                            <i class="bi bi-hourglass-split fs-4 text-warning"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Pending</h6>
                            <h3 class="fw-bold mb-0">{{ $bookings->where('status', 'pending')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                            <i class="bi bi-x-circle fs-4 text-danger"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1">Cancelled</h6>
                            <h3 class="fw-bold mb-0">{{ $bookings->where('status', 'cancelled')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Advanced Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0">
                <i class="bi bi-funnel me-2"></i>Advanced Filters
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('bookings.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="searchQuery" name="search" placeholder="Search...">
                            <label for="searchQuery">Search Query</label>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select class="form-select" id="statusFilter" name="status">
                                <option value="" selected>All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="completed">Completed</option>
                            </select>
                            <label for="statusFilter">Booking Status</label>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="date" class="form-control" id="startDate" name="start_date">
                            <label for="startDate">Check-in Date</label>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="date" class="form-control" id="endDate" name="end_date">
                            <label for="endDate">Check-out Date</label>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="hstack gap-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-1"></i> Apply Filters
                            </button>
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i> Clear Filters
                            </button>
                            <div class="ms-auto">
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" name="view" id="listView" value="list" autocomplete="off" checked>
                                    <label class="btn btn-outline-primary" for="listView">
                                        <i class="bi bi-list"></i>
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="view" id="gridView" value="grid" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="gridView">
                                        <i class="bi bi-grid-3x3-gap"></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Bookings Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="card-title mb-0">Bookings List</h5>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-gear me-1"></i> Actions
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-check-all me-2"></i>Select All</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-trash me-2"></i>Delete Selected</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-file-earmark-excel me-2"></i>Export Selected</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-printer me-2"></i>Print List</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th scope="col">Booking ID</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Room Details</th>
                            <th scope="col">Check-in Date</th>
                            <th scope="col">Check-out Date</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td class="ps-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $booking->id }}">
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold">#{{ $booking->id }}</span>
                                <div class="small text-muted">{{ $booking->created_at->format('M d, Y') }}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <span>{{ strtoupper(substr($booking->user->name, 0, 2)) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $booking->user->name }}</div>
                                        <div class="small text-muted">{{ $booking->user->email ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">Room {{ $booking->room_number }}</span>
                                <div class="small text-muted mt-1">{{ $booking->room->type ?? 'Standard Room' }}</div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</td>
                            <td>
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-warning text-dark',
                                        'confirmed' => 'bg-success',
                                        'cancelled' => 'bg-danger',
                                        'completed' => 'bg-info'
                                    ];
                                    $statusClass = $statusClasses[$booking->status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ ucfirst($booking->status) }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="#" class="btn btn-outline-primary" data-bs-toggle="tooltip" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-success" data-bs-toggle="tooltip" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" onclick="confirmDelete({{ $booking->id }})" data-bs-toggle="tooltip" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>
                                    <h5>No Bookings Found</h5>
                                    <p>There are no bookings matching your criteria.</p>
                                    <a href="#" class="btn btn-sm btn-primary mt-2">Create New Booking</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-muted small">
            Showing <span class="fw-medium">{{ $bookings->count() }}</span> 
            @if(method_exists($bookings, 'total'))
                out of <span class="fw-medium">{{ $bookings->total() }}</span>
            @endif
            bookings
        </div>
        @if(method_exists($bookings, 'links'))
        <div>
            {{ $bookings->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
    </div>
</div>


@endsection

@push('styles')
<!-- Make sure to include Bootstrap 5 JS and Bootstrap Icons CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush

@push('scripts')


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Select all functionality
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('tbody .form-check-input');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
});

function confirmDelete(bookingId) {
    if (confirm('Are you sure you want to delete this booking?')) {
        // Add your delete logic here
        fetch(`/admin/bookings/${bookingId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Failed to delete booking');
            }
        }).catch(error => {
            console.error('Error:', error);
        });
    }
}
</script>
    
@endpush