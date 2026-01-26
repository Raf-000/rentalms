/* ============================================
   TENANT MAINTENANCE - AJAX FUNCTIONALITY
   ============================================ */

// Complete maintenance request via AJAX
function completeMaintenanceAjax(requestID) {
    if (!confirm('Are you sure the issue has been fixed?')) {
        return;
    }
    
    const btn = event.target.closest('.btn-complete');
    const btnText = btn.querySelector('.btn-text');
    const btnLoading = btn.querySelector('.btn-loading');
    
    // Show loading
    btn.disabled = true;
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
            
            // Update status badge
            const statusBadge = document.getElementById(`status-badge-${requestID}`);
            statusBadge.textContent = 'Completed';
            statusBadge.className = 'status-badge status-completed';
            
            // Update status message
            const statusMessage = document.getElementById(`status-message-${requestID}`);
            statusMessage.innerHTML = `
                <p style="font-size: 13px; color: #155724; background-color: #d4edda; padding: 8px 12px; border-radius: 4px; margin: 0;">
                    ✓ Issue resolved and completed
                </p>
            `;
            
            // Remove the button
            const actionButtons = document.getElementById(`action-buttons-${requestID}`);
            const completeBtn = actionButtons.querySelector('.btn-complete');
            if (completeBtn) {
                completeBtn.remove();
            }
            
            // Show success notification
            showNotification('success', data.message);
        } else {
            showNotification('error', data.message);
            // Reset button
            btn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Network error. Please try again.');
        // Reset button
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