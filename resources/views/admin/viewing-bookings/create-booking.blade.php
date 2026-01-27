@extends('layouts.admin-layout')

@section('content')
<div class="content-header">
    <h1>Create Viewing Booking</h1>
    <p>Manually add a booking</p>
</div>

<div style="background: white; padding: 30px; border-radius: 8px; max-width: 600px;">
    <form method="POST" action="{{ route('admin.viewing-bookings.store') }}">
        @csrf

        <!-- Name -->
        <div style="margin-bottom: 20px;">
            <label>Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <!-- Email -->
        <div style="margin-bottom: 20px;">
            <label>Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <!-- Phone -->
        <div style="margin-bottom: 20px;">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}">
        </div>

        <!-- Gender -->
        <div style="margin-bottom: 20px;">
            <label>Gender *</label>
            <select name="gender" required>
                <option value="male" {{ old('gender')=='male'?'selected':'' }}>Male</option>
                <option value="female" {{ old('gender')=='female'?'selected':'' }}>Female</option>
            </select>
        </div>

        <!-- Bedspace -->
        <div style="margin-bottom: 20px;">
            <label>Bedspace</label>
            <select name="bedspace_id">
                <option value="">Not assigned</option>
                @foreach($bedspaces as $bedspace)
                    <option value="{{ $bedspace->unitID }}" {{ old('bedspace_id')==$bedspace->unitID?'selected':'' }}>
                        {{ $bedspace->unitCode }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Preferred Date -->
        <div style="margin-bottom: 20px;">
            <label>Preferred Date *</label>
            <input type="date" name="preferred_date" value="{{ old('preferred_date', date('Y-m-d')) }}" required>
        </div>

        <!-- Preferred Time -->
        <div style="margin-bottom: 20px;">
            <label>Preferred Time *</label>
            <input type="text" name="preferred_time" value="{{ old('preferred_time') }}" required>
        </div>

        <!-- Message -->
        <div style="margin-bottom: 20px;">
            <label>Message</label>
            <textarea name="message">{{ old('message') }}</textarea>
        </div>

        <!-- Status -->
        <div style="margin-bottom: 20px;">
            <label>Status *</label>
            <select name="status" required>
                <option value="pending" {{ old('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="approved" {{ old('status')=='approved'?'selected':'' }}>Approved</option>
                <option value="cancelled" {{ old('status')=='cancelled'?'selected':'' }}>Cancelled</option>
            </select>
        </div>

        <!-- Buttons -->
        <div style="display:flex; gap:10px;">
            <a href="{{ route('admin.viewing-bookings.index') }}">Cancel</a>
            <button type="submit">Save Booking</button>
        </div>
    </form>
</div>
@endsection
