@extends('layouts.admin-layout')

<style>
.btn-icon {
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

        <div>
            <h1 class="text-4xl font-bold text-[#135757] mb-2">Payments Management</h1>
            <p class="text-gray-600 text-lg">Review and manage tenant payments</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
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
            
            <!-- Confirmed Revenue -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-green-500">
                <p class="text-xs uppercase tracking-wide text-gray-500">Confirmed Revenue</p>
                <p class="text-sm text-gray-400">{{ $currentMonth }}</p>
                <p class="mt-4 text-3xl font-bold text-green-600">
                    ₱{{ number_format($verifiedThisMonth, 2) }}
                </p>
            </div>

            <!-- Awaiting Verification Card -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-blue-500">
                <p class="text-xs uppercase tracking-wide text-gray-500">Pending Verification</p>
                <p class="text-sm text-gray-400">Awaiting admin review</p>
                <p class="mt-4 text-3xl font-bold text-blue-600">
                    ₱{{ number_format($pendingVerification, 2) }}
                </p>
            </div>

            <!-- Outstanding Balance -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-yellow-500">
                <p class="text-xs uppercase tracking-wide text-gray-500">Outstanding Balance</p>
                <p class="text-sm text-gray-400">As of {{ now()->format('M d, Y') }}</p>
                <p class="mt-4 text-3xl font-bold text-yellow-500">
                    ₱{{ number_format($expectedRevenue, 2) }}
                </p>
            </div>
        </div>

        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Payment History</h3>
            </div>
            
            <div class="max-h-[65vh] overflow-y-auto p-6 space-y-4">
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
                        
                        <div id="payment-card-{{ $payment->paymentID }}"
                            class="rounded-xl border p-5 transition
                            {{ $isVerified ? 'bg-green-50 border-green-200' :
                                ($isRejected ? 'bg-red-50 border-red-200' : 'bg-blue-50 border-blue-200') }}">

                            
                            <div style="display: flex; justify-content: space-between; align-items: start;">
                                <div style="flex: 1;">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                        <h4 style="margin: 0; font-size: 15px; font-weight: 600; color: #333;">{{ $payment->tenant->name }}</h4>
                                        <span id="status-badge-{{ $payment->paymentID }}"
                                            class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $isVerified ? 'bg-green-100 text-green-700' :
                                                ($isRejected ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
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
                                
                                <div id="action-buttons-{{ $payment->paymentID }}" class="flex gap-2">

                                    @if($payment->receiptImage)
                                        <button onclick="viewReceipt('{{ asset('storage/' . $payment->receiptImage) }}')"
                                                title="View Receipt"
                                                class="btn-icon bg-gray-200 hover:bg-gray-300 text-gray-700">
                                            <!-- eye icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5
                                                        c4.478 0 8.268 2.943 9.542 7
                                                        -1.274 4.057-5.064 7-9.542 7
                                                        -4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    @endif

                                    @if($isPending)
                                        <button onclick="showActionModal({{ $payment->paymentID }}, '{{ $payment->tenant->name }}', {{ $payment->bill->amount }})"
                                                title="Review Payment"
                                                class="btn-icon bg-blue-200 hover:bg-blue-300 text-blue-700">
                                            ✓
                                        </button>
                                    @else
                                        <span class="text-xs italic text-gray-400">No actions</span>
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
@endsection

@section('scripts')
<script src="{{ asset('js/admin-payments.js') }}"></script>
@endsection