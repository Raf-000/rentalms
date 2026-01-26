@extends('layouts.admin-layout')

@section('content')
<!-- Link external CSS -->
<link rel="stylesheet" href="{{ asset('css/tenants.css') }}">

<div class="content-header">
    <div class="header-content">
        <h1>Tenants</h1>
        <p>Information Overview and Management</p>
    </div>
</div>

<div class="card">
    <!-- Header with filters and search -->
    <div class="card-header">
        <div class="header-row">
            <div class="header-info">
                <h2 class="card-title">All Tenants</h2>
                <span class="tenant-count">{{ $tenants->count() }} tenant{{ $tenants->count() !== 1 ? 's' : '' }}</span>
            </div>
            
            <div class="header-actions">
                <div class="filter-group">
                    <select id="statusFilter" onchange="filterTable()" class="filter-select">
                        <option value="all">All Status</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid only</option>
                    </select>
                </div>
                
                <div class="search-group">
                    <div class="search-input-wrapper">
                        <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search by name..." class="search-input">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile filters -->
        <div class="mobile-filters">
            <div class="filter-group mobile">
                <select id="statusFilterMobile" onchange="filterTable()" class="filter-select">
                    <option value="all">All Status</option>
                    <option value="paid">Paid</option>
                    <option value="unpaid">Unpaid</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Tenants Table -->
    @if($tenants->count() > 0)
        <div class="table-container">
            <div class="table-responsive">
                <table id="tenantsTable" class="tenants-table">
                    <thead>
                        <tr>
                            <th class="tenant-name">
                                <span>TENANT</span>
                            </th>
                            <th class="tenant-contact">
                                <span>CONTACT</span>
                            </th>
                            <th class="tenant-bedspace">
                                <span>BEDSPACE</span>
                            </th>
                            <th class="tenant-lease">
                                <span>LEASE PERIOD</span>
                            </th>
                            <th class="tenant-balance">
                                <span>BALANCE</span>
                            </th>
                            <th class="tenant-status">
                                <span>STATUS</span>
                            </th>
                            <th class="tenant-actions">
                                <span>ACTION</span>
                            </th>
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
                        @endphp
                        <tr class="tenant-row {{ $hasOverdue ? 'has-overdue' : '' }}" 
                            data-name="{{ strtolower($tenant->name) }}" 
                            data-status="{{ $paymentStatus }}"
                            data-tenant-id="{{ $tenant->id }}"
                            data-overdue="{{ $hasOverdue ? 'true' : 'false' }}">
                            <td class="tenant-name">
                                <div class="tenant-info">
                                    <div class="tenant-avatar">
                                        {{ substr($tenant->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="tenant-name-text"><strong>{{ $tenant->name }}</strong></div>
                                        <div class="tenant-email">{{ $tenant->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="tenant-contact">
                                <div class="contact-info">
                                    <div class="phone-number">
                                        {{ $tenant->phone ?? 'Not provided' }}
                                    </div>
                                </div>
                            </td>
                            <td class="tenant-bedspace">
                                @if($tenant->bedspace)
                                    <div class="bedspace-info">
                                        <span class="bedspace-code"><strong>{{ $tenant->bedspace->unitCode }}</strong></span>
                                        <span class="bedspace-price">{{ number_format($tenant->bedspace->price, 2) }}/mo</span>
                                    </div>
                                @else
                                    <span class="not-assigned">Not assigned</span>
                                @endif
                            </td>
                            <td class="tenant-lease">
                                @if($tenant->leaseStart && $tenant->leaseEnd)
                                    <div class="lease-period">
                                        <div class="lease-start">
                                            {{ date('M d, Y', strtotime($tenant->leaseStart)) }}
                                        </div>
                                        <div class="lease-end">
                                            to {{ date('M d, Y', strtotime($tenant->leaseEnd)) }}
                                        </div>
                                    </div>
                                @else
                                    <span class="not-set">Not set</span>
                                @endif
                            </td>
                            <td class="tenant-balance">
                                @if($totalBalance > 0)
                                    <div class="balance-amount negative">
                                        {{ number_format($totalBalance, 2) }}
                                    </div>
                                @else
                                    <div class="balance-amount positive">
                                        0.00
                                    </div>
                                @endif
                            </td>
                            <td class="tenant-status">
                                @if($totalBalance > 0)
                                    <div class="status-badge {{ $hasOverdue ? 'overdue' : 'unpaid' }}">
                                        <span class="badge-dot"></span>
                                        {{ $hasOverdue ? 'Overdue' : 'Unpaid' }}
                                    </div>
                                @else
                                    <div class="status-badge paid">
                                        <span class="badge-dot"></span>
                                        Paid
                                    </div>
                                @endif
                            </td>
                            <td class="tenant-actions">
                                <div class="action-buttons">
                                    <button onclick="viewTenant({{ $tenant->id }}, '{{ addslashes($tenant->name) }}', '{{ $tenant->email }}', '{{ $tenant->phone ?? 'Not provided' }}', '{{ $tenant->leaseStart ? date('M d, Y', strtotime($tenant->leaseStart)) : 'Not set' }}', '{{ $tenant->leaseEnd ? date('M d, Y', strtotime($tenant->leaseEnd)) : 'Not set' }}', '{{ $tenant->bedspace ? $tenant->bedspace->unitCode : 'Not assigned' }}', {{ $tenant->bedspace ? $tenant->bedspace->price : 0 }}, {{ $totalBalance }})" 
                                        class="btn btn-icon view-btn" 
                                        title="View details">
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
            
            <!-- Table Summary -->
            <div class="table-summary">
                <div class="summary-item">
                    <span class="summary-label">Total Tenants:</span>
                    <span class="summary-value">{{ $tenants->count() }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">With Balance:</span>
                    <span class="summary-value">
                        @php
                            $withBalanceCount = 0;
                            foreach($tenants as $tenant) {
                                $balance = \App\Models\Bill::where('tenantID', $tenant->id)
                                    ->whereIn('status', ['pending', 'unpaid'])
                                    ->sum('amount');
                                if ($balance > 0) {
                                    $withBalanceCount++;
                                }
                            }
                            echo $withBalanceCount;
                        @endphp
                    </span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Paid Up:</span>
                    <span class="summary-value">
                        @php
                            $paidUpCount = 0;
                            foreach($tenants as $tenant) {
                                $balance = \App\Models\Bill::where('tenantID', $tenant->id)
                                    ->whereIn('status', ['pending', 'unpaid'])
                                    ->sum('amount');
                                if ($balance == 0) {
                                    $paidUpCount++;
                                }
                            }
                            echo $paidUpCount;
                        @endphp
                    </span>
                </div>
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <h3>No tenants found</h3>
            <p>There are no tenants in the system yet.</p>
        </div>
    @endif
</div>

<!-- MODAL -->
<div id="tenantModal" class="modal-overlay" style="display: none;">
    <div class="modal-content" id="modalContent">
        <div id="viewMode" class="modal-view">
            <div class="modal-header">
                <h2>Tenant Information</h2>
                <button onclick="closeModal()" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div id="tenantDetails"></div>
            </div>
        </div>
    </div>
</div>

<script>
// Modal control functions
function openModal() {
    document.getElementById('tenantModal').style.display = 'flex';
    setTimeout(() => {
        document.getElementById('tenantModal').classList.add('active');
    }, 10);
}

function closeModal() {
    document.getElementById('tenantModal').classList.remove('active');
    setTimeout(() => {
        document.getElementById('tenantModal').style.display = 'none';
    }, 300);
}

// View tenant details - PASSING DATA DIRECTLY IN FUNCTION CALL
function viewTenant(tenantId, name, email, phone, leaseStart, leaseEnd, bedspaceCode, bedspacePrice, totalBalance) {
    console.log('Viewing tenant:', tenantId, name);
    
    // Simple modal content
    const detailsHtml = `
        <div class="tenant-profile">
            <div class="profile-avatar">
                ${name.charAt(0).toUpperCase()}
            </div>
            <div class="profile-info">
                <h3>${name}</h3>
                <p>${email}</p>
            </div>
        </div>
        
        <div class="details-grid">
            <div class="detail-card">
                <div class="detail-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                </div>
                <div>
                    <p class="detail-label">Phone</p>
                    <p class="detail-value">${phone}</p>
                </div>
            </div>
            
            <div class="detail-card">
                <div class="detail-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <div>
                    <p class="detail-label">Bedspace</p>
                    <p class="detail-value primary">${bedspaceCode}</p>
                    <p class="detail-subtext">${parseFloat(bedspacePrice).toFixed(2)}/month</p>
                </div>
            </div>
            
            <div class="detail-card">
                <div class="detail-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <div>
                    <p class="detail-label">Lease Period</p>
                    <p class="detail-value">${leaseStart}</p>
                    <p class="detail-subtext">to ${leaseEnd}</p>
                </div>
            </div>
            
            <div class="detail-card">
                <div class="detail-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <div>
                    <p class="detail-label">Total Balance</p>
                    <p class="detail-value ${parseFloat(totalBalance) > 0 ? 'text-danger' : 'text-success'}">${parseFloat(totalBalance).toFixed(2)}</p>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('tenantDetails').innerHTML = detailsHtml;
    openModal();
}

// Sync mobile and desktop filters
document.getElementById('statusFilter')?.addEventListener('change', function() {
    const mobileFilter = document.getElementById('statusFilterMobile');
    if (mobileFilter) mobileFilter.value = this.value;
    filterTable();
});

document.getElementById('statusFilterMobile')?.addEventListener('change', function() {
    const desktopFilter = document.getElementById('statusFilter');
    if (desktopFilter) desktopFilter.value = this.value;
    filterTable();
});

// Filter table with debounce
let filterTimeout;
function filterTable() {
    clearTimeout(filterTimeout);
    filterTimeout = setTimeout(() => {
        const statusFilter = document.getElementById('statusFilter')?.value || 
                           document.getElementById('statusFilterMobile')?.value || 'all';
        const searchInput = document.getElementById('searchInput')?.value.toLowerCase() || '';
        const rows = document.querySelectorAll('.tenant-row');
        
        let visibleCount = 0;
        
        rows.forEach(row => {
            const name = row.getAttribute('data-name');
            const status = row.getAttribute('data-status');
            
            let matchesStatus = true;
            if (statusFilter === 'paid') {
                matchesStatus = status === 'paid';
            } else if (statusFilter === 'unpaid') {
                matchesStatus = status === 'unpaid';
            }
            
            const matchesSearch = name.includes(searchInput);
            const shouldShow = matchesStatus && matchesSearch;
            
            row.style.display = shouldShow ? '' : 'none';
            if (shouldShow) visibleCount++;
        });
        
        updateVisibleCount(visibleCount);
    }, 300);
}

function updateVisibleCount(count) {
    const countElement = document.querySelector('.tenant-count');
    if (countElement) {
        countElement.textContent = `${count} tenant${count !== 1 ? 's' : ''}`;
    }
}

// Close modals on ESC key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeModal();
    }
});

// Close modal when clicking outside
document.getElementById('tenantModal').addEventListener('click', (e) => {
    if (e.target.id === 'tenantModal') {
        closeModal();
    }
});

// Initialize filter on page load
document.addEventListener('DOMContentLoaded', function() {
    filterTable();
});
</script>

@endsection