<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Tenants
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if($tenants->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bedspace</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Monthly Rent</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lease Period</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($tenants as $tenant)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tenant->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tenant->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tenant->phone ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($tenant->bedspace)
                                                <span class="text-blue-600">{{ $tenant->bedspace->unitCode }}</span>
                                            @else
                                                <span class="text-gray-400">Not assigned</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($tenant->bedspace)
                                                ₱{{ number_format($tenant->bedspace->price, 2) }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($tenant->leaseStart && $tenant->leaseEnd)
                                                {{ date('M d, Y', strtotime($tenant->leaseStart)) }} - {{ date('M d, Y', strtotime($tenant->leaseEnd)) }}
                                            @else
                                                <span class="text-gray-400">Not set</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No tenants found.</p>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>