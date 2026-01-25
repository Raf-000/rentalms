<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boarding Homes - Your Safe and Affordable Home Near Campus</title>
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
</head>
<body>
    <!-- Top Contact Bar -->
    <div class="contact-bar">
        <div class="contact-item">
            <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
            <span>0922 222 2222</span>
        </div>
        <div class="contact-item">
            <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <span>hello@boardinghomes.com</span>
        </div>
        <div class="contact-item">
            <svg class="contact-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span>123 Diyan Lang, Manila</span>
        </div>
    </div>

    <!-- Header Navigation -->
    <header class="header">
        <div class="header-container">
            <a href="/" class="logo">BOARDING HOMES</a>
            <nav class="nav">
                <a href="/" class="nav-link active">Home</a>
                <a href="{{ route('login') }}" class="nav-link">Sign In</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">Welcome to Boarding Homes!   </h1>
            <p class="hero-slogan">Your safe and affordable home near campus.</p>
            <div class="hero-buttons">
                <a href="#rooms" class="btn btn-primary">See Available Rooms</a>
            </div>
        </div>
        
        <!-- Scroll Down Indicator -->
        <div class="scroll-indicator" onclick="scrollToAmenities()">
            <svg class="scroll-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Amenities & Inclusions Section -->
    <section class="amenities-section">
        <div class="amenities-container">
            <h2 class="amenities-title">Amenities & Inclusions</h2>
            <p class="amenities-subtitle">Enjoy premium student living with everything you need</p>
            
            <div class="amenities-grid">
                <!-- Free WiFi -->
                <div class="amenity-card card-blue">
                    <svg class="amenity-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                    </svg>
                    <h3 class="amenity-name">Free WiFi</h3>
                </div>

                <!-- Electricity -->
                <div class="amenity-card card-yellow">
                    <svg class="amenity-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <h3 class="amenity-name">Electricity</h3>
                </div>

                <!-- Water -->
                <div class="amenity-card card-cyan">
                    <svg class="amenity-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h3 class="amenity-name">Water</h3>
                </div>

                <!-- Shared Kitchen -->
                <div class="amenity-card card-pink">
                    <svg class="amenity-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <h3 class="amenity-name">Shared Kitchen</h3>
                </div>

                <!-- Shared Bathroom -->
                <div class="amenity-card card-purple">
                    <svg class="amenity-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="amenity-name">Shared Bathroom</h3>
                </div>

                <!-- Near PUP -->
                <div class="amenity-card card-green">
                    <svg class="amenity-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h3 class="amenity-name">Near PUP</h3>
                </div>

                <!-- Laundry Area -->
                <div class="amenity-card card-orange">
                    <svg class="amenity-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <h3 class="amenity-name">Laundry Area</h3>
                </div>

                <!-- Affordable -->
                <div class="amenity-card card-teal">
                    <svg class="amenity-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="amenity-name">Affordable</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-column">
                <h3 class="footer-title">BOARDING HOMES</h3>
                <p class="footer-slogan">Your safe and affordable home near campus.</p>
            </div>

            <div class="footer-column">
                <h3 class="footer-title">QUICK LINKS</h3>
                <a href="#rooms" class="footer-link">Available Rooms</a>
                <a href="#" class="footer-link">Book a Visit</a>
                <a href="{{ route('login') }}" class="footer-link">Resident Log In</a>
            </div>

            <div class="footer-column">
                <h3 class="footer-title">CONTACT US</h3>
                <p class="footer-text">123 Diyan Lang, Manila</p>
                <p class="footer-text">Phone: 0922 222 2222</p>
                <p class="footer-text">Email: hello@gmail.com</p>
            </div>

            <div class="footer-column">
                <h3 class="footer-title">VISITING HOURS</h3>
                <p class="footer-text">Monday to Saturday</p>
                <p class="footer-text">10:00 AM to 5:00 PM</p>
            </div>
        </div>

        <hr class="footer-divider">

        <div class="footer-copyright">
            <p>© 2026 BOARDING HOMES. All Rights Reserved.</p>
        </div>
    </footer>
    
    <!-- Scroll to Top Button -->
    <button id="scrollTopBtn" class="scroll-top-btn" onclick="scrollToTop()">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <script src="{{ asset('js/homepage.js') }}"></script>
</body>
</html>