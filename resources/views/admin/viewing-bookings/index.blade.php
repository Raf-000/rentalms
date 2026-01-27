@extends('layouts.admin-layout')

@section('content')
<div class="content-header">
    <h1>Viewing Bookings</h1>
    <p>Manage all viewing requests</p>
</div>

@if(session('success'))
<div style="background-color:#d4edda;color:#155724;padding:12px;border-radius:6px;margin-bottom:20px;">
    {{ session('success') }}
</div>
@endif

<!-- Filters -->
<div style="background:white;padding:20px;border-radius:8px;margin-bottom:20px;">
    <form method="GET" style="display:flex;gap:15px;flex-wrap:wrap;">
        <div>
            <label>Status</label>
            <select name="status">
                <option value="">All</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
                <option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>Cancelled</option>
            </select>
        </div>
        <button type="submit" style="padding:8px 16px;background:#007bff;color:white;border:none;border-radius:4px;">Filter</button>
        <a href="{{ route('admin.viewing-bookings.index') }}" style="padding:8px 16px;background:#6c757d;color:white;border-radius:4px;text-decoration:none;">Reset</a>
    </form>
</div>

<!-- Table -->
<div style="background:white;border-radius:8px;overflow:hidden;">
    <table style="width:100%;border-collapse:collapse;">
        <thead style="background:#f8f9fa;">
            <tr>
                <th style="padding:10px;">Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Bedspace</th>
                <th>Preferred Date</th>
                <th>Preferred Time</th>
                <th>Status</th>
                <th style="text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
            <tr style="border-bottom:1px solid #eee;">
                <td>{{ $booking->name }}</td>
                <td>{{ $booking->email }}</td>
                <td>{{ $booking->phone ?? 'N/A' }}</td>
                <td>{{ ucfirst($booking->gender) }}</td>
                <td>{{ $booking->bedspace?->unitCode ?? 'Not assigned' }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->preferred_date)->format('M d, Y') }}</td>
                <td>{{ $booking->preferred_time }}</td>
                <td>{{ ucfirst($booking->status) }}</td>
                <td style="text-align:center;">
                    <a href="{{ route('admin.viewing-bookings.edit',$booking->id) }}" style="padding:6px 12px;background:#007bff;color:white;border-radius:4px;text-decoration:none;">Edit</a>
                    <form method="POST" action="{{ route('admin.viewing-bookings.delete',$booking->id) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" style="padding:6px 12px;background:#dc3545;color:white;border:none;border-radius:4px;">Cancel</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" style="padding:20px;text-align:center;color:#999;">No bookings found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
