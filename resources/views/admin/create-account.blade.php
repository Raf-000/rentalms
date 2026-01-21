<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create New Account
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('admin.store-account') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Name</label>
                            <input type="text" name="name" required 
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Email</label>
                            <input type="email" name="email" required 
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Password</label>
                            <input type="password" name="password" required 
                                   class="w-full border-gray-300 rounded-md shadow-sm">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Account Type</label>
                            <select name="role" id="role" required 
                                    class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="tenant">Tenant</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4" id="bedspace-section" style="display: none;">
                            <label class="block text-sm font-medium mb-2">Assign Bedspace (Optional)</label>
                            <select name="bedspace_id" id="bedspace_id" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">No bedspace assigned</option>
                                @foreach($bedspaces as $bedspace)
                                    <option value="{{ $bedspace->unitID }}">
                                        {{ $bedspace->unitCode }} - ₱{{ number_format($bedspace->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="lease-section" style="display: none;">
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Lease Start Date</label>
                                <input type="date" name="leaseStart" 
                                       class="w-full border-gray-300 rounded-md shadow-sm">
                                @error('leaseStart')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Lease End Date</label>
                                <input type="date" name="leaseEnd" 
                                       class="w-full border-gray-300 rounded-md shadow-sm">
                                @error('leaseEnd')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                Create Account
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

    <!-- Success Popup Modal -->
    @if(session('success') && session('user'))
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4 shadow-xl">
            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Account Created Successfully!</h3>
                <p class="text-sm text-gray-600">Here are the login credentials:</p>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-200">
                <div class="mb-3">
                    <p class="text-xs text-gray-500 mb-1">Name</p>
                    <p class="font-medium text-gray-900">{{ session('user')['name'] }}</p>
                </div>
                <div class="mb-3">
                    <p class="text-xs text-gray-500 mb-1">Email (Username)</p>
                    <p class="font-medium text-gray-900">{{ session('user')['email'] }}</p>
                </div>
                <div class="mb-3">
                    <p class="text-xs text-gray-500 mb-1">Password</p>
                    <p class="font-medium text-gray-900">{{ session('user')['password'] }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Role</p>
                    <p class="font-medium text-gray-900">{{ session('user')['role'] }}</p>
                </div>
            </div>

            <p class="text-xs text-gray-500 text-center mb-4">
                Screenshot this information and send to the user
            </p>

            <button onclick="closeModal()" 
                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Close
            </button>
        </div>
    </div>
    @endif

    <script>
        // Show bedspace and lease sections only when Tenant is selected
        document.getElementById('role').addEventListener('change', function() {
            const bedspaceSection = document.getElementById('bedspace-section');
            if (this.value === 'tenant') {
                bedspaceSection.style.display = 'block';
            } else {
                bedspaceSection.style.display = 'none';
                document.getElementById('lease-section').style.display = 'none';
            }
        });

        // Show lease dates when a bedspace is selected
        document.getElementById('bedspace_id').addEventListener('change', function() {
            const leaseSection = document.getElementById('lease-section');
            if (this.value) {
                leaseSection.style.display = 'block';
            } else {
                leaseSection.style.display = 'none';
            }
        });

        function closeModal() {
            document.getElementById('successModal').style.display = 'none';
        }
    </script>
</x-app-layout>