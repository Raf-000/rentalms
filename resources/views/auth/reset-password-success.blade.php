<x-guest-layout>
    <!-- Background Image -->
    <div class="login-background"></div>
    
    <!-- Centered Container -->
    <div class="auth-container">
        <div class="login-box">
            <!-- Back Link -->
            <a href="{{ route('login') }}" class="home-link">< Back</a>
            
            <!-- Success Icon -->
            <div class="success-icon">
                <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="60" cy="60" r="58" stroke="#2d7070" stroke-width="4"/>
                    <path d="M35 60L52 77L85 44" stroke="#2d7070" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            
            <!-- Success Heading -->
            <h1 class="success-heading">Successful!</h1>
            
            <!-- Description -->
            <p class="success-description">
                Congratulations! You have changed your password. Click continue to log in.
            </p>

            <!-- Continue Button -->
            <div class="reset-button-container">
                <a href="{{ route('login') }}" class="btn btn-primary btn-full">
                    Continue
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>