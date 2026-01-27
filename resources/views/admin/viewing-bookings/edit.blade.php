@extends('layouts.admin-layout')

@section('content')
<div class="content-header">
    <h1>Edit Viewing Booking</h1>
</div>

<div style="background:white;padding:30px;border-radius:8px;max-width:600px;">
    <form method="POST" action="{{ route('admin.viewing-bookings.update',$booking->id) }}">
        @csrf @method('PUT')

        <!-- Name -->
        <label>Name *</label>
        <input type="text" name="name" value="{{ old('name',$booking->name) }}" required>

        <!-- Email -->
        <label>Email *</label>
        <input type="email" name="email" value="{{ old('email',$booking->email) }}" required>

        <!-- Phone -->
        <label>Phone</label>
        <input type="text" name="phone" value="{{ old('phone',$booking->phone) }}">

        <!-- Gender -->
        <label>Gender *</label>
        <select name="gender" required>
            <option value="male" {{ old('gender',$booking->gender)=='male'?'selected':'' }}>Male</option>
            <option value="female" {{ old('gender',$booking->gender)=='female'?'selected':'' }}>Female</option>
        </select>

        <!-- Bedspace -->
        <label>Bedspace</label>
        <select name="bedspace_id">
            <option value="">Not assigned</option>
            @foreach($bedspaces as $bedspace)
                <option value="{{ $bedspace->unitID }}" {{ old('bedspace_id',$booking->bedspace_id)==$bedspace->unitID?'selected':'' }}>
                    {{ $bedspace->unitCode }}
                </option>
            @endforeach
        </select>

        <!-- Preferred Date -->
        <label>Preferred Date *</label>
        <input type="date" name="preferred_date" value="{{ old('preferred_date',$booking->preferred_date) }}" required>

        <!-- Preferred Time -->
        <label>Preferred Time *</label>
        <input type="text" name="preferred_time" value="{{ old('preferred_time',$booking->preferred_time) }}" required>

        <!-- Message -->
        <label>Message</label>
        <textarea name="message">{{ old('message',$booking->message) }}</textarea>

        <!-- Status -->
        <label>Status *</label>
        <select name="status" required>
            <option value="pending" {{ old('status',$booking->status)=='pending'?'selected':'' }}>Pending</option>
            <option value="approved" {{ old('status',$booking->status)=='approved'?'selected':'' }}>Approved</option>
            <option value="cancelled" {{ old('status',$booking->status)=='cancelled'?'selected':'' }}>Cancelled</option>
        </select>

        <!-- Buttons -->
        <div style="margin-top:20px;display:flex;gap:10px;">
            <a href="{{ route('admin.viewing-bookings.index') }}" style="flex:1;text-align:center;background:#6c757d;color:white;padding:10px;border-radius:4px;text-decoration:none;">Cancel</a>
            <button type="submit" style="flex:1;background:#007bff;color:white;padding:10px;border:none;border-radius:4px;">Update Booking</button>
        </div>
    </form>
</div>
@endsection
