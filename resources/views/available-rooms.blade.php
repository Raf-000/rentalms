@extends('layouts.public-layout')

@section('title', 'Available Rooms - Boarding Homes')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/available-rooms.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection

@section('content')
<!-- Simple Header with Back Button -->
<div class="simple-header">
    <a href="/" class="back-btn">
        <span>&lt;</span> Home
    </a>
</div>

<!-- Main Content -->
<div class="main-content">
    <h1 class="page-title">Available Rooms</h1>

    <div class="houses-container">
        <!-- House 1: Mixed Gender -->
        <div class="house-card">
            <h2 class="house-title">
                <svg class="house-icon house1-color" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                MIXED GENDER HOUSE
            </h2>
            
            <!-- Floor 3 -->
            <div class="floor-section">
                <h3 class="floor-title">3RD FLOOR</h3>
                <p class="floor-note">For landlord use only</p>
            </div>

            <div class="floor-divider"></div>

            <!-- Floor 2 (Girls Only) -->
            @if(isset($bedspaces[1][2]))
            <div class="floor-section">
                <h3 class="floor-title">2ND FLOOR (GIRLS ONLY)</h3>
                
                <div class="rooms-grid single-room">
                    @foreach($bedspaces[1][2] as $roomNo => $beds)
                    @php
                        $total = $beds->count();
                        $occupied = $beds->where('status', 'occupied')->count();
                        $available = $total - $occupied;
                        $price = $beds->first()->price;
                    @endphp
                    
                    <div class="room-card">
                        <div class="room-header">
                            <p class="room-name">Room {{ $roomNo }}</p>
                            <p class="room-price">₱{{ number_format($price, 0) }}</p>
                        </div>
                        
                        <div class="beds-grid">
                            @foreach($beds as $bed)
                                <i class="fa-solid fa-bed bed-icon {{ $bed->status }}"></i>
                            @endforeach
                        </div>
                        
                        <p class="availability-text">{{ $available }} out of {{ $total }} units available</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="floor-divider"></div>
            @endif

            <!-- Floor 1 (Boys Only) -->
            @if(isset($bedspaces[1][1]))
            <div class="floor-section">
                <h3 class="floor-title">1ST FLOOR (BOYS ONLY)</h3>
                
                <div class="rooms-grid">
                    @foreach($bedspaces[1][1] as $roomNo => $beds)
                    @php
                        $total = $beds->count();
                        $occupied = $beds->where('status', 'occupied')->count();
                        $available = $total - $occupied;
                        $price = $beds->first()->price;
                    @endphp
                    
                    <div class="room-card">
                        <div class="room-header">
                            <p class="room-name">Room {{ $roomNo }}</p>
                            <p class="room-price">₱{{ number_format($price, 0) }}</p>
                        </div>
                        
                        <div class="beds-grid">
                            @foreach($beds as $bed)
                                <i class="fa-solid fa-bed bed-icon {{ $bed->status }}"></i>
                            @endforeach
                        </div>
                        
                        <p class="availability-text">{{ $available }} out of {{ $total }} units available</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Book Viewing Button -->
            <div class="book-section">
                <a href="{{ route('book-viewing') }}" class="book-btn">BOOK VIEWING</a>
            </div>
        </div>

        <!-- House 2: Girls Only -->
        <div class="house-card">
            <h2 class="house-title">
                <svg class="house-icon house2-color" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                GIRLS ONLY HOUSE
            </h2>
            
            <!-- Floor 2 -->
            @if(isset($bedspaces[2][2]))
            <div class="floor-section">
                <h3 class="floor-title">2ND FLOOR</h3>
                
                <div class="rooms-grid">
                    @foreach($bedspaces[2][2] as $roomNo => $beds)
                    @php
                        $total = $beds->count();
                        $occupied = $beds->where('status', 'occupied')->count();
                        $available = $total - $occupied;
                        $price = $beds->first()->price;
                    @endphp
                    
                    <div class="room-card">
                        <div class="room-header">
                            <p class="room-name">Room {{ $roomNo }}</p>
                            <p class="room-price">₱{{ number_format($price, 0) }}</p>
                        </div>
                        
                        <div class="beds-grid">
                            @foreach($beds as $bed)
                                <i class="fa-solid fa-bed bed-icon {{ $bed->status }}"></i>
                            @endforeach
                        </div>
                        
                        <p class="availability-text">{{ $available }} out of {{ $total }} units available</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="floor-divider"></div>
            @endif

            <!-- Floor 1 -->
            @if(isset($bedspaces[2][1]))
            <div class="floor-section">
                <h3 class="floor-title">1ST FLOOR</h3>
                
                <div class="rooms-grid">
                    @foreach($bedspaces[2][1] as $roomNo => $beds)
                    @php
                        $total = $beds->count();
                        $occupied = $beds->where('status', 'occupied')->count();
                        $available = $total - $occupied;
                        $price = $beds->first()->price;
                    @endphp
                    
                    <div class="room-card">
                        <div class="room-header">
                            <p class="room-name">Room {{ $roomNo }}</p>
                            <p class="room-price">₱{{ number_format($price, 0) }}</p>
                        </div>
                        
                        <div class="beds-grid">
                            @foreach($beds as $bed)
                                <i class="fa-solid fa-bed bed-icon {{ $bed->status }}"></i>
                            @endforeach
                        </div>
                        
                        <p class="availability-text">{{ $available }} out of {{ $total }} units available</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Book Viewing Button -->
            <div class="book-section">
                <a href="{{ route('book-viewing') }}" class="book-btn">BOOK VIEWING</a>
            </div>
        </div>
    </div>
</div>
@endsection