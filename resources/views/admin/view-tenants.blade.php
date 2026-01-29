@extends('layouts.admin-layout')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/tenants.css') }}">
@endsection

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
// Slide down notification
document.addEventListener('DOMContentLoaded', function() {
    const notification = document.getElementById('successNotification');
    if (notification) {
        setTimeout(() => {
            notification.style.transform = 'translateX(-50%) translateY(0)';
        }, 100);
        
        // Auto hide after 5 seconds
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

<div class="tenants-wrapper py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-[#135757] mb-2">Tenants Management</h1>
            <p class="text-gray-700 text-lg font-medium">View and manage all tenant accounts</p>
        </div>

        <!-- Main Card -->
        <div class="tenants-card">
            <!-- Header with Filters -->
            <div class="card-header-tenants">
                <div class="header-row">
                    <div class="header-info">
                        <h2 class="card-title-tenants">All Tenants</h2>
                        <span class="tenant-count">{{ $tenants->count() }} tenant{{ $tenants->count() !== 1 ? 's' : '' }}</span>
                    </div>
                    
                    <div class="header-actions">
                        <select id="statusFilter" onchange="filterTable()" class="filter-select">
                            <option value="all">All Status</option>
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                        </select>
                        
                        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search by name..." class="search-input">
                    </div>
                </div>
            </div>

            <!-- Table -->
            @if($tenants->count() > 0)
                <div class="table-responsive">
                    <table id="tenantsTable" class="tenants-table">
                        <thead>
                            <tr>
                                <th class="tenant-name">TENANT</th>
                                <th class="tenant-contact">CONTACT</th>
                                <th class="tenant-bedspace">BEDSPACE</th>
                                <th class="tenant-lease">LEASE PERIOD</th>
                                <th class="tenant-balance">BALANCE</th>
                                <th class="tenant-status">STATUS</th>
                                <th class="tenant-actions" style="text-align: center;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tenants as $tenant)
                            @php
                                $unpaidBills = \App\Models\Bill::where('tenantID', $tenant->id)
                                    ->whereIn('status', ['pending', 'unpaid'])
                                    ->get();
                                $totalBalance = $unpaidBills->sum('amount');
                                $paymentStatus = $totalBalance > 0 ? 'unpaid' : 'paid';
                                $hasOverdue = $unpaidBills->where('dueDate', '<', now())->count() > 0;
                                
                                $tenantData = [
                                    'id' => $tenant->id,
                                    'name' => $tenant->name,
                                    'email' => $tenant->email,
                                    'phone' => $tenant->phone,
                                    'emergencyContact' => $tenant->emergencyContact,
                                    'bedspace' => $tenant->bedspace,
                                    'lease_start' => $tenant->leaseStart,
                                    'lease_end' => $tenant->leaseEnd,
                                    'total_balance' => $totalBalance
                                ];
                            @endphp
                            <tr class="tenant-row" 
                                data-name="{{ strtolower($tenant->name) }}" 
                                data-status="{{ $paymentStatus }}"
                                data-tenant-id="{{ $tenant->id }}">
                                <td class="tenant-name">
                                    <div class="tenant-info">
                                        <div class="tenant-avatar">{{ substr($tenant->name, 0, 1) }}</div>
                                        <div>
                                            <div class="tenant-name-text">{{ $tenant->name }}</div>
                                            <div class="tenant-email">{{ $tenant->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="tenant-contact">
                                    <div class="contact-info">
                                        <div class="phone-number">📱 {{ $tenant->phone ?? 'Not provided' }}</div>
                                        <div class="phone-number" style="color: #999;">🚨 {{ $tenant->emergencyContact ?? 'Not provided' }}</div>
                                    </div>
                                </td>
                                <td class="tenant-bedspace">
                                    @if($tenant->bedspace)
                                        <div>
                                            <div class="bedspace-code">{{ $tenant->bedspace->unitCode }}</div>
                                            <div class="bedspace-price">₱{{ number_format($tenant->bedspace->price, 2) }}/mo</div>
                                        </div>
                                    @else
                                        <span class="not-assigned">Not assigned</span>
                                    @endif
                                </td>
                                <td class="tenant-lease">
                                @if($tenant->leaseStart && $tenant->leaseEnd)
                                    <div class="lease-period">
                                        <div class="lease-start">{{ date('M d, Y', strtotime($tenant->leaseStart)) }}</div>
                                        <div class="lease-end">to {{ date('M d, Y', strtotime($tenant->leaseEnd)) }}</div>
                                    </div>
                                @else
                                    <span class="not-set">Not set</span>
                                @endif
                                </td>
                                <td class="tenant-balance">
                                    <div class="balance-amount {{ $totalBalance > 0 ? 'negative' : 'positive' }}">
                                        ₱{{ number_format($totalBalance, 2) }}
                                    </div>
                                </td>
                                <td class="tenant-status">
                                    <div class="status-badge {{ $hasOverdue ? 'overdue' : ($totalBalance > 0 ? 'unpaid' : 'paid') }}">
                                        <span class="badge-dot"></span>
                                        {{ $hasOverdue ? 'Overdue' : ($totalBalance > 0 ? 'Unpaid' : 'Paid') }}
                                    </div>
                                </td>
                                <td class="tenant-actions">
                                    <div class="action-buttons">
                                        <button onclick='viewTenant(@json($tenantData))' class="btn-icon btn-view" title="View Details">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                <circle cx="12" cy="12" r="3"></circle>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-20 text-center text-gray-400">
                    <p class="text-lg">No tenants found</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- View Details Modal -->
<div id="tenantModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tenant Information</h2>
            <button onclick="closeModal()" class="modal-close">&times;</button>
        </div>
        <div class="modal-actions-header">
            <button onclick="editTenant()" class="btn-modal btn-edit-modal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Edit Details
            </button>
            <button onclick="showDeleteConfirm({{ $tenant->id }})" class="btn-modal btn-delete-modal">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
                Delete Account
            </button>
        </div>
        
        <div class="modal-body">
            <div id="tenantDetails"></div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h2>Delete Account</h2>
            <button onclick="closeDeleteModal()" class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div class="delete-modal-content">
                <div class="delete-warning-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <h3>Are you sure?</h3>
                <p>You are about to <strong>permanently delete</strong> this tenant account. This action cannot be undone.</p>
                <ul class="delete-info-list">
                    <li>All tenant data will be removed from the database</li>
                    <li>Assigned bedspace will become available</li>
                    <li>Bill history will be deleted</li>
                    <li>Payment records will be removed</li>
                </ul>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="closeDeleteModal()" class="btn-secondary">Cancel</button>
            
            <form id="deleteForm" method="POST" style="flex: 1;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger-large" style="width: 100%;">
                    Yes, Delete Account
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/tenants.js') }}"></script>
@endsection