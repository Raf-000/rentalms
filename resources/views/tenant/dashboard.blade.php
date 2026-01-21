<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tenant Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Bedspace Information Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">My Bedspace Information</h3>
                    
                    @if($bedspace)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Unit Code</p>
                                <p class="font-medium text-lg">{{ $bedspace->unitCode }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Monthly Rent</p>
                                <p class="font-medium text-lg text-blue-600">₱{{ number_format($bedspace->price, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">House & Floor</p>
                                <p class="font-medium">House {{ $bedspace->houseNo }}, Floor {{ $bedspace->floor }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Room</p>
                                <p class="font-medium">Room {{ $bedspace->roomNo }}, Bed #{{ $bedspace->bedspaceNo }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Restriction</p>
                                <p class="font-medium">{{ ucfirst($bedspace->restriction) }} only</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Status</p>
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-sm">
                                    {{ ucfirst($bedspace->status) }}
                                </span>
                            </div>
                        </div>

                        @if($tenant->leaseStart && $tenant->leaseEnd)
                            <div class="mt-4 pt-4 border-t">
                                <p class="text-sm text-gray-600">Lease Period</p>
                                <p class="font-medium">
                                    {{ date('M d, Y', strtotime($tenant->leaseStart)) }} - 
                                    {{ date('M d, Y', strtotime($tenant->leaseEnd)) }}
                                </p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No bedspace assigned yet.</p>
                            <p class="text-sm text-gray-400 mt-2">Please contact the admin for bedspace assignment.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions Menu -->
            <div class="mb-4">
                <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- View Bills Card -->
                <a href="{{ route('tenant.view-bills') }}" 
                   class="block bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border-l-4 border-blue-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h4 class="font-semibold text-lg">My Bills</h4>
                    </div>
                    <p class="text-sm text-gray-600">View and pay your bills</p>
                </a>

                <!-- Maintenance Requests Card -->
                <a href="{{ route('tenant.view-maintenance') }}" 
                   class="block bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border-l-4 border-red-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <h4 class="font-semibold text-lg">Maintenance</h4>
                    </div>
                    <p class="text-sm text-gray-600">Report and track maintenance issues</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>