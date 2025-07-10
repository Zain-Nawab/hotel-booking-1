<style>
    .modern-sidebar {
    width: 280px;
    height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    position: fixed;
    left: 0;
    top: 0;
    display: flex;
    flex-direction: column;
    box-shadow: 2px 0 15px rgba(0,0,0,0.1);
    z-index: 1000;
}

.sidebar-header {
    padding: 2rem 1.5rem 1.5rem;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    text-align: center;
}

.logo-section {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.sidebar-title {
    color: white;
    font-weight: 600;
    font-size: 1.25rem;
}

.sidebar-nav {
    flex: 1;
    padding: 1rem 0;
    overflow-y: auto;
}

.sidebar-link {
    display: flex;
    align-items: center;
    padding: 0.875rem 1.5rem;
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
    position: relative;
    overflow: hidden;
}

.sidebar-link:hover {
    color: white;
    background: rgba(255,255,255,0.1);
    border-left-color: #fff;
    transform: translateX(5px);
}

.sidebar-link.active {
    background: rgba(255,255,255,0.15);
    color: white;
    border-left-color: #fff;
}

.sidebar-link i {
    font-size: 1.1rem;
    margin-right: 0.75rem;
    min-width: 20px;
}

/* Colorful hover effects for different sections */
.dashboard-link:hover { background: linear-gradient(90deg, rgba(255,193,7,0.2), transparent); }
.customers-link:hover { background: linear-gradient(90deg, rgba(40,167,69,0.2), transparent); }
.rooms-link:hover { background: linear-gradient(90deg, rgba(0,123,255,0.2), transparent); }
.bookings-link:hover { background: linear-gradient(90deg, rgba(220,53,69,0.2), transparent); }
.reports-link:hover { background: linear-gradient(90deg, rgba(102,16,242,0.2), transparent); }
.settings-link:hover { background: linear-gradient(90deg, rgba(108,117,125,0.2), transparent); }

.sidebar-footer {
    border-top: 1px solid rgba(255,255,255,0.1);
    padding: 1rem;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    padding: 0.5rem;
    background: rgba(255,255,255,0.1);
    border-radius: 8px;
}

.user-details {
    display: flex;
    flex-direction: column;
}

.username {
    font-weight: 500;
    font-size: 0.9rem;
}

.user-role {
    font-size: 0.75rem;
}

.logout-form {
    width: 100%;
}

.logout-btn {
    width: 100%;
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    background: linear-gradient(45deg, #ff6b6b, #ee5a52);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    font-weight: 500;
}

.logout-btn:hover {
    background: linear-gradient(45deg, #ee5a52, #dc3545);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220,53,69,0.3);
}

.logout-btn i {
    margin-right: 0.5rem;
    font-size: 1rem;
}

/* Responsive */
@media (max-width: 768px) {
    .modern-sidebar {
        width: 260px;
        transform: translateX(-100%); /* This hides the sidebar */
        transition: transform 0.3s ease;
    }
    
    .modern-sidebar.active {
        transform: translateX(0); /* Only shows when .active class is added */
    }
}

/* Scrollbar styling */
.sidebar-nav::-webkit-scrollbar {
    width: 4px;
}

.sidebar-nav::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.1);
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.3);
    border-radius: 2px;
}

.sidebar-nav::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.5);
}
</style>

<div class="sidebar modern-sidebar">
    <div class="sidebar-header">
        <div class="logo-section">
            <i class="bi bi-building text-primary fs-3"></i>
            <h4 class="sidebar-title mb-0">Admin Panel</h4>
        </div>
        <small class="text-muted">Hotel Management</small>
    </div>
    
    <nav class="sidebar-nav">
        <a href="{{ route('admin.main') }}" class="sidebar-link dashboard-link">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('customers.index') }}" class="sidebar-link customers-link">
            <i class="bi bi-people"></i>
            <span>Customers</span>
        </a>
        
        <a href="{{ route('room.index') }}" class="sidebar-link rooms-link">
            <i class="bi bi-door-open"></i>
            <span>Rooms</span>
        </a>
        
        <a href="{{ route('bookings.index') }}" class="sidebar-link bookings-link">
            <i class="bi bi-calendar-check"></i>
            <span>Bookings</span>
        </a>
        
        {{-- <a href="#" class="sidebar-link reports-link">
            <i class="bi bi-bar-chart-line"></i>
            <span>Reports</span>
        </a>
        
        <a href="#" class="sidebar-link settings-link mb-2">
            <i class="bi bi-gear"></i>
            <span>Settings</span>
        </a> --}}
    </nav>
    
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">
                <i class="bi bi-person-circle fs-4 text-primary"></i>
            </div>
            <div class="user-details">
                <span class="username">{{ auth()->user()->name ?? 'Admin' }}</span>
                <small class="user-role text-muted">Administrator</small>
            </div>
        </div>

        <a href="{{ route("logout") }}" class="logout-btn" style="text-decoration: none;">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
        </a>
        
        
    </div>
</div>