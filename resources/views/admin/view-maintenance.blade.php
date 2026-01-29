@extends('layouts.admin-layout')

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-[#f6f8f7]/80 to-[#E2E8E7]/80">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Header -->
        <div>
            <h1 class="text-4xl font-bold text-[#135757] mb-1">Maintenance Requests</h1>
            <p class="text-gray-600">Manage and track all maintenance issues</p>
        </div>

        <!-- Stats -->
        @php
            $pendingCount = $requests->where('status', 'pending')->count();
            $scheduledCount = $requests->where('status', 'scheduled')->count();
            $completedCount = $requests->where('status', 'completed')->count();
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-yellow-400">
                <p class="text-xs uppercase tracking-wide text-gray-500">Pending</p>
                <p class="mt-4 text-3xl font-bold text-yellow-500">{{ $pendingCount }}</p>
            </div>

            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-blue-500">
                <p class="text-xs uppercase tracking-wide text-gray-500">Scheduled</p>
                <p class="mt-4 text-3xl font-bold text-blue-600">{{ $scheduledCount }}</p>
            </div>

            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-6 shadow-lg border-l-4 border-green-500">
                <p class="text-xs uppercase tracking-wide text-gray-500">Completed</p>
                <p class="mt-4 text-3xl font-bold text-green-600">{{ $completedCount }}</p>
            </div>
        </div>

        <!-- Requests List -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">All Requests</h3>
            </div>

            <div class="max-h-[65vh] overflow-y-auto p-6 space-y-4">
                @forelse($requests as $req)
                <div id="request-card-{{ $req->requestID }}"
                     class="rounded-xl border p-5
                     {{ $req->status === 'completed' ? 'bg-green-50 border-green-200' :
                        ($req->status === 'scheduled' ? 'bg-blue-50 border-blue-200' : 'bg-yellow-50 border-yellow-200') }}">

                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-3 mb-2">
                                <h4 class="font-semibold text-gray-800">{{ $req->tenant->name }}</h4>
                                <span id="status-badge-{{ $req->requestID }}"
                                      class="px-3 py-1 rounded-full text-xs font-semibold
                                      {{ $req->status === 'completed' ? 'bg-green-100 text-green-700' :
                                         ($req->status === 'scheduled' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ ucfirst($req->status) }}
                                </span>
                            </div>

                            <p class="text-sm text-gray-700 mb-2">{{ $req->description }}</p>

                            <p class="text-xs text-gray-400">
                                Reported: {{ date('M d, Y h:i A', strtotime($req->created_at)) }}
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            @if($req->photo)
                            <button onclick="viewImage('{{ asset('storage/' . $req->photo) }}')"
                                    title="View Image"
                                    class="w-9 h-9 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5
                                             c4.478 0 8.268 2.943 9.542 7
                                             -1.274 4.057-5.064 7-9.542 7
                                             -4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                            @endif

                            @if($req->status !== 'completed')
                            <form method="POST" action="{{ route('admin.update-maintenance', $req->requestID) }}"
                                  class="flex items-center gap-2">
                                @csrf
                                <select name="status"
                                        class="px-3 py-2 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-[#135757]">
                                    <option value="pending" {{ $req->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="scheduled" {{ $req->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                </select>
                                <button type="submit"
                                        class="px-4 py-2 bg-[#135757] text-white text-sm font-semibold rounded-lg hover:opacity-90">
                                    Update
                                </button>
                            </form>
                            @else
                            <span class="text-xs italic text-gray-400">No actions</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="py-16 text-center text-gray-400">
                    No maintenance requests found
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4">
    <div class="relative max-w-4xl w-full">
        <button onclick="closeImageModal()"
                class="absolute -top-10 right-0 w-9 h-9 rounded-full bg-white text-gray-700 text-xl flex items-center justify-center">
            ×
        </button>
        <img id="modalImage" src="" class="max-h-[80vh] mx-auto rounded-xl shadow-2xl">
    </div>
</div>

<script>
function viewImage(url) {
    document.getElementById('modalImage').src = url;
    document.getElementById('imageModal').classList.remove('hidden');
}
function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}
document.getElementById('imageModal').addEventListener('click', e => {
    if (e.target.id === 'imageModal') closeImageModal();
});
</script>
@endsection
