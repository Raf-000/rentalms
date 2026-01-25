@extends('layouts.admin-layout')

@section('content')
<div class="content-header">
    <h1>All Tenants</h1>
    <p>Manage and view all tenant information</p>
</div>

<div class="card">
    <!-- Filters and Search -->
    <div style="display: flex; gap: 15px; margin-bottom: 20px; align-items: center;">
        <div>
            <label style="display: block; margin-bottom: 5px; font-size: 13px; color: #666;">Filter by Status:</label>
            <select id="statusFilter" onchange="filterTable()" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="all">All Statuses</option>
                <option value="paid">Paid</option>
                <option value="unpaid">Unpaid Balance</option>
            </select>
        </div>
        
        <div style="flex: 1;">
            <label style="display: block; margin-bottom: 5px; font-size: 13px; color: #666;">Search by Name:</label>
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Type tenant name..." 
                   style="width: 100%; padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
    </div>

    <!-- Tenants Table -->
    @if($tenants->count() > 0)
        <div style="overflow-x: auto;">
            <table id="tenantsTable" style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead style="background-color: #f5f5f5;">
                    <tr>
                        <th style="padding: 12px 10px; text-align: left; border-bottom: 2px solid #ddd; font-weight: 600;">Name</th>
                        <th style="padding: 12px 10px; text-align: left; border-bottom: 2px solid #ddd; font-weight: 600;">Email</th>
                        <th style="padding: 12px 10px; text-align: left; border-bottom: 2px solid #ddd; font-weight: 600;">Phone</th>
                        <th style="padding: 12px 10px; text-align: left; border-bottom: 2px solid #ddd; font-weight: 600;">Bedspace</th>
                        <th style="padding: 12px 10px; text-align: left; border-bottom: 2px solid #ddd; font-weight: 600;">Monthly Rent</th>
                        <th style="padding: 12px 10px; text-align: left; border-bottom: 2px solid #ddd; font-weight: 600;">Lease Period</th>
                        <th style="padding: 12px 10px; text-align: left; border-bottom: 2px solid #ddd; font-weight: 600;">Status</th>
                        <th style="padding: 12px 10px; text-align: left; border-bottom: 2px solid #ddd; font-weight: 600;">Total Balance</th>
                        <th style="padding: 12px 10px; text-align: center; border-bottom: 2px solid #ddd; font-weight: 600;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tenants as $tenant)
                    @php
                        // Calculate unpaid bills (pending + paid but not verified)
                        $unpaidBills = \App\Models\Bill::where('tenantID', $tenant->id)
                            ->whereIn('status', ['pending', 'paid'])
                            ->get();
                        $totalBalance = $unpaidBills->sum('amount');
                        $paymentStatus = $totalBalance > 0 ? 'unpaid' : 'paid';
                    @endphp
                    <tr class="tenant-row" 
                        data-name="{{ strtolower($tenant->name) }}" 
                        data-status="{{ $paymentStatus }}"
                        data-tenant-id="{{ $tenant->id }}">
                        <td style="padding: 12px 10px; border-bottom: 1px solid #eee;">{{ $tenant->name }}</td>
                        <td style="padding: 12px 10px; border-bottom: 1px solid #eee;">{{ $tenant->email }}</td>
                        <td style="padding: 12px 10px; border-bottom: 1px solid #eee;">{{ $tenant->phone ?? 'N/A' }}</td>
                        <td style="padding: 12px 10px; border-bottom: 1px solid #eee;">
                            @if($tenant->bedspace)
                                <span style="color: #007bff; font-weight: 500;">{{ $tenant->bedspace->unitCode }}</span>
                            @else
                                <span style="color: #999;">Not assigned</span>
                            @endif
                        </td>
                        <td style="padding: 12px 10px; border-bottom: 1px solid #eee;">
                            @if($tenant->bedspace)
                                ₱{{ number_format($tenant->bedspace->price, 2) }}
                            @else
                                <span style="color: #999;">-</span>
                            @endif
                        </td>
                        <td style="padding: 12px 10px; border-bottom: 1px solid #eee;">
                            @if($tenant->leaseStart && $tenant->leaseEnd)
                                {{ date('M d, Y', strtotime($tenant->leaseStart)) }} - {{ date('M d, Y', strtotime($tenant->leaseEnd)) }}
                            @else
                                <span style="color: #999;">Not set</span>
                            @endif
                        </td>
                        <td style="padding: 12px 10px; border-bottom: 1px solid #eee;">
                            @if($totalBalance > 0)
                                <span style="background-color: #fff3cd; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Unpaid Balance</span>
                            @else
                                <span style="background-color: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 12px;">Paid</span>
                            @endif
                        </td>
                        <td style="padding: 12px 10px; border-bottom: 1px solid #eee; font-weight: 500;">
                            @if($totalBalance > 0)
                                <span style="color: #dc3545;">₱{{ number_format($totalBalance, 2) }}</span>
                            @else
                                <span style="color: #28a745;">₱0.00</span>
                            @endif
                        </td>
                        <td style="padding: 12px 10px; border-bottom: 1px solid #eee; text-align: center;">
                            <button onclick="viewTenant({{ $tenant->id }})" 
                                    style="padding: 5px 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; margin-right: 5px;">
                                View
                            </button>
                            <button onclick="confirmDelete({{ $tenant->id }}, '{{ $tenant->name }}')" 
                                    style="padding: 5px 12px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                                Delete
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Hidden data for modal -->
                    <script>
                        if (!window.tenantsData) window.tenantsData = {};
                        window.tenantsData[{{ $tenant->id }}] = {
                            name: "{{ $tenant->name }}",
                            email: "{{ $tenant->email }}",
                            phone: "{{ $tenant->phone ?? 'Not provided' }}",
                            bedspace: "{{ $tenant->bedspace ? $tenant->bedspace->unitCode : 'Not assigned' }}",
                            bills: [
                                @foreach($unpaidBills as $bill)
                                {
                                    amount: {{ $bill->amount }},
                                    status: "{{ $bill->status }}",
                                    dueDate: "{{ date('M d, Y', strtotime($bill->dueDate)) }}"
                                },
                                @endforeach
                            ]
                        };
                    </script>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p style="color: #666; text-align: center; padding: 40px 0;">No tenants found.</p>
    @endif
