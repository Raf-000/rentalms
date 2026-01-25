@extends('layouts.admin-layout')

@section('content')
<div class="content-header">
    <h1>Payment Management</h1>
    <p>Review and manage tenant payments</p>
</div>

@if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #28a745;">
        {{ session('success') }}
    </div>
@endif

<div style="display: flex; gap: 20px;">
    
    <!-- Left Side - Stats Cards (25%) -->
    <div style="width: 25%; min-width: 250px;">
            @php
                $currentMonth = now()->format('F Y');
                
                // Verified payments this month (money received and confirmed)
                $verifiedThisMonth = \App\Models\Payment::with('bill')
                    ->whereNotNull('verifiedAt')
                    ->whereYear('verifiedAt', now()->year)
                    ->whereMonth('verifiedAt', now()->month)
                    ->get()
                    ->sum(function($payment) {
                        return $payment->bill->amount;
                    });
                
                // Payments waiting for verification (paid but not verified)
                $pendingVerification = \App\Models\Payment::with('bill')
                    ->whereNull('verifiedBy')
                    ->whereNull('rejectedBy')
                    ->get()
                    ->sum(function($payment) {
                        return $payment->bill->amount;
                    });
                
                // Expected revenue (all unpaid bills)
                $expectedRevenue = \App\Models\Bill::whereIn('status', ['pending'])
                    ->sum('amount');
            @endphp
        
        <!-- Verified This Month Card -->
        <div style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 15px; border-left: 4px solid #28a745; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="margin-bottom: 10px;">
                <p style="font-size: 11px; color: #666; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Confirmed Revenue</p>
                <p style="font-size: 12px; color: #999; margin: 0;">{{ $currentMonth }}</p>
            </div>
            <p style="font-size: 32px; font-weight: bold; margin: 0; color: #28a745;">₱{{ number_format($verifiedThisMonth, 2) }}</p>
        </div>

        <!-- Awaiting Verification Card -->
        <div style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 15px; border-left: 4px solid #007bff; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="margin-bottom: 10px;">
                <p style="font-size: 11px; color: #666; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Pending Verification</p>
                <p style="font-size: 12px; color: #999; margin: 0;">Awaiting admin review</p>
            </div>
            <p style="font-size: 32px; font-weight: bold; margin: 0; color: #007bff;">₱{{ number_format($pendingVerification, 2) }}</p>
        </div>

        <!-- Expected Revenue Card -->
        <div style="background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #ffc107; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="margin-bottom: 10px;">
                <p style="font-size: 11px; color: #666; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Outstanding Balance</p>
                <p style="font-size: 12px; color: #999; margin: 0;">As of {{ now()->format('M d, Y') }}</p>
            </div>
            <p style="font-size: 32px; font-weight: bold; margin: 0; color: #ffc107;">₱{{ number_format($expectedRevenue, 2) }}</p>
        </div>
    </div>

    <!-- Right Side - Payment History (75%) -->
    <div style="flex: 1;">
        <div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); height: calc(100vh - 200px); display: flex; flex-direction: column;">
            <div style="padding: 20px; border-bottom: 1px solid #e0e0e0;">
                <h3 style="margin: 0; font-size: 18px; color: #333;">Payment History</h3>
            </div>
            
            <div style="flex: 1; overflow-y: auto; padding: 20px;">
                @php
                    $payments = \App\Models\Payment::with(['bill', 'tenant'])
                        ->orderBy('paidAt', 'desc')
                        ->get();
                @endphp

                @if($payments->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        @foreach($payments as $payment)
                        @php
                            $isPending = is_null($payment->verifiedBy) && is_null($payment->rejectedBy);
                            $isVerified = !is_null($payment->verifiedBy);
                            $isRejected = !is_null($payment->rejectedBy);
                        @endphp
                        
                        <div style="border: 1px solid #e0e0e0; border-radius: 8px; padding: 16px;
                            {{ $isVerified ? 'background-color: #f0f9f4;' : 
                               ($isRejected ? 'background-color: #fff5f5;' : 'background-color: #f0f7ff;') }}">
                            
                            <div style="display: flex; justify-content: space-between; align-items: start;">
                                <div style="flex: 1;">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                        <h4 style="margin: 0; font-size: 15px; font-weight: 600; color: #333;">{{ $payment->tenant->name }}</h4>
                                        <span style="padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 500;
                                            {{ $isVerified ? 'background-color: #d4edda; color: #155724;' : 
                                               ($isRejected ? 'background-color: #f8d7da; color: #721c24;' : 'background-color: #cfe2ff; color: #084298;') }}">
                                            {{ $isVerified ? 'Verified' : ($isRejected ? 'Rejected' : 'Pending') }}
                                        </span>
                                    </div>
                                    
                                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 10px;">
                                        <div>
                                            <p style="font-size: 11px; color: #666; margin: 0;">Amount</p>
                                            <p style="font-size: 18px; font-weight: 600; margin: 0; color: #333;">₱{{ number_format($payment->bill->amount, 2) }}</p>
                                        </div>
                                        <div>
                                            <p style="font-size: 11px; color: #666; margin: 0;">Due Date</p>
                                            <p style="font-size: 14px; margin: 0;">{{ date('M d, Y', strtotime($payment->bill->dueDate)) }}</p>
                                        </div>
                                        <div>
                                            <p style="font-size: 11px; color: #666; margin: 0;">Payment Method</p>
                                            <p style="font-size: 14px; margin: 0;">{{ ucfirst($payment->paymentMethod) }}</p>
                                        </div>
                                        <div>
                                            <p style="font-size: 11px; color: #666; margin: 0;">Paid At</p>
                                            <p style="font-size: 14px; margin: 0;">{{ date('M d, Y h:i A', strtotime($payment->paidAt)) }}</p>
                                        </div>
                                    </div>

                                    @if($isRejected)
                                        <div style="background-color: #fff; padding: 10px; border-radius: 4px; border-left: 3px solid #dc3545; margin-top: 10px;">
                                            <p style="font-size: 11px; color: #721c24; margin: 0; font-weight: 500;">Rejection Reason:</p>
                                            <p style="font-size: 13px; color: #666; margin: 5px 0 0 0;">{{ $payment->rejectionReason ?? 'No reason provided' }}</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <div style="display: flex; gap: 8px; align-items: start; margin-left: 15px;">
                                    @if($payment->receiptImage)
                                        <button onclick="viewReceipt('{{ asset('storage/' . $payment->receiptImage) }}')" 
                                                style="padding: 6px 12px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; white-space: nowrap;">
                                            View Receipt
                                        </button>
                                    @endif
                                    
                                    @if($isPending)
                                        <button onclick="showActionModal({{ $payment->paymentID }}, '{{ $payment->tenant->name }}', {{ $payment->bill->amount }})" 
                                                style="padding: 6px 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; white-space: nowrap;">
                                            Review
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 60px 20px; color: #999;">
                        <p style="font-size: 16px; margin: 0;">No payment history found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Receipt Viewer Modal -->
<div id="receiptModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.85); z-index: 1000; align-items: center; justify-content: center;">
    <div style="position: relative; max-width: 90%; max-height: 90%;">
        <button onclick="closeReceiptModal()" 
                style="position: absolute; top: -40px; right: 0; background: white; border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; font-size: 20px;">
            ×
        </button>
        <img id="modalReceipt" src="" style="max-width: 100%; max-height: 90vh; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
    </div>
</div>

<!-- Action Modal (Verify/Reject) -->
<div id="actionModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 8px; max-width: 450px; width: 90%; padding: 25px;">
        <h3 style="margin: 0 0 15px 0; font-size: 18px;">Review Payment</h3>
        
        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            <p style="font-size: 13px; color: #666; margin: 0 0 5px 0;">Tenant</p>
            <p id="reviewTenantName" style="font-size: 16px; font-weight: 500; margin: 0 0 10px 0;"></p>
            <p style="font-size: 13px; color: #666; margin: 0 0 5px 0;">Amount</p>
            <p id="reviewAmount" style="font-size: 20px; font-weight: 600; color: #28a745; margin: 0;"></p>
        </div>

        <div id="rejectReasonSection" style="display: none; margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-size: 13px; font-weight: 500;">Rejection Reason</label>
            <textarea id="rejectionReason" rows="3" placeholder="Explain why this payment is being rejected..." 
                      style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px;"></textarea>
        </div>

        <div style="display: flex; gap: 10px;">
            <button onclick="closeActionModal()" 
                    style="flex: 1; padding: 10px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Cancel
            </button>
            <button onclick="verifyPayment()" 
                    style="flex: 1; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
                ✓ Verify
            </button>
            <button onclick="toggleRejectReason()" id="rejectBtn"
                    style="flex: 1; padding: 10px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">
                ✗ Reject
            </button>
        </div>

        <button id="confirmRejectBtn" onclick="rejectPayment()" style="display: none; width: 100%; margin-top: 10px; padding: 10px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Confirm Rejection
        </button>
    </div>
</div>

<script>
let selectedPaymentId = null;

function viewReceipt(receiptUrl) {
    document.getElementById('modalReceipt').src = receiptUrl;
    document.getElementById('receiptModal').style.display = 'flex';
}

function closeReceiptModal() {
    document.getElementById('receiptModal').style.display = 'none';
}

document.getElementById('receiptModal').addEventListener('click', function(e) {
    if (e.target === this) closeReceiptModal();
});

function showActionModal(paymentId, tenantName, amount) {
    selectedPaymentId = paymentId;
    document.getElementById('reviewTenantName').textContent = tenantName;
    document.getElementById('reviewAmount').textContent = '₱' + parseFloat(amount).toFixed(2);
    document.getElementById('actionModal').style.display = 'flex';
    document.getElementById('rejectReasonSection').style.display = 'none';
    document.getElementById('confirmRejectBtn').style.display = 'none';
    document.getElementById('rejectBtn').style.display = 'block';
}

function closeActionModal() {
    document.getElementById('actionModal').style.display = 'none';
    selectedPaymentId = null;
}

function toggleRejectReason() {
    document.getElementById('rejectReasonSection').style.display = 'block';
    document.getElementById('confirmRejectBtn').style.display = 'block';
    document.getElementById('rejectBtn').style.display = 'none';
}

function verifyPayment() {
    if (!selectedPaymentId) return;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/verify-payment/${selectedPaymentId}`;
    
    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    
    form.appendChild(csrf);
    document.body.appendChild(form);
    form.submit();
}

function rejectPayment() {
    if (!selectedPaymentId) return;
    
    const reason = document.getElementById('rejectionReason').value;
    if (!reason.trim()) {
        alert('Please provide a reason for rejection');
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/reject-payment/${selectedPaymentId}`;
    
    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = '{{ csrf_token() }}';
    
    const reasonInput = document.createElement('input');
    reasonInput.type = 'hidden';
    reasonInput.name = 'reason';
    reasonInput.value = reason;
    
    form.appendChild(csrf);
    form.appendChild(reasonInput);
    document.body.appendChild(form);
    form.submit();
}
</script>

@endsection