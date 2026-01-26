/* ============================================
   AVAILABLE ROOMS - SUCCESS MESSAGE
   ============================================ */

document.addEventListener('DOMContentLoaded', function() {
    // Check for success message from booking
    const successMessage = sessionStorage.getItem('bookingSuccess');
    
    if (successMessage) {
        // Remove from storage
        sessionStorage.removeItem('bookingSuccess');
        
        // Show success notification
        showSuccessNotification(successMessage);
    }
});

function showSuccessNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'top-success-notification';
    notification.innerHTML = `
        <svg class="success-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>${message}</span>
        <button class="notification-close" onclick="this.parentElement.remove()">×</button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('fade-out');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}