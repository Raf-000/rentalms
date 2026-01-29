@extends('layouts.admin-layout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#f6f8f7]/80 to-[#E2E8E7]/80 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-[#135757] mb-2">Create New Account</h1>
            <p class="text-gray-600">Add a new admin or tenant to the system</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border-l-4 border-teal-800">
            <div class="p-8">
                <form id="createAccountForm" method="POST" action="{{ route('admin.store-account') }}">
                    @csrf

                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-semibold text-[#333333] mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                value="{{ old('name') }}" 
                                required
                                class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200"
                                placeholder="Enter full name"
                            >
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email & Phone Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-[#333333] mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    value="{{ old('email') }}" 
                                    required
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200"
                                    placeholder="user@example.com"
                                >
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-semibold text-[#333333] mb-2">
                                    Phone Number
                                </label>
                                <input 
                                    type="text" 
                                    name="phone" 
                                    id="phone" 
                                    value="{{ old('phone') }}"
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200"
                                    placeholder="+63 XXX XXX XXXX"
                                >
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Password & Role Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Password -->
                            <div>
                                <label class="block text-sm font-semibold text-[#333333] mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password" 
                                    required
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200"
                                    placeholder="Enter password"
                                >
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-sm font-semibold text-[#333333] mb-2">
                                    Account Type <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="role" 
                                    id="role" 
                                    required
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white"
                                >
                                    <option value="">Select Role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="tenant" {{ old('role') == 'tenant' ? 'selected' : '' }}>Tenant</option>
                                </select>
                                @error('role')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tenant-Specific Section -->
                         <div id="tenant-section" class="hidden space-y-6 pt-4 border-t-2 border-gray-200">
                            <div class="bg-gradient-to-r from-teal-50/80 to-transparent backdrop-blur-sm p-4 rounded-lg">
                                <h3 class="text-sm font-semibold text-[#135757] mb-4">Tenant Details</h3>
                                
                                <!-- Bedspace -->
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-[#333333] mb-2">
                                        Assign Bedspace
                                    </label>
                                    <select 
                                        name="bedspace_id" 
                                        id="bedspace_id"
                                        class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white"
                                    >
                                        <option value="">No bedspace assigned</option>
                                        @foreach($bedspaces as $bedspace)
                                            <option value="{{ $bedspace->unitID }}" {{ old('bedspace_id') == $bedspace->unitID ? 'selected' : '' }}>
                                                {{ $bedspace->unitCode }} - House {{ $bedspace->houseNo }}, Floor {{ $bedspace->floor }}, Room {{ $bedspace->roomNo }}, Bed {{ $bedspace->bedspaceNo }} (₱{{ number_format($bedspace->price, 0) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Lease Dates -->
                                <div id="lease-section" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-[#333333] mb-2">
                                            Lease Start Date
                                        </label>
                                        <input 
                                            type="date" 
                                            name="leaseStart" 
                                            id="leaseStart"
                                            value="{{ old('leaseStart') }}"
                                            onchange="clearLeaseErrors()"
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-teal-800 transition duration-200"
                                        >

                                        @error('leaseStart')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-[#333333] mb-2">
                                            Lease End Date
                                        </label>
                                        <input 
                                            type="date" 
                                            name="leaseEnd" 
                                            id="leaseEnd"
                                            value="{{ old('leaseEnd') }}"
                                            onchange="clearLeaseErrors()"
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-teal-800 transition duration-200"
                                        >

                                        @error('leaseEnd')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button 
                                type="button" 
                                onclick="showConfirmModal()"
                                class="w-full bg-gradient-to-r from-[#135757] to-[#1a7272] text-white font-semibold py-4 rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200"
                            >
                                Create Account
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-gray-50/80 backdrop-blur-sm rounded-xl p-6 mb-6 space-y-3">
        <div class="p-8">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-[#135757] to-[#1a7272] rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-[#333333] mb-2">Confirm Account Creation</h3>
                <p class="text-gray-600">Please review the details before proceeding</p>
            </div>
            
            <div class="bg-[#f6f8f7] rounded-xl p-6 mb-6 space-y-3">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Name</p>
                    <p id="confirm_name" class="text-sm font-semibold text-[#333333]">-</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Email</p>
                    <p id="confirm_email" class="text-sm font-semibold text-[#333333]">-</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Role</p>
                    <p id="confirm_role" class="text-sm font-semibold text-[#333333]">-</p>
                </div>
                <div id="confirm_phone_section" class="hidden">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Phone</p>
                    <p id="confirm_phone" class="text-sm font-semibold text-gray-800">-</p>
                </div>
                <div id="confirm_bedspace_section" class="hidden">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Bedspace</p>
                    <p id="confirm_bedspace" class="text-sm font-semibold text-[#333333]">-</p>
                </div>
            </div>
            
            <div class="flex gap-3">
                <button 
                    type="button" 
                    onclick="closeConfirmModal()"
                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition duration-200"
                >
                    Cancel
                </button>
                <button 
                    type="button" 
                    onclick="submitForm()"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-[#135757] to-[#1a7272] text-white font-semibold rounded-lg hover:shadow-lg transition duration-200"
                >
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
@if(session('success') && session('user'))
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-gradient-to-br from-gray-50/80 to-gray-200/80 backdrop-blur-sm rounded-xl p-4 m-4 border-2 border-dashed border-teal-700">
        <div class="p-4">
            <div class="text-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-[#333333] mb-2">Account Created!</h3>
                <p class="text-gray-600">Screenshot these credentials and share with the user</p>
            </div>
            
            <div class="bg-gradient-to-br from-[#f6f8f7] to-[#E2E8E7] rounded-xl p-6 mb-6 border-2 border-dashed border-[#135757]">
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Name</p>
                        <p class="text-lg font-bold text-[#333333]">{{ session('user')['name'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Email (Username)</p>
                        <p class="text-lg font-bold text-[#135757]">{{ session('user')['email'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Password</p>
                        <p class="text-lg font-bold text-[#333333] font-mono bg-yellow-100 px-3 py-2 rounded">{{ session('user')['password'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Role</p>
                        <p class="text-lg font-bold text-[#333333]">{{ session('user')['role'] }}</p>
                    </div>
                    @if(session('user')['bedspace'])
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Bedspace</p>
                        <p class="text-lg font-bold text-[#135757]">{{ session('user')['bedspace'] }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <button 
                onclick="closeSuccessModal()"
                class="w-full px-6 py-4 bg-gradient-to-r from-[#135757] to-[#1a7272] text-white font-semibold rounded-lg hover:shadow-lg transition duration-200"
            >
                Done
            </button>
        </div>
    </div>
</div>

<script>
    function closeSuccessModal() {
        document.getElementById('successModal').style.display = 'none';
    }
</script>
@endif

<script>
// Show tenant section when role is tenant
document.getElementById('role').addEventListener('change', function() {
    const tenantSection = document.getElementById('tenant-section');
    if (this.value === 'tenant') {
        tenantSection.classList.remove('hidden');
    } else {
        tenantSection.classList.add('hidden');
        document.getElementById('lease-section').classList.add('hidden');
    }
});

// Show lease dates when bedspace is selected
document.getElementById('bedspace_id').addEventListener('change', function() {
    const leaseSection = document.getElementById('lease-section');
    if (this.value) {
        leaseSection.classList.remove('hidden');
    } else {
        leaseSection.classList.add('hidden');
    }
});

// Validate lease dates
function validateLeaseDates() {
    const bedspaceId = document.getElementById('bedspace_id').value;
    
    // Only validate if bedspace is selected
    if (!bedspaceId) {
        return true; // No bedspace = no lease dates required
    }
    
    const leaseStart = document.getElementById('leaseStart').value;
    const leaseEnd = document.getElementById('leaseEnd').value;
    
    // Remove old error messages first
    const existingErrors = document.querySelectorAll('.lease-error');
    existingErrors.forEach(error => error.remove());
    
    // Check if dates are filled
    if (!leaseStart || !leaseEnd) {
        showLeaseError('leaseEnd', 'Both lease start and end dates are required when assigning a bedspace');
        return false;
    }
    
    // Validate that end date is after start date
    const startDate = new Date(leaseStart);
    const endDate = new Date(leaseEnd);
    
    if (endDate <= startDate) {
        showLeaseError('leaseEnd', 'The lease end date must be after the lease start date');
        return false;
    }
    
    return true;
}

function showLeaseError(fieldName, message) {
    const field = document.getElementById(fieldName);
    const errorEl = document.createElement('p');
    errorEl.className = 'text-red-500 text-sm mt-1 lease-error';
    errorEl.textContent = message;
    field.parentElement.appendChild(errorEl);
    
    // Add red border to field
    field.classList.add('border-red-500');
    field.classList.remove('border-gray-200');
}

// Clear errors when dates change
document.getElementById('leaseStart')?.addEventListener('change', function() {
    // Remove error styling
    this.classList.remove('border-red-500');
    this.classList.add('border-gray-200');
    
    // Remove error message
    const nextError = this.parentElement.querySelector('.lease-error');
    if (nextError) nextError.remove();
});

document.getElementById('leaseEnd')?.addEventListener('change', function() {
    // Remove error styling
    this.classList.remove('border-red-500');
    this.classList.add('border-gray-200');
    
    // Remove error message
    const nextError = this.parentElement.querySelector('.lease-error');
    if (nextError) nextError.remove();
});

// Show confirmation modal ONLY after all validation passes
function showConfirmModal() {
    const form = document.getElementById('createAccountForm');
    
    // First check HTML5 validation (required fields, email format, etc.)
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    // Then check custom lease date validation
    if (!validateLeaseDates()) {
        // Scroll to the error
        const errorElement = document.querySelector('.lease-error');
        if (errorElement) {
            errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return;
    }
    
    // All validation passed - populate and show confirmation modal
    document.getElementById('confirm_name').textContent = document.getElementById('name').value;
    document.getElementById('confirm_email').textContent = document.getElementById('email').value;
    document.getElementById('confirm_role').textContent = document.getElementById('role').options[document.getElementById('role').selectedIndex].text;
    
    const phoneValue = document.getElementById('phone').value;
    if (phoneValue) {
        const phoneSection = document.getElementById('confirm_phone_section');
        if (!phoneSection) {
            // Add phone section if it doesn't exist
            const roleDiv = document.getElementById('confirm_role').parentElement;
            const phoneDiv = document.createElement('div');
            phoneDiv.id = 'confirm_phone_section';
            phoneDiv.innerHTML = `
                <p class="text-xs text-gray-500 uppercase tracking-wider">Phone</p>
                <p id="confirm_phone" class="text-sm font-semibold text-gray-800">${phoneValue}</p>
            `;
            roleDiv.parentElement.appendChild(phoneDiv);
        } else {
            document.getElementById('confirm_phone').textContent = phoneValue;
        }
    }
    
    const bedspaceSelect = document.getElementById('bedspace_id');
    const bedspaceSection = document.getElementById('confirm_bedspace_section');
    if (bedspaceSelect.value) {
        bedspaceSection.classList.remove('hidden');
        const selectedText = bedspaceSelect.options[bedspaceSelect.selectedIndex].text;
        const leaseStart = document.getElementById('leaseStart').value;
        const leaseEnd = document.getElementById('leaseEnd').value;
        
        let bedspaceText = selectedText;
        if (leaseStart && leaseEnd) {
            const startFormatted = new Date(leaseStart).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
            const endFormatted = new Date(leaseEnd).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
            bedspaceText += ` (${startFormatted} - ${endFormatted})`;
        }
        
        document.getElementById('confirm_bedspace').textContent = bedspaceText;
    } else {
        bedspaceSection.classList.add('hidden');
    }
    
    document.getElementById('confirmModal').classList.remove('hidden');
}

function closeConfirmModal() {
    document.getElementById('confirmModal').classList.add('hidden');
}

function submitForm() {
    document.getElementById('createAccountForm').submit();
}

// Close modals on outside click
document.getElementById('confirmModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeConfirmModal();
    }
});

// Add validation on form submit as backup
document.getElementById('createAccountForm').addEventListener('submit', function(e) {
    if (!validateLeaseDates()) {
        e.preventDefault();
        const errorElement = document.querySelector('.lease-error');
        if (errorElement) {
            errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
});
</script>
@endsection