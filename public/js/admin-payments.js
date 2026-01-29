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
