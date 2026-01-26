@extends('layouts.admin-layout')

@section('content')
<!-- Link to external CSS -->
<link rel="stylesheet" href="{{ asset('css/payments.css') }}">

<div class="content-header">
    <h1>Payment Management</h1>
    <p>Review and manage tenant payments</p>
</div>

@if(session('success'))
    <div class="success-alert">
        {{ session('success') }}
    </div>
@endif

<div class="payment-container">
    
    <!-- Left Side - Stats Cards (25%) -->
    <div class="stats-sidebar">
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
        <div class="stat-card verified">
            <div class="stat-header">
                <p class="stat-label">Confirmed Revenue</p>
                <p class="stat-sublabel">{{ $currentMonth }}</p>
            </div>
            <p class="stat-amount verified">₱{{ number_format($verifiedThisMonth, 2) }}</p>
        </div>

        <!-- Awaiting Verification Card -->
        <div class="stat-card pending">
            <div class="stat-header">
                <p class="stat-label">Pending Verification</p>
                <p class="stat-sublabel">Awaiting admin review</p>
            </div>
            <p class="stat-amount pending">₱{{ number_format($pendingVerification, 2) }}</p>
        </div>

        <!-- Expected Revenue Card -->
        <div class="stat-card outstanding">
            <div class="stat-header">
                <p class="stat-label">Outstanding Balance</p>
                <p class="stat-sublabel">As of {{ now()->format('M d, Y') }}</p>
            </div>
            <p class="stat-amount outstanding">₱{{ number_format($expectedRevenue, 2) }}</p>
        </div>
    </div>

    <!-- Right Side - Payment History (75%) -->
    <div class="history-section">
        <div class="history-card">
            <div class="history-header">
                <h3>Payment History</h3>
            </div>
            
            <div class="history-content">
                @php
                    $payments = \App\Models\Payment::with(['bill', 'tenant'])
                        ->orderBy('paidAt', 'desc')
                        ->get();
                @endphp

                @if($payments->count() > 0)
                    <div class="payment-list">
                        @foreach($payments as $payment)
                        @php
                            $isPending = is_null($payment->verifiedBy) && is_null($payment->rejectedBy);
                            $isVerified = !is_null($payment->verifiedBy);
                            $isRejected = !is_null($payment->rejectedBy);
                            $statusClass = $isVerified ? 'verified' : ($isRejected ? 'rejected' : 'pending');
                        @endphp
                        
                        <div class="payment-item {{ $statusClass }}">
                            <div class="payment-header">
                                <div class="payment-info">
                                    <div class="payment-title">
                                        <h4>{{ $payment->tenant->name }}</h4>
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ $isVerified ? 'Verified' : ($isRejected ? 'Rejected' : 'Pending') }}
                                        </span>
                                    </div>
                                    
                                    <div class="payment-details">
                                        <div class="detail-item">
                                            <p>Amount</p>
                                            <p class="amount">₱{{ number_format($payment->bill->amount, 2) }}</p>
                                        </div>
                                        <div class="detail-item">
                                            <p>Due Date</p>
                                            <p>{{ date('M d, Y', strtotime($payment->bill->dueDate)) }}</p>
                                        </div>
                                        <div class="detail-item">
                                            <p>Payment Method</p>
                                            <p>{{ ucfirst($payment->paymentMethod) }}</p>
                                        </div>
                                        <div class="detail-item">
                                            <p>Paid At</p>
                                            <p>{{ date('M d, Y h:i A', strtotime($payment->paidAt)) }}</p>
                                        </div>
                                    </div>

                                    @if($isRejected)
                                        <div class="rejection-notice">
                                            <p>Rejection Reason:</p>
                                            <p>{{ $payment->rejectionReason ?? 'No reason provided' }}</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="payment-actions">
                                    @if($payment->receiptImage)
                                        <button onclick="viewReceipt('{{ asset('storage/' . $payment->receiptImage) }}')" 
                                                class="btn btn-secondary">
                                            View Receipt
                                        </button>
                                    @endif
                                    
                                    @if($isPending)
                                        <button onclick="showActionModal({{ $payment->paymentID }}, '{{ $payment->tenant->name }}', {{ $payment->bill->amount }})" 
                                                class="btn btn-primary">
                                            Review
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <p>No payment history found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Receipt Viewer Modal -->
<div id="receiptModal" class="modal-overlay receipt-modal-overlay">
    <div class="receipt-modal-content">
        <button onclick="closeReceiptModal()" class="modal-close-btn">×</button>
        <img id="modalReceipt" src="" class="receipt-image">
    </div>
</div>

<!-- Action Modal (Verify/Reject) -->
<div id="actionModal" class="modal-overlay action-modal-overlay">
    <div class="action-modal-content">
        <h3>Review Payment</h3>
        
        <div class="review-info">
            <p>Tenant</p>
            <p id="reviewTenantName" class="review-tenant-name"></p>
            <p>Amount</p>
            <p id="reviewAmount" class="review-amount"></p>
        </div>

        <div id="rejectReasonSection" class="reject-reason-section" style="display: none;">
            <label>Rejection Reason</label>
            <textarea id="rejectionReason" rows="3" placeholder="Explain why this payment is being rejected..." 
                      class="reject-reason-textarea"></textarea>
        </div>

        <div class="modal-actions">
            <button onclick="closeActionModal()" class="btn btn-cancel">Cancel</button>
            <button onclick="verifyPayment()" class="btn btn-verify">✓ Verify</button>
            <button onclick="toggleRejectReason()" id="rejectBtn" class="btn btn-reject">✗ Reject</button>
        </div>

        <button id="confirmRejectBtn" onclick="rejectPayment()" class="btn btn-confirm-reject" style="display: none;">
            Confirm Rejection
        </button>
    </div>
</div>

<!-- Link to external JavaScript -->
<script src="{{ asset('js/payment-management.js') }}"></script>

@endsection