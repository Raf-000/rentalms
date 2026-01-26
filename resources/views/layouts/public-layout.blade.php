<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Boarding Homes')</title>
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
    @yield('extra-css')
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

    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-column">
                <h3 class="footer-title">BOARDING HOMES</h3>
                <p class="footer-slogan">Your safe and affordable home near campus.</p>
            </div>

            <div class="footer-column">
                <h3 class="footer-title">QUICK LINKS</h3>
                <a href="{{ route('available-rooms') }}" class="footer-link">Available Rooms</a>
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

    @yield('extra-js')
</body>
</html> 