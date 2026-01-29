/* Tenants Management - External JS */

let currentTenantId = null;

function viewTenant(tenant) {
    currentTenantId = tenant.id;
    
    const detailsHtml = `
        <div class="tenant-profile">
            <div class="profile-avatar">${tenant.name.charAt(0).toUpperCase()}</div>
            <div class="profile-info">
                <h3>${tenant.name}</h3>
                <p>${tenant.email}</p>
            </div>
        </div>
        
        <div class="details-grid">
            <div class="detail-card">
                <p class="detail-label">Phone Number</p>
                <p class="detail-value">${tenant.phone || 'Not provided'}</p>
                <p class="detail-subtext">Emergency: ${tenant.emergencyContact || 'Not provided'}</p>
            </div>
            
            <div class="detail-card">
                <p class="detail-label">Bedspace</p>
                <p class="detail-value primary">${tenant.bedspace ? tenant.bedspace.unitCode : 'Not assigned'}</p>
                ${tenant.bedspace ? `<p class="detail-subtext">₱${parseFloat(tenant.bedspace.price).toFixed(2)}/month</p>` : ''}
            </div>
            
            <div class="detail-card">
                <p class="detail-label">Lease Period</p>
                <p class="detail-value">${tenant.lease_start ? new Date(tenant.lease_start).toLocaleDateString('en-US', {year: 'numeric', month: 'short', day: 'numeric'}) : 'Not set'}</p>
                <p class="detail-subtext">to ${tenant.lease_end ? new Date(tenant.lease_end).toLocaleDateString('en-US', {year: 'numeric', month: 'short', day: 'numeric'}) : 'Not set'}</p>
            </div>
            
            <div class="detail-card">
                <p class="detail-label">Total Balance</p>
                <p class="detail-value ${parseFloat(tenant.total_balance || 0) > 0 ? 'text-danger' : 'text-success'}">₱${parseFloat(tenant.total_balance || 0).toFixed(2)}</p>
            </div>
        </div>
    `;
    
    document.getElementById('tenantDetails').innerHTML = detailsHtml;
    document.getElementById('tenantModal').classList.add('active');
    document.body.classList.add('modal-open');
}

function editTenant() {
    if (currentTenantId) {
        window.location.href = `/admin/tenants/${currentTenantId}/edit`;
    }
}


function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
    document.body.classList.remove('modal-open');
}

function showDeleteConfirm(id) {
    currentTenantId = id; // set the tenant ID here
    document.getElementById('deleteForm').action = `/admin/tenants/${currentTenantId}`;
    document.getElementById('deleteModal').classList.add('active');
    document.body.classList.add('modal-open');
}


function closeModal() {
    document.getElementById('tenantModal').classList.remove('active');
    document.body.classList.remove('modal-open');
    currentTenantId = null;
}

function filterTable() {
    const statusFilter = document.getElementById('statusFilter').value;
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('.tenant-row');
    
    let visibleCount = 0;
    
    rows.forEach(row => {
        const name = row.getAttribute('data-name');
        const status = row.getAttribute('data-status');
        
        let matchesStatus = statusFilter === 'all' || status === statusFilter;
        let matchesSearch = name.includes(searchInput);
        
        if (matchesStatus && matchesSearch) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    document.querySelector('.tenant-count').textContent = `${visibleCount} tenant${visibleCount !== 1 ? 's' : ''}`;
}

// Close modals on ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeModal();
        closeDeleteModal();
    }
});

// Close modal when clicking outside
document.getElementById('tenantModal')?.addEventListener('click', (e) => {
    if (e.target.id === 'tenantModal') closeModal();
});

document.getElementById('deleteModal')?.addEventListener('click', (e) => {
    if (e.target.id === 'deleteModal') closeDeleteModal();
});