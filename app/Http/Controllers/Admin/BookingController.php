<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the bookings with filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'room']);
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhere('room_id', 'like', "%{$search}%")
                  ->orWhereHas('room', function($roomQuery) use ($search) {
                      $roomQuery->where('type', 'like', "%{$search}%");
                  });
            });
        }
        
        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        
        // Apply date filters
        if ($request->filled('start_date')) {
            $query->where('check_in', '>=', $request->input('start_date'));
        }
        
        if ($request->filled('end_date')) {
            $query->where('check_out', '<=', $request->input('end_date'));
        }
        
        // Get results with pagination
        $bookings = $query->latest()->paginate(15)->withQueryString();
        
        // Get the selected view type (list/grid)
        $viewType = $request->input('view', 'list');
        
        return view('admin.bookings.index', compact('bookings', 'viewType'));
    }
    
    /**
     * Show the form for creating a new booking.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Load necessary data for booking creation
        // For example, get available rooms, customers, etc.
        
        
    }
    
    /**
     * Store a newly created booking in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            // Add more validation rules as needed
        ]);
        
        $booking = Booking::create($validated);
        
        return redirect()->route('admin.main')
            ->with('success', 'Booking created successfully.');
    }
    
    /**
     * Display the specified booking.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
       
    }
    
    /**
     * Show the form for editing the specified booking.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        
    }
    
    /**
     * Update the specified booking in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            // Add more validation rules as needed
        ]);
        
        $booking->update($validated);
        
        return redirect()->route('bookings.index')
            ->with('success', 'Booking updated successfully.');
    }
    
    /**
     * Remove the specified booking from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Export bookings to CSV/Excel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        // Implementation for exporting bookings
        // This would typically use Laravel Excel or a similar package
        
        return response()->download($filePath);
    }
}