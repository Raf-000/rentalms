@extends('layouts.admin-layout')

<style>
.btn-icon {
    width: 36px;
    height: 36px;
    border-radius: 0.75rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}
</style>

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-[#f6f8f7]/80 to-[#E2E8E7]/80">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="mb-8 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div>
                <h1 class="text-4xl font-bold text-[#135757] mb-2">Bills Management</h1>
                <p class="text-gray-600 text-lg">View, create, and manage all bills</p>
            </div>

            <a href="{{ route('admin.bills.create') }}"
               class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-[#135757] to-[#1a7272] text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                + Issue New Bill
            </a>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-xl shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-lg mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5 items-end">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tenant</label>
                    <select name="tenant_id" class="w-full px-4 py-2.5 border-2 border-[#E2E8E7] rounded-lg focus:border-[#135757] focus:outline-none">
                        <option value="">All Tenants</option>
                        @foreach($tenants as $tenant)
                            <option value="{{ $tenant->id }}" {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                {{ $tenant->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 border-2 border-[#E2E8E7] rounded-lg focus:border-[#135757] focus:outline-none">
                        <option value="">All Statuses</option>
                        @foreach(['pending','paid','verified','rejected','void'] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">From</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="w-full px-4 py-2.5 border-2 border-[#E2E8E7] rounded-lg focus:border-[#135757] focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">To</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="w-full px-4 py-2.5 border-2 border-[#E2E8E7] rounded-lg focus:border-[#135757] focus:outline-none">
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="flex-1 px-5 py-2.5 bg-[#135757] text-white font-semibold rounded-lg hover:opacity-90 transition">
                        Filter
                    </button>
                    <a href="{{ route('admin.bills.index') }}"
                       class="flex-1 px-5 py-2.5 bg-gray-200 text-gray-700 font-semibold rounded-lg text-center hover:bg-gray-300 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Bills Table -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-[#135757]">
                    <tr class="text-left text-xs uppercase tracking-wider text-white">
                        <th class="px-6 py-4 bill-id">Bill ID</th>
                        <th class="px-6 py-4 bill-tenant">Tenant</th>
                        <th class="px-6 py-4 bill-amount">Amount</th>
                        <th class="px-6 py-4 bill-desc">Description</th>
                        <th class="px-6 py-4 bill-date">Due Date</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($bills as $bill)
                    <tr class="border-t hover:bg-[#135757]/5 transition">
                        <td class="px-6 py-4 bill-id">#{{ $bill->billID }}</td>
                        <td class="px-6 py-4 bill-tenant font-semibold text-[#135757]">{{ $bill->tenant->name }}</td>
                        <td class="px-6 py-4 bill-amount font-bold">₱{{ number_format($bill->amount, 2) }}</td>
                        <td class="px-6 py-4 bill-desc text-sm text-gray-600">{{ $bill->description ?? 'Monthly Rent' }}</td>
                        <td class="px-6 py-4 bill-date">{{ \Carbon\Carbon::parse($bill->dueDate)->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase
                                @class([
                                    'bg-green-100 text-green-700' => $bill->status === 'verified',
                                    'bg-blue-100 text-blue-700' => $bill->status === 'paid',
                                    'bg-yellow-100 text-yellow-700' => $bill->status === 'pending',
                                    'bg-red-100 text-red-700' => $bill->status === 'rejected',
                                    'bg-gray-200 text-gray-600' => $bill->status === 'void',
                                ])">
                                {{ $bill->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center bill-actions">
                            <div class="flex justify-center gap-2">
                                <!-- Edit -->
                                <a href="{{ route('admin.bills.edit', $bill->billID) }}"
                                title="Edit Bill"
                                class="btn-icon bg-blue-100 hover:bg-blue-200 text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5h2m-1-1v2m8.485 2.929l-9.9 9.9a2 2 0 01-1.414.586H6v-3.172a2 2 0 01.586-1.414l9.9-9.9a2 2 0 012.828 2.828z"/>
                                    </svg>
                                </a>

                                <!-- Delete -->
                                <button onclick="confirmDelete({{ $bill->billID }}, '{{ $bill->tenant->name }}')"
                                        title="Delete Bill"
                                        class="btn-icon bg-red-100 hover:bg-red-200 text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7m2-3h6a1 1 0 011 1v1H8V5a1 1 0 011-1z"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-400">
                            No bills found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full">
        <div class="text-center mb-6">
            <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-red-600 text-2xl">🗑️</span>
            </div>
            <h3 class="text-xl font-bold mb-2">Delete Bill</h3>
            <p class="text-gray-600 text-sm">
                Are you sure you want to permanently delete this bill for <strong id="deleteTenantName"></strong>?
            </p>
            <p class="text-red-600 text-xs mt-2 font-semibold">⚠️ This action cannot be undone!</p>
        </div>

        <form id="deleteForm" method="POST" class="flex gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteModal()"
                    class="flex-1 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg">
                Cancel
            </button>
            <button type="submit"
                    class="flex-1 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700">
                Delete Bill
            </button>
        </form>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    document.getElementById('deleteTenantName').textContent = name;
    document.getElementById('deleteForm').action = `/admin/bills/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection
