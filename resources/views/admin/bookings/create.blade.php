@extends('layouts.admin-layout')

@section('content')
<div class="content-header">
    <h1>Add New Booking</h1>
    <p>Manually create a viewing appointment</p>
</div>

<div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); max-width: 700px;">
    <form method="POST" action="{{ route('admin.bookings.store') }}">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <!-- Name -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                @error('name')
                    <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gender -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Gender *</label>
                <select name="gender" required
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                    <option value="">Select Gender</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('gender')
                    <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <!-- Email -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                @error('email')
                    <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Phone *</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                @error('phone')
                    <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Bedspace -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Bedspace to View *</label>
            <select name="bedspace_id" required
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                <option value="">Select Bedspace</option>
                @foreach($bedspaces as $bedspace)
                    <option value="{{ $bedspace->unitID }}" {{ old('bedspace_id') == $bedspace->unitID ? 'selected' : '' }}>
                        {{ $bedspace->unitCode }} - House {{ $bedspace->houseNo }}, Floor {{ $bedspace->floor }}, Room {{ $bedspace->roomNo }}, Bed {{ $bedspace->bedspaceNo }} (₱{{ number_format($bedspace->price, 0) }})
                    </option>
                @endforeach
            </select>
            @error('bedspace_id')
                <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <!-- Preferred Date -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Preferred Date *</label>
                <input type="date" name="preferred_date" value="{{ old('preferred_date', date('Y-m-d')) }}" required
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                @error('preferred_date')
                    <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Preferred Time -->
            <div>
                <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Preferred Time (Optional)</label>
                <input type="text" name="preferred_time" value="{{ old('preferred_time') }}" 
                       placeholder="e.g., 10:00 AM - 12:00 PM"
                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                @error('preferred_time')
                    <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Message -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Additional Notes (Optional)</label>
            <textarea name="message" rows="3"
                      style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-family: Arial, sans-serif; font-size: 14px;">{{ old('message') }}</textarea>
            @error('message')
                <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div style="margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Status *</label>
            <select name="status" required
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                <option value="pending" {{ old('status', $booking->status ?? 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ old('status', $booking->status ?? '') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="completed" {{ old('status', $booking->status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ old('status', $booking->status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @error('status')
                <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('admin.bookings.index') }}" 
               style="flex: 1; padding: 12px; background-color: #6c757d; color: white; border: none; border-radius: 6px; text-decoration: none; text-align: center; font-size: 15px;">
                Cancel
            </a>
            <button type="submit" 
                    style="flex: 1; padding: 12px; background-color: #28a745; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 15px;">
                Create Booking
            </button>
        </div>
    </form>
</div>
@endsection