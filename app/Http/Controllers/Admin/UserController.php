<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function dashboard(){
        $user = Auth::user();

        // Recent Bookings (last 5 bookings)
        $recentBookings = $user->bookings()
            ->with(['room', 'payments'])
            ->latest()
            ->take(5)
            ->get();

        // Recent Reviews (reviews written by user)
        $recentReviews = $user->reviews()
            ->with(['room'])
            ->latest()
            ->take(5)
            ->get();

        // Total Bookings Count
        $totalBookings = $user->bookings()->count();

        // Total Revenue (amount spent by user)
        $totalRevenue = $user->bookings()
            ->join('payments', 'bookings.id', '=', 'payments.booking_id')
            ->where('payments.status', 'paid')
            ->sum('payments.amount');

        // Upcoming Bookings (future check-ins)
        $upcomingBookings = $user->bookings()
            ->with(['room'])
            ->where('check_in', '>', now())
            ->where('status', '!=', 'cancelled')
            ->where('status', '!=', 'pending')
            ->orderBy('check_in', 'asc')
            ->take(5)
            ->get();

        // Current Active Bookings (checked in but not checked out)
        $activeBookings = $user->bookings()
            ->with(['room'])
            ->where('check_in', '<=', now())
            ->where('check_out', '>=', now())
            ->where('status', 'confirmed')
            ->get();

        // Booking Statistics by Status
        $bookingStats = $user->bookings()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Favorite Rooms (most booked room types)
        $favoriteRooms = $user->bookings()
            ->with(['room'])
            ->select('room_id', DB::raw('count(*) as booking_count'))
            ->groupBy('room_id')
            ->orderBy('booking_count', 'desc')
            ->take(3)
            ->get();

        // Total Nights Stayed - Database calculation
        $totalNights = $user->bookings()
            ->where('status', 'confirmed')
            ->where('check_in', '<=', now())
            ->selectRaw('
                SUM(
                    CASE 
                        WHEN check_out <= NOW() THEN DATEDIFF(check_out, check_in)
                        ELSE DATEDIFF(NOW(), check_in)
                    END
                ) as total_nights
            ')
            ->value('total_nights') ?? 0;

        // Average Review Rating Given by User
        $averageRating = $user->reviews()->avg('rating') ?? 0;

        // Loyalty Points (if you have a points system)
        $loyaltyPoints = $user->loyalty_points ?? 0;

        // Last Login Information
        $lastLogin = $user->last_login_at ?? $user->updated_at;

        // Pending Payments
        $pendingPayments = $user->bookings()
            ->join('payments', 'bookings.id', '=', 'payments.booking_id')
            ->where('payments.status', 'pending')
            ->with(['room'])
            ->get();

        // Monthly Spending (last 12 months)
        $monthlySpending = $user->bookings()
            ->join('payments', 'bookings.id', '=', 'payments.booking_id')
            ->where('payments.status', 'paid')
            ->where('payments.created_at', '>=', now()->subMonths(12))
            ->select(
                DB::raw('MONTH(payments.created_at) as month'),
                DB::raw('YEAR(payments.created_at) as year'),
                DB::raw('SUM(payments.amount) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('user.dashboard', compact(
            'recentBookings',
            'recentReviews',
            'totalBookings',
            'totalRevenue',
            'upcomingBookings',
            'activeBookings',
            'bookingStats',
            'favoriteRooms',
            'totalNights',
            'averageRating',
            'loyaltyPoints',
            'lastLogin',
            'pendingPayments',
            'monthlySpending'
        ));
    }

    // Show user profile
    public function show($id){
        
        $user = User::findOrFail($id);

        // Fetch user details
        $userDetails = $user->where('id', $id)->first();

        if (!$userDetails) {
            return redirect()->back()->withErrors(['error' => 'User not found.']);
        }

        // Fetch user's bookings
        $bookings = $userDetails->bookings()
            ->with(['room', 'payments'])
            ->latest()
            ->paginate(10);

        // Fetch user's reviews
        $reviews = $userDetails->reviews()
            ->with(['room'])
            ->latest()
            ->paginate(10);

        return view('user.booking-history', compact('userDetails', 'bookings', 'reviews'));
    }

    // Additional method for user profile data
    public function profile(){
        $user = FacadesAuth::user();
        
        // User's personal information
        $profileData = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? null,
            'address' => $user->address ?? null,
            'date_of_birth' => $user->date_of_birth ?? null,
            'gender' => $user->gender ?? null,
            'nationality' => $user->nationality ?? null,
            'member_since' => $user->created_at,
            'profile_picture' => $user->profile_picture ?? null,
        ];

        return view('user.profile', compact('profileData'));
    }

    // User booking history with filters
    public function bookingHistory(Request $request){
        $user = Auth::user();
        
        $query = $user->bookings()->with(['room', 'payments']);

        // Apply filters if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('check_in', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('check_out', '<=', $request->date_to);
        }

        $bookings = $query->latest()->paginate(10)->withQueryString();

        return view('user.booking-history', compact('bookings'));
    }

    //delete user account
    public function deleteAccount(Request $request, $id) {

        $user = User::findOrFail($id);
        $Authuser = Auth::user();

        // Check if the user has any bookings
        if ($user->bookings()->exists()) {
            return redirect()->back()->withErrors(['error' => 'You cannot delete your account while you have active bookings.']);
        }

        // Delete user reviews
        Review::where('user_id', $user->id)->delete();

        // Delete user payments
        Payment::where('user_id', $user->id)->delete();

        // Delete user bookings
        Booking::where('user_id', $user->id)->delete();

        // Finally, delete the user account
        $user->delete();

        return redirect('/')->with('success', 'User account has been deleted successfully.');
    }
}
