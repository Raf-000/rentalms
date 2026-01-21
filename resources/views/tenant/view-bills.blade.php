@extends('layouts.tenant-layout')

@section('content')
<div class="content-header">
    <h1>Pay Bills</h1>
    <p>Manage your rental payments</p>
</div>

@if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #28a745;">
        {{ session('success') }}
    </div>
@endif

@php
    $tenant = Auth::user();
    
    // Get pending/paid bills (not yet verified)
    $activeBills = \App\Models\Bill::where('tenantID', $tenant->id)
        ->whereIn('status', ['pending', 'paid', 'rejected'])
        ->orderBy('dueDate', 'asc')
        ->get();
    
    // Get verified bills (payment history)
    $verifiedBills = \App\Models\Bill::where('tenantID', $tenant->id)
        ->where('status', 'verified')
        ->orderBy('dueDate', 'desc')
        ->get();
@endphp

<!-- Active Bills (Pending/Paid/Rejected) -->
@if($activeBills->count() > 0)
    <div style="display: flex; flex-direction: column; gap: 15px; margin-bottom: 30px;">
        @foreach($activeBills as $bill)
        @php
            $payment = \App\Models\Payment::where('billID', $bill->billID)->first();
            $isPending = $bill->status === 'pending';
            $isPaid = $bill->status === 'paid';
            $isRejected = $bill->status === 'rejected';
        @endphp
        
        <div class="card" style="border-left: 4px solid {{ $isPending ? '#ffc107' : ($isRejected ? '#dc3545' : '#007bff') }};">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                        <h3 style="margin: 0; font-size: 24px; font-weight: bold; color: #333;">₱{{ number_format($bill->amount, 2) }}</h3>
                        <span style="padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500;
                            {{ $isPending ? 'background-color: #fff3cd; color: #856404;' : 
                               ($isRejected ? 'background-color: #f8d7da; color: #721c24;' : 'background-color: #cfe2ff; color: #084298;') }}">
                            {{ $isPending ? 'Pending' : ($isRejected ? 'Rejected' : 'Awaiting Verification') }}
                        </span>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 10px;">
                        <div>
                            <p style="font-size: 12px; color: #666; margin: 0;">Due Date</p>
                            <p style="font-size: 15px; font-weight: 500; margin: 0;">{{ date('M d, Y', strtotime($bill->dueDate)) }}</p>
                        </div>
                        <div>
                            <p style="font-size: 12px; color: #666; margin: 0;">Issued</p>
                            <p style="font-size: 15px; margin: 0;">{{ date('M d, Y', strtotime($bill->created_at)) }}</p>
                        </div>
                    </div>

                    @if($isRejected && $payment)
                        <div style="background-color: #fff; padding: 12px; border-radius: 4px; border-left: 3px solid #dc3545; margin-top: 10px;">
                            <p style="font-size: 11px; color: #721c24; margin: 0; font-weight: 600;">PAYMENT REJECTED</p>
                            <p style="font-size: 13px; color: #666; margin: 5px 0 0 0;">{{ $payment->rejectionReason ?? 'No reason provided' }}</p>
                        </div>
                    @endif

                    @if($isPaid && !$isRejected)
                        <div style="background-color: #e3f2fd; padding: 10px; border-radius: 4px; margin-top: 10px;">
                            <p style="font-size: 12px; color: #084298; margin: 0;">
                                <svg style="width: 14px; height: 14px; display: inline-block; vertical-align: middle;" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                </svg>
                                Payment submitted on {{ date('M d, Y h:i A', strtotime($payment->paidAt)) }}
                            </p>
                        </div>
                    @endif
                </div>
                
                <div style="margin-left: 20px;">
                    @if($isPending || $isRejected)
                        <button onclick="openPaymentModal({{ $bill->billID }}, {{ $bill->amount }})" 
                                style="padding: 12px 30px; background-color: {{ $isRejected ? '#dc3545' : '#007bff' }}; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 15px; font-weight: 500; white-space: nowrap;">
                            {{ $isRejected ? 'Re-submit Payment' : 'Pay Now' }}
                        </button>
                    @else
                        <div style="text-align: center; color: #666;">
                            <svg style="width: 40px; height: 40px; margin-bottom: 5px;" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                            </svg>
                            <p style="font-size: 13px; margin: 0;">Waiting for<br>admin review</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="card" style="text-align: center; padding: 40px; background-color: #f8f9fa;">
        <svg style="width: 64px; height: 64px; margin: 0 auto 15px; opacity: 0.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 style="color: #666; font-size: 18px; margin: 0 0 8px 0;">No pending bills</h3>
        <p style="color: #999; font-size: 14px; margin: 0;">You're all caught up!</p>
    </div>
@endif

