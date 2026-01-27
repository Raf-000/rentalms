@extends('layouts.admin-layout')

@section('content')
<div class="content-header">
    <h1>Create Viewing Booking</h1>
</div>

<div style="background:white;padding:30px;border-radius:8px;max-width:600px;">
    <form method="POST" action="{{ route('admin.viewing-bookings.store') }}">
        @csrf

        <label>Name *</label>
        <input type="text" name="name" value="{{ old('name') }}" required>

        <label>Email *</label>
        <input type="email" name="email" value="{{ old('email') }}" required>

        <label>Phone</label>
        <input type="text" name="phone" value="{{ old('phone') }}">

        <label>Gender *</label>
        <select name="gender" required>
            <option value="male" {{ old('gender')=='male'?'selected':'' }}>Male</option>
            <option value="female" {{ old('gender')=='female'?'selected':'' }}>Female</option>
        </select>

        <label>Bedspace</label>
        <select name="bedspace_id">
            <option value="">Not assigned</option>
            @foreach($bedspaces as $bedspace)
                <option value="{{ $bedspace->unitID }}" {{ old('bedspace_id')==$bedspace->unitID?'selected':'' }}>
                    {{ $bedspace->unitCode }}
                </option>
            @endforeach
        </select>

        <label>Preferred Date *</label>
        <input type="date" name="preferred_date" value="{{ old('preferred_date',date('Y-m-d')) }}" required>

        <label>Preferred Time *</label>
        <input type="text" name="preferred_time" value="{{ old('preferred_time') }}" required>

        <label>Message</label>
        <textarea name="message">{{ old('message') }}</textarea>

        <label>Status *</label>
        <select name="status" required>
            <option value="pending" {{ old('status')=='pending'?'selected':'' }}>Pending</option>
            <option value="approved" {{ old('status')=='approved'?'selected':'' }}>Approved</option>
            <option value="cancelled" {{ old('status')=='cancelled'?'selected':'' }}>Cancelled</option>
        </select>

        <div style="margin-top:20px;display:flex;gap:10px;">
            <a href="{{ route('admin.viewing-bookings.index') }}" style="flex:1;text-align:center;background:#6c757d;color:white;padding:10px;border-radius:4px;text-decoration:none;">Cancel</a>
            <button type="submit" style="flex:1;background:#007bff;color:white;padding:10px;border:none;border-radius:4px;">Save</button>
        </div>
    </form>
</div>
@endsection
