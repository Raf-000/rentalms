<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Maintenance Requests
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

                    <div class="mb-4">
                        <a href="{{ route('tenant.create-maintenance') }}" 
                           class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            + New Request
                        </a>
                    </div>

                    @if($requests->count() > 0)
                        <div class="space-y-4">
                            @foreach($requests as $req)
                            <div class="border rounded-lg p-4 
                                {{ $req->status === 'completed' ? 'bg-green-50 border-green-200' : 
                                   ($req->status === 'scheduled' ? 'bg-blue-50 border-blue-200' : 'bg-yellow-50 border-yellow-200') }}">
                                
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-2 py-1 text-xs rounded-full
                                                {{ $req->status === 'completed' ? 'bg-green-200 text-green-800' : 
                                                   ($req->status === 'scheduled' ? 'bg-blue-200 text-blue-800' : 'bg-yellow-200 text-yellow-800') }}">
                                                {{ ucfirst($req->status) }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-sm mb-2">{{ $req->description }}</p>
                                        <p class="text-xs text-gray-500">
                                            Reported: {{ date('M d, Y h:i A', strtotime($req->created_at)) }}
                                        </p>
                                    </div>
                                    
                                    @if($req->photo)
                                        <a href="{{ asset('storage/' . $req->photo) }}" target="_blank" class="ml-4">
                                            <img src="{{ asset('storage/' . $req->photo) }}" 
                                                 alt="Issue photo" 
                                                 class="w-24 h-24 object-cover rounded border">
                                        </a>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No maintenance requests yet.</p>
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
</x-app-layout>