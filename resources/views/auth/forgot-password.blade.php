<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Boarding House Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #477774 0%, #585858 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .reset-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
        }

        .reset-header {
            background: linear-gradient(135deg, #425554 0%, #477774 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .reset-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .reset-icon svg {
            width: 32px;
            height: 32px;
        }

        .reset-header h1 {
            font-size: 24px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .reset-header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .reset-body {
            padding: 40px 30px;
        }

        .info-box {
            background-color: #e8f4f8;
            border-left: 4px solid #477774;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }

        .info-box strong {
            display: block;
            margin-bottom: 5px;
            color: #477774;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
            color: #333;
        }

        .form-group label .required {
            color: #dc3545;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #477774;
            box-shadow: 0 0 0 3px rgba(71, 119, 116, 0.1);
        }

        .form-group input.error {
            border-color: #dc3545;
        }

        .error-message {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .password-requirements {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #856404;
        }

        .password-requirements strong {
            display: block;
            margin-bottom: 5px;
        }

        .password-requirements ul {
            margin-left: 20px;
            margin-top: 5px;
        }

        .password-requirements li {
            margin-bottom: 3px;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #477774 0%, #558380 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(71, 119, 116, 0.4);
            margin-bottom: 15px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(71, 119, 116, 0.5);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .back-login {
            text-align: center;
        }

        .back-login a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: color 0.3s;
        }

        .back-login a:hover {
            color: #477774;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        @media (max-width: 480px) {
            .reset-header {
                padding: 30px 20px;
            }

            .reset-header h1 {
                font-size: 20px;
            }

            .reset-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <div class="reset-header">
            <div class="reset-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                </svg>
            </div>
            <h1>Reset Your Password</h1>
            <p>Verify your identity and create a new password</p>
        </div>

        <div class="reset-body">
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <div class="info-box">
                <strong>Security Verification</strong>
                Please enter your account details to verify your identity and reset your password.
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email Address <span class="required">*</span></label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        class="{{ $errors->has('email') ? 'error' : '' }}"
                        placeholder="Enter your registered email"
                    >
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Full Name (for verification) -->
                <div class="form-group">
                    <label for="name">Full Name <span class="required">*</span></label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required
                        class="{{ $errors->has('name') ? 'error' : '' }}"
                        placeholder="Enter your full name as registered"
                    >
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Requirements -->
                <div class="password-requirements">
                    <strong>New Password Requirements:</strong>
                    <ul>
                        <li>At least 8 characters long</li>
                        <li>Mix of letters and numbers recommended</li>
                    </ul>
                </div>

                <!-- New Password -->
                <div class="form-group">
                    <label for="password">New Password <span class="required">*</span></label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="{{ $errors->has('password') ? 'error' : '' }}"
                        placeholder="Enter new password"
                        minlength="8"
                    >
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password <span class="required">*</span></label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required
                        placeholder="Confirm new password"
                        minlength="8"
                    >
                </div>

                <button type="submit" class="submit-btn">
                    Reset Password
                </button>

                <div class="back-login">
                    <a href="{{ route('login') }}">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>