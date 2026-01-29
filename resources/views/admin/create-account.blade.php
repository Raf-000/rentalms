@extends('layouts.admin-layout')

@section('content')
<div class="min-h-screen py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-8" style="background: linear-gradient(to bottom, rgba(246, 248, 247, 0.85), rgba(226, 232, 231, 0.85)); backdrop-filter: blur(5px);">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#135757] mb-1 sm:mb-2">Create New Account</h1>
            <p class="text-sm sm:text-base text-gray-600">Add a new admin or tenant to the system</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white/90 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-xl overflow-hidden border-l-4 border-teal-800">
            <div class="p-4 sm:p-6 lg:p-8">
                <form id="createAccountForm" method="POST" action="{{ route('admin.store-account') }}">
                    @csrf

                    <div class="space-y-4 sm:space-y-6">
                        <!-- Name -->
                        <div>
                            <label class="block text-xs sm:text-sm font-semibold text-[#333333] mb-1 sm:mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                value="{{ old('name') }}" 
                                required
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200"
                                placeholder="Enter full name"
                            >
                            @error('name')
                                <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email & Phone Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            <!-- Email -->
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-[#333333] mb-1 sm:mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    value="{{ old('email') }}" 
                                    required
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200"
                                    placeholder="user@example.com"
                                >
                                @error('email')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-[#333333] mb-1 sm:mb-2">
                                    Phone Number
                                </label>
                                <input 
                                    type="text" 
                                    name="phone" 
                                    id="phone" 
                                    value="{{ old('phone') }}"
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200"
                                    placeholder="+63 XXX XXX XXXX"
                                >
                                @error('phone')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Password & Role Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            <!-- Password -->
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-[#333333] mb-1 sm:mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password" 
                                    required
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200"
                                    placeholder="Enter password"
                                >
                                @error('password')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-[#333333] mb-1 sm:mb-2">
                                    Account Type <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="role" 
                                    id="role" 
                                    required
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white"
                                >
                                    <option value="">Select Role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="tenant" {{ old('role') == 'tenant' ? 'selected' : '' }}>Tenant</option>
                                </select>
                                @error('role')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tenant-Specific Section -->
                        <div id="tenant-section" class="hidden space-y-4 sm:space-y-6 pt-3 sm:pt-4 border-t-2 border-gray-200">
                            <div class="bg-gradient-to-r from-teal-50/80 to-transparent backdrop-blur-sm p-3 sm:p-4 rounded-lg">
                                <h3 class="text-xs sm:text-sm font-semibold text-[#135757] mb-3 sm:mb-4">Tenant Details</h3>
                                
                                <!-- Bedspace -->
                                <div class="mb-3 sm:mb-4">
                                    <label class="block text-xs sm:text-sm font-semibold text-[#333333] mb-1 sm:mb-2">
                                        Assign Bedspace
                                    </label>
                                    <select 
                                        name="bedspace_id" 
                                        id="bedspace_id"
                                        class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white"
                                    >
                                        <option value="">No bedspace assigned</option>
                                        @foreach($bedspaces as $bedspace)
                                            <option value="{{ $bedspace->unitID }}" {{ old('bedspace_id') == $bedspace->unitID ? 'selected' : '' }}>
                                                {{ $bedspace->unitCode }} - H{{ $bedspace->houseNo }}, F{{ $bedspace->floor }}, R{{ $bedspace->roomNo }}, B{{ $bedspace->bedspaceNo }} (₱{{ number_format($bedspace->price, 0) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Lease Dates -->
                                <div id="lease-section" class="hidden grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-[#333333] mb-1 sm:mb-2">
                                            Lease Start Date
                                        </label>
                                        <input 
                                            type="date" 
                                            name="leaseStart" 
                                            id="leaseStart"
                                            value="{{ old('leaseStart') }}"
                                            onchange="clearLeaseErrors()"
                                            class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:outline-none focus:border-teal-800 transition duration-200"
                                        >
                                        @error('leaseStart')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs sm:text-sm font-semibold text-[#333333] mb-1 sm:mb-2">
                                            Lease End Date
                                        </label>
                                        <input 
                                            type="date" 
                                            name="leaseEnd" 
                                            id="leaseEnd"
                                            value="{{ old('leaseEnd') }}"
                                            onchange="clearLeaseErrors()"
                                            class="w-full px-3 sm:px-4 py-2 sm:py-3 text-xs sm:text-sm border-2 border-gray-200 rounded-lg focus:outline-none focus:border-teal-800 transition duration-200"
                                        >
                                        @error('leaseEnd')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-3 sm:pt-4">
                            <button 
                                type="button" 
                                onclick="showConfirmModal()"
                                class="w-full bg-gradient-to-r from-[#135757] to-[#1a7272] text-white font-semibold py-3 sm:py-4 text-sm sm:text-base rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200"
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
<div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-xl sm:rounded-2xl max-w-md w-full mx-3 sm:mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="text-center mb-4 sm:mb-6">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-[#135757] to-[#1a7272] rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-[#333333] mb-1 sm:mb-2">Confirm Account Creation</h3>
                <p class="text-xs sm:text-sm text-gray-600">Please review the details before proceeding</p>
            </div>
            
            <div class="bg-[#f6f8f7] rounded-lg sm:rounded-xl p-4 sm:p-6 mb-4 sm:mb-6 space-y-2 sm:space-y-3">
                <div>
                    <p class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-wider">Name</p>
                    <p id="confirm_name" class="text-xs sm:text-sm font-semibold text-[#333333]">-</p>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-wider">Email</p>
                    <p id="confirm_email" class="text-xs sm:text-sm font-semibold text-[#333333] break-all">-</p>
                </div>
                <div>
                    <p class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-wider">Role</p>
                    <p id="confirm_role" class="text-xs sm:text-sm font-semibold text-[#333333]">-</p>
                </div>
                <div id="confirm_phone_section" class="hidden">
                    <p class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-wider">Phone</p>
                    <p id="confirm_phone" class="text-xs sm:text-sm font-semibold text-gray-800">-</p>
                </div>
                <div id="confirm_bedspace_section" class="hidden">
                    <p class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-wider">Bedspace</p>
                    <p id="confirm_bedspace" class="text-xs sm:text-sm font-semibold text-[#333333]">-</p>
                </div>
            </div>
            
            <div class="flex gap-2 sm:gap-3">
                <button 
                    type="button" 
                    onclick="closeConfirmModal()"
                    class="flex-1 px-4 sm:px-6 py-2 sm:py-3 text-sm sm:text-base bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition duration-200"
                >
                    Cancel
                </button>
                <button 
                    type="button" 
                    onclick="submitForm()"
                    class="flex-1 px-4 sm:px-6 py-2 sm:py-3 text-sm sm:text-base bg-gradient-to-r from-[#135757] to-[#1a7272] text-white font-semibold rounded-lg hover:shadow-lg transition duration-200"
                >
                    Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
@if(session('success') && session('user'))
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-xl sm:rounded-2xl max-w-md w-full mx-3 sm:mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-4 sm:p-6">
            <div class="text-center mb-4 sm:mb-6">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4 animate-bounce">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-[#333333] mb-1 sm:mb-2">Account Created!</h3>
                <p class="text-xs sm:text-sm text-gray-600">Screenshot these credentials and share with the user</p>
            </div>
            
            <div class="bg-gradient-to-br from-[#f6f8f7] to-[#E2E8E7] rounded-lg sm:rounded-xl p-4 sm:p-6 mb-4 sm:mb-6 border-2 border-dashed border-[#135757]">
                <div class="space-y-3 sm:space-y-4">
                    <div>
                        <p class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-wider mb-1">Name</p>
                        <p class="text-sm sm:text-base lg:text-lg font-bold text-[#333333]">{{ session('user')['name'] }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-wider mb-1">Email (Username)</p>
                        <p class="text-sm sm:text-base lg:text-lg font-bold text-[#135757] break-all">{{ session('user')['email'] }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-wider mb-1">Password</p>
                        <p class="text-sm sm:text-base lg:text-lg font-bold text-[#333333] font-mono bg-yellow-100 px-2 sm:px-3 py-1 sm:py-2 rounded break-all">{{ session('user')['password'] }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-wider mb-1">Role</p>
                        <p class="text-sm sm:text-base lg:text-lg font-bold text-[#333333]">{{ session('user')['role'] }}</p>
                    </div>
                    @if(session('user')['bedspace'])
                    <div>
                        <p class="text-[10px] sm:text-xs text-gray-500 uppercase tracking-wider mb-1">Bedspace</p>
                        <p class="text-sm sm:text-base lg:text-lg font-bold text-[#135757]">{{ session('user')['bedspace'] }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <button 
                onclick="closeSuccessModal()"
                class="w-full px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base bg-gradient-to-r from-[#135757] to-[#1a7272] text-white font-semibold rounded-lg hover:shadow-lg transition duration-200"
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
    
    if (!bedspaceId) {
        return true;
    }
    
    const leaseStart = document.getElementById('leaseStart').value;
    const leaseEnd = document.getElementById('leaseEnd').value;
    
    const existingErrors = document.querySelectorAll('.lease-error');
    existingErrors.forEach(error => error.remove());
    
    if (!leaseStart || !leaseEnd) {
        showLeaseError('leaseEnd', 'Both lease start and end dates are required when assigning a bedspace');
        return false;
    }
    
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
    errorEl.className = 'text-red-500 text-xs sm:text-sm mt-1 lease-error';
    errorEl.textContent = message;
    field.parentElement.appendChild(errorEl);
    
    field.classList.add('border-red-500');
    field.classList.remove('border-gray-200');
}

document.getElementById('leaseStart')?.addEventListener('change', function() {
    this.classList.remove('border-red-500');
    this.classList.add('border-gray-200');
    
    const nextError = this.parentElement.querySelector('.lease-error');
    if (nextError) nextError.remove();
});

document.getElementById('leaseEnd')?.addEventListener('change', function() {
    this.classList.remove('border-red-500');
    this.classList.add('border-gray-200');
    
    const nextError = this.parentElement.querySelector('.lease-error');
    if (nextError) nextError.remove();
});

function showConfirmModal() {
    const form = document.getElementById('createAccountForm');
    
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    if (!validateLeaseDates()) {
        const errorElement = document.querySelector('.lease-error');
        if (errorElement) {
            errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return;
    }
    
    document.getElementById('confirm_name').textContent = document.getElementById('name').value;
    document.getElementById('confirm_email').textContent = document.getElementById('email').value;
    document.getElementById('confirm_role').textContent = document.getElementById('role').options[document.getElementById('role').selectedIndex].text;
    
    const phoneValue = document.getElementById('phone').value;
    const phoneSection = document.getElementById('confirm_phone_section');
    if (phoneValue) {
        phoneSection.classList.remove('hidden');
        document.getElementById('confirm_phone').textContent = phoneValue;
    } else {
        phoneSection.classList.add('hidden');
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

document.getElementById('confirmModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeConfirmModal();
    }
});

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