</div>

<!-- View Tenant Modal -->
<div id="viewModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; max-width: 600px; width: 90%; max-height: 80vh; overflow-y: auto;">
        <div style="padding: 25px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #f0f0f0; padding-bottom: 15px;">
                <h2 style="margin: 0; font-size: 20px;">Tenant Details</h2>
                <button onclick="closeViewModal()" style="background: none; border: none; font-size: 24px; color: #999; cursor: pointer; padding: 0; line-height: 1;">&times;</button>
            </div>
            
            <div id="tenantDetails"></div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; max-width: 450px; width: 90%; padding: 30px;">
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="width: 50px; height: 50px; background-color: #fee; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                <span style="color: #dc3545; font-size: 24px;">⚠</span>
            </div>
            <h3 style="margin: 0 0 10px 0; font-size: 18px;">Delete Tenant Account</h3>
            <p style="color: #666; margin: 0; font-size: 14px;">Are you sure you want to permanently delete <strong id="deleteTenantName"></strong>? This action cannot be undone and will:</p>
            <ul style="text-align: left; color: #666; font-size: 13px; margin: 15px 0;">
                <li>Remove the tenant from the system</li>
                <li>Free up their assigned bedspace</li>
                <li>Keep their billing records for archive</li>
            </ul>
        </div>
        
        <div style="display: flex; gap: 10px;">
            <button onclick="closeDeleteModal()" 
                    style="flex: 1; padding: 10px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Cancel
            </button>
            <button onclick="deleteTenant()" 
                    style="flex: 1; padding: 10px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Delete Tenant
            </button>
        </div>
    </div>
</div>

<script>
// Initialize if not exists
if (!window.tenantsData) window.tenantsData = {};
let selectedTenantId = null;

