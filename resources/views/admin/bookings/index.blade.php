@extends('layouts.admin-layout')

@section('extra-css')
<style>
.action-icon-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s;
    position: relative;
}

.action-icon-btn svg {
    width: 16px;
    height: 16px;
}

.action-icon-btn:hover::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background-color: rgba(0, 0, 0, 0.9);
    color: white;
    padding: 6px 10px;
    border-radius: 4px;
    font-size: 12px;
    white-space: nowrap;
    margin-bottom: 5px;
    z-index: 1000;
    pointer-events: none;
}

.action-icon-btn:hover::before {
    content: '';
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 5px solid transparent;
    border-top-color: rgba(0, 0, 0, 0.9);
    margin-bottom: -5px;
    pointer-events: none;
}

.btn-edit {
    background-color: #007bff;
    color: white;
}

.btn-edit:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
}

.btn-confirm {
    background-color: #28a745;
    color: white;
}

.btn-confirm:hover {
    background-color: #1e7e34;
    transform: translateY(-2px);
}

.btn-complete {
    background-color: #17a2b8;
    color: white;
}

.btn-complete:hover {
    background-color: #138496;
    transform: translateY(-2px);
}

.btn-cancel-action {
    background-color: #ffc107;
    color: #333;
}

.btn-cancel-action:hover {
    background-color: #e0a800;
    transform: translateY(-2px);
}

.btn-delete {
    background-color: #dc3545;
    color: white;
}

