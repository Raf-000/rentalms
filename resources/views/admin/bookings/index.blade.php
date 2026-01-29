@extends('layouts.admin-layout')

@section('content')
<!-- Success Notification -->
@if(session('success'))
<div id="successNotification" class="fixed top-20 left-1/2 transform -translate-x-1/2 -translate-y-32 transition-all duration-500 ease-out z-[10000]">
    <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl border-l-4 border-green-500 px-6 py-4 flex items-center gap-4 min-w-[400px]">
        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
        </div>
        <div class="flex-1">
            <p class="font-semibold text-[#135757] text-lg">Success!</p>
            <p class="text-gray-600 text-sm">{{ session('success') }}</p>
        </div>
        <button onclick="closeNotification()" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const notification = document.getElementById('successNotification');
    if (notification) {
        setTimeout(() => {
            notification.style.transform = 'translateX(-50%) translateY(0)';
        }, 100);
        
        setTimeout(() => {
            closeNotification();
        }, 5000);
    }
});

function closeNotification() {
    const notification = document.getElementById('successNotification');
    if (notification) {
        notification.style.transform = 'translateX(-50%) translateY(-8rem)';
        setTimeout(() => {
            notification.remove();
        }, 500);
    }
}
</script>
@endif

<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(to bottom, rgba(246, 248, 247, 0.85), rgba(226, 232, 231, 0.85)); backdrop-filter: blur(5px);">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-4xl font-bold text-[#135757] mb-2">Viewing Bookings</h1>
                <p class="text-gray-700 text-lg font-medium">Manage room viewing appointments</p>
            </div>
            <a href="{{ route('admin.bookings.create') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#135757] to-[#1a7272] text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add Booking
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-green-500 hover:shadow-xl transition-all duration-300">
                <p class="text-xs uppercase tracking-wide text-gray-600 font-semibold mb-2">Viewings This Month</p>
                <p class="text-4xl font-bold text-green-600">{{ $stats['thisMonth'] }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ now()->format('F Y') }}</p>
            </div>
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-yellow-500 hover:shadow-xl transition-all duration-300">
                <p class="text-xs uppercase tracking-wide text-gray-600 font-semibold mb-2">Pending Confirmation</p>
                <p class="text-4xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                <p class="text-sm text-gray-500 mt-1">Awaiting response</p>
            </div>
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300">
                <p class="text-xs uppercase tracking-wide text-gray-600 font-semibold mb-2">Confirmed Viewings</p>
                <p class="text-4xl font-bold text-blue-600">{{ $stats['confirmed'] }}</p>
                <p class="text-sm text-gray-500 mt-1">Scheduled appointments</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-lg mb-6">
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-semibold text-[#135757] mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-[#135757] mb-2">From Date</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-[#135757] mb-2">To Date</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white">
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-[#135757] to-[#1a7272] text-white rounded-lg hover:shadow-lg transition-all duration-200 font-semibold">
                        Filter
                    </button>
                    <a href="{{ route('admin.bookings.index') }}" class="px-4 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 font-semibold">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Bookings Table -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-[#f6f8f7]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-[#135757] uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-[#135757] uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-[#135757] uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-[#135757] uppercase tracking-wider">Bedspace</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-[#135757] uppercase tracking-wider">Viewing Date</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-[#135757] uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-[#135757] uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $booking->id }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-[#135757]">{{ $booking->name }}</div>
                                <div class="text-xs text-gray-500">{{ ucfirst($booking->gender) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700">{{ $booking->email }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->phone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-[#135757]">{{ $booking->bedspace->unitCode ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->preferred_date)->format('M d, Y') }}</div>
                                @if($booking->preferred_time)
                                <div class="text-xs text-gray-500">{{ $booking->preferred_time }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                    {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-700' :
                                       ($booking->status == 'completed' ? 'bg-blue-100 text-blue-700' :
                                       ($booking->status == 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700')) }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.bookings.edit', $booking->id) }}" 
                                       class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200 flex items-center justify-center"
                                       title="Edit">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    
                                    @if($booking->status == 'pending')
                                    <button onclick="showConfirmModal({{ $booking->id }}, '{{ $booking->name }}')" 
                                            class="w-8 h-8 rounded-lg bg-green-100 text-green-600 hover:bg-green-600 hover:text-white transition-all duration-200 flex items-center justify-center"
                                            title="Confirm">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>
                                    @elseif($booking->status == 'confirmed')
                                    <button onclick="showCompleteModal({{ $booking->id }}, '{{ $booking->name }}')" 
                                            class="w-8 h-8 rounded-lg bg-teal-100 text-teal-600 hover:bg-teal-600 hover:text-white transition-all duration-200 flex items-center justify-center"
                                            title="Complete">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                    @endif
                                    
                                    @if(!in_array($booking->status, ['completed','cancelled']))
                                    <button onclick="showCancelModal({{ $booking->id }}, '{{ $booking->name }}')" 
                                            class="w-8 h-8 rounded-lg bg-yellow-100 text-yellow-600 hover:bg-yellow-600 hover:text-white transition-all duration-200 flex items-center justify-center"
                                            title="Cancel">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                    @endif
                                    
                                    <button onclick="showDeleteModal({{ $booking->id }}, '{{ $booking->name }}')" 
                                            class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-600 hover:text-white transition-all duration-200 flex items-center justify-center"
                                            title="Delete">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center text-gray-400 text-lg">
                                <svg class="w-16 h-16 mx-auto mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                No bookings found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<style>
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(3px);
}

.modal-overlay.show {
    display: flex;
}
</style>

<!-- Confirm Modal -->
<div id="confirmModal" class="modal-overlay">
    <div class="bg-white rounded-2xl max-w-md w-11/12 p-8 shadow-2xl">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg width="32" height="32" fill="none" stroke="#22c55e" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-[#135757] mb-2">Confirm Viewing</h3>
            <p class="text-gray-600">Confirm viewing appointment for <strong id="confirmBookingName" class="text-[#135757]"></strong>?</p>
        </div>
        
        <form id="confirmForm" method="POST" class="flex gap-3">
            @csrf
            <button type="button" onclick="closeConfirmModal()" 
                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition duration-200">
                Cancel
            </button>
            <button type="submit" 
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-lg hover:shadow-lg transition duration-200">
                Confirm
            </button>
        </form>
    </div>
</div>

<!-- Complete Modal -->
<div id="completeModal" class="modal-overlay">
    <div class="bg-white rounded-2xl max-w-md w-11/12 p-8 shadow-2xl">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg width="32" height="32" fill="none" stroke="#14b8a6" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-[#135757] mb-2">Mark as Completed</h3>
            <p class="text-gray-600">Mark viewing as completed for <strong id="completeBookingName" class="text-[#135757]"></strong>?</p>
        </div>
        
        <form id="completeForm" method="POST" class="flex gap-3">
            @csrf
            <button type="button" onclick="closeCompleteModal()" 
                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition duration-200">
                Cancel
            </button>
            <button type="submit" 
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-lg hover:shadow-lg transition duration-200">
                Complete
            </button>
        </form>
    </div>
</div>

<!-- Cancel Modal -->
<div id="cancelModal" class="modal-overlay">
    <div class="bg-white rounded-2xl max-w-md w-11/12 p-8 shadow-2xl">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg width="32" height="32" fill="none" stroke="#f59e0b" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-[#135757] mb-2">Cancel Booking</h3>
            <p class="text-gray-600">Cancel the booking for <strong id="cancelBookingName" class="text-[#135757]"></strong>?</p>
        </div>
        
        <form id="cancelForm" method="POST" class="flex gap-3">
            @csrf
            <button type="button" onclick="closeCancelModal()" 
                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition duration-200">
                Close
            </button>
            <button type="submit" 
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-900 font-semibold rounded-lg hover:shadow-lg transition duration-200">
                Cancel Booking
            </button>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal-overlay">
    <div class="bg-white rounded-2xl max-w-md w-11/12 p-8 shadow-2xl">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg width="32" height="32" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-[#135757] mb-2">Delete Permanently</h3>
            <p class="text-gray-600 mb-4">Permanently delete booking for <strong id="deleteBookingName" class="text-[#135757]"></strong>?</p>
            <p class="text-red-600 text-sm font-semibold">⚠️ This action cannot be undone!</p>
        </div>
        
        <form id="deleteForm" method="POST" class="flex gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteModal()" 
                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition duration-200">
                Cancel
            </button>
            <button type="submit" 
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-lg hover:shadow-lg transition duration-200">
                Delete
            </button>
        </form>
    </div>
</div>

<script>
// Modal Functions
function showConfirmModal(id, name) {
    document.getElementById('confirmBookingName').textContent = name;
    document.getElementById('confirmForm').action = `/admin/bookings/${id}/confirm`;
    document.getElementById('confirmModal').classList.add('show');
}

function closeConfirmModal() {
    document.getElementById('confirmModal').classList.remove('show');
}

function showCompleteModal(id, name) {
    document.getElementById('completeBookingName').textContent = name;
    document.getElementById('completeForm').action = `/admin/bookings/${id}/complete`;
    document.getElementById('completeModal').classList.add('show');
}

function closeCompleteModal() {
    document.getElementById('completeModal').classList.remove('show');
}

function showCancelModal(id, name) {
    document.getElementById('cancelBookingName').textContent = name;
    document.getElementById('cancelForm').action = `/admin/bookings/${id}/cancel`;
    document.getElementById('cancelModal').classList.add('show');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.remove('show');
}

function showDeleteModal(id, name) {
    document.getElementById('deleteBookingName').textContent = name;
    document.getElementById('deleteForm').action = `/admin/bookings/${id}`;
    document.getElementById('deleteModal').classList.add('show');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('show');
}

// Close modals on outside click
document.querySelectorAll('.modal-overlay').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('show');
        }
    });
});

// Close on ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('show'));
    }
});
</script>
@endsection