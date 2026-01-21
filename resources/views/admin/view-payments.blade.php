<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pending Payment Verifications
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

                    @if($payments->count() > 0)
                        <div class="space-y-4">
                            @foreach($payments as $payment)
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-lg">{{ $payment->tenant->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $payment->tenant->email }}</p>
                                        <div class="mt-2 space-y-1">
                                            <p class="text-sm"><span class="font-medium">Amount:</span> ₱{{ number_format($payment->bill->amount, 2) }}</p>
                                            <p class="text-sm"><span class="font-medium">Due Date:</span> {{ date('M d, Y', strtotime($payment->bill->dueDate)) }}</p>
                                            <p class="text-sm"><span class="font-medium">Payment Method:</span> {{ ucfirst($payment->paymentMethod) }}</p>
                                            <p class="text-sm"><span class="font-medium">Paid At:</span> {{ date('M d, Y h:i A', strtotime($payment->paidAt)) }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="ml-4">
                                        @if($payment->receiptImage)
                                            <a href="{{ asset('storage/' . $payment->receiptImage) }}" target="_blank" 
                                               class="block mb-2">
                                                <img src="{{ asset('storage/' . $payment->receiptImage) }}" 
                                                     alt="Receipt" 
                                                     class="w-32 h-32 object-cover rounded border">
                                            </a>
                                        @else
                                            <div class="w-32 h-32 bg-gray-200 rounded flex items-center justify-center">
                                                <p class="text-xs text-gray-500">Cash Payment</p>
                                            </div>
                                        @endif
                                        
                                        <form method="POST" action="{{ route('admin.verify-payment', $payment->paymentID) }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
                                                Verify Payment
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No pending payments to verify.</p>
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