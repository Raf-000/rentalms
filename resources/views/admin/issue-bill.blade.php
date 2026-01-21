<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Issue Bill to Tenant
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.store-bill') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Select Tenant</label>
                            <select name="tenantID" id="tenantID" required 
                                    class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Choose a tenant</option>
                                @foreach($tenants as $tenant)
                                    <option value="{{ $tenant->id }}" 
                                            data-price="{{ $tenant->bedspace ? $tenant->bedspace->price : 0 }}">
                                        {{ $tenant->name }} 
                                        @if($tenant->bedspace)
                                            ({{ $tenant->bedspace->unitCode }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('tenantID')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Amount</label>
                            <input type="number" name="amount" id="amount" step="0.01" required 
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                            @error('amount')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Due Date</label>
                            <input type="date" name="dueDate" required 
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                            @error('dueDate')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Issue Bill
                            </button>
                            <a href="{{ route('admin.dashboard') }}" 
                               class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                Back to Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-fill amount when tenant is selected
        document.getElementById('tenantID').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            if (price) {
                document.getElementById('amount').value = price;
            }
        });
    </script>
</x-app-layout>