// Filter table
function filterTable() {
    const statusFilter = document.getElementById('statusFilter').value;
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('.tenant-row');
    
    rows.forEach(row => {
        const name = row.getAttribute('data-name');
        const status = row.getAttribute('data-status');
        
        const matchesStatus = statusFilter === 'all' || status === statusFilter;
        const matchesSearch = name.includes(searchInput);
        
        row.style.display = (matchesStatus && matchesSearch) ? '' : 'none';
    });
}

// View tenant details
function viewTenant(tenantId) {
    console.log('View clicked for tenant:', tenantId);
    console.log('Tenants data:', window.tenantsData);
    
    const tenant = window.tenantsData[tenantId];
    if (!tenant) {
        console.error('Tenant not found:', tenantId);
        alert('Error loading tenant data');
        return;
    }
    
    let billsHtml = '';
    if (tenant.bills && tenant.bills.length > 0) {
        billsHtml = '<ul style="list-style: none; padding: 0; margin: 0;">';
        tenant.bills.forEach(bill => {
            const statusColor = bill.status === 'paid' ? '#007bff' : '#ffc107';
            billsHtml += `
                <li style="padding: 10px; background-color: #f8f9fa; margin-bottom: 8px; border-radius: 4px; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="font-weight: 500;">₱${parseFloat(bill.amount).toFixed(2)}</span>
                        <span style="font-size: 12px; color: #666; margin-left: 10px;">Due: ${bill.dueDate}</span>
                    </div>
                    <span style="background-color: ${statusColor}; color: white; padding: 3px 8px; border-radius: 3px; font-size: 11px;">${bill.status.toUpperCase()}</span>
                </li>
            `;
        });
        billsHtml += '</ul>';
    } else {
        billsHtml = '<p style="color: #28a745; font-size: 14px; background-color: #d4edda; padding: 10px; border-radius: 4px; text-align: center;">✓ No unpaid bills</p>';
    }
    
    const detailsHtml = `
        <div style="margin-bottom: 20px;">
            <p style="font-size: 12px; color: #666; margin: 0 0 5px 0;">Name</p>
            <p style="font-size: 16px; font-weight: 500; margin: 0;">${tenant.name}</p>
        </div>
        <div style="margin-bottom: 20px;">
            <p style="font-size: 12px; color: #666; margin: 0 0 5px 0;">Email</p>
            <p style="font-size: 16px; margin: 0;">${tenant.email}</p>
        </div>
        <div style="margin-bottom: 20px;">
            <p style="font-size: 12px; color: #666; margin: 0 0 5px 0;">Phone</p>
            <p style="font-size: 16px; margin: 0;">${tenant.phone}</p>
        </div>
        <div style="margin-bottom: 20px;">
            <p style="font-size: 12px; color: #666; margin: 0 0 5px 0;">Bedspace Unit</p>
            <p style="font-size: 16px; font-weight: 500; color: #007bff; margin: 0;">${tenant.bedspace}</p>
        </div>
        <div style="border-top: 1px solid #e0e0e0; padding-top: 15px; margin-top: 20px;">
            <p style="font-size: 14px; font-weight: 500; margin: 0 0 10px 0;">Pending/Unpaid Bills</p>
            ${billsHtml}
        </div>
    `;
    
    document.getElementById('tenantDetails').innerHTML = detailsHtml;
    document.getElementById('viewModal').style.display = 'flex';
}

function closeViewModal() {
    document.getElementById('viewModal').style.display = 'none';
}

// Delete tenant
function confirmDelete(tenantId, tenantName) {
    selectedTenantId = tenantId;
    document.getElementById('deleteTenantName').textContent = tenantName;
    document.getElementById('deleteModal').style.display = 'flex';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    selectedTenantId = null;
}

function deleteTenant() {
    if (!selectedTenantId) return;
    
    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/delete-tenant/${selectedTenantId}`;
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    
    form.appendChild(csrfInput);
    document.body.appendChild(form);
    form.submit();
}
</script>

@endsection