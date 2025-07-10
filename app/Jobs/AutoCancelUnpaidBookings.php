<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AutoCancelUnpaidBookings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Find bookings that are pending and created more than 1 hour ago
        $unpaidBookings = Booking::where('status', 'pending')
            ->where('created_at', '<', now()->subHour())
            ->whereDoesntHave('payments', function ($query) {
                $query->where('status', 'paid');
            })
            ->with(['user', 'room'])
            ->get();

        foreach ($unpaidBookings as $booking) {
            $this->cancelBooking($booking);
        }

        Log::info("Auto-cancelled {$unpaidBookings->count()} unpaid bookings");
    }

    private function cancelBooking($booking)
    {
        // Update booking status
        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => 'auto_cancelled_unpaid'
        ]);

        // Cancel any pending payments
        $booking->payments()->where('status', 'pending')->update([
            'status' => 'cancelled'
        ]);

        // Make room available
        if ($booking->room) {
            $booking->room->update(['status' => 'available']);
        }

        // Optional: Send notification to user
        // Notification::send($booking->user, new BookingAutoCancelledNotification($booking));

        Log::info("Auto-cancelled booking {$booking->id} for user {$booking->user_id}");
    }
}
