@extends('admin.layout')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">Room Management</h1>
                    <p class="text-muted mb-0">Manage hotel rooms and their details</p>
                </div>
                <a href="{{ route('room.create') }}" class="btn btn-primary btn-lg shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i>Add New Room
                </a>
            </div>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-primary mb-2">
                        <i class="bi bi-door-open fs-2"></i>
                    </div>
                    <h5 class="card-title mb-1">{{ $rooms->count() }}</h5>
                    <p class="card-text text-muted small">Total Rooms</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Rooms Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Rooms</h5>
                <div class="d-flex gap-2">
                    <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search rooms..." style="width: 200px;">
                    <select id="typeFilter" class="form-select form-select-sm" style="width: 150px;">
                        <option value="">All Types</option>
                        <option value="single">Single</option>
                        <option value="double">Double</option>
                        <option value="luxury">Luxury</option>
                        <option value="suite">Suite</option>
                        <option value="deluxe">Deluxe</option>
                    </select>
                    <select id="statusFilter" class="form-select form-select-sm" style="width: 150px;">
                        <option value="">All Status</option>
                        <option value="available">Available</option>
                        <option value="unavailable">Booked</option>
                        <option value="maintenance">Maintenance</option>
                    </select>
                    <button type="button" id="applyFilters" class="btn btn-primary btn-sm">
                        <i class="bi bi-search"></i> Apply
                    </button>
                    <button type="button" id="clearFilters" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-clockwise"></i> Clear
                    </button>
                </div>
            </div>
        </div>
        
        @if(!$rooms->isEmpty())
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="roomsTable">
                    <thead class="bg-light">
                        <tr>
                            <th>Room Details</th>
                            <th>Status</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('admin.rooms.partials.room-table', ['rooms' => $rooms])
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination container -->
            <div id="pagination-container" class="mt-3">
                {{ $rooms->links() }}
            </div>

            <!-- No Results Message -->
            <div id="noResults" class="text-center py-5" style="display: none;">
                <div class="mb-3">
                    <i class="bi bi-search text-muted" style="font-size: 3rem;"></i>
                </div>
                <h5 class="text-muted mb-2">No rooms found</h5>
                <p class="text-muted">Try adjusting your search criteria.</p>
            </div>
        </div>
        @else
        <!-- Empty State -->
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="bi bi-door-open text-muted" style="font-size: 4rem;"></i>
            </div>
            <h5 class="text-muted mb-3">No rooms available</h5>
            <p class="text-muted mb-4">Get started by creating your first room.</p>
            <a href="{{ route('room.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Create Your First Room
            </a>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(tooltipTriggerEl => {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });

    const searchInput = document.getElementById('searchInput');
    const typeFilter = document.getElementById('typeFilter');
    const statusFilter = document.getElementById('statusFilter');
    const applyFiltersBtn = document.getElementById('applyFilters');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const tableBody = document.querySelector('#roomsTable tbody');
    let searchTimeout;

    // Check if elements exist
    if (!searchInput || !typeFilter || !statusFilter || !tableBody) {
        console.error('Required elements not found');
        return;
    }

    // AJAX Search Function
    function performAjaxSearch() {
        const params = new URLSearchParams({
            search: searchInput.value || '',
            type_filter: typeFilter.value || '',
            status: statusFilter.value || ''
        });

        // Show loading state
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center py-4">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="ms-2">Searching...</span>
                </td>
            </tr>
        `;

        // Make AJAX request
        fetch(`{{ route("room.index") }}?${params.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                tableBody.innerHTML = data.html;
                
                // Reinitialize tooltips for new content
                document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(tooltipTriggerEl => {
                    new bootstrap.Tooltip(tooltipTriggerEl);
                });
                
                const paginationContainer = document.getElementById('pagination-container');
                if (paginationContainer && data.pagination) {
                    paginationContainer.innerHTML = data.pagination;
                }
            } else {
                throw new Error('Server returned success: false');
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-4 text-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span class="ms-2">Error loading results. Please try again.</span>
                    </td>
                </tr>
            `;
        });
    }

    // Event listeners
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performAjaxSearch, 500);
    });

    typeFilter.addEventListener('change', performAjaxSearch);
    statusFilter.addEventListener('change', performAjaxSearch);

    applyFiltersBtn.addEventListener('click', function(e) {
        e.preventDefault();
        performAjaxSearch();
    });

    clearFiltersBtn.addEventListener('click', function(e) {
        e.preventDefault();
        searchInput.value = '';
        typeFilter.value = '';
        statusFilter.value = '';
        performAjaxSearch();
    });

    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            clearTimeout(searchTimeout);
            performAjaxSearch();
        }
    });
});

// Delete confirmation function
function confirmDelete(roomId) {
    if (confirm('Are you sure you want to delete this room?')) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/room/delete/${roomId}`;

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        const tokenField = document.createElement('input');
        tokenField.type = 'hidden';
        tokenField.name = '_token';
        tokenField.value = '{{ csrf_token() }}';
        
        form.appendChild(methodField);
        form.appendChild(tokenField);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
@endsection