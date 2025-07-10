@extends('admin.layout')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css">
@endpush

@section('content')
<div class="content container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark mb-0">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard
        </h1>
        <div>
            <a href="{{ route('rooms.index') }}" class="btn btn-primary me-2"><i class="bi bi-plus-circle me-1"></i> New Booking</a>
            <button class="btn btn-outline-secondary"><i class="bi bi-download me-1"></i> Export Report</button>
        </div>
    </div>

    <!-- Status Overview Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100 position-relative overflow-hidden">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Rooms</p>
                            <h3 class="fw-bold mb-0">{{ $totalRooms }}</h3>
                            <p class="text-success small mt-2 mb-0"><i class="bi bi-arrow-up-short"></i> 4% from last week</p>
                        </div>
                        <div class="bg-light-info rounded-circle p-3">
                            <i class="bi bi-door-open text-info fs-4"></i>
                        </div>
                    </div>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100 bg-info" style="height: 4px;"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100 position-relative overflow-hidden">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Bookings</p>
                            <h3 class="fw-bold mb-0">{{ $totalBookings }}</h3>
                            <p class="text-success small mt-2 mb-0"><i class="bi bi-arrow-up-short"></i> 12% from last month</p>
                        </div>
                        <div class="bg-light-success rounded-circle p-3">
                            <i class="bi bi-calendar-check text-success fs-4"></i>
                        </div>
                    </div>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100 bg-success" style="height: 4px;"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100 position-relative overflow-hidden">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Customers</p>
                            <h3 class="fw-bold mb-0">{{ $totalUsers }}</h3>
                            <p class="text-success small mt-2 mb-0"><i class="bi bi-arrow-up-short"></i> 7% from last month</p>
                        </div>
                        <div class="bg-light-warning rounded-circle p-3">
                            <i class="bi bi-people text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100 bg-warning" style="height: 4px;"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 h-100 position-relative overflow-hidden">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Revenue</p>
                            <h3 class="fw-bold mb-0">${{ number_format($totalRevenue, 2) }}</h3>
                            <p class="text-success small mt-2 mb-0"><i class="bi bi-arrow-up-short"></i> 15% from last month</p>
                        </div>
                        <div class="bg-light-danger rounded-circle p-3">
                            <i class="bi bi-currency-dollar text-danger fs-4"></i>
                        </div>
                    </div>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100 bg-danger" style="height: 4px;"></div>
            </div>
        </div>
    </div>

    <!-- Charts & Data Visualization -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Booking Trends</h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-secondary active">Weekly</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Monthly</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Yearly</button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="bookingTrends" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Room Occupancy</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <canvas id="roomOccupancy" height="220"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings & Alerts -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Bookings</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Booking ID</th>
                                    <th>Guest</th>
                                    <th>Room</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Status</th>
                                    <th class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentBookings as $booking)
                                    <tr>
                                        <td class="ps-3">#{{ $booking->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <span class="text-primary">{{ strtoupper(substr($booking->user->name, 0, 2)) }}</span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $booking->user->name ?? 'N/A' }}</h6>
                                                    <small class="text-muted">{{ $booking->user->email ?? '' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Room {{ $booking->room->room_number ?? 'N/A' }}</td>
                                        <td>{{ isset($booking->check_in) ? date('M d, Y', strtotime($booking->check_in)) : 'N/A' }}</td>
                                        <td>{{ isset($booking->check_out) ? date('M d, Y', strtotime($booking->check_out)) : 'N/A' }}</td>
                                        <td>
                                            @if(isset($booking->status))
                                                @if($booking->status == 'confirmed')
                                                    <span class="badge bg-success">Confirmed</span>
                                                @elseif($booking->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($booking->status == 'cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary">Unknown</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-3">
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $booking->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $booking->id }}">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>View Details</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-printer me-2"></i>Print</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">No recent bookings found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Upcoming Check-ins</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                       @forelse($upcomingCheckIns as $checkin)
                            <li class="list-group-item px-3 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 text-uppercase">{{ $checkin->user->name ?? 'N/A' }}</h6>
                                        <p class="text-muted small mb-0">
                                            Room {{ $checkin->room->room_number ?? 'TBD' }} • 
                                            {{ \Carbon\Carbon::parse($checkin->check_in)->diffInDays($checkin->check_out) }} nights
                                        </p>
                                    </div>
                                    <span class="badge {{ \Carbon\Carbon::parse($checkin->check_in)->isToday() ? 'bg-danger text-white' : 'bg-light text-dark' }}">
                                        {{ \Carbon\Carbon::parse($checkin->check_in)->isToday() ? 'Today' : \Carbon\Carbon::parse($checkin->check_in)->diffForHumans() }}
                                    </span>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center py-4">
                                No upcoming check-ins for the next few days
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="#" class="text-decoration-none">View all check-ins</a>
                </div>
            </div>
            
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h5 class="mb-0">System Notifications</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-3 py-3 d-flex">
                            <div class="me-3">
                                <span class="badge rounded-pill bg-warning p-2"><i class="bi bi-exclamation-triangle"></i></span>
                            </div>
                            <div>
                                <h6 class="mb-1">Low inventory alert</h6>
                                <p class="text-muted small mb-0">Room supplies running low</p>
                                <small class="text-muted">2 hours ago</small>
                            </div>
                        </li>
                        <li class="list-group-item px-3 py-3 d-flex">
                            <div class="me-3">
                                <span class="badge rounded-pill bg-info p-2"><i class="bi bi-info-circle"></i></span>
                            </div>
                            <div>
                                <h6 class="mb-1">System update completed</h6>
                                <p class="text-muted small mb-0">All systems running normally</p>
                                <small class="text-muted">Yesterday</small>
                            </div>
                        </li>
                        <li class="list-group-item px-3 py-3 d-flex">
                            <div class="me-3">
                                <span class="badge rounded-pill bg-success p-2"><i class="bi bi-check-circle"></i></span>
                            </div>
                            <div>
                                <h6 class="mb-1">Backup completed</h6>
                                <p class="text-muted small mb-0">Database backup successful</p>
                                <small class="text-muted">2 days ago</small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Booking Trends Chart
    const bookingTrendsCtx = document.getElementById('bookingTrends').getContext('2d');
    const bookingTrendsChart = new Chart(bookingTrendsCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'New Bookings',
                data: [12, 19, 13, 15, 20, 27, 18],
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [2],
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            }
        }
    });

    // Room Occupancy Chart
    const roomOccupancyCtx = document.getElementById('roomOccupancy').getContext('2d');
    const roomOccupancyChart = new Chart(roomOccupancyCtx, {
        type: 'doughnut',
        data: {
            labels: ['Occupied', 'Available', 'Maintenance'],
            datasets: [{
                data: [65, 30, 5],
                backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e'],
                hoverOffset: 4
            }]
        },
        options: {
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush