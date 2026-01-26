@extends('layouts.admin-layout')

@section('content')
<div class="content-header">
    <h1>Payment Management</h1>
    <p>Review and manage tenant payments</p>
</div>

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
                        
                        <div id="payment-card-{{ $payment->paymentID }}" style="border: 1px solid #e0e0e0; border-radius: 8px; padding: 16px;
                            {{ $isVerified ? 'background-color: #f0f9f4;' : 
                               ($isRejected ? 'background-color: #fff5f5;' : 'background-color: #f0f7ff;') }}">
                            
                            <div style="display: flex; justify-content: space-between; align-items: start;">
                                <div style="flex: 1;">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                        <h4 style="margin: 0; font-size: 15px; font-weight: 600; color: #333;">{{ $payment->tenant->name }}</h4>
                                        <span id="status-badge-{{ $payment->paymentID }}" style="padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 500;
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
                                            <p style="font-size: 14px; margin: 0;">{{ optional($payment->bill->dueDate)->format('M d, Y') }}</p>
                                        </div>
                                        <div>
                                            <p style="font-size: 11px; color: #666; margin: 0;">Payment Method</p>
                                            <p style="font-size: 14px; margin: 0;">{{ ucfirst($payment->paymentMethod) }}</p>
                                        </div>
                                        <div>
                                            <p style="font-size: 11px; color: #666; margin: 0;">Paid At</p>
                                            <p style="font-size: 14px; margin: 0;">{{ optional($payment->paidAt)->format('M d, Y h:i A') }}</p>
                                        </div>
                                    </div>

                                    <div id="rejection-box-{{ $payment->paymentID }}" style="{{ $isRejected ? '' : 'display: none;' }} background-color: #fff; padding: 10px; border-radius: 4px; border-left: 3px solid #dc3545; margin-top: 10px;">
                                        <p style="font-size: 11px; color: #721c24; margin: 0; font-weight: 500;">Rejection Reason:</p>
                                        <p id="rejection-reason-{{ $payment->paymentID }}" style="font-size: 13px; color: #666; margin: 5px 0 0 0;">{{ $payment->rejectionReason ?? 'No reason provided' }}</p>
                                    </div>
                                </div>
                                
                                <div id="action-buttons-{{ $payment->paymentID }}" style="display: flex; gap: 8px; align-items: start; margin-left: 15px;">
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
                                    @else
                                        <span style="font-size: 12px; color: #6c757d; font-style: italic;">No actions</span>
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
            <span id="rejection_reason_error" style="display: none; color: #dc3545; font-size: 12px; margin-top: 5px;"></span>
        </div>

        <div style="display: flex; gap: 10px;">
            <button onclick="closeActionModal()" 
                    style="flex: 1; padding: 10px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Cancel
            </button>
            <button id="verifyBtn" onclick="verifyPaymentAjax()" 
                    style="flex: 1; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
                <span class="btn-text">✓ Verify</span>
                <span class="btn-loading" style="display: none;">
                    <span class="loading-spinner"></span> Verifying...
                </span>
            </button>
            <button onclick="toggleRejectReason()" id="rejectBtn"
                    style="flex: 1; padding: 10px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">
                ✗ Reject
            </button>
        </div>

        <button id="confirmRejectBtn" onclick="rejectPaymentAjax()" style="display: none; width: 100%; margin-top: 10px; padding: 10px; background-color: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">
            <span class="btn-text">Confirm Rejection</span>
            <span class="btn-loading" style="display: none;">
                <span class="loading-spinner"></span> Submitting...
            </span>
        </button>
    </div>
</div>

