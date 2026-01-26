<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Viewing - Boarding Homes</title>
    <link rel="stylesheet" href="{{ asset('css/book-viewing.css') }}">
</head>
<body>
    <!-- Simple Header -->
    <div class="simple-header">
        <a href="{{ route('available-rooms') }}" class="back-btn">
            <span>&lt;</span> Available Rooms
        </a>
        <a href="/" class="home-btn">Home</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="form-container">
            <h1 class="page-title">Book a Viewing</h1>
            <p class="page-subtitle">Fill out the form below to schedule a visit to our boarding house</p>

            @if(session('success'))
                <div class="success-message">
                    <svg class="success-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('store-booking-ajax') }}" class="booking-form">
                @csrf

                <!-- Personal Information -->
                <div class="form-section">
                    <h3 class="section-title">Personal Information</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Full Name <span class="required">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender <span class="required">*</span></label>
                            <select id="gender" name="gender" required onchange="filterBedspaces()">
                                <option value="">Select gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                            @error('gender')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number <span class="required">*</span></label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="09XX XXX XXXX" required>
                            @error('phone')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Room Selection -->
                <div class="form-section">
                    <h3 class="section-title">Room Preference</h3>
                    
                    <div class="form-group">
                        <label for="bedspace_id">Select Room to View <span class="required">*</span></label>
                        <select id="bedspace_id" name="bedspace_id" required>
                            <option value="">Please select your gender first</option>
                            @foreach($bedspaces as $bedspace)
                                <option 
                                    value="{{ $bedspace->unitID }}" 
                                    data-gender="{{ $bedspace->restriction }}"
                                    style="display: none;"
                                    {{ old('bedspace_id') == $bedspace->unitID ? 'selected' : '' }}
                                >
                                    House {{ $bedspace->houseNo }} - Floor {{ $bedspace->floor }}, Room {{ $bedspace->roomNo }} (₱{{ number_format($bedspace->price, 0) }}/month)
                                </option>
                            @endforeach
                        </select>
                        @error('bedspace_id')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Schedule -->
                <div class="form-section">
                    <h3 class="section-title">Preferred Schedule</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="preferred_date">Preferred Date <span class="required">*</span></label>
                            <input type="date" id="preferred_date" name="preferred_date" value="{{ old('preferred_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            @error('preferred_date')
                                <span class="error-text">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="preferred_time">Preferred Time</label>
                            <select id="preferred_time" name="preferred_time">
                                <option value="">Select time (optional)</option>
                                <option value="Morning (9AM-12PM)" {{ old('preferred_time') == 'Morning (9AM-12PM)' ? 'selected' : '' }}>Morning (9AM-12PM)</option>
                                <option value="Afternoon (1PM-5PM)" {{ old('preferred_time') == 'Afternoon (1PM-5PM)' ? 'selected' : '' }}>Afternoon (1PM-5PM)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Additional Message -->
                <div class="form-section">
                    <h3 class="section-title">Additional Information</h3>
                    
                    <div class="form-group">
                        <label for="message">Message or Special Requests</label>
                        <textarea id="message" name="message" rows="4" placeholder="Any additional information or questions...">{{ old('message') }}</textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-actions">
                    <button type="submit" class="submit-btn">Submit Booking Request</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/book-viewing.js') }}"></script>
</body>
</html>