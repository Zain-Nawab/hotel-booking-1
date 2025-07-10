<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - Hotel Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Same styling as your other forms */
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --card-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        body {
            background: var(--primary-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .verify-container {
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .verify-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .otp-input {
            font-size: 1.5rem;
            text-align: center;
            letter-spacing: 0.5rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="verify-container">
        <div class="card verify-card">
            <div class="card-header text-center py-4">
                <div class="brand-logo mx-auto mb-3" style="width: 60px; height: 60px; background: var(--primary-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                    <i class="bi bi-envelope-check"></i>
                </div>
                <h3 class="fw-bold text-dark mb-2">Verify Your Email</h3>
                <p class="text-muted mb-0">We've sent a 6-digit code to</p>
                <p class="fw-bold text-primary">{{ $user->email }}</p>
            </div>
            
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('email.verify', $user->id) }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="otp" class="form-label text-center d-block">Enter Verification Code</label>
                        <input 
                            type="text" 
                            class="form-control otp-input @error('otp') is-invalid @enderror" 
                            id="otp" 
                            name="otp" 
                            maxlength="6"
                            pattern="[0-9]{6}"
                            placeholder="xxxxxx"
                            required
                            autofocus
                        >
                        @error('otp')
                            <div class="invalid-feedback text-center">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="bi bi-check-circle me-2"></i>Verify Email
                        </button>
                    </div>
                </form>

                <div class="text-center">
                    <p class="text-muted mb-2">Didn't receive the code?</p>
                    <a href="{{ route('email.resend', $user->id) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-clockwise me-1"></i>Resend Code
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-format OTP input
        document.getElementById('otp').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>