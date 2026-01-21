<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Bills
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($bills->count() > 0)
                        <div class="space-y-4">
                            @foreach($bills as $bill)
                            <div class="border rounded-lg p-4 
                                {{ $bill->status === 'verified' ? 'bg-green-50 border-green-200' : 
                                   ($bill->status === 'paid' ? 'bg-blue-50 border-blue-200' : 'bg-yellow-50 border-yellow-200') }}">
                                
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <h3 class="font-semibold text-lg">₱{{ number_format($bill->amount, 2) }}</h3>
                                            <span class="px-2 py-1 text-xs rounded-full
                                                {{ $bill->status === 'verified' ? 'bg-green-200 text-green-800' : 
                                                   ($bill->status === 'paid' ? 'bg-blue-200 text-blue-800' : 'bg-yellow-200 text-yellow-800') }}">
                                                {{ ucfirst($bill->status) }}
                                            </span>
                                        </div>
                                        
                                        <div class="space-y-1">
                                            <p class="text-sm">
                                                <span class="text-gray-600">Due Date:</span> 
                                                <span class="font-medium">{{ date('M d, Y', strtotime($bill->dueDate)) }}</span>
                                            </p>
                                            <p class="text-sm">
                                                <span class="text-gray-600">Issued:</span> 
                                                <span>{{ date('M d, Y', strtotime($bill->created_at)) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        @if($bill->status === 'pending')
                                            <button onclick="openPaymentModal({{ $bill->billID }}, {{ $bill->amount }})" 
                                               class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700">
                                                Pay Now
                                            </button>
                                        @elseif($bill->status === 'paid')
                                            <span class="text-sm text-blue-600">Awaiting verification</span>
                                        @else
                                            <span class="text-sm text-green-600">✓ Verified</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No bills found.</p>
                        </div>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('tenant.dashboard') }}" 
                           class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold mb-4">Upload Payment</h3>
            
            <form id="paymentForm" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Amount to Pay</p>
                    <p id="paymentAmount" class="text-2xl font-bold text-blue-600"></p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Payment Method</label>
                    <select name="paymentMethod" id="paymentMethod" required 
                            class="w-full border-gray-300 rounded-md">
                        <option value="">Select method</option>
                        <option value="cash">Cash</option>
                        <option value="gcash">GCash</option>
                    </select>
                </div>

                <div class="mb-4" id="receiptSection" style="display: none;">
                    <label class="block text-sm font-medium mb-2">Upload Receipt (GCash Screenshot)</label>
                    <input type="file" name="receiptImage" accept="image/*" 
                           class="w-full border-gray-300 rounded-md">
                    <p class="text-xs text-gray-500 mt-1">Optional - upload GCash payment screenshot</p>
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Submit Payment
                    </button>
                    <button type="button" onclick="closePaymentModal()" 
                            class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openPaymentModal(billID, amount) {
            document.getElementById('paymentModal').classList.remove('hidden');
            document.getElementById('paymentAmount').textContent = '₱' + parseFloat(amount).toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('paymentForm').action = '/tenant/upload-payment/' + billID;
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        // Show/hide receipt upload based on payment method
        document.getElementById('paymentMethod').addEventListener('change', function() {
            const receiptSection = document.getElementById('receiptSection');
            if (this.value === 'gcash') {
                receiptSection.style.display = 'block';
            } else {
                receiptSection.style.display = 'none';
            }
        });
    </script>
</x-app-layout>