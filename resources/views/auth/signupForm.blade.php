<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking - Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --card-shadow: 0 20px 40px rgba(0,0,0,0.1);
            --input-focus: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        body {
            background: var(--primary-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px 0;
        }

        .signup-container {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }

        .signup-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .card-header {
            background: transparent;
            border: none;
            padding: 40px 40px 20px;
            text-align: center;
        }

        .card-body {
            padding: 0 40px 40px;
        }

        .form-floating {
            margin-bottom: 1rem;
            position: relative;
        }

        .form-floating > .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            height: 60px;
            transition: all 0.3s ease;
        }

        .form-floating > .form-control:focus {
            border-color: #667eea;
            box-shadow: var(--input-focus);
            transform: translateY(-2px);
        }

        .form-floating > label {
            color: #6c757d;
            font-weight: 500;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            z-index: 10;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        .btn-signup {
            background: var(--secondary-gradient);
            border: none;
            border-radius: 12px;
            height: 50px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-signup:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(240, 147, 251, 0.4);
        }

        .btn-signup:active {
            transform: translateY(0);
        }

        .signup-links a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .signup-links a:hover {
            color: #764ba2;
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            background: var(--secondary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 24px;
        }

        .welcome-text {
            color: #495057;
            font-size: 0.95rem;
            margin-top: 10px;
        }

        .password-strength {
            margin-top: 5px;
            font-size: 0.875rem;
        }

        .strength-weak { color: #dc3545; }
        .strength-medium { color: #ffc107; }
        .strength-strong { color: #198754; }

        .optional-text {
            font-size: 0.8rem;
            color: #6c757d;
        }

        @media (max-width: 576px) {
            .signup-container {
                padding: 15px;
            }
            
            .card-header {
                padding: 30px 30px 15px;
            }
            
            .card-body {
                padding: 0 30px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="card signup-card">

             <!-- Success Alert -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-3" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <div class="card-header">
                <div class="brand-logo">
                    <i class="bi bi-person-plus"></i>
                </div>
                <h3 class="fw-bold text-dark mb-0">Join Us Today</h3>
                <p class="welcome-text">Create your account to get started</p>
            </div>
            
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-floating mb-3">
                        <input 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror" 
                            id="name" 
                            name="name" 
                            placeholder="John Doe"
                            value="{{ old('name') }}" 
                            required 
                            autofocus
                        >
                        <label for="name">
                            <i class="bi bi-person me-2"></i>Full Name
                        </label>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            id="email" 
                            name="email" 
                            placeholder="name@example.com"
                            value="{{ old('email') }}" 
                            required
                        >
                        <label for="email">
                            <i class="bi bi-envelope me-2"></i>Email Address
                        </label>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input 
                            type="tel" 
                            class="form-control @error('phone') is-invalid @enderror" 
                            id="phone" 
                            name="phone" 
                            placeholder="+1234567890"
                            value="{{ old('phone') }}"
                        >
                        <label for="phone">
                            <i class="bi bi-telephone me-2"></i>Phone Number <span class="optional-text">(Optional)</span>
                        </label>
                        @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            id="password" 
                            name="password" 
                            placeholder="Password"
                            required
                        >
                        <label for="password">
                            <i class="bi bi-lock me-2"></i>Password
                        </label>
                        <button type="button" class="password-toggle" onclick="togglePassword('password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div id="passwordStrength" class="password-strength"></div>
                    </div>

                    <div class="form-floating mb-4">
                        <input 
                            type="password" 
                            class="form-control" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            placeholder="Confirm Password"
                            required
                        >
                        <label for="password_confirmation">
                            <i class="bi bi-shield-check me-2"></i>Confirm Password
                        </label>
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>

                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-primary btn-signup">
                            <i class="bi bi-person-check me-2"></i>
                            Create Account
                        </button>
                    </div>

                    <div class="signup-links">
                        <div class="text-center">
                            <span class="text-muted">Already have an account?</span>
                            <a href="{{ route('loginForm') }}" class="ms-1">
                                Sign in here
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthDiv = document.getElementById('passwordStrength');
            
            if (password.length === 0) {
                strengthDiv.innerHTML = '';
                return;
            }
            
            let strength = 0;
            let feedback = [];
            
            // Check password criteria
            if (password.length >= 8) strength++;
            else feedback.push('at least 8 characters');
            
            if (/[a-z]/.test(password)) strength++;
            else feedback.push('lowercase letter');
            
            if (/[A-Z]/.test(password)) strength++;
            else feedback.push('uppercase letter');
            
            if (/[0-9]/.test(password)) strength++;
            else feedback.push('number');
            
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            else feedback.push('special character');
            
            // Display strength
            if (strength < 3) {
                strengthDiv.innerHTML = '<span class="strength-weak"><i class="bi bi-shield-x me-1"></i>Weak password</span>';
            } else if (strength < 5) {
                strengthDiv.innerHTML = '<span class="strength-medium"><i class="bi bi-shield-check me-1"></i>Medium strength</span>';
            } else {
                strengthDiv.innerHTML = '<span class="strength-strong"><i class="bi bi-shield-fill-check me-1"></i>Strong password</span>';
            }
        });
    </script>
</body>
</html>