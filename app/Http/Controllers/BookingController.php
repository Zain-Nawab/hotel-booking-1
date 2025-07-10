<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
   

    public function create($id)
    {
        $room = Room::findOrFail($id);
        return view('blog.booking.booking', compact('room'));
    }

    public function store(Request $request, $id)
{

    $request->validate([
        'check_in' => 'required|date|after_or_equal:today',
        'check_out' => 'required|date|after:check_in',
        'guests' => 'required|integer|min:1',
    ]);

    $room = Room::findOrFail($id);

    // Optional: Check room availability logic here

     $booking = Booking::create([
        'user_id' => Auth::id(),
        'room_id' => $room->id,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'status' => 'pending', // default per your schema
        'amount' => $room->price_per_night, // Assuming room price is set
    ]);
    
    // Send booking confirmation email
    try {
        $user = Auth::user();
        Mail::send('mails.bookingmail', compact('booking'), function($message) use ($booking, $user) {
            $message->to($user->email)
                    ->subject('Booking Confirmation - #' . $booking->id);
        });
    } catch (\Exception $e) {
        // Log email error but don't stop the booking process
        Log::error('Failed to send booking confirmation email: ' . $e->getMessage());
    }

    return redirect()->route('user.dashboard')->with('success', 'Booking request submitted! Pay now to confirm your booking. Status: Pending. We sent you an email with booking details.');
}

        // Add this method to your RoomController or appropriate controller
public function checkAvailability(Request $request, $roomId)
{
    $room = Room::findOrFail($roomId);
    $checkIn = $request->check_in;
    $checkOut = $request->check_out;
    
    $isAvailable = true;
    
    if ($checkIn && $checkOut) {
        // Check if room is already booked for the selected dates
        $existingBookings = Booking::where('room_id', $roomId)
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out', [$checkIn, $checkOut])
                      ->orWhere(function ($q) use ($checkIn, $checkOut) {
                          $q->where('check_in', '<=', $checkIn)
                            ->where('check_out', '>=', $checkOut);
                      });
            })
            ->where('status', '!=', 'cancelled')
            ->exists();
        
        $isAvailable = !$existingBookings;
    }
    
    return view('blog.singleroom', compact('room', 'isAvailable'));
}



public function checkAvailabilityJson(Request $request, $roomId)
{
    $checkIn = $request->check_in;
    $checkOut = $request->check_out;
    
    // Check if room exists
    $room = Room::findOrFail($roomId);
    
    // Check if room status is available
    if ($room->status !== 'available') {
        return response()->json(['available' => false]);
    }
    
    $isAvailable = true;
    
    if ($checkIn && $checkOut) {
        // Check if room is already booked for the selected dates
        $existingBookings = Booking::where('room_id', $roomId)
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out', [$checkIn, $checkOut])
                      ->orWhere(function ($q) use ($checkIn, $checkOut) {
                          $q->where('check_in', '<=', $checkIn)
                            ->where('check_out', '>=', $checkOut);
                      });
            })
            ->where('status', '!=', 'cancelled')
            ->exists();
        
        $isAvailable = !$existingBookings;
    }
    
    return response()->json(['available' => $isAvailable]);
} 


 public function cancel(Request $request, $id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if booking can be cancelled
        if (!$this->canCancelBooking($booking)) {
            return redirect()->back()->with('error', 'This booking cannot be cancelled.');
        }
        
         DB::transaction(function () use ($booking, $request) {
            // Update booking status
            $booking->update([
                'status' => 'cancelled'
            ]);

            // Handle payment refunds
            $this->handleRefund($booking);

            // Make room available again
            if ($booking->room) {
                $booking->room->update(['status' => 'available']);
            }

            // Log cancellation
            Log::info("Booking {$booking->id} cancelled by user {$booking->user_id}");
        });

        return redirect()->route('user.dashboard')
            ->with('success', 'Booking cancelled successfully. Refund will be processed according to our policy If you have paid.');
    }

    public function show($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['room', 'payments'])
            ->firstOrFail();

        return view('user.booking-details', compact('booking'));
    }

    public function statusCheck()
    {
        $cancelledBookings = Booking::where('user_id', Auth::id())
            ->where('status', 'cancelled')
            ->where('updated_at', '>=', now()->subMinutes(1))
            ->get(['id', 'room_id']);

        return response()->json([
            'cancelled_bookings' => $cancelledBookings
        ]);
    }

    private function canCancelBooking($booking)
    {
        // Cannot cancel if already cancelled or completed
        if (in_array($booking->status, ['cancelled', 'confirmed'])) {
            return false;
        }

        // Cannot cancel if check-in is within 24 hours (confirmed bookings)
        if ($booking->status == 'onfirmed') {
            $checkInTime = \Carbon\Carbon::parse($booking->check_in);
            if ($checkInTime->lte(now()->addHours(24))) {
                return false;
            }
        }

        return true;
    }

    private function handleRefund($booking)
    {
        $user = Auth::user();
        
        $paidPayments = $booking->payments()->where('status', 'paid')->get();
        
        foreach ($paidPayments as $payment) {
            $refundAmount = $this->calculateRefund($booking, $payment);
            
            if ($refundAmount > 0) {
                // Create refund record
                Payment::create([
                    'booking_id' => $booking->id,
                    'amount' => -$refundAmount, // Negative amount for refund
                    'status' => 'refund_pending',
                    'transaction_id' => 'refund_' . uniqid(),
                    'user_id' => $user->id,
                    'method' => 'card',
                    'stripe_session_id' => "NULL", // Assuming no Stripe session for refunds
                ]);
            }
        }
        // Cancel pending payments
        $booking->payments()->where('status', 'pending')->update([
            'status' => 'cancelled'
        ]);
    }

    private function calculateRefund($booking, $payment)
    {
        $checkInTime = \Carbon\Carbon::parse($booking->check_in);
        $hoursUntilCheckIn = now()->diffInHours($checkInTime, false);

        // Refund policy
        if ($hoursUntilCheckIn > 48) {
            return $payment->amount; // Full refund
        } elseif ($hoursUntilCheckIn > 24) {
            return $payment->amount * 0.5; // 50% refund
        } else {
            return 0; // No refund
        }
    }
    
}