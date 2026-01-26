// Payment Management JavaScript

let selectedPaymentId = null;

// Receipt Modal Functions
function viewReceipt(receiptUrl) {
    document.getElementById('modalReceipt').src = receiptUrl;
    document.getElementById('receiptModal').style.display = 'flex';
}

function closeReceiptModal() {
    document.getElementById('receiptModal').style.display = 'none';
}

// Close receipt modal when clicking outside
document.getElementById('receiptModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReceiptModal();
    }
});

// Action Modal Functions
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

// Payment Actions
function verifyPayment() {
    if (!selectedPaymentId) return;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/verify-payment/${selectedPaymentId}`;
    
    const csrf = document.createElement('input');
    csrf.type = 'hidden';
    csrf.name = '_token';
    csrf.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
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
    csrf.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    const reasonInput = document.createElement('input');
    reasonInput.type = 'hidden';
    reasonInput.name = 'reason';
    reasonInput.value = reason;
    
    form.appendChild(csrf);
    form.appendChild(reasonInput);
    document.body.appendChild(form);
    form.submit();
}