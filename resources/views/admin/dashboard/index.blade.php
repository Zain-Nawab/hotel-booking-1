<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: white;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center py-3">Admin Panel</h4>
        <a href="#">Customers</a>
        <a href="#">Rooms</a>
        <a href="#">Check In</a>
        <a href="#">Check Out</a>
        <a href="#">Status</a>
    </div>
    <div class="content">
        <h1 class="mb-4">Dashboard</h1>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Rooms</h5>
                        <p class="card-text display-6">{{ $totalRooms }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Bookings</h5>
                        <p class="card-text display-6">{{ $totalBookings }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Revenue</h5>
                        <p class="card-text display-6">${{ number_format($totalRevenue, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <h3>Recent Bookings</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Room</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recentBookings as $booking)
                    <tr>
                        <td>{{ $booking->customer_name }}</td>
                        <td>{{ $booking->room->number ?? 'N/A' }}</td>
                        <td>{{ $booking->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
