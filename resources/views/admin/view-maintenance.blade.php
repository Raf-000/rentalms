<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Maintenance Requests
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

                    @if($requests->count() > 0)
                        <div class="space-y-4">
                            @foreach($requests as $req)
                            <div class="border rounded-lg p-4 
                                {{ $req->status === 'completed' ? 'bg-green-50' : 
                                   ($req->status === 'scheduled' ? 'bg-blue-50' : 'bg-gray-50') }}">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <h3 class="font-semibold text-lg">{{ $req->tenant->name }}</h3>
                                            <span class="px-2 py-1 text-xs rounded-full
                                                {{ $req->status === 'completed' ? 'bg-green-200 text-green-800' : 
                                                   ($req->status === 'scheduled' ? 'bg-blue-200 text-blue-800' : 'bg-yellow-200 text-yellow-800') }}">
                                                {{ ucfirst($req->status) }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-2">{{ $req->description }}</p>
                                        <p class="text-xs text-gray-500">
                                            Reported: {{ date('M d, Y h:i A', strtotime($req->created_at)) }}
                                        </p>
                                    </div>
                                    
                                    <div class="ml-4 flex gap-2">
                                        @if($req->photo)
                                            <a href="{{ asset('storage/' . $req->photo) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $req->photo) }}" 
                                                     alt="Issue photo" 
                                                     class="w-24 h-24 object-cover rounded border">
                                            </a>
                                        @endif
                                        
                                        <form method="POST" action="{{ route('admin.update-maintenance', $req->requestID) }}" class="flex flex-col gap-2">
                                            @csrf
                                            <select name="status" class="border-gray-300 rounded-md text-sm">
                                                <option value="pending" {{ $req->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="scheduled" {{ $req->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                                <option value="completed" {{ $req->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                            <button type="submit" 
                                                    class="px-3 py-1 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700">
                                                Update
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No maintenance requests found.</p>
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