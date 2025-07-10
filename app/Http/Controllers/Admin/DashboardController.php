<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

            //dd($recentBookings);
            //dd(Booking::with(['user', 'room'])->get());

            $upcomingCheckIns = Booking::with(['user', 'room'])
    ->where('status', 'confirmed')
    ->where('check_in', '>=', now()->format('Y-m-d')) // Use the correct column name
    ->where('check_in', '<=', now()->addDays(7)->format('Y-m-d')) // Extend to 7 days for more results
    ->orderBy('check_in')
    ->take(4)
    ->get();

    //Log::info('Upcoming check-ins: ' . $upcomingCheckIns);

    //dd($upcomingCheckIns);

        return view('admin.index', compact(
            'totalUsers',
            'totalRooms',
            'totalBookings',
            'totalRevenue',
            'recentBookings',
            'upcomingCheckIns',
            
        ));
    }

    public function customers()
    {
        $customers = User::where('role', 'customer')->latest()->paginate(10);
        return view('admin.customers.index', [
            'customers' => $customers
        ]);
    }

    public function report()
    {
        return view('admin.reports.index');
    }
}