.btn-delete:hover {
    background-color: #c82333;
    transform: translateY(-2px);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.stat-card-booking {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border-left: 4px solid;
    transition: transform 0.2s;
}

.stat-card-booking:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.stat-card-booking.green { border-left-color: #28a745; }
.stat-card-booking.blue { border-left-color: #007bff; }
.stat-card-booking.teal { border-left-color: #17a2b8; }

.stat-value-booking {
    font-size: 32px;
    font-weight: bold;
    margin: 10px 0 5px 0;
}

.stat-label-booking {
    font-size: 13px;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.modal.show {
    display: flex;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="content-header">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        <div>
            <h1>Viewing Bookings</h1>
            <p>Manage room viewing appointments</p>
        </div>
        <a href="{{ route('admin.bookings.create') }}" 
           style="padding: 12px 24px; background-color: #28a745; color: white; text-decoration: none; border-radius: 6px; font-weight: 500;">
            + Add Booking
        </a>
    </div>
</div>

@if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #28a745;">
        {{ session('success') }}
    </div>
@endif

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card-booking green">
        <p class="stat-label-booking">Viewings This Month</p>
        <p class="stat-value-booking">{{ $stats['thisMonth'] }}</p>
        <p style="font-size: 12px; color: #666; margin: 0;">{{ now()->format('F Y') }}</p>
    </div>
    
    <div class="stat-card-booking blue">
        <p class="stat-label-booking">Pending Confirmation</p>
        <p class="stat-value-booking">{{ $stats['pending'] }}</p>
        <p style="font-size: 12px; color: #666; margin: 0;">Awaiting response</p>
    </div>
    
    <div class="stat-card-booking teal">
        <p class="stat-label-booking">Confirmed Viewings</p>
        <p class="stat-value-booking">{{ $stats['confirmed'] }}</p>
        <p style="font-size: 12px; color: #666; margin: 0;">Scheduled appointments</p>
    </div>
</div>

<!-- Filters -->
<div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px;">
    <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
        <div>
            <label style="display: block; margin-bottom: 5px; font-size: 13px; font-weight: 500;">Status</label>
            <select name="status" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        
        <div>
            <label style="display: block; margin-bottom: 5px; font-size: 13px; font-weight: 500;">From Date</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" 
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <div>
            <label style="display: block; margin-bottom: 5px; font-size: 13px; font-weight: 500;">To Date</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" 
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
        
        <div style="display: flex; gap: 10px;">
            <button type="submit" 
                    style="padding: 8px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Filter
            </button>
            <a href="{{ route('admin.bookings.index') }}" 
               style="padding: 8px 20px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 4px; display: inline-block;">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Bookings Table -->
<div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; min-width: 900px;">
        <thead style="background-color: #f8f9fa;">
            <tr>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: #666; font-weight: 600;">ID</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: #666; font-weight: 600;">Name</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: #666; font-weight: 600;">Contact</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: #666; font-weight: 600;">Bedspace</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: #666; font-weight: 600;">Viewing Date</th>
                <th style="padding: 12px; text-align: center; font-size: 13px; color: #666; font-weight: 600;">Status</th>
                <th style="padding: 12px; text-align: center; font-size: 13px; color: #666; font-weight: 600;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
            <tr style="border-bottom: 1px solid #e9ecef;">
                <td style="padding: 12px; font-size: 14px;">#{{ $booking->id }}</td>
                <td style="padding: 12px; font-size: 14px; font-weight: 500;">
                    {{ $booking->name }}
                    <br>
                    <span style="font-size: 12px; color: #666;">{{ ucfirst($booking->gender) }}</span>
                </td>
                <td style="padding: 12px; font-size: 13px;">
                    {{ $booking->email }}<br>
                    {{ $booking->phone }}
                </td>
                <td style="padding: 12px; font-size: 14px; font-weight: 500; color: #28a745;">
                    {{ $booking->bedspace->unitCode ?? 'N/A' }}
                </td>
                <td style="padding: 12px; font-size: 14px;">
                    {{ \Carbon\Carbon::parse($booking->preferred_date)->format('M d, Y') }}
                    @if($booking->preferred_time)
                    <br><span style="font-size: 12px; color: #666;">{{ $booking->preferred_time }}</span>
                    @endif
                </td>
                <td style="padding: 12px; text-align: center;">
                    <span style="padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; text-transform: uppercase;
                        {{ $booking->status == 'confirmed' ? 'background-color: #d4edda; color: #155724;' : 
                           ($booking->status == 'completed' ? 'background-color: #d1ecf1; color: #0c5460;' :
                           ($booking->status == 'cancelled' ? 'background-color: #f8d7da; color: #721c24;' : 'background-color: #fff3cd; color: #856404;')) }}">
                        {{ $booking->status }}
                    </span>
                </td>
                <td style="padding: 12px;">
                    <div style="display: flex; gap: 6px; justify-content: center; align-items: center; flex-wrap: wrap;">
                        <!-- Edit -->
                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" 
                           class="action-icon-btn btn-edit"
                           data-tooltip="Edit">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        
                        <!-- Confirm (only if pending) -->
                        @if($booking->status == 'pending')
                        <button onclick="showConfirmModal({{ $booking->id }}, '{{ $booking->name }}')" 
                                class="action-icon-btn btn-confirm"
                                data-tooltip="Confirm">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </button>
                        @endif
                        
                        <!-- Complete (only if confirmed) -->
                        @if($booking->status == 'confirmed')
                        <button onclick="showCompleteModal({{ $booking->id }}, '{{ $booking->name }}')" 
                                class="action-icon-btn btn-complete"
                                data-tooltip="Mark Complete">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                        @endif
                        
                        <!-- Cancel (only if not cancelled or completed) -->
                        @if(!in_array($booking->status, ['cancelled', 'completed']))
                        <button onclick="showCancelModal({{ $booking->id }}, '{{ $booking->name }}')"
                                class="action-icon-btn btn-cancel-action"
                                data-tooltip="Cancel">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        @endif
                        
                        <!-- Delete -->
                        <button onclick="showDeleteModal({{ $booking->id }}, '{{ $booking->name }}')"
                                class="action-icon-btn btn-delete"
                                data-tooltip="Delete">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding: 40px; text-align: center; color: #999;">
                    No bookings found
                </td>
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
