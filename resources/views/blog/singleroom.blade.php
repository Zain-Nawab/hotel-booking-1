@extends('master')

@push('styles')
<style>
    :root {
        --primary-color: #6366f1;
        --primary-hover: #4f46e5;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
        --info-color: #06b6d4;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-600: #4b5563;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }

    .modern-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .availability-card {
        background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--gray-200);
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }

    .availability-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--info-color));
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .modern-input {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.2s ease;
        background: white;
        color: var(--gray-800);
    }

    .modern-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgb(99 102 241 / 0.1);
        transform: translateY(-1px);
    }

    .modern-input:hover {
        border-color: var(--gray-300);
    }

    .btn-modern {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        color: white;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        box-shadow: var(--shadow-md);
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-xl);
        color: white;
        text-decoration: none;
    }

    .btn-modern:active {
        transform: translateY(0);
    }

    .btn-modern.btn-full {
        width: 100%;
    }

    .btn-modern:disabled,
    .btn-modern.disabled {
        background: var(--gray-300);
        cursor: not-allowed;
        transform: none;
        box-shadow: var(--shadow-sm);
    }

    .alert-modern {
        padding: 1.25rem 1.5rem;
        border-radius: 16px;
        border: none;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
        box-shadow: var(--shadow-md);
    }

    .alert-success {
        background: linear-gradient(135deg, #dcfce7 0%, #f0fdf4 100%);
        color: #166534;
        border-left: 4px solid var(--success-color);
    }

    .alert-danger {
        background: linear-gradient(135deg, #fef2f2 0%, #fef7f7 100%);
        color: #991b1b;
        border-left: 4px solid var(--danger-color);
    }

    .room-showcase {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        margin-top: 3rem;
    }

    .room-image-container {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }

    .room-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .room-image:hover {
        transform: scale(1.05);
    }

    .room-details {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--gray-200);
    }

    .room-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--gray-900);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: var(--gray-50);
        border-radius: 12px;
        transition: all 0.2s ease;
    }

    .detail-item:hover {
        background: var(--gray-100);
        transform: translateX(4px);
    }

    .detail-label {
        font-weight: 600;
        color: var(--gray-700);
    }

    .detail-value {
        color: var(--gray-900);
        font-weight: 500;
    }

    .price-highlight {
        background: linear-gradient(135deg, #fef3c7 0%, #fef7cd 100%);
        border: 2px solid var(--warning-color);
        font-size: 1.125rem;
        font-weight: 700;
    }

    .total-price-highlight {
        background: linear-gradient(135deg, #dcfce7 0%, #f0fdf4 100%);
        border: 2px solid var(--success-color);
        font-size: 1.125rem;
        font-weight: 700;
    }

    .description-section {
        margin-top: 2rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
        border-radius: 16px;
        border: 1px solid var(--gray-200);
    }

    .description-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .description-text {
        color: var(--gray-600);
        line-height: 1.6;
        font-size: 1rem;
    }

    .booking-section {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid var(--gray-100);
    }

    .loading-spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 2px solid transparent;
        border-top: 2px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr 200px;
        gap: 1.5rem;
        align-items: end;
    }

    @media (max-width: 768px) {
        .modern-container {
            padding: 1rem;
        }
        
        .room-showcase {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .availability-card {
            padding: 1.5rem;
        }
        
        .room-details {
            padding: 1.5rem;
        }
    }

    /* Animation for form submission */
    .form-submitting .loading-spinner {
        display: inline-block;
    }
    
    .form-submitting .btn-text {
        display: none;
    }
</style>
@endpush

@section('content')
<div class="modern-container py-5 mt-5">
    <!-- Availability Check Section -->
    <div class="availability-card">
        <h4 class="section-title">
            <i class="bi bi-calendar-range text-primary"></i>
            Check Room Availability
        </h4>
        
        <form action="{{ route('room.check-availability', $room->id) }}" method="GET" id="availabilityForm">
            <div class="form-row">
                <div class="form-group">
                    <label for="check_in" class="form-label">
                        <i class="bi bi-calendar-check"></i>Check-in Date
                    </label>
                    <input type="date" 
                           class="modern-input" 
                           id="check_in" 
                           name="check_in" 
                           value="{{ request('check_in') }}"
                           min="{{ date('Y-m-d') }}"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="check_out" class="form-label">
                        <i class="bi bi-calendar-x"></i>Check-out Date
                    </label>
                    <input type="date" 
                           class="modern-input" 
                           id="check_out" 
                           name="check_out" 
                           value="{{ request('check_out') }}"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn-modern btn-full">
                        <div class="loading-spinner"></div>
                        <span class="btn-text">
                            <i class="bi bi-search"></i>
                            Check Now
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Availability Status -->
    @if(request('check_in') && request('check_out'))
        @if(isset($isAvailable))
            @if($isAvailable)
                <div class="alert-modern alert-success mt-5">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <div>
                        <strong>Excellent!</strong> This room is available for your selected dates.
                        <br><small>You can proceed with the booking.</small>
                    </div>
                </div>
            @else
                <div class="alert-modern alert-danger mt-5">
                    <i class="bi bi-x-circle-fill fs-5"></i>
                    <div>
                        <strong>Unfortunately,</strong> this room is not available for your selected dates.
                        <br><small>Please try different dates.</small>
                    </div>
                </div>
            @endif
        @endif
    @endif

    <!-- Room Showcase -->
    <div class="room-showcase">
        <div class="room-image-container">
            <img src="{{ asset('storage/'.$room->image) }}" 
                 class="room-image" 
                 alt="Room {{ $room->room_number }}"
                 loading="lazy">
        </div>
        
        <div class="room-details">
            <h1 class="room-title">
                <i class="bi bi-door-open-fill text-primary"></i>
                Room {{ $room->room_number }}
            </h1>

            <div class="detail-item">
                <i class="bi bi-tag-fill text-primary"></i>
                <span class="detail-label">Room Type:</span>
                <span class="detail-value">{{ $room->type }}</span>
            </div>

            <div class="detail-item">
                <i class="bi bi-circle-fill {{ $room->status === 'available' ? 'text-success' : 'text-danger' }}"></i>
                <span class="detail-label">Status:</span>
                <span class="detail-value text-capitalize">{{ $room->status }}</span>
            </div>

            <div class="detail-item price-highlight">
                <i class="bi bi-currency-dollar text-warning"></i>
                <span class="detail-label">Price per night:</span>
                <span class="detail-value">${{ number_format($room->price_per_night, 2) }}</span>
            </div>

            @if(request('check_in') && request('check_out'))
                @php
                    $nights = \Carbon\Carbon::parse(request('check_in'))->diffInDays(\Carbon\Carbon::parse(request('check_out')));
                    $totalPrice = $room->price_per_night * $nights;
                @endphp
                
                <div class="detail-item">
                    <i class="bi bi-calendar-range text-info"></i>
                    <span class="detail-label">Total nights:</span>
                    <span class="detail-value">{{ $nights }} {{ $nights == 1 ? 'night' : 'nights' }}</span>
                </div>
                
                <div class="detail-item total-price-highlight">
                    <i class="bi bi-calculator text-success"></i>
                    <span class="detail-label">Total price:</span>
                    <span class="detail-value">${{ number_format($totalPrice, 2) }}</span>
                </div>
            @endif

            <div class="description-section">
                <h5 class="description-title">
                    <i class="bi bi-file-text text-info"></i>
                    Room Description
                </h5>
                <p class="description-text">{!! $room->description !!}</p>
            </div>

            <div class="booking-section">
                @php
                    $bookingUrl = route('room.booking', $room->id);
                    if(request('check_in') && request('check_out')) {
                        $bookingUrl .= '?check_in=' . request('check_in') . '&check_out=' . request('check_out');
                    }
                    $isDisabled = (request('check_in') && request('check_out') && isset($isAvailable) && !$isAvailable);
                @endphp

                <a href="{{ $bookingUrl }}" 
                   class="btn-modern btn-full {{ $isDisabled ? 'disabled' : '' }}"
                   {{ $isDisabled ? 'aria-disabled=true' : '' }}>
                    <i class="bi bi-calendar-check"></i>
                    {{ $isDisabled ? 'Room Not Available' : 'Book This Room Now' }}
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const form = document.getElementById('availabilityForm');
    
    // Enhanced date validation
    function updateCheckOutMin() {
        if (checkInInput.value) {
            const checkInDate = new Date(checkInInput.value);
            const nextDay = new Date(checkInDate);
            nextDay.setDate(checkInDate.getDate() + 1);
            
            checkOutInput.min = nextDay.toISOString().split('T')[0];
            
            if (checkOutInput.value && new Date(checkOutInput.value) <= checkInDate) {
                checkOutInput.value = '';
                showToast('Please select a check-out date after the check-in date', 'warning');
            }
        }
    }
    
    checkInInput.addEventListener('change', updateCheckOutMin);
    
    // Form submission with loading state
    form.addEventListener('submit', function() {
        this.classList.add('form-submitting');
        setTimeout(() => {
            this.classList.remove('form-submitting');
        }, 3000);
    });
    
    // Simple toast notification function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `alert-modern alert-${type} position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = `
            <i class="bi bi-info-circle-fill"></i>
            <div class='mt-5'>${message}</div>
        `;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
    
    // Initialize check-out min date on page load
    updateCheckOutMin();
});
</script>
@endsection

@section('footer')
@include('partials.footer')
@endsection