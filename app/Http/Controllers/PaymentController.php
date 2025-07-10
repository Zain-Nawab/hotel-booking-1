<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;


class PaymentController extends Controller
{

    public function __construct()
    {
        // Set the Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    }

    public function processPayment(Request $request, $id)
    {
        
        $user = Auth::user();
        // get booking details by id
        $booking_room = Booking::findOrFail($id);
        //dd($booking_room);
        // Check if the booking belongs to the authenticated user
        if ($booking_room->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        // Check if the booking is already paid
        if ($booking_room->status === 'paid') {
            return response()->json(['error' => 'Booking already paid'], 400);
        }
        // Check if the booking is cancelled
        if ($booking_room->status === 'cancelled') {
            return response()->json(['error' => 'Booking is cancelled'], 400);
        }

        
        // /dd($booking_room->amount);

        DB::beginTransaction();

        // Process the payment logic here
        // stripe session 
        $stripeSession = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Your Booking Room Number ' . $booking_room->room->room_number . ' Payment',
                    ],
                    'unit_amount' => $booking_room->amount * 100, // Amount in cents
                ],
                'quantity' => 1,
            ]],
            'customer_email' => $user->email,
            'metadata' => [
                'booking_id' => $booking_room->id,
                'user_id' => $user->id,
            ],
            'mode' => 'payment',
            'success_url' => route('payments.success'). '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payments.cancel'). '?session_id={CHECKOUT_SESSION_ID}',
        ]);

        DB::commit();

        //create payment record
        Payment::create([
            'user_id' => $user->id,
            'booking_id' => $booking_room->id,
            'amount' => $booking_room->amount,
            'method' => 'card',
            'payment_status' => 'pending', // Initial status
            'stripe_session_id' => $stripeSession->id, // Store the Stripe session ID
        ]);

        return redirect($stripeSession->url, 303);


        // userid , // booking_id, amount, status, stripe_session_id, payment_status
        // Return a response indicating success or failure
        return response()->json(['message' => 'Payment processed successfully'], 200);
    }

    public function paymentSuccess()
    {
        //stripe session id retrieved from the request
        $session_id = request()->query('session_id');
        //dd($session_id);
        // Validate the session ID
        if (!$session_id) {
            return response()->json(['error' => 'Session ID is required'], 400);
        }

        // Retrieve the Stripe session
        $stripeSession = StripeSession::retrieve($session_id);
        // Check if the session is valid and completed
        if (!$stripeSession || $stripeSession->payment_status !== 'paid') {
            return response()->json(['error' => 'Payment not completed'], 400);
        }
        // Retrieve the booking ID from the session metadata
        $bookingId = $stripeSession->metadata->booking_id;
        // Check if the booking ID is valid
        if (!$bookingId) {
            return response()->json(['error' => 'Booking ID not found'], 400);
        }
        // Update the payment status in the database
        $payment = Payment::where('stripe_session_id', $session_id)->first();
        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }
        
        $payment->payment_status = 'completed';
        $payment->status= 'paid';
        $payment->save();

        //update the booking status
        $booking = Booking::findOrFail($bookingId);
        $booking->status = 'confirmed';
        $booking->save();

        return redirect()->route('user.dashboard')->with(['message' => 'Payment successful. Your Room is Booked']);
    }
    public function paymentCancel(Request $request, $id)
    {
        // Handle payment cancellation logic here
        // For example, redirecting the user back to the booking page

        return redirect()->route('user.dashboard')->with(['message' => 'Payment cancelled'], 200);
    }

    public function refundPayment(Request $request)
    {
        // Validate the request data
        $request->validate([
            'transaction_id' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Process the refund logic here
        // For example, integrating with a payment gateway

        // Return a response indicating success or failure
        return response()->json(['message' => 'Refund processed successfully'], 200);
    }
    public function getPaymentStatus(Request $request)
    {
        // Validate the request data
        $request->validate([
            'transaction_id' => 'required|string',
        ]);

        // Retrieve the payment status logic here
        // For example, checking with a payment gateway

        // Return a response with the payment status
        return response()->json(['status' => 'Payment status retrieved successfully'], 200);
    }
    public function listTransactions(Request $request)
    {
        // Retrieve the list of transactions logic here
        // For example, fetching from a database or payment gateway

        // Return a response with the list of transactions
        return response()->json(['transactions' => []], 200);
    }
}
