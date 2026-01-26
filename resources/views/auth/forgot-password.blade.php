<x-guest-layout>
    <!-- Background Image -->
    <div class="login-background"></div>
    
    <!-- Centered Container -->
    <div class="auth-container">
        <div class="login-box">
            <!-- Back Link -->
            <a href="{{ route('login') }}" class="home-link">< Back</a>
            
            <!-- Heading -->
            <h1 class="welcome-heading">Forgot Password</h1>
            
            <!-- Description -->
            <p class="forgot-description">
                Enter your email address and we’ll send you a link to reset your password.
            </p>
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="status-message">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <img src="{{ asset('images/user.png') }}" alt="email" class="input-icon-img">
                        <input 
                            id="email" 
                            class="form-input" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            placeholder="Email Address"    
                        />
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Reset Button -->
                <div class="reset-button-container">
                    <button type="submit" class="btn btn-primary btn-full">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>