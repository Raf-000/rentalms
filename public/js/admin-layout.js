/* ============================================
   ADMIN LAYOUT SCRIPTS
   ============================================ */

let sidebarCollapsed = false;

// Toggle sidebar (collapse/expand)
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    
    sidebarCollapsed = !sidebarCollapsed;
    
    if (sidebarCollapsed) {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('expanded');
    } else {
        sidebar.classList.remove('collapsed');
        mainContent.classList.remove('expanded');
    }
    
    // Save preference
    localStorage.setItem('sidebarCollapsed', sidebarCollapsed);
}

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

// Load sidebar state on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin layout loaded successfully');
    
    // Restore sidebar state
    const savedState = localStorage.getItem('sidebarCollapsed');
    if (savedState === 'true') {
        sidebarCollapsed = false; // Set to false so toggle makes it true
        toggleSidebar();
    }
});