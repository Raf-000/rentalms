@extends('layouts.admin-layout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#f6f8f7]/80 to-[#E2E8E7]/80 py-8 px-4">
    <div class="max-w-3xl mx-auto">

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-[#135757] mb-2">Issue New Bill</h1>
            <p class="text-gray-600">Create a bill for a tenant</p>
        </div>

        <!-- Card -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border-l-4 border-teal-800">
            <div class="p-8">
                <form method="POST" action="{{ route('admin.bills.store') }}">
                    @csrf

                    <div class="space-y-6">

                        <!-- Tenant -->
                        <div>
                            <label class="block text-sm font-semibold text-[#333] mb-2">
                                Tenant <span class="text-red-500">*</span>
                            </label>
                            <select name="tenantID" required
                                class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:border-[#135757] transition">
                                <option value="">Select tenant</option>
                                @foreach($tenants as $tenant)
                                    <option value="{{ $tenant->id }}" {{ old('tenantID') == $tenant->id ? 'selected' : '' }}>
                                        {{ $tenant->name }} – {{ $tenant->bedspace?->unitCode ?? 'No bedspace' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tenantID') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label class="block text-sm font-semibold text-[#333] mb-2">
                                Amount <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="amount" step="0.01" min="0"
                                value="{{ old('amount') }}" required
                                class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:border-[#135757] transition"
                                placeholder="0.00">
                            @error('amount') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-semibold text-[#333] mb-2">
                                Description
                            </label>
                            <textarea name="description" rows="3"
                                class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:border-[#135757] transition"
                                placeholder="Leave blank for Monthly Rent">{{ old('description') }}</textarea>
                        </div>

                        <!-- Due Date + Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-[#333] mb-2">
                                    Due Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="dueDate"
                                    value="{{ old('dueDate', now()->format('Y-m-d')) }}" required
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:border-[#135757] transition">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#333] mb-2">
                                    Status
                                </label>
                                <select name="status"
                                    class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg focus:border-[#135757] transition bg-white">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="verified">Verified</option>
                                </select>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-4 pt-4">
                            <a href="{{ route('admin.bills.index') }}"
                               class="flex-1 text-center py-4 rounded-lg bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="flex-1 py-4 rounded-lg bg-gradient-to-r from-[#135757] to-[#1a7272] text-white font-semibold hover:shadow-lg transition">
                                Issue Bill
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
