@extends('master')

@section('content')
<div class="container-fluid py-5 mt-5 bg-light">
    <div class="container">
        <!-- Modern Header Section -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-10">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary rounded-circle p-3 me-3">
                        <i class="fas fa-history text-white fs-4"></i>
                    </div>
                    <div>
                        <h1 class="display-5 fw-bold text-dark mb-0">Booking History</h1>
                        <p class="text-muted mb-0">Track all your reservations and stays</p>
                    </div>
                </div>
                
                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3 col-6">
                        <div class="card border-0 bg-primary text-white">
                            <div class="card-body text-center py-3">
                                <h4 class="fw-bold mb-1">{{ $bookings->count() }}</h4>
                                <small class="opacity-75">Total Bookings</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card border-0 bg-success text-white">
                            <div class="card-body text-center py-3">
                                <h4 class="fw-bold mb-1">{{ $bookings->where('status', 'confirmed')->count() }}</h4>
                                <small class="opacity-75">Confirmed</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card border-0 bg-warning text-white">
                            <div class="card-body text-center py-3">
                                <h4 class="fw-bold mb-1">{{ $bookings->where('status', 'pending')->count() }}</h4>
                                <small class="opacity-75">Pending</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card border-0 bg-info text-white">
                            <div class="card-body text-center py-3">
                                <h4 class="fw-bold mb-1">{{ $bookings->where('status', 'completed')->count() }}</h4>
                                <small class="opacity-75">Completed</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modern Booking Cards -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @if($bookings->count() > 0)
                    <div class="row g-4">
                        @foreach ($bookings as $booking)
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-transparent border-0 pb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="text-muted mb-1">Booking ID</h6>
                                            <h5 class="fw-bold text-primary mb-0">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</h5>
                                        </div>
                                        <div class="text-end">
                                            @if($booking->status == 'confirmed')
                                                <span class="badge bg-success rounded-pill px-3 py-2">
                                                    <i class="fas fa-check me-1"></i>Confirmed
                                                </span>
                                            @elseif($booking->status == 'pending')
                                                <span class="badge bg-warning rounded-pill px-3 py-2">
                                                    <i class="fas fa-clock me-1"></i>Pending
                                                </span>
                                            @elseif($booking->status == 'completed')
                                                <span class="badge bg-info rounded-pill px-3 py-2">
                                                    <i class="fas fa-flag-checkered me-1"></i>Completed
                                                </span>
                                            @else
                                                <span class="badge bg-secondary rounded-pill px-3 py-2">
                                                    <i class="fas fa-times me-1"></i>{{ ucfirst($booking->status) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                    <!-- Room Info -->
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-light rounded-circle p-2 me-3">
                                            <i class="fas fa-bed text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0">{{ $booking->room->type }}</h6>
                                            <small class="text-muted">Room Type</small>
                                        </div>
                                    </div>

                                    <!-- Date Range -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-6">
                                            <div class="border rounded p-3 text-center">
                                                <i class="fas fa-calendar-plus text-success mb-2"></i>
                                                <div class="fw-bold">{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</div>
                                                <small class="text-muted">Check-in</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="border rounded p-3 text-center">
                                                <i class="fas fa-calendar-minus text-danger mb-2"></i>
                                                <div class="fw-bold">{{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</div>
                                                <small class="text-muted">Check-out</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Duration & Price -->
                                    <div class="row g-3 mb-3">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-moon text-primary me-2"></i>
                                                <div>
                                                    <div class="fw-bold">{{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }} nights</div>
                                                    <small class="text-muted">Duration</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-dollar-sign text-success me-2"></i>
                                                <div>
                                                    <div class="fw-bold">${{ $booking->total_amount ?? ($booking->room->price_per_night * \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out))) }}</div>
                                                    <small class="text-muted">Total Amount</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer bg-transparent border-0">
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-primary btn-sm flex-fill">
                                            <i class="fas fa-eye me-1"></i>View Details
                                        </button>
                                        @if($booking->status == 'pending')
                                            <button class="btn btn-sm btn-outline-danger" 
                                                    onclick="confirmCancellation({{ $booking->id }}, '{{ $booking->room->type ?? 'Room' }}', '{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}', '{{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}', {{ $booking->total_amount ?? ($booking->room->price_per_night * \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out))) }})">
                                                <i class="fas fa-times me-1"></i>Cancel
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-calendar-times text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h3 class="fw-bold text-muted mb-3">No Bookings Found</h3>
                        <p class="text-muted mb-4">You haven't made any reservations yet. Start exploring our rooms!</p>
                        <a href="{{ route('rooms.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-search me-2"></i>Browse Rooms
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Cancellation Modal -->
<div class="modal fade" id="cancelBookingModal" tabindex="-1" aria-labelledby="cancelBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger" id="cancelBookingModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Cancel Booking
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center px-4">
                <div class="mb-4">
                    <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                </div>
                <h6 class="mb-3 fw-bold">Are you sure you want to cancel this booking?</h6>
                
                <div class="alert alert-info text-start mb-3">
                    <strong>Booking Details:</strong><br>
                    <div class="row mt-2">
                        <div class="col-4"><strong>Room:</strong></div>
                        <div class="col-8"><span id="cancelRoomType"></span></div>
                    </div>
                    <div class="row">
                        <div class="col-4"><strong>Check-in:</strong></div>
                        <div class="col-8"><span id="cancelCheckIn"></span></div>
                    </div>
                    <div class="row">
                        <div class="col-4"><strong>Check-out:</strong></div>
                        <div class="col-8"><span id="cancelCheckOut"></span></div>
                    </div>
                    <div class="row">
                        <div class="col-4"><strong>Total:</strong></div>
                        <div class="col-8">$<span id="cancelAmount"></span></div>
                    </div>
                </div>
                
                <div class="alert alert-warning text-start">
                    <strong><i class="fas fa-info-circle me-2"></i>Refund Policy:</strong><br>
                    <small class="text-muted">
                        • Cancellations made 24 hours before check-in: Full refund<br>
                        • Cancellations within 24 hours: 50% refund<br>
                        • No-show: No refund
                    </small>
                </div>
                
                <p class="text-muted small mb-0">
                    <i class="fas fa-warning me-1"></i>This action cannot be undone.
                </p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    <i class="fas fa-shield-alt me-2"></i>Keep Booking
                </button>
                <form id="cancelForm" method="POST" style="display: inline-block;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="cancelReason" name="reason" value="user_cancelled">
                    <button type="submit" class="btn btn-danger px-4" id="confirmCancelBtn">
                        <i class="fas fa-times me-2"></i>Yes, Cancel Booking
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.badge {
    font-size: 0.75rem;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.modal-content {
    border-radius: 15px;
}

.modal-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px 15px 0 0;
}

@media (max-width: 768px) {
    .display-5 {
        font-size: 1.5rem;
    }
    
    .row.g-3 .col-6 {
        margin-bottom: 0.5rem;
    }
    
    .modal-dialog {
        margin: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
function confirmCancellation(bookingId, roomType, checkIn, checkOut, totalAmount) {
    // Set booking details in modal
    document.getElementById('cancelRoomType').textContent = roomType;
    document.getElementById('cancelCheckIn').textContent = checkIn;
    document.getElementById('cancelCheckOut').textContent = checkOut;
    document.getElementById('cancelAmount').textContent = totalAmount;
    
    // Set form action URL
    document.getElementById('cancelForm').action = `/bookings/${bookingId}/cancel`;
    
    // Show the modal
    var cancelModal = new bootstrap.Modal(document.getElementById('cancelBookingModal'));
    cancelModal.show();
}

// Handle form submission with loading state
document.getElementById('cancelForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('confirmCancelBtn');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Cancelling...';
    submitBtn.disabled = true;
});

// Reset button state when modal is hidden
document.getElementById('cancelBookingModal').addEventListener('hidden.bs.modal', function() {
    const submitBtn = document.getElementById('confirmCancelBtn');
    submitBtn.innerHTML = '<i class="fas fa-times me-2"></i>Yes, Cancel Booking';
    submitBtn.disabled = false;
});
</script>
@endpush