<style>
/* Loading Spinner */
.loading-spinner {
    display: inline-block;
    width: 14px;
    height: 14px;
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 0.6s linear infinite;
    vertical-align: middle;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.btn-loading {
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
</style>

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
    document.getElementById('reviewAmount').textContent = '₱' + parseFloat(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    document.getElementById('actionModal').style.display = 'flex';
    document.getElementById('rejectReasonSection').style.display = 'none';
    document.getElementById('confirmRejectBtn').style.display = 'none';
    document.getElementById('rejectBtn').style.display = 'block';
    document.getElementById('rejectionReason').value = '';
    document.getElementById('rejection_reason_error').style.display = 'none';
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

// AJAX Verify Payment
function verifyPaymentAjax() {
    if (!selectedPaymentId) return;
    
    const btn = document.getElementById('verifyBtn');
    const btnText = btn.querySelector('.btn-text');
    const btnLoading = btn.querySelector('.btn-loading');
    
    // Show loading
    btn.disabled = true;
    btnText.style.display = 'none';
    btnLoading.style.display = 'inline-flex';
    
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    
    fetch(`/admin/payments/${selectedPaymentId}/verify-ajax`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update card background
            const card = document.getElementById(`payment-card-${selectedPaymentId}`);
            card.style.backgroundColor = '#f0f9f4';
            
            // Update status badge
            const badge = document.getElementById(`status-badge-${selectedPaymentId}`);
            badge.textContent = 'Verified';
            badge.style.backgroundColor = '#d4edda';
            badge.style.color = '#155724';
            
            // Update action buttons
            const actions = document.getElementById(`action-buttons-${selectedPaymentId}`);
            const reviewBtn = actions.querySelector('button[onclick^="showActionModal"]');
            if (reviewBtn) {
                reviewBtn.outerHTML = '<span style="font-size: 12px; color: #6c757d; font-style: italic;">No actions</span>';
            }
            
            // Close modal
            closeActionModal();
            
            // Show success notification
            showNotification('success', data.message);
        } else {
            showNotification('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Network error. Please try again.');
    })
    .finally(() => {
        btn.disabled = false;
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
    });
}

// AJAX Reject Payment
function rejectPaymentAjax() {
    if (!selectedPaymentId) return;
    
    const reason = document.getElementById('rejectionReason').value.trim();
    const errorSpan = document.getElementById('rejection_reason_error');
    
    if (!reason) {
        errorSpan.textContent = 'Rejection reason is required.';
        errorSpan.style.display = 'block';
        return;
    }
    
    const btn = document.getElementById('confirmRejectBtn');
    const btnText = btn.querySelector('.btn-text');
    const btnLoading = btn.querySelector('.btn-loading');
    
    // Show loading
    btn.disabled = true;
    btnText.style.display = 'none';
    btnLoading.style.display = 'inline-flex';
    errorSpan.style.display = 'none';
    
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
    
    fetch(`/admin/payments/${selectedPaymentId}/reject-ajax`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            rejection_reason: reason
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update card background
            const card = document.getElementById(`payment-card-${selectedPaymentId}`);
            card.style.backgroundColor = '#fff5f5';
            
            // Update status badge
            const badge = document.getElementById(`status-badge-${selectedPaymentId}`);
            badge.textContent = 'Rejected';
            badge.style.backgroundColor = '#f8d7da';
            badge.style.color = '#721c24';
            
            // Show rejection reason
            const rejectionBox = document.getElementById(`rejection-box-${selectedPaymentId}`);
            rejectionBox.style.display = 'block';
            document.getElementById(`rejection-reason-${selectedPaymentId}`).textContent = reason;
            
            // Update action buttons
            const actions = document.getElementById(`action-buttons-${selectedPaymentId}`);
            const reviewBtn = actions.querySelector('button[onclick^="showActionModal"]');
            if (reviewBtn) {
                reviewBtn.outerHTML = '<span style="font-size: 12px; color: #6c757d; font-style: italic;">No actions</span>';
            }
            
            // Close modal
            closeActionModal();
            
            // Show success notification
            showNotification('success', data.message);
        } else {
            if (data.errors && data.errors.rejection_reason) {
                errorSpan.textContent = data.errors.rejection_reason[0];
                errorSpan.style.display = 'block';
            } else {
                showNotification('error', data.message);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Network error. Please try again.');
    })
    .finally(() => {
        btn.disabled = false;
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
    });
}

// Show notification
function showNotification(type, message) {
    const existing = document.querySelector('.notification');
    if (existing) existing.remove();
    
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: ${type === 'success' ? '#d4edda' : '#f8d7da'};
        color: ${type === 'success' ? '#155724' : '#721c24'};
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 2000;
        min-width: 300px;
        max-width: 500px;
        animation: slideIn 0.3s ease;
        border-left: 4px solid ${type === 'success' ? '#28a745' : '#dc3545'};
    `;
    
    notification.innerHTML = `
        <svg style="width: 24px; height: 24px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            ${type === 'success' 
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
            }
        </svg>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 20px; color: inherit; cursor: pointer; margin-left: auto; padding: 0; line-height: 1;">×</button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

const style = document.createElement('style');
style.textContent = '@keyframes slideIn { from { transform: translateX(400px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }';
document.head.appendChild(style);

window.onclick = function(event) {
    if (event.target === document.getElementById('actionModal')) {
        closeActionModal();
    }
}
</script>

@endsection