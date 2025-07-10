@extends('master')

@push('styles')
<style>
    .booking-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 50px 0;
    }
    
    .booking-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        padding: 40px;
        max-width: 600px;
        margin: 0 auto;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 15px 20px;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        transform: translateY(-2px);
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 10px;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .icon-input {
        position: relative;
    }
    
    .icon-input i {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 18px;
        z-index: 10;
        cursor: pointer;
        transition: color 0.3s ease;
    }
    
    .icon-input i:hover {
        color: #667eea;
    }
    
    /* Hide native date picker indicator */
    input[type="date"]::-webkit-calendar-picker-indicator {
        opacity: 0;
        position: absolute;
        right: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .btn-booking {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 12px;
        padding: 15px 30px;
        font-size: 18px;
        font-weight: 600;
        color: white;
        width: 100%;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .btn-booking:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(40, 167, 69, 0.4);
        background: linear-gradient(135deg, #218838 0%, #1e7e34 100%);
    }
    
    .btn-booking:disabled {
        background: #6c757d !important;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }
    
    .room-info {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        border-left: 5px solid #667eea;
    }
    
    .room-title {
        color: #495057;
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    .price-info {
        background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
        color: white;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
        margin-top: 20px;
    }
    
    .availability-status {
        padding: 15px;
        border-radius: 10px;
        margin-top: 20px;
        text-align: center;
    }
    
    .available {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }
    
    .unavailable {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }
    
    .checking {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: white;
    }
    
    .alert-danger {
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }
    
    .pulse {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .floating {
        animation: floating 3s ease-in-out infinite;
    }
    
    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
    }
</style>
@endpush

@section('content')
<div class="booking-container">
    <div class="container">
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

        <div class="booking-card floating">
            <!-- Room Information Header -->
            <div class="room-info">
                <h2 class="room-title">
                    <i class="bi bi-door-open-fill me-2 text-primary"></i>
                    Booking Room #{{ $room->room_number }}
                </h2>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <i class="bi bi-tag-fill me-2 text-info"></i>
                            <strong>Type:</strong> {{ $room->type }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <i class="bi bi-currency-dollar me-2 text-success"></i>
                            <strong>Price:</strong> ${{ $room->price_per_night }}/night
                        </p>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <form action="{{ route('room.book.store', $room->id) }}" method="POST" id="bookingForm">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="check_in" class="form-label">
                            <i class="bi bi-calendar-check me-1"></i>Check-In Date
                        </label>
                        <div class="icon-input">
                            <input type="date" 
                                   class="form-control" 
                                   id="check_in"
                                   name="check_in" 
                                   value="{{ request('check_in') }}"
                                   min="{{ date('Y-m-d') }}"
                                   required
                                   onclick="this.showPicker()">
                            <i class="bi bi-calendar-event" onclick="document.getElementById('check_in').showPicker()"></i>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="check_out" class="form-label">
                            <i class="bi bi-calendar-x me-1"></i>Check-Out Date
                        </label>
                        <div class="icon-input">
                            <input type="date" 
                                   class="form-control" 
                                   id="check_out"
                                   name="check_out" 
                                   value="{{ request('check_out') }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   required
                                   onclick="this.showPicker()">
                            <i class="bi bi-calendar-event" onclick="document.getElementById('check_out').showPicker()"></i>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="guests" class="form-label">
                        <i class="bi bi-people me-1"></i>Number of Guests
                    </label>
                    <div class="icon-input">
                        <input type="number" 
                               class="form-control" 
                               id="guests"
                               name="guests" 
                               min="1" 
                               max="6"
                               value="1"
                               required>
                        <i class="bi bi-person-fill"></i>
                    </div>
                </div>

                <!-- Availability Status -->
                <div class="availability-status d-none" id="availabilityStatus">
                    <div id="availabilityContent"></div>
                </div>

                <!-- Price Calculation -->
                <div class="price-info" id="priceInfo" style="display: none;">
                    <div class="row text-center">
                        <div class="col-4">
                            <i class="bi bi-calendar-range d-block mb-1"></i>
                            <small>Nights</small>
                            <div class="fw-bold" id="totalNights">0</div>
                        </div>
                        <div class="col-4">
                            <i class="bi bi-currency-dollar d-block mb-1"></i>
                            <small>Per Night</small>
                            <div class="fw-bold">${{ $room->price_per_night }}</div>
                        </div>
                        <div class="col-4">
                            <i class="bi bi-calculator d-block mb-1"></i>
                            <small>Total</small>
                            <div class="fw-bold" id="totalPrice">$0</div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-booking pulse mt-4" id="bookingBtn" disabled>
                    <i class="bi bi-credit-card me-2"></i>
                    <span id="bookingBtnText">Select Dates to Continue</span>
                    <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </form>

            <!-- Additional Information -->
            <div class="mt-4 text-center">
                <small class="text-muted">
                    <i class="bi bi-shield-check me-1"></i>
                    Secure booking • Free cancellation up to 24 hours
                </small>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    const priceInfo = document.getElementById('priceInfo');
    const totalNights = document.getElementById('totalNights');
    const totalPrice = document.getElementById('totalPrice');
    const availabilityStatus = document.getElementById('availabilityStatus');
    const availabilityContent = document.getElementById('availabilityContent');
    const bookingBtn = document.getElementById('bookingBtn');
    const bookingBtnText = document.getElementById('bookingBtnText');
    const pricePerNight = {{ $room->price_per_night }};
    const roomId = {{ $room->id }};
    
    let isAvailable = false;
    let isChecking = false;
    
    // Enhanced calendar picker functionality
    function openDatePicker(inputElement) {
        if (typeof inputElement.showPicker === 'function') {
            inputElement.showPicker();
        } else {
            inputElement.focus();
            inputElement.click();
        }
    }
    
    // Add click handlers for calendar icons
    document.querySelectorAll('.icon-input i.bi-calendar-event').forEach(icon => {
        icon.addEventListener('click', function(e) {
            e.preventDefault();
            const input = this.parentElement.querySelector('input[type="date"]');
            if (input) {
                openDatePicker(input);
            }
        });
    });
    
    function updateButtonState() {
        if (isChecking) {
            bookingBtn.disabled = true;
            bookingBtnText.textContent = 'Checking Availability...';
        } else if (!checkInInput.value || !checkOutInput.value) {
            bookingBtn.disabled = true;
            bookingBtnText.textContent = 'Select Dates to Continue';
        } else if (isAvailable) {
            bookingBtn.disabled = false;
            bookingBtnText.textContent = 'Confirm Booking';
            bookingBtn.classList.add('pulse');
        } else {
            bookingBtn.disabled = true;
            bookingBtnText.textContent = 'Room Not Available';
            bookingBtn.classList.remove('pulse');
        }
    }
    
    function showAvailabilityStatus(status, message, icon) {
        availabilityStatus.className = `availability-status ${status}`;
        availabilityContent.innerHTML = `<i class="bi ${icon} me-2"></i>${message}`;
        availabilityStatus.classList.remove('d-none');
    }
    
    function hideAvailabilityStatus() {
        availabilityStatus.classList.add('d-none');
    }
    
    async function checkAvailability() {
        if (!checkInInput.value || !checkOutInput.value) {
            hideAvailabilityStatus();
            priceInfo.style.display = 'none';
            isAvailable = false;
            updateButtonState();
            return;
        }
        
        const checkInDate = new Date(checkInInput.value);
        const checkOutDate = new Date(checkOutInput.value);
        
        if (checkOutDate <= checkInDate) {
            hideAvailabilityStatus();
            priceInfo.style.display = 'none';
            isAvailable = false;
            updateButtonState();
            return;
        }
        
        isChecking = true;
        updateButtonState();
        
        showAvailabilityStatus('checking', 'Checking availability...', 'bi-hourglass-split');
        
        try {
            const response = await fetch(`/room/${roomId}/check-availability-json?check_in=${checkInInput.value}&check_out=${checkOutInput.value}`);
            const data = await response.json();
            
            isAvailable = data.available;
            
            if (data.available) {
                showAvailabilityStatus('available', 'Great! This room is available for your selected dates.', 'bi-check-circle-fill');
                
                // Calculate and show price
                const nights = Math.ceil((checkOutDate - checkInDate) / (1000 * 60 * 60 * 24));
                const total = nights * pricePerNight;
                
                totalNights.textContent = nights;
                totalPrice.textContent = '$' + total;
                priceInfo.style.display = 'block';
            } else {
                showAvailabilityStatus('unavailable', 'Sorry! This room is not available for your selected dates.', 'bi-x-circle-fill');
                priceInfo.style.display = 'none';
            }
        } catch (error) {
            console.error('Error checking availability:', error);
            showAvailabilityStatus('unavailable', 'Error checking availability. Please try again.', 'bi-exclamation-triangle-fill');
            isAvailable = false;
            priceInfo.style.display = 'none';
        }
        
        isChecking = false;
        updateButtonState();
    }
    
    checkInInput.addEventListener('change', function() {
        const checkInDate = new Date(this.value);
        const nextDay = new Date(checkInDate);
        nextDay.setDate(checkInDate.getDate() + 1);
        
        checkOutInput.min = nextDay.toISOString().split('T')[0];
        
        if (checkOutInput.value && new Date(checkOutInput.value) <= checkInDate) {
            checkOutInput.value = '';
        }
        
        checkAvailability();
    });
    
    checkOutInput.addEventListener('change', checkAvailability);
    
    // Form submission validation
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        if (!isAvailable || isChecking) {
            e.preventDefault();
            if (isChecking) {
                alert('Please wait while we check availability.');
            } else {
                alert('This room is not available for the selected dates.');
            }
            return false;
        }
    });
    
    // Initial check if dates are pre-filled
    if (checkInInput.value && checkOutInput.value) {
        checkAvailability();
    } else {
        updateButtonState();
    }
});
</script>
@endsection