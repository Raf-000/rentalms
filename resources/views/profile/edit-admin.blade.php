@extends('layouts.admin-layout')

@section('content')
<!-- Success Notification -->
@if(session('success'))
<div id="successNotification" class="fixed top-20 left-1/2 transform -translate-x-1/2 -translate-y-32 transition-all duration-500 ease-out z-[10000]">
    <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl border-l-4 border-green-500 px-6 py-4 flex items-center gap-4 min-w-[300px] max-w-[90vw]">
        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
        </div>
        <div class="flex-1">
            <p class="font-semibold text-[#135757] text-base sm:text-lg">Success!</p>
            <p class="text-gray-600 text-xs sm:text-sm">{{ session('success') }}</p>
        </div>
        <button onclick="closeNotification()" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const notification = document.getElementById('successNotification');
    if (notification) {
        setTimeout(() => {
            notification.style.transform = 'translateX(-50%) translateY(0)';
        }, 100);
        
        setTimeout(() => {
            closeNotification();
        }, 5000);
    }
});

function closeNotification() {
    const notification = document.getElementById('successNotification');
    if (notification) {
        notification.style.transform = 'translateX(-50%) translateY(-8rem)';
        setTimeout(() => {
            notification.remove();
        }, 500);
    }
}
</script>
@endif

<div class="min-h-screen py-4 sm:py-6 lg:py-8 px-3 sm:px-4 lg:px-8" style="background: linear-gradient(to bottom, rgba(246, 248, 247, 0.85), rgba(226, 232, 231, 0.85)); backdrop-filter: blur(5px);">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#135757] mb-1 sm:mb-2">Edit Profile</h1>
            <p class="text-sm sm:text-base text-gray-700 font-medium">Update your account information</p>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            <!-- Update Profile Information -->
            <div class="bg-white/95 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-lg border-l-4 border-[#135757] overflow-hidden">
                <div class="p-4 sm:p-6 lg:p-8">
                    <h3 class="text-lg sm:text-xl font-bold text-[#135757] mb-4 sm:mb-6 pb-3 border-b-2 border-[#E2E8E7]">Profile Information</h3>
                    
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-4 sm:space-y-5">
                            <!-- Name -->
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-[#135757] mb-1 sm:mb-2">
                                    Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required 
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200">
                                @error('name')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-[#135757] mb-1 sm:mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required 
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200">
                                @error('email')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-[#135757] mb-1 sm:mb-2">
                                    Phone Number
                                </label>
                                <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}" 
                                       placeholder="e.g., 09123456789"
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200">
                                @error('phone')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Emergency Contact -->
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-[#135757] mb-1 sm:mb-2">
                                    Emergency Contact
                                </label>
                                <input type="text" name="emergencyContact" value="{{ old('emergencyContact', Auth::user()->emergencyContact) }}" 
                                       placeholder="Name and phone of emergency contact"
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200">
                                @error('emergencyContact')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-2">
                                <button type="submit" 
                                        class="w-full px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base bg-gradient-to-r from-[#135757] to-[#1a7272] text-white font-semibold rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Password -->
            <div class="bg-white/95 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-lg border-l-4 border-green-600 overflow-hidden">
                <div class="p-4 sm:p-6 lg:p-8">
                    <h3 class="text-lg sm:text-xl font-bold text-green-700 mb-4 sm:mb-6 pb-3 border-b-2 border-[#E2E8E7]">Update Password</h3>
                    
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4 sm:space-y-5">
                            <!-- Current Password -->
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-[#135757] mb-1 sm:mb-2">
                                    Current Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="current_password" required 
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200"
                                       placeholder="Enter current password">
                                @error('current_password')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-[#135757] mb-1 sm:mb-2">
                                    New Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password" required 
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200"
                                       placeholder="Enter new password">
                                @error('password')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm New Password -->
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-[#135757] mb-1 sm:mb-2">
                                    Confirm New Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password_confirmation" required 
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200"
                                       placeholder="Confirm new password">
                            </div>

                            <!-- Password Requirements -->
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-3 sm:p-4 rounded-lg">
                                <p class="text-xs sm:text-sm text-blue-800 font-semibold mb-2">Password Requirements:</p>
                                <ul class="text-xs sm:text-sm text-blue-700 space-y-1 list-disc list-inside">
                                    <li>At least 8 characters long</li>
                                    <li>Mix of letters and numbers recommended</li>
                                </ul>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-2">
                                <button type="submit" 
                                        class="w-full px-4 sm:px-6 py-3 sm:py-4 text-sm sm:text-base bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Account Information Card (Below) -->
        <div class="mt-4 sm:mt-6 bg-white/95 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-lg border-l-4 border-blue-500 overflow-hidden">
            <div class="p-4 sm:p-6 lg:p-8">
                <h3 class="text-lg sm:text-xl font-bold text-blue-700 mb-4 sm:mb-6 pb-3 border-b-2 border-[#E2E8E7]">Account Information</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    <!-- Account Type -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 sm:p-5 rounded-lg border-2 border-blue-200">
                        <p class="text-xs text-blue-600 uppercase tracking-wider font-semibold mb-2">Account Type</p>
                        <p class="text-base sm:text-lg font-bold text-blue-900 capitalize">{{ Auth::user()->role }}</p>
                    </div>

                    <!-- Account Created -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 sm:p-5 rounded-lg border-2 border-purple-200">
                        <p class="text-xs text-purple-600 uppercase tracking-wider font-semibold mb-2">Member Since</p>
                        <p class="text-base sm:text-lg font-bold text-purple-900">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                    </div>

                    <!-- User ID -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-4 sm:p-5 rounded-lg border-2 border-gray-200">
                        <p class="text-xs text-gray-600 uppercase tracking-wider font-semibold mb-2">User ID</p>
                        <p class="text-base sm:text-lg font-bold text-gray-900">#{{ Auth::user()->id }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection