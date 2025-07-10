@extends('master')
@section('title', 'Dashboard')

@push('styles')
<style>
    .gradient-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .gradient-card-2 {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    .gradient-card-3 {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    .gradient-card-4 {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }
    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.8;
    }
    .progress-circle {
        width: 60px;
        height: 60px;
    }
    .avatar-circle {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 20px;
        height: 20px;
        background: #dc3545;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="content container-fluid py-5 mt-5">
     @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Please fix the following errors:</strong>
                </div>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li><i class="bi bi-arrow-right me-1"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        
        <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-3" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Success Alert -->
    @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-3" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
        

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark mb-1 text-uppercase">
                Welcome back, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-muted mb-0">Here's what's happening with your bookings today.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('rooms.index') }}" class="btn btn-primary text-white"><i class="bi bi-plus-circle me-1"></i> New Booking</a>
            <div class="position-relative">
                <button class="btn btn-outline-secondary"><i class="bi bi-bell"></i></button>
                <span class="notification-badge">3</span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm gradient-card h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75">Total Bookings</p>
                            <h3 class="fw-bold mb-0">{{ $totalBookings }}</h3>
                            <small class="opacity-75">
                                <i class="bi bi-arrow-up"></i> 12% from last month
                            </small>
                        </div>
                        <i class="bi bi-calendar-check stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm gradient-card-2 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75">Total Spent</p>
                            <h3 class="fw-bold mb-0">${{ number_format($totalRevenue ?? 0, 2) }}</h3>
                            <small class="opacity-75">
                                <i class="bi bi-arrow-up"></i> $250 this month
                            </small>
                        </div>
                        <i class="bi bi-currency-dollar stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm gradient-card-3 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75">Nights Stayed</p>
                            <h3 class="fw-bold mb-0">{{ $totalNights ?? 0 }}</h3>
                            <small class="opacity-75">
                                <i class="bi bi-moon"></i> Across {{ $totalBookings }} bookings
                            </small>
                        </div>
                        <i class="bi bi-moon-stars stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm gradient-card-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75">Loyalty Points</p>
                            <h3 class="fw-bold mb-0">{{ $loyaltyPoints ?? 0 }}</h3>
                            <small class="opacity-75">
                                <i class="bi bi-star"></i> Earn more points!
                            </small>
                        </div>
                        <i class="bi bi-star-fill stat-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Status -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <!-- Recent Activity -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Bookings</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Booking</th>
                                    <th>Room</th>
                                    <th>Dates</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $booking)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <i class="bi bi-house text-white"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Booking #{{ $booking->id }}</h6>
                                                <small class="text-muted">{{ $booking->created_at->format('M d, Y') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $booking->room->type ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">Room {{ $booking->room->room_number ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ \Carbon\Carbon::parse($booking->check_in)->format('M d') }}</strong> - 
                                            <strong>{{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</strong>
                                        </div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($booking->check_in)->diffInDays($booking->check_out) }} nights
                                        </small>
                                    </td>
                                    <td>
                                        @if($booking->status == 'confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                        @elseif($booking->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($booking->status == 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>${{ number_format($booking->room->price_per_night ?? 0, 2) }}</strong>
                                    </td>
                                    <td class="text-end pe-2">
                                        <div class="btn-group">
                                            <a href="{{ route('rooms.show', $booking->room->id) }}" class="btn btn-sm btn-outline-primary mt-1">
                                                <i class="bi bi-eye me-1"></i>View
                                            </a>
                                            
                                            @php
                                                $canCancel = $booking->status == 'pending' || 
                                                            ($booking->status == 'confirmed' && \Carbon\Carbon::parse($booking->check_in)->gt(now()->addHours(24)));
                                                $hasUnpaidPayment = $booking->where('status', 'pending')->count() > 0;
                                                
                                            @endphp
                                            
                                            @if ($booking->status !== 'confirmed')
                                                @if($canCancel)
                                                <button class="btn btn-sm btn-outline-danger mt-1" 
                                                        onclick="confirmCancellation({{ $booking->id }}, '{{ $booking->room->type ?? 'Room' }}', {{ $hasUnpaidPayment ? 'true' : 'false' }})">
                                                    <i class="bi bi-x-circle me-1"></i>Cancel
                                                </button>
                                            @endif
                                            @endif
                                            
        
                                           
                                        </div>
                                         @if($hasUnpaidPayment && $booking->status == 'pending')
                                                <a href="{{ route('payment.process', $booking->id) }}" class="btn btn-sm btn-warning mt-1 mr-4">
                                                    <i class="bi bi-credit-card me-1"></i>Pay Now
                                                </a>
                                            @endif
                                     </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="bi bi-calendar-x display-4 text-muted"></i>
                                        <p class="text-muted mt-2">No bookings found</p>
                                        <a href="{{ route('rooms.index') }}" class="btn btn-primary">Make Your First Booking</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Upcoming Check-ins -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Upcoming Check-ins</h5>
                </div>
                <div class="card-body p-0">
                    @forelse($upcomingBookings ?? [] as $upcoming)
                    <div class="p-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Room {{ $upcoming->room->room_number ?? 'N/A' }}</h6>
                                <p class="text-muted small mb-0">
                                    {{ \Carbon\Carbon::parse($upcoming->check_in)->format('M d, Y') }}
                                </p>
                            </div>
                            <span class="badge bg-primary">
                                {{ \Carbon\Carbon::parse($upcoming->check_in)->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center">
                        <i class="bi bi-calendar-plus display-5 text-muted"></i>
                        <p class="text-muted mt-2">No upcoming check-ins</p>
                    </div>
                    @endforelse
                    <div class="p-3">
                        <a href="{{ route('user.bookings.history') }}" class="btn btn-outline-primary btn-sm w-100">View All Bookings History</a>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Average Rating</span>
                        <div class="d-flex align-items-center">
                            <span class="me-2">{{ number_format($averageRating ?? 0, 1) }}</span>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= ($averageRating ?? 0))
                                    <i class="bi bi-star-fill text-warning"></i>
                                @else
                                    <i class="bi bi-star text-muted"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Member Since</span>
                        <span class="fw-bold">{{ auth()->user()->created_at->format('M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Status</span>
                        @if(($loyaltyPoints ?? 0) > 1000)
                            <span class="badge bg-warning">Gold Member</span>
                        @elseif(($loyaltyPoints ?? 0) > 500)
                            <span class="badge bg-info">Silver Member</span>
                        @else
                            <span class="badge bg-secondary">Bronze Member</span>
                        @endif
                    </div>
                    <hr>
                    <button class="btn btn-outline-success btn-sm w-100">
                        <i class="bi bi-download me-1"></i> Download Booking History
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    @if(isset($recentReviews) && $recentReviews->count() > 0)
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">My Recent Reviews</h5>
            <a href="#" class="btn btn-sm btn-outline-primary">Write Review</a>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($recentReviews as $review)
                <div class="col-md-6 mb-3">
                    <div class="border rounded p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="mb-0">{{ $review->room->type ?? 'N/A' }}</h6>
                            <div class="d-flex">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="bi bi-star-fill text-warning"></i>
                                    @else
                                        <i class="bi bi-star text-muted"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <p class="text-muted small mb-0">{{ Str::limit($review->comment, 100) }}</p>
                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Cancellation Modal -->
 <div class="modal fade" id="cancelBookingModal" tabindex="-1" aria-labelledby="cancelBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="cancelBookingModalLabel">Cancel Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-4">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                </div>
                <h6 class="mb-3">Are you sure you want to cancel this booking?</h6>
                <div class="alert alert-info text-start">
                    <strong>Booking Details:</strong><br>
                    <span id="cancelRoomType"></span><br>
                    <small id="cancelPolicy" class="text-muted"></small>
                </div>
                <div id="refundInfo" class="alert alert-warning text-start" style="display: none;">
                    <strong>Refund Policy:</strong><br>
                    <span id="refundDetails"></span>
                </div>
                <p class="text-muted small">This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    <i class="bi bi-shield-check me-2"></i>Keep Booking
                </button>
                <form id="cancelForm" method="POST" style="display: inline-block;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="cancelReason" name="reason" value="user_cancelled">
                    <button type="submit" class="btn btn-danger px-4" id="confirmCancelBtn">
                        <i class="bi bi-x-circle me-2"></i>Yes, Cancel Booking
                    </button>
                </form>
            </div>
        </div>
    </div>
 </div>
</div>
@endsection

@push('scripts')
<script>
function confirmCancellation(bookingId, roomType, hasUnpaidPayment) {
    const modal = new bootstrap.Modal(document.getElementById('cancelBookingModal'));
    const form = document.getElementById('cancelForm');
    const roomTypeSpan = document.getElementById('cancelRoomType');
    const policySpan = document.getElementById('cancelPolicy');
    const refundInfo = document.getElementById('refundInfo');
    const refundDetails = document.getElementById('refundDetails');
    const confirmBtn = document.getElementById('confirmCancelBtn');
    
    // Set form action
    form.action = `/bookings/${bookingId}/cancel`;
    
    // Set room type
    roomTypeSpan.textContent = roomType + ' - Booking #' + bookingId;
    
    // Set policy based on payment status
    if (hasUnpaidPayment) {
        policySpan.textContent = 'No payment has been made yet.';
        refundDetails.textContent = 'No charges will be applied since payment is still pending.';
        refundInfo.style.display = 'block';
        confirmBtn.innerHTML = '<i class="bi bi-x-circle me-2"></i>Cancel Booking';
        confirmBtn.className = 'btn btn-warning px-4';
    } else {
        policySpan.textContent = 'Cancellation may be subject to fees based on timing.';
        refundDetails.textContent = 'Refund will be processed according to our cancellation policy within 5-7 business days.';
        refundInfo.style.display = 'block';
        confirmBtn.innerHTML = '<i class="bi bi-x-circle me-2"></i>Yes, Cancel Booking';
        confirmBtn.className = 'btn btn-danger px-4';
    }
    
    modal.show();
}

// Handle modal events
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('cancelBookingModal');
    const form = document.getElementById('cancelForm');
    
    // Handle modal close events
    modal.addEventListener('hidden.bs.modal', function () {
        console.log('Modal closed - booking kept');
        // Reset form state
        const submitBtn = document.getElementById('confirmCancelBtn');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="bi bi-x-circle me-2"></i>Yes, Cancel Booking';
    });
    
    // Handle form submission with loading state (REMOVED DOUBLE CONFIRMATION)
    form.addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('confirmCancelBtn');
        
        // Show loading state
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Cancelling...';
        submitBtn.disabled = true;
        
        // Form will submit normally without additional confirmation
        return true;
    });
    
    // Ensure all modal close buttons work properly
    const modalElement = document.getElementById('cancelBookingModal');
    const closeButtons = modalElement.querySelectorAll('[data-bs-dismiss="modal"], .btn-close');
    
    closeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (modalInstance) {
                modalInstance.hide();
            }
            console.log('User chose to keep the booking');
        });
    });
});

// Auto-refresh booking status every 5 minutes
setInterval(function() {
    fetch('/user/bookings/status-check')
        .then(response => response.json())
        .then(data => {
            if (data.cancelled_bookings && data.cancelled_bookings.length > 0) {
                showCancellationNotification(data.cancelled_bookings);
            }
        })
        .catch(error => console.log('Status check failed'));
}, 500000);

function showCancellationNotification(cancelledBookings) {
    cancelledBookings.forEach(booking => {
        const toast = document.createElement('div');
        toast.className = 'toast position-fixed top-0 end-0 m-3';
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="toast-header bg-warning">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong class="me-auto">Booking Cancelled</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                Booking #${booking.id} was automatically cancelled due to non-payment.
            </div>
        `;
        document.body.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast, {
            autohide: true,
            delay: 5000
        });
        bsToast.show();
        
        // Clean up and refresh
        toast.addEventListener('hidden.bs.toast', function() {
            document.body.removeChild(toast);
            location.reload();
        });
    });
}
</script>
@endpush