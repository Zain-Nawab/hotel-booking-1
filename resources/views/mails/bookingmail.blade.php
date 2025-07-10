<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 16px;
        }
        
        .booking-details {
            padding: 30px;
        }
        
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #1f2937;
        }
        
        .confirmation-box {
            background: linear-gradient(135deg, #dcfce7 0%, #f0fdf4 100%);
            border: 2px solid #10b981;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        
        .confirmation-id {
            font-size: 24px;
            font-weight: 700;
            color: #166534;
            margin-bottom: 10px;
        }
        
        .confirmation-text {
            color: #166534;
            font-weight: 500;
        }
        
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 30px 0;
        }
        
        .detail-card {
            background: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            border-left: 4px solid #6366f1;
        }
        
        .detail-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #6b7280;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        
        .detail-value {
            font-size: 16px;
            font-weight: 600;
            color: #1f2937;
        }
        
        .room-info {
            background: linear-gradient(135deg, #fef3c7 0%, #fef7cd 100%);
            border: 2px solid #f59e0b;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
        }
        
        .room-title {
            font-size: 20px;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .room-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }
        
        .room-detail {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #92400e;
            font-weight: 500;
        }
        
        .price-summary {
            background: linear-gradient(135deg, #e0e7ff 0%, #f0f4ff 100%);
            border: 2px solid #6366f1;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
        }
        
        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 5px 0;
        }
        
        .price-row.total {
            border-top: 2px solid #6366f1;
            padding-top: 15px;
            margin-top: 15px;
            font-size: 18px;
            font-weight: 700;
            color: #4338ca;
        }
        
        .important-info {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .important-title {
            color: #dc2626;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .important-list {
            color: #7f1d1d;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .important-list li {
            margin-bottom: 5px;
        }
        
        .contact-info {
            background: #f3f4f6;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        
        .contact-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 10px;
        }
        
        .contact-details {
            color: #6b7280;
            font-size: 14px;
        }
        
        .footer {
            background: #1f2937;
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .footer-text {
            margin-bottom: 15px;
            opacity: 0.8;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-link {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            transition: background 0.2s;
        }
        
        .social-link:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .details-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            
            .room-details {
                grid-template-columns: 1fr;
            }
            
            .header {
                padding: 20px;
            }
            
            .booking-details {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>🏨 Booking Confirmation!</h1>
            <p>Thank you for choosing our hotel</p>
        </div>
        
        <!-- Main Content -->
        <div class="booking-details">
            <div class="greeting">
                Hello {{ $booking->customer_name ?? 'Valued Guest' }},
            </div>
            <p>We're excited to confirm your reservation! Your booking has been successfully processed.</p>
            
            <!-- Confirmation Box -->
            <div class="confirmation-box">
                <div class="confirmation-id">
                    Booking ID: #{{ $booking->id ?? 'BOOK' . rand(1000, 9999) }}
                </div>
                <div class="confirmation-text">
                    ✅ Please confirm your payment for booking reservation. Go to your dashboard to complete the payment.
                </div>
            </div>
            
            <!-- Booking Details Grid -->
            <div class="details-grid">
                <div class="detail-card">
                    <div class="detail-label">Check-in Date</div>
                    <div class="detail-value">
                        📅 {{ isset($booking->check_in) ? \Carbon\Carbon::parse($booking->check_in)->format('D, M j, Y') : 'Date not specified' }}
                    </div>
                </div>
                
                <div class="detail-card">
                    <div class="detail-label">Check-out Date</div>
                    <div class="detail-value">
                        📅 {{ isset($booking->check_out) ? \Carbon\Carbon::parse($booking->check_out)->format('D, M j, Y') : 'Date not specified' }}
                    </div>
                </div>
                
                <div class="detail-card">
                    <div class="detail-label">Total Nights</div>
                    <div class="detail-value">
                        🌙 {{ isset($booking->check_in) && isset($booking->check_out) ? \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) : 1 }} {{ (isset($booking->check_in) && isset($booking->check_out) && \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) == 1) ? 'night' : 'nights' }}
                    </div>
                </div>
                
                <div class="detail-card">
                    <div class="detail-label">Guests</div>
                    <div class="detail-value">
                        👥 {{ $booking->guests ?? 1 }} {{ ($booking->guests ?? 1) == 1 ? 'guest' : 'guests' }}
                    </div>
                </div>
            </div>
            
            <!-- Room Information -->
            <div class="room-info">
                <div class="room-title">
                    🏠 Room {{ $booking->room->room_number ?? 'TBD' }}
                </div>
                <div class="room-details">
                    <div class="room-detail">
                        🏷️ Type: {{ $booking->room->type ?? 'Standard' }}
                    </div>
                    <div class="room-detail">
                        💰 Rate: ${{ number_format($booking->room->price_per_night ?? 0, 2) }}/night
                    </div>
                </div>
            </div>
            
            <!-- Price Summary -->
            <div class="price-summary">
                <h3 style="color: #4338ca; margin-bottom: 15px;">💳 Price Summary</h3>
                
                @php
                    $nights = isset($booking->check_in) && isset($booking->check_out) 
                        ? \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) 
                        : 1;
                    $roomRate = $booking->room->price_per_night ?? 100;
                    $subtotal = $roomRate * $nights;
                    $tax = $subtotal * 0.1; // 10% tax
                    $total = $subtotal + $tax;
                @endphp
                
                <div class="price-row">
                    <span>Room Rate ({{ $nights }} {{ $nights == 1 ? 'night' : 'nights' }})</span>
                    <span>${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="price-row">
                    <span>Taxes & Fees</span>
                    <span>${{ number_format($tax, 2) }}</span>
                </div>
                <div class="price-row total">
                    <span>Total Amount</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
            </div>
            
            <!-- Important Information -->
            <div class="important-info">
                <div class="important-title">
                    ⚠️ Important Reminders
                </div>
                <ul class="important-list">
                    <li>Check-in time: 3:00 PM | Check-out time: 11:00 AM</li>
                    <li>Please bring a valid photo ID and credit card</li>
                    <li>Cancellation allowed up to 24 hours before check-in</li>
                    <li>For modifications, contact us at least 48 hours in advance</li>
                    <li>Early check-in/late check-out subject to availability</li>
                </ul>
            </div>
            
            <!-- Contact Information -->
            <div class="contact-info">
                <div class="contact-title">Need Help?</div>
                <div class="contact-details">
                    📞 Phone: +1 (555) 123-4567<br>
                    📧 Email: reservations@hotel.com<br>
                    🌐 Website: www.hotel.com<br>
                    💬 24/7 Customer Support Available
                </div>
            </div>
            
            <p style="margin-top: 30px; font-style: italic; color: #6b7280;">
                We look forward to welcoming you and ensuring you have a memorable stay with us!
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-text">
                Thank you for choosing our hotel. We appreciate your business!
            </div>
            <div style="font-size: 12px; opacity: 0.7;">
                © {{ date('Y') }} Hotel Booking System. All rights reserved.
            </div>
            <div class="social-links">
                <a href="#" class="social-link">Facebook</a>
                <a href="#" class="social-link">Twitter</a>
                <a href="#" class="social-link">Instagram</a>
            </div>
        </div>
    </div>
</body>
</html>