<!-- Payment History -->
<div style="margin-top: 30px;">
    <h3 style="margin-bottom: 15px; font-size: 18px; color: #333;">Payment History</h3>
    
    <div style="background: white; border-radius: 8px; border: 1px solid #e0e0e0; height: 300px; overflow-y: auto;">
        @if($verifiedBills->count() > 0)
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background-color: #f8f9fa; position: sticky; top: 0;">
                    <tr>
                        <th style="padding: 12px 15px; text-align: left; font-size: 13px; color: #666; border-bottom: 2px solid #e0e0e0;">Amount</th>
                        <th style="padding: 12px 15px; text-align: left; font-size: 13px; color: #666; border-bottom: 2px solid #e0e0e0;">Due Date</th>
                        <th style="padding: 12px 15px; text-align: left; font-size: 13px; color: #666; border-bottom: 2px solid #e0e0e0;">Paid Date</th>
                        <th style="padding: 12px 15px; text-align: center; font-size: 13px; color: #666; border-bottom: 2px solid #e0e0e0;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($verifiedBills as $bill)
                    @php
                        $payment = \App\Models\Payment::where('billID', $bill->billID)->where('verifiedBy', '!=', null)->first();
                    @endphp
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 15px; font-weight: 500;">₱{{ number_format($bill->amount, 2) }}</td>
                        <td style="padding: 15px;">{{ date('M d, Y', strtotime($bill->dueDate)) }}</td>
                        <td style="padding: 15px;">{{ $payment ? date('M d, Y', strtotime($payment->verifiedAt)) : '-' }}</td>
                        <td style="padding: 15px; text-align: center;">
                            <span style="background-color: #d4edda; color: #155724; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500;">
                                Verified
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="text-align: center; padding: 60px 20px; color: #999;">
                <p style="font-size: 14px; margin: 0;">No payment history yet</p>
            </div>
        @endif
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; max-width: 450px; width: 90%; padding: 25px;">
        <h3 style="margin: 0 0 15px 0; font-size: 18px;">Submit Payment</h3>
        
        <form id="paymentForm" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 6px; margin-bottom: 15px;">
                <p style="font-size: 13px; color: #666; margin: 0 0 5px 0;">Amount to Pay</p>
                <p id="paymentAmount" style="font-size: 28px; font-weight: 600; color: #007bff; margin: 0;"></p>
            </div>

            @php
                $admin = \App\Models\User::where('role', 'admin')->first();
            @endphp

            @if($admin)
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 15px; border-radius: 6px; margin-bottom: 15px; color: white;">
                <p style="font-size: 12px; margin: 0 0 8px 0; opacity: 0.9;">GCash Payment Details</p>
                <div style="background: rgba(255,255,255,0.15); padding: 10px; border-radius: 4px; margin-bottom: 8px;">
                    <p style="font-size: 11px; margin: 0 0 3px 0; opacity: 0.9;">Account Name</p>
                    <p style="font-size: 15px; font-weight: 600; margin: 0;">{{ $admin->name }}</p>
                </div>
                <div style="background: rgba(255,255,255,0.15); padding: 10px; border-radius: 4px;">
                    <p style="font-size: 11px; margin: 0 0 3px 0; opacity: 0.9;">GCash Number</p>
                    <p style="font-size: 18px; font-weight: 600; margin: 0; letter-spacing: 1px;">{{ $admin->phone ?? 'Not set' }}</p>
                </div>
            </div>
            @endif

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px; font-weight: 500;">Payment Method</label>
                <select name="paymentMethod" id="paymentMethod" required 
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="">Select method</option>
                    <option value="cash">Cash</option>
                    <option value="gcash">GCash</option>
                </select>
            </div>

            <div id="receiptSection" style="display: none; margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 14px; font-weight: 500;">Upload Receipt (GCash Screenshot)</label>
                <input type="file" name="receiptImage" accept="image/*" 
                       style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <p style="font-size: 12px; color: #666; margin: 5px 0 0 0;">Upload GCash payment screenshot</p>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="button" onclick="closePaymentModal()" 
                        style="flex: 1; padding: 10px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    Cancel
                </button>
                <button type="submit" 
                        style="flex: 1; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
                    Submit Payment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openPaymentModal(billID, amount) {
    document.getElementById('paymentModal').style.display = 'flex';
    document.getElementById('paymentAmount').textContent = '₱' + parseFloat(amount).toFixed(2);
    document.getElementById('paymentForm').action = '/tenant/upload-payment/' + billID;
}

function closePaymentModal() {
    document.getElementById('paymentModal').style.display = 'none';
    document.getElementById('paymentMethod').value = '';
    document.getElementById('receiptSection').style.display = 'none';
}

// Show/hide receipt upload based on payment method
document.getElementById('paymentMethod').addEventListener('change', function() {
    const receiptSection = document.getElementById('receiptSection');
    if (this.value === 'gcash') {
        receiptSection.style.display = 'block';
    } else {
        receiptSection.style.display = 'none';
    }
});
</script>

@endsection