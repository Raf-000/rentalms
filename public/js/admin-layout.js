/* ============================================
   ADMIN LAYOUT SCRIPTS
   Person 3: You can add interactive features here
   ============================================ */

// Toggle dropdown menu
function toggleDropdown() {
    document.getElementById('userDropdown').classList.toggle('show');
}

// Close dropdown when clicking outside
window.onclick = function(event) {
    if (!event.target.closest('.user-menu')) {
        var dropdown = document.getElementById('userDropdown');
        if (dropdown && dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
        }
    }
}

// Smooth scroll for page transitions (optional - you can remove if not needed)
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin layout loaded successfully');
});