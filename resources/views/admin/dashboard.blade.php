<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Welcome, Admin!</h3>
                <p class="text-gray-600">Manage your boarding house from here.</p>
            </div>

            <!-- Admin Menu Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Create Account Card -->
                <a href="{{ route('admin.create-account') }}" 
                   class="block bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border-l-4 border-blue-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <h4 class="font-semibold text-lg">Create Account</h4>
                    </div>
                    <p class="text-sm text-gray-600">Add new admin or tenant accounts</p>
                </a>

                <!-- View Tenants Card -->
                <a href="{{ route('admin.view-tenants') }}" 
                   class="block bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border-l-4 border-green-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h4 class="font-semibold text-lg">View Tenants</h4>
                    </div>
                    <p class="text-sm text-gray-600">See all tenants and their bedspaces</p>
                </a>

                <!-- Issue Bills Card -->
                <a href="{{ route('admin.issue-bill') }}" 
                   class="block bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border-l-4 border-yellow-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h4 class="font-semibold text-lg">Issue Bills</h4>
                    </div>
                    <p class="text-sm text-gray-600">Create and send bills to tenants</p>
                </a>

                <!-- View Payments Card -->
                <a href="{{ route('admin.view-payments') }}" 
                   class="block bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border-l-4 border-purple-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h4 class="font-semibold text-lg">Verify Payments</h4>
                    </div>
                    <p class="text-sm text-gray-600">Review and verify tenant payments</p>
                </a>

                <!-- View Maintenance Card -->
                <a href="{{ route('admin.view-maintenance') }}" 
                   class="block bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border-l-4 border-red-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <h4 class="font-semibold text-lg">Maintenance Requests</h4>
                    </div>
                    <p class="text-sm text-gray-600">Manage maintenance issues</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>