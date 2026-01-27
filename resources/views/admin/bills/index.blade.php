@extends('layouts.admin-layout')

@section('content')
<div class="content-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>Bills Management</h1>
            <p>View, create, and manage all bills</p>
        </div>
        <a href="{{ route('admin.bills.create') }}" 
           style="padding: 12px 24px; background-color: #007bff; color: white; text-decoration: none; border-radius: 6px; font-weight: 500;">
            + Issue New Bill
        </a>
    </div>
</div>

@if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #28a745;">
        {{ session('success') }}
    </div>
@endif

<!-- Filters -->
<div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px;">
    <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
        <div>
            <label style="display: block; margin-bottom: 5px; font-size: 13px; font-weight: 500;">Tenant</label>
            <select name="tenant_id" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">All Tenants</option>
                @foreach($tenants as $tenant)
                    <option value="{{ $tenant->id }}" {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>
                        {{ $tenant->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div>
            <label style="display: block; margin-bottom: 5px; font-size: 13px; font-weight: 500;">Status</label>
            <select name="status" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="void" {{ request('status') == 'void' ? 'selected' : '' }}>Void</option>
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
                    style="padding: 8px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Filter
            </button>
            <a href="{{ route('admin.bills.index') }}" 
               style="padding: 8px 20px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 4px; display: inline-block;">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Bills Table -->
<div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead style="background-color: #f8f9fa;">
            <tr>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: #666; font-weight: 600;">Bill ID</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: #666; font-weight: 600;">Tenant</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: #666; font-weight: 600;">Amount</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: #666; font-weight: 600;">Description</th>
                <th style="padding: 12px; text-align: left; font-size: 13px; color: #666; font-weight: 600;">Due Date</th>
                <th style="padding: 12px; text-align: center; font-size: 13px; color: #666; font-weight: 600;">Status</th>
                <th style="padding: 12px; text-align: center; font-size: 13px; color: #666; font-weight: 600;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bills as $bill)
            <tr style="border-bottom: 1px solid #e9ecef;">
                <td style="padding: 12px; font-size: 14px;">#{{ $bill->billID }}</td>
                <td style="padding: 12px; font-size: 14px; font-weight: 500;">{{ $bill->tenant->name }}</td>
                <td style="padding: 12px; font-size: 14px; font-weight: 600;">₱{{ number_format($bill->amount, 2) }}</td>
                <td style="padding: 12px; font-size: 13px; color: #666;">
                    {{ $bill->description ?? 'Monthly Rent' }}
                </td>
                <td style="padding: 12px; font-size: 14px;">
                    {{ \Carbon\Carbon::parse($bill->dueDate)->format('M d, Y') }}
                </td>
                <td style="padding: 12px; text-align: center;">
                    <span style="padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; text-transform: uppercase;
                        {{ $bill->status == 'verified' ? 'background-color: #d4edda; color: #155724;' : 
                           ($bill->status == 'paid' ? 'background-color: #cfe2ff; color: #084298;' : 
                           ($bill->status == 'rejected' ? 'background-color: #f8d7da; color: #721c24;' : 
                           ($bill->status == 'void' ? 'background-color: #e2e3e5; color: #6c757d;' : 'background-color: #fff3cd; color: #856404;'))) }}">
                        {{ $bill->status }}
                    </span>
                </td>
                <td style="padding: 12px; text-align: center;">
                    <div style="display: flex; gap: 8px; justify-content: center;">
                        @if($bill->status != 'void')
                        <a href="{{ route('admin.bills.edit', $bill->billID) }}" 
                           style="padding: 6px 12px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; font-size: 12px;">
                            Edit
                        </a>
                        <button onclick="confirmVoid({{ $bill->billID }}, '{{ $bill->tenant->name }}')"
                                style="padding: 6px 12px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                            Void
                        </button>
                        @else
                        <span style="font-size: 12px; color: #6c757d; font-style: italic;">No actions</span>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding: 40px; text-align: center; color: #999;">
                    No bills found
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Void Confirmation Modal -->
<div id="voidModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; max-width: 450px; width: 90%; padding: 30px;">
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="width: 50px; height: 50px; background-color: #fee; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                <span style="color: #dc3545; font-size: 24px;">⚠</span>
            </div>
            <h3 style="margin: 0 0 10px 0; font-size: 18px;">Void Bill</h3>
            <p style="color: #666; margin: 0; font-size: 14px;">
                Are you sure you want to void this bill for <strong id="voidTenantName"></strong>? 
                This will mark the bill as cancelled and it cannot be recovered.
            </p>
        </div>
        
        <form id="voidForm" method="POST" style="display: flex; gap: 10px;">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeVoidModal()" 
                    style="flex: 1; padding: 10px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Cancel
            </button>
            <button type="submit" 
                    style="flex: 1; padding: 10px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Void Bill
            </button>
        </form>
    </div>
</div>

<script>
function confirmVoid(billID, tenantName) {
    document.getElementById('voidTenantName').textContent = tenantName;
    document.getElementById('voidForm').action = `/admin/bills/${billID}`;
    document.getElementById('voidModal').style.display = 'flex';
}

function closeVoidModal() {
    document.getElementById('voidModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('voidModal');
    if (event.target === modal) {
        closeVoidModal();
    }
}
</script>
@endsection