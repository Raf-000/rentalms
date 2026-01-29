@extends('layouts.admin-layout')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#f6f8f7]/80 to-[#E2E8E7]/80 py-8 px-4">
    <div class="max-w-3xl mx-auto">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-[#135757] mb-2">Edit Bill</h1>
            <p class="text-gray-600">Update bill details</p>
        </div>

        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border-l-4 border-teal-800">
            <div class="p-8">
                <form method="POST" action="{{ route('admin.bills.update', $bill->billID) }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">

                        <!-- Tenant (read-only) -->
                        <div>
                            <label class="block text-sm font-semibold text-[#333] mb-2">
                                Tenant
                            </label>
                            <input
                                type="text"
                                value="{{ $bill->tenant->name }}"
                                disabled
                                class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-lg text-gray-600 cursor-not-allowed"
                            >
                        </div>

                        <!-- Amount -->
                        <div>
                            <label class="block text-sm font-semibold mb-2">Amount</label>
                            <input type="number" name="amount" step="0.01"
                                value="{{ old('amount', $bill->amount) }}"
                                class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg">
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-semibold mb-2">Description</label>
                            <textarea name="description" rows="3"
                                class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg">{{ old('description', $bill->description) }}</textarea>
                        </div>

                        <!-- Due Date + Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <input type="date" name="dueDate"
                                value="{{ old('dueDate', $bill->dueDate->format('Y-m-d')) }}"
                                class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg">

                            <select name="status"
                                class="w-full px-4 py-3 border-2 border-[#E2E8E7] rounded-lg bg-white">
                                @foreach(['pending','paid','verified'] as $s)
                                    <option value="{{ $s }}" {{ $bill->status === $s ? 'selected' : '' }}>
                                        {{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-4 pt-4">
                            <a href="{{ route('admin.bills.index') }}"
                               class="flex-1 text-center py-4 rounded-lg bg-gray-200 text-gray-700 font-semibold">
                                Cancel
                            </a>
                            <button class="flex-1 py-4 rounded-lg bg-gradient-to-r from-[#135757] to-[#1a7272] text-white font-semibold">
                                Save Changes
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
