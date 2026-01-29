/* ============================================
   ADMIN LAYOUT SCRIPTS - Mobile Responsive
   ============================================ */

let sidebarCollapsed = false;
let isMobile = window.innerWidth <= 768;

// Toggle sidebar (collapse/expand on desktop, slide on mobile)
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const backdrop = document.getElementById('sidebarBackdrop');
    
    if (isMobile) {
        // Mobile: Toggle slide-in sidebar
        sidebar.classList.toggle('mobile-open');
        backdrop.classList.toggle('show');
        document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
    } else {
        // Desktop: Toggle collapse
        sidebarCollapsed = !sidebarCollapsed;
        
        if (sidebarCollapsed) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
        } else {
            sidebar.classList.remove('collapsed');
            mainContent.classList.remove('expanded');
        }
        
        localStorage.setItem('sidebarCollapsed', sidebarCollapsed);
    }
}

// Close sidebar when clicking backdrop (mobile)
function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebarBackdrop');
    
    sidebar.classList.remove('mobile-open');
    backdrop.classList.remove('show');
    document.body.style.overflow = '';
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

// Handle window resize
function handleResize() {
    const wasMobile = isMobile;
    isMobile = window.innerWidth <= 768;
    
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const backdrop = document.getElementById('sidebarBackdrop');
    
    if (wasMobile !== isMobile) {
        // Screen size category changed
        if (isMobile) {
            // Switched to mobile
            sidebar.classList.remove('collapsed');
            sidebar.classList.remove('mobile-open');
            mainContent.classList.remove('expanded');
            backdrop.classList.remove('show');
            document.body.style.overflow = '';
        } else {
            // Switched to desktop
            sidebar.classList.remove('mobile-open');
            backdrop.classList.remove('show');
            document.body.style.overflow = '';
            
            // Restore desktop sidebar state
            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
                sidebarCollapsed = true;
            }
        }
    }
}

// Debounce resize handler
let resizeTimeout;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(handleResize, 150);
});

// Load sidebar state on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin layout loaded successfully');
    
    // Detect initial screen size
    isMobile = window.innerWidth <= 768;
    
    if (!isMobile) {
        // Restore desktop sidebar state
        const savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true') {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
            sidebarCollapsed = true;
        }
    }
});

// Close sidebar when clicking on a link (mobile only)
document.querySelectorAll('.sidebar-nav a').forEach(link => {
    link.addEventListener('click', function() {
        if (isMobile) {
            closeSidebar();
        }
    });
});