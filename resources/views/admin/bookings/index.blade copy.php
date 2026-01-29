@extends('layouts.admin-layout')

<style>
.action-icon-btn {
    width: 36px;
    height: 36px;
    border-radius: 0.75rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}
</style>

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-[#f6f8f7]/80 to-[#E2E8E7]/80">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold text-[#135757]">Viewing Bookings</h1>
                <p class="text-gray-600 text-sm sm:text-base">Manage room viewing appointments</p>
            </div>
            <a href="{{ route('admin.bookings.create') }}"
               class="px-4 py-2 bg-[#28a745] text-white font-semibold rounded-lg hover:opacity-90 transition">
               + Add Booking
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-green-500">
                <p class="text-xs uppercase tracking-wide text-gray-500">Viewings This Month</p>
                <p class="mt-2 text-3xl sm:text-4xl font-bold text-green-600">{{ $stats['thisMonth'] }}</p>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">{{ now()->format('F Y') }}</p>
            </div>
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-yellow-500">
                <p class="text-xs uppercase tracking-wide text-gray-500">Pending Confirmation</p>
                <p class="mt-2 text-3xl sm:text-4xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Awaiting response</p>
            </div>
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-blue-500">
                <p class="text-xs uppercase tracking-wide text-gray-500">Confirmed Viewings</p>
                <p class="mt-2 text-3xl sm:text-4xl font-bold text-blue-600">{{ $stats['confirmed'] }}</p>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Scheduled appointments</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-lg">
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-gray-600 text-xs sm:text-sm font-semibold mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#135757] focus:outline-none text-sm">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-600 text-xs sm:text-sm font-semibold mb-1">From Date</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#135757] focus:outline-none text-sm">
                </div>
                <div>
                    <label class="block text-gray-600 text-xs sm:text-sm font-semibold mb-1">To Date</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#135757] focus:outline-none text-sm">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-[#135757] text-white rounded-lg hover:opacity-90 transition text-sm">Filter</button>
                    <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg text-sm hover:opacity-90 transition">Reset</a>
                </div>
            </form>
        </div>

        <!-- Bookings List -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-lg overflow-x-auto">
            <table class="min-w-full text-left border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-xs sm:text-sm font-semibold text-gray-600">ID</th>
                        <th class="px-4 py-3 text-xs sm:text-sm font-semibold text-gray-600">Name</th>
                        <th class="px-4 py-3 text-xs sm:text-sm font-semibold text-gray-600">Contact</th>
                        <th class="px-4 py-3 text-xs sm:text-sm font-semibold text-gray-600">Bedspace</th>
                        <th class="px-4 py-3 text-xs sm:text-sm font-semibold text-gray-600">Viewing Date</th>
                        <th class="px-4 py-3 text-xs sm:text-sm font-semibold text-gray-600 text-center">Status</th>
                        <th class="px-4 py-3 text-xs sm:text-sm font-semibold text-gray-600 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm">#{{ $booking->id }}</td>
                        <td class="px-4 py-3 text-sm font-medium">
                            {{ $booking->name }}<br>
                            <span class="text-gray-500 text-xs">{{ ucfirst($booking->gender) }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $booking->email }}<br>
                            {{ $booking->phone }}
                        </td>
                        <td class="px-4 py-3 text-sm font-medium text-green-600">
                            {{ $booking->bedspace->unitCode ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ \Carbon\Carbon::parse($booking->preferred_date)->format('M d, Y') }}
                            @if($booking->preferred_time)
                            <br><span class="text-gray-500 text-xs">{{ $booking->preferred_time }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase
                                {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-700' :
                                   ($booking->status == 'completed' ? 'bg-blue-100 text-blue-700' :
                                   ($booking->status == 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700')) }}">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex flex-wrap justify-center gap-2">
                                <!-- Edit -->
                                <a href="{{ route('admin.bookings.edit', $booking->id) }}" 
                                   class="action-icon-btn bg-blue-600 text-white hover:bg-blue-700" data-tooltip="Edit">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <!-- Conditional Actions -->
                                @if($booking->status == 'pending')
                                <button onclick="showConfirmModal({{ $booking->id }}, '{{ $booking->name }}')" 
                                        class="action-icon-btn bg-green-500 text-white hover:bg-green-600" data-tooltip="Confirm">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                                @elseif($booking->status == 'confirmed')
                                <button onclick="showCompleteModal({{ $booking->id }}, '{{ $booking->name }}')" 
                                        class="action-icon-btn bg-teal-500 text-white hover:bg-teal-600" data-tooltip="Mark Complete">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>
                                @endif
                                @if(!in_array($booking->status, ['completed','cancelled']))
                                <button onclick="showCancelModal({{ $booking->id }}, '{{ $booking->name }}')" 
                                        class="action-icon-btn bg-yellow-400 text-gray-800 hover:bg-yellow-500" data-tooltip="Cancel">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                                @endif
                                <button onclick="showDeleteModal({{ $booking->id }}, '{{ $booking->name }}')" 
                                        class="action-icon-btn bg-red-600 text-white hover:bg-red-700" data-tooltip="Delete">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-16 text-center text-gray-400">No bookings found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Confirm Modal -->
        <div id="confirmModal" class="modal">
            <div style="background: white; border-radius: 8px; max-width: 450px; width: 90%; padding: 30px;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="width: 50px; height: 50px; background-color: #d4edda; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <span style="color: #28a745; font-size: 24px;">✓</span>
                    </div>
                    <h3 style="margin: 0 0 10px 0; font-size: 18px;">Confirm Viewing</h3>
                    <p style="color: #666; margin: 0; font-size: 14px;">
                        Confirm viewing appointment for <strong id="confirmBookingName"></strong>?
                    </p>
                </div>
                
                <form id="confirmForm" method="POST" style="display: flex; gap: 10px;">
                    @csrf
                    <button type="button" onclick="closeConfirmModal()" 
                            style="flex: 1; padding: 10px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Close
                    </button>
                    <button type="submit" 
                            style="flex: 1; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Confirm
                    </button>
                </form>
            </div>
        </div>

        <!-- Complete Modal -->
        <div id="completeModal" class="modal">
            <div style="background: white; border-radius: 8px; max-width: 450px; width: 90%; padding: 30px;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="width: 50px; height: 50px; background-color: #d1ecf1; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <span style="color: #17a2b8; font-size: 24px;">✓</span>
                    </div>
                    <h3 style="margin: 0 0 10px 0; font-size: 18px;">Mark as Completed</h3>
                    <p style="color: #666; margin: 0; font-size: 14px;">
                        Mark viewing as completed for <strong id="completeBookingName"></strong>?
                    </p>
                </div>
                
                <form id="completeForm" method="POST" style="display: flex; gap: 10px;">
                    @csrf
                    <button type="button" onclick="closeCompleteModal()" 
                            style="flex: 1; padding: 10px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Close
                    </button>
                    <button type="submit" 
                            style="flex: 1; padding: 10px; background-color: #17a2b8; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Complete
                    </button>
                </form>
            </div>
        </div>

        <!-- Cancel Modal -->
        <div id="cancelModal" class="modal">
            <div style="background: white; border-radius: 8px; max-width: 450px; width: 90%; padding: 30px;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="width: 50px; height: 50px; background-color: #fff3cd; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <span style="color: #ffc107; font-size: 24px;">⚠</span>
                    </div>
                    <h3 style="margin: 0 0 10px 0; font-size: 18px;">Cancel Booking</h3>
                    <p style="color: #666; margin: 0; font-size: 14px;">
                        Cancel the booking for <strong id="cancelBookingName"></strong>?
                    </p>
                </div>
                
                <form id="cancelForm" method="POST" style="display: flex; gap: 10px;">
                    @csrf
                    <button type="button" onclick="closeCancelModal()" 
                            style="flex: 1; padding: 10px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Close
                    </button>
                    <button type="submit" 
                            style="flex: 1; padding: 10px; background-color: #ffc107; color: #333; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">
                        Cancel Booking
                    </button>
                </form>
            </div>
        </div>

        <!-- Delete Modal -->
        <div id="deleteModal" class="modal">
            <div style="background: white; border-radius: 8px; max-width: 450px; width: 90%; padding: 30px;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="width: 50px; height: 50px; background-color: #fee; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <span style="color: #dc3545; font-size: 24px;">🗑️</span>
                    </div>
                    <h3 style="margin: 0 0 10px 0; font-size: 18px;">Delete Permanently</h3>
                    <p style="color: #666; margin: 0; font-size: 14px;">
                        Permanently delete booking for <strong id="deleteBookingName"></strong>?
                    </p>
                    <p style="color: #dc3545; margin: 10px 0 0 0; font-size: 13px; font-weight: 600;">
                        ⚠️ This action cannot be undone!
                    </p>
                </div>
                <form id="deleteForm" method="POST" style="display: flex; gap: 10px;">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="closeDeleteModal()" 
                            style="flex: 1; padding: 10px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Close
                    </button>
                    <button type="submit" 
                            style="flex: 1; padding: 10px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Confirm Modal
function showConfirmModal(id, name) {
    document.getElementById('confirmBookingName').textContent = name;
    document.getElementById('confirmForm').action = `/admin/bookings/${id}/confirm`;
    document.getElementById('confirmModal').classList.add('show');
}

function closeConfirmModal() {
    document.getElementById('confirmModal').classList.remove('show');
}

// Complete Modal
function showCompleteModal(id, name) {
    document.getElementById('completeBookingName').textContent = name;
    document.getElementById('completeForm').action = `/admin/bookings/${id}/complete`;
    document.getElementById('completeModal').classList.add('show');
}

function closeCompleteModal() {
    document.getElementById('completeModal').classList.remove('show');
}

// Cancel Modal
function showCancelModal(id, name) {
    document.getElementById('cancelBookingName').textContent = name;
    document.getElementById('cancelForm').action = `/admin/bookings/${id}/cancel`;
    document.getElementById('cancelModal').classList.add('show');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.remove('show');
}

// Delete Modal
function showDeleteModal(id, name) {
    document.getElementById('deleteBookingName').textContent = name;
    document.getElementById('deleteForm').action = `/admin/bookings/${id}`;
    document.getElementById('deleteModal').classList.add('show');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('show');
}

// Close modals on outside click
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('show');
    }
}
</script>
@endsection
