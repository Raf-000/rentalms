@extends('layouts.public-layout')

@section('title', 'Boarding Homes - Your Safe and Affordable Home Near Campus')

@section('extra-css')
<style>
    /* Homepage-specific styles */
    body {
        overflow-x: hidden;
    }
</style>
@endsection

@section('content')
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
<section id="hero" class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">Welcome to Boarding Homes!</h1>
        <p class="hero-slogan">Your safe and affordable home near campus.</p>
        <div class="hero-buttons">
            <a href="{{ route('available-rooms') }}" class="btn btn-primary">See Available Rooms</a>
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
<section id="amenities" class="amenities-section">
    <div class="amenities-container">
        <h2 class="amenities-title">Amenities & Inclusions</h2>
        <p class="amenities-subtitle">Enjoy premium student living with everything you need</p>
        
        <div class="amenities-grid">
            <!-- Card 1: Free WiFi (Dark bg) -->
            <div class="amenity-card alt-dark">
                <svg class="amenity-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                </svg>
                <h3 class="amenity-name">Free WiFi</h3>
            </div>

            <!-- Card 2: Electricity (Light bg) -->
            <div class="amenity-card alt-light">
                <svg class="amenity-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <h3 class="amenity-name">Electricity</h3>
            </div>

            <!-- Card 3: Water (Dark bg) -->
            <div class="amenity-card alt-dark">
                <svg class="amenity-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="amenity-name">Water</h3>
            </div>

            <!-- Card 4: Shared Kitchen (Light bg) -->
            <div class="amenity-card alt-light">
                <svg class="amenity-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <h3 class="amenity-name">Shared Kitchen</h3>
            </div>

            <!-- Card 5: Shared Bathroom (Dark bg) -->
            <div class="amenity-card alt-dark">
                <svg class="amenity-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h3 class="amenity-name">Shared Bathroom</h3>
            </div>

            <!-- Card 6: Near PUP (Light bg) -->
            <div class="amenity-card alt-light">
                <svg class="amenity-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <h3 class="amenity-name">Near PUP</h3>
            </div>

            <!-- Card 7: Laundry Area (Dark bg) -->
            <div class="amenity-card alt-dark">
                <svg class="amenity-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="amenity-name">Laundry Area</h3>
            </div>

            <!-- Card 8: Affordable (Light bg) -->
            <div class="amenity-card alt-light">
                <svg class="amenity-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="amenity-name">Affordable</h3>
            </div>
        </div>
    </div>
</section>

<!-- Scroll to Top Button -->
<button id="scrollTopBtn" class="scroll-top-btn" onclick="scrollToTop()">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
    </svg>
</button>
@endsection

@section('extra-js')
<script src="{{ asset('js/homepage.js') }}"></script>
@endsection