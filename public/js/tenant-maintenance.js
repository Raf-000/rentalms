/* ============================================
   TENANT MAINTENANCE - AJAX FUNCTIONALITY
   ============================================ */

let currentRequestID = null;

// Show confirmation modal
function showConfirmModal(requestID) {
    currentRequestID = requestID;
    const modal = document.getElementById('confirmModal');
    modal.classList.add('show');
}

// Close confirmation modal
function closeConfirmModal() {
    const modal = document.getElementById('confirmModal');
    modal.classList.remove('show');
    currentRequestID = null;
}

// Complete maintenance request via AJAX
function completeMaintenanceAjax() {
    if (!currentRequestID) return;
    
    const requestID = currentRequestID;
    const confirmBtn = document.getElementById('confirmCompleteBtn');
    const btnText = confirmBtn.querySelector('.btn-text');
    const btnLoading = confirmBtn.querySelector('.btn-loading');
    
    // Show loading
    confirmBtn.disabled = true;
    btnText.style.display = 'none';
    btnLoading.style.display = 'inline-flex';
    
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    fetch(`/tenant/complete-maintenance/${requestID}/ajax`, {
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
            const card = document.getElementById(`request-card-${requestID}`);
            card.style.backgroundColor = '#f0f9f4';
            card.style.borderLeft = '4px solid #28a745';
            
            // Update status badge
            const statusBadge = document.getElementById(`status-badge-${requestID}`);
            statusBadge.textContent = 'Completed';
            statusBadge.className = 'status-badge status-completed';
            
            // Update status message
            const statusMessage = document.getElementById(`status-message-${requestID}`);
            statusMessage.innerHTML = `
                <p style="font-size: 13px; color: #155724; background-color: #d4edda; padding: 10px 15px; border-radius: 6px; margin: 0; display: inline-flex; align-items: center; gap: 8px;">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Issue resolved and completed
                </p>
            `;
            
            // Remove the button
            const actionButtons = document.getElementById(`action-buttons-${requestID}`);
            const completeBtn = actionButtons.querySelector('.btn-complete');
            if (completeBtn) {
                completeBtn.remove();
            }
            
            // Close modal
            closeConfirmModal();
            
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
        // Reset button
        confirmBtn.disabled = false;
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
    });
}

// Show notification
function showNotification(type, message) {
    const existing = document.querySelector('.notification');
    if (existing) existing.remove();
    
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    
    notification.innerHTML = `
        <svg class="notification-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            ${type === 'success' 
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
            }
        </svg>
        <span>${message}</span>
        <button class="notification-close" onclick="this.parentElement.remove()">×</button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 5000);
}

// Close modal on outside click
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('confirmModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeConfirmModal();
            }
        });
    }
});