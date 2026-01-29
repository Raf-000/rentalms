@extends('layouts.admin-layout')

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(to bottom, rgba(246, 248, 247, 0.85), rgba(226, 232, 231, 0.85)); backdrop-filter: blur(5px);">
    <div class="max-w-4xl mx-auto">
        <!-- Header with Back Button -->
        <div class="mb-8 flex items-center gap-4">
            <a href="{{ route('admin.view-tenants') }}" class="w-10 h-10 rounded-lg bg-white/95 backdrop-blur-sm border-2 border-[#E2E8E7] flex items-center justify-center hover:border-[#135757] hover:bg-[#135757] hover:text-white transition-all duration-300">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-4xl font-bold text-[#135757] mb-1">Edit Tenant</h1>
                <p class="text-gray-700 text-lg font-medium">Update {{ $tenant->name }}'s information</p>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg backdrop-blur-sm bg-opacity-95">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main Form Card -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8">
                <form id="editTenantForm" method="POST" action="{{ route('admin.tenants.update', $tenant->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Tenant Profile Section -->
                    <div class="mb-8 pb-6 border-b-2 border-[#E2E8E7]">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#10b981] via-[#14b8a6] to-[#06b6d4] flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                                {{ substr($tenant->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-[#135757]">Account Information</h3>
                                <p class="text-sm text-gray-600">Update basic tenant details</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-semibold text-[#135757] mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                value="{{ old('name', $tenant->name) }}" 
                                required
                                class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white"
                            >
                        </div>

                        <!-- Email & Phone Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-[#135757] mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email', $tenant->email) }}" 
                                    required
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#135757] mb-2">
                                    Phone Number
                                </label>
                                <input 
                                    type="text" 
                                    name="phone" 
                                    value="{{ old('phone', $tenant->phone) }}"
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white"
                                    placeholder="+63 XXX XXX XXXX"
                                >
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div>
                            <label class="block text-sm font-semibold text-[#135757] mb-2">
                                Emergency Contact Number
                            </label>
                            <input 
                                type="text" 
                                name="emergencyContact" 
                                value="{{ old('emergencyContact', $tenant->emergencyContact) }}"
                                class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white"
                                placeholder="+63 XXX XXX XXXX"
                            >
                        </div>

                        <!-- Divider -->
                        <div class="pt-6 pb-4 border-t-2 border-[#E2E8E7]">
                            <h3 class="text-lg font-bold text-[#135757] mb-1">Bedspace & Lease Information</h3>
                            <p class="text-sm text-gray-600">Manage bedspace assignment and lease dates</p>
                        </div>

                        <!-- Bedspace -->
                        <div>
                            <label class="block text-sm font-semibold text-[#135757] mb-2">
                                Assigned Bedspace
                            </label>
                            <select 
                                name="bedspace_id" 
                                id="bedspace_id"
                                class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white"
                            >
                                <option value="">No bedspace assigned</option>
                                @foreach($bedspaces as $bedspace)
                                    <option value="{{ $bedspace->unitID }}" 
                                        {{ old('bedspace_id', $tenant->bedspace?->unitID) == $bedspace->unitID ? 'selected' : '' }}>
                                        {{ $bedspace->unitCode }} - House {{ $bedspace->houseNo }}, Floor {{ $bedspace->floor }}, Room {{ $bedspace->roomNo }}, Bed {{ $bedspace->bedspaceNo }} (₱{{ number_format($bedspace->price, 0) }}/mo)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Lease Dates -->
                        <div id="lease-section" class="{{ $tenant->bedspace ? '' : 'hidden' }} grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-[#135757] mb-2">
                                    Lease Start Date
                                </label>
                                <input 
                                    type="date" 
                                    name="leaseStart" 
                                    id="leaseStart"
                                    value="{{ old('leaseStart', $tenant->leaseStart) }}"
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#135757] mb-2">
                                    Lease End Date
                                </label>
                                <input 
                                    type="date" 
                                    name="leaseEnd" 
                                    id="leaseEnd"
                                    value="{{ old('leaseEnd', $tenant->leaseEnd) }}"
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white"
                                >
                            </div>
                        </div>

                        <!-- Password Change (Optional) -->
                        <div class="pt-6 pb-4 border-t-2 border-[#E2E8E7]">
                            <h3 class="text-lg font-bold text-[#135757] mb-1">Security</h3>
                            <p class="text-sm text-gray-600">Leave blank to keep current password</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-[#135757] mb-2">
                                New Password (Optional)
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white"
                                placeholder="Enter new password or leave blank"
                            >
                            <p class="text-xs text-gray-500 mt-1">Only fill this if you want to change the password</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4 pt-6">
                            <a href="{{ route('admin.view-tenants') }}" 
                               class="flex-1 px-6 py-4 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition duration-200 text-center">
                                Cancel
                            </a>
                            <button 
                                type="submit"
                                class="flex-1 px-6 py-4 bg-gradient-to-r from-[#135757] to-[#1a7272] text-white font-semibold rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                                Update Tenant
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="mt-6 bg-red-50/95 backdrop-blur-sm rounded-2xl shadow-lg border-2 border-red-200 p-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-red-900 mb-1">Danger Zone</h3>
                    <p class="text-sm text-red-700 mb-4">Deleting this tenant will permanently remove all associated data including bills, payments, and maintenance records. This action cannot be undone.</p>
                    <button 
                        type="button"
                        onclick="showDeleteModal()"
                        class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-200">
                        Delete This Tenant
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.6); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(3px);">
    <div style="background: white; border-radius: 16px; max-width: 500px; width: 90%; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
        <div style="padding: 24px; border-bottom: 2px solid #E2E8E7; display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0; font-size: 22px; font-weight: 700; color: #135757;">Delete Tenant Account</h2>
            <button onclick="closeDeleteModal()" style="background: none; border: none; font-size: 28px; color: #999; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 24px; text-align: center;">
            <div style="width: 72px; height: 72px; background: linear-gradient(135deg, #fee2e2, #fecaca); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: #dc2626;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </div>
            <h3 style="margin: 0 0 12px 0; font-size: 20px; font-weight: 700; color: #135757;">Are you absolutely sure?</h3>
            <p style="color: #555; margin: 0 0 16px 0; font-size: 14px;">This will permanently delete <strong>{{ $tenant->name }}</strong>'s account and all associated data.</p>
        </div>
        <div style="display: flex; gap: 12px; padding: 20px 24px; border-top: 2px solid #E2E8E7;">
            <button onclick="closeDeleteModal()" style="flex: 1; padding: 12px 20px; background: #E2E8E7; color: #135757; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer;">
                Cancel
            </button>
            <form method="POST" action="{{ route('admin.tenants.delete', $tenant->id) }}" style="flex: 1;">
                @csrf
                @method('DELETE')
                <button type="submit" style="width: 100%; padding: 12px 20px; background: linear-gradient(135deg, #c62828, #e53935); color: white; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer;">
                    Yes, Delete Account
                </button>
            </form>
        </div>
    </div>
</div>

<script>
// Show/hide lease section based on bedspace selection
document.getElementById('bedspace_id').addEventListener('change', function() {
    const leaseSection = document.getElementById('lease-section');
    if (this.value) {
        leaseSection.classList.remove('hidden');
    } else {
        leaseSection.classList.add('hidden');
    }
});

// Delete modal functions
function showDeleteModal() {
    document.getElementById('deleteModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close on ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeDeleteModal();
});

// Close on outside click
document.getElementById('deleteModal').addEventListener('click', (e) => {
    if (e.target.id === 'deleteModal') closeDeleteModal();
});
</script>
@endsection