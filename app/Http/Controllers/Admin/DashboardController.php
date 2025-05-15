<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
       $totalUsers = User::where('role', 'customer')->count();
        $totalRooms = Room::count();
        $totalBookings = Booking::count();
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');

        $recentBookings = Booking::with('user', 'room')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'totalRooms',
            'totalBookings',
            'totalRevenue',
            'recentBookings'
        ));
    }
}
