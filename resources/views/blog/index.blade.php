@extends('master')

@section('content')

<div class="container-fluid py-5 bg-light">
    <div class="container">
        <!-- Modern Section Header -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">Premium Stays</span>
                <h1 class="display-4 fw-bold text-dark mb-3">Hotel Accommodation</h1>
                <p class="lead text-muted">Discover luxury and comfort in our thoughtfully designed rooms, where modern amenities meet exceptional service.</p>
            </div>
        </div>

        <!-- Modern Room Cards Grid -->
        <div class="row g-4">
            @foreach ($rooms as $room)
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 overflow-hidden position-relative">
                    <!-- Image with Overlay -->
                    <div class="position-relative overflow-hidden">
                        <img src="{{ asset('storage/' . $room->image) }}" 
                             class="card-img-top" 
                             alt="{{ $room->name }}" 
                             style="height: 250px; object-fit: cover; transition: transform 0.3s ease;">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-primary rounded-pill px-3 py-2 fw-semibold">
                                ${{ $room->price_per_night }}/night
                            </span>
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title fw-bold text-uppercase mb-0 text-primary">
                                {{ $room->type }}
                            </h5>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        
                        <p class="card-text text-muted mb-4 lh-base">
                            {!! Str::limit($room->description, 100) !!}
                        </p>

                        <!-- Features -->
                        <div class="row g-2 mb-4">
                            <div class="col-6">
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fas fa-wifi text-primary me-2"></i>Free WiFi
                                </small>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fas fa-car text-primary me-2"></i>Parking
                                </small>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fas fa-utensils text-primary me-2"></i>Breakfast
                                </small>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-flex align-items-center">
                                    <i class="fas fa-swimming-pool text-primary me-2"></i>Pool
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card-footer bg-transparent border-0 p-4 pt-0">
                        <div class="d-grid gap-2">
                            <a href="{{ route('rooms.show', $room->id) }}" 
                               class="btn btn-outline-primary btn-lg fw-semibold">
                                <i class="fas fa-eye me-2"></i>View Details
                            </a>
                            <a href="{{ route('room.booking', $room->id) }}" 
                               class="btn btn-primary btn-lg fw-semibold">
                                <i class="fas fa-calendar-check me-2"></i>Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Call to Action -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8 text-center">
                <div class="bg-primary rounded-4 p-5 text-white">
                    <h3 class="fw-bold mb-3">Need Help Choosing?</h3>
                    <p class="mb-4">Our hospitality experts are here to help you find the perfect accommodation for your stay.</p>
                    <button class="btn btn-light btn-lg fw-semibold">
                        <i class="fas fa-phone me-2"></i>Contact Us
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.card:hover img {
    transform: scale(1.05);
}

.card:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
}

.badge {
    font-size: 0.75rem;
}

@media (max-width: 768px) {
    .display-4 {
        font-size: 2rem;
    }
    
    .card-footer .d-grid {
        gap: 0.5rem;
    }
    
    .btn-lg {
        font-size: 0.9rem;
        padding: 0.75rem 1rem;
    }
}
</style>
    
@endpush


@endsection