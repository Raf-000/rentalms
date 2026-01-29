@extends('layouts.admin-layout')

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(to bottom, rgba(246, 248, 247, 0.85), rgba(226, 232, 231, 0.85)); backdrop-filter: blur(5px);">
    <div class="max-w-4xl mx-auto">
        <!-- Header with Back Button -->
        <div class="mb-8 flex items-center gap-4">
            <a href="{{ route('admin.bookings.index') }}" class="w-10 h-10 rounded-lg bg-white/95 backdrop-blur-sm border-2 border-[#E2E8E7] flex items-center justify-center hover:border-[#135757] hover:bg-[#135757] hover:text-white transition-all duration-300">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-4xl font-bold text-[#135757] mb-1">Add New Booking</h1>
                <p class="text-gray-700 text-lg font-medium">Manually create a viewing appointment</p>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8">
                <form method="POST" action="{{ route('admin.bookings.store') }}">
                    @csrf

                    <div class="space-y-6">
                        <!-- Name & Gender Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-[#135757] mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                        class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-[#135757] mb-2">
                                    Gender <span class="text-red-500">*</span>
                                </label>
                                <select name="gender" required
                                        class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Email & Phone Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-[#135757] mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#135757] mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white"
                                    placeholder="+63 XXX XXX XXXX">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Bedspace -->
                        <div>
                            <label class="block text-sm font-semibold text-[#135757] mb-2">
                                Bedspace to View <span class="text-red-500">*</span>
                            </label>
                            <select name="bedspace_id" required
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white">
                                <option value="">Select Bedspace</option>
                                @foreach($bedspaces as $bedspace)
                                    <option value="{{ $bedspace->unitID }}" {{ old('bedspace_id') == $bedspace->unitID ? 'selected' : '' }}>
                                        {{ $bedspace->unitCode }} - House {{ $bedspace->houseNo }}, Floor {{ $bedspace->floor }}, Room {{ $bedspace->roomNo }}, Bed {{ $bedspace->bedspaceNo }} (₱{{ number_format($bedspace->price, 0) }}/mo)
                                    </option>
                                @endforeach
                            </select>
                            @error('bedspace_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date & Time Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-[#135757] mb-2">
                                    Preferred Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="preferred_date" value="{{ old('preferred_date', date('Y-m-d')) }}" required
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white">
                                @error('preferred_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#135757] mb-2">
                                    Preferred Time (Optional)
                                </label>
                                <input type="text" name="preferred_time" value="{{ old('preferred_time') }}" 
                                    placeholder="e.g., 10:00 AM - 12:00 PM"
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white">
                                @error('preferred_time')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Message -->
                        <div>
                            <label class="block text-sm font-semibold text-[#135757] mb-2">
                                Additional Notes (Optional)
                            </label>
                            <textarea name="message" rows="3"
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white"
                                    placeholder="Any special requests or notes...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-semibold text-[#135757] mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" required
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:outline-none focus:border-[#135757] transition duration-200 bg-white">
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4 pt-6">
                            <a href="{{ route('admin.bookings.index') }}" 
                            class="flex-1 px-6 py-4 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition duration-200 text-center">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="flex-1 px-6 py-4 bg-gradient-to-r from-[#135757] to-[#1a7272] text-white font-semibold rounded-lg hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                                Create Booking
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection