<x-guest-layout>
    <!-- Background Image -->
    <div class="login-background"></div>
    
    <!-- Centered Container -->
    <div class="auth-container">
        <div class="login-box">
            <!-- Home Link -->
            <a href="/" class="home-link">< Home</a>
            
            <!-- Welcome Heading -->
            <h1 class="welcome-heading">Welcome Back!</h1>
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="status-message">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <img src="{{ asset('images/user.png') }}" alt="user" class="input-icon-img">
                        <input 
                            id="email" 
                            class="form-input" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            autocomplete="username"
                            placeholder="Email Address/Phone Number"    
                        />
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <img src="{{ asset('images/key.png') }}" alt="key" class="input-icon-img">
                        <input 
                            id="password" 
                            class="form-input"
                            type="password"
                            name="password"
                            required 
                            autocomplete="current-password"
                            placeholder="Password"
                        />
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    
                    <!-- Forgot Password Link -->
                    @if (Route::has('password.request'))
                        <div class="forgot-password">
                            <a href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="remember-me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">{{ __('Remember me') }}</label>
                </div>

                <!-- Buttons -->
                <div class="buttons-container">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-secondary">
                            Sign Up
                        </a>
                    @else
                        <div></div>
                    @endif
                    <button type="submit" class="btn btn-primary">
                        Continue
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>   