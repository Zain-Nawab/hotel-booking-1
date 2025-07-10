
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email Verification</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; }
        .content { padding: 30px; }
        .otp-code { font-size: 36px; font-weight: bold; text-align: center; color: #667eea; letter-spacing: 8px; margin: 20px 0; padding: 20px; background: #f8f9fa; border-radius: 8px; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Hotel Booking!</h1>
            <p>Please verify your email address</p>
        </div>
        
        <div class="content">
            <h2>Hello {{ $user->name }},</h2>
            <p>Thank you for registering with Hotel Booking. To complete your registration, please use the verification code below:</p>
            
            <div class="otp-code">{{ $otp }}</div>
            
            <p><strong>This code will expire in 15 minutes.</strong></p>
            <p>If you didn't create an account, please ignore this email.</p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Hotel Booking. All rights reserved.</p>
        </div>
    </div>
</body>
</html>