@extends('layouts.admin-layout')

@section('content')
<div class="content-header">
    <h1>Maintenance Requests</h1>
    <p>Manage and track all maintenance issues</p>
</div>

@if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #28a745;">
        {{ session('success') }}
    </div>
@endif

<div style="display: flex; gap: 20px;">
    
    <!-- Left Side - Stats Cards (20%) -->
    <div style="width: 20%; min-width: 200px;">
        @php
            $pendingCount = $requests->where('status', 'pending')->count();
            $scheduledCount = $requests->where('status', 'scheduled')->count();
            $completedCount = $requests->where('status', 'completed')->count();
        @endphp
        
        <!-- Pending Card -->
        <div style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 15px; border-left: 4px solid #ffc107; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                <div style="width: 40px; height: 40px; background-color: #fff3cd; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 24px; height: 24px; color: #ffc107;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p style="font-size: 28px; font-weight: bold; margin: 0; color: #333;">{{ $pendingCount }}</p>
                </div>
            </div>
            <p style="font-size: 13px; color: #666; margin: 0; font-weight: 500;">Pending</p>
        </div>

        <!-- Scheduled Card -->
        <div style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 15px; border-left: 4px solid #007bff; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                <div style="width: 40px; height: 40px; background-color: #cfe2ff; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 24px; height: 24px; color: #007bff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p style="font-size: 28px; font-weight: bold; margin: 0; color: #333;">{{ $scheduledCount }}</p>
                </div>
            </div>
            <p style="font-size: 13px; color: #666; margin: 0; font-weight: 500;">Scheduled</p>
        </div>

        <!-- Completed Card -->
        <div style="background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #28a745; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                <div style="width: 40px; height: 40px; background-color: #d4edda; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 24px; height: 24px; color: #28a745;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p style="font-size: 28px; font-weight: bold; margin: 0; color: #333;">{{ $completedCount }}</p>
                </div>
            </div>
            <p style="font-size: 13px; color: #666; margin: 0; font-weight: 500;">Completed</p>
        </div>
    </div>

    <!-- Right Side - Requests List (80%) -->
    <div style="flex: 1;">
        <div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); height: calc(100vh - 200px); display: flex; flex-direction: column;">
            <div style="padding: 20px; border-bottom: 1px solid #e0e0e0;">
                <h3 style="margin: 0; font-size: 18px; color: #333;">All Requests</h3>
            </div>
            
            <div style="flex: 1; overflow-y: auto; padding: 20px;">
                @if($requests->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        @foreach($requests as $req)
                        <div style="border: 1px solid #e0e0e0; border-radius: 8px; padding: 16px;
                            {{ $req->status === 'completed' ? 'background-color: #f0f9f4;' : 
                               ($req->status === 'scheduled' ? 'background-color: #f0f7ff;' : 'background-color: #fffbf0;') }}">
                            
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                                <div style="flex: 1;">
                                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                        <h4 style="margin: 0; font-size: 15px; font-weight: 600; color: #333;">{{ $req->tenant->name }}</h4>
                                        <span style="padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 500;
                                            {{ $req->status === 'completed' ? 'background-color: #d4edda; color: #155724;' : 
                                               ($req->status === 'scheduled' ? 'background-color: #cfe2ff; color: #084298;' : 'background-color: #fff3cd; color: #856404;') }}">
                                            {{ ucfirst($req->status) }}
                                        </span>
                                    </div>
                                    <p style="margin: 0 0 8px 0; color: #555; font-size: 14px; line-height: 1.5;">{{ $req->description }}</p>
                                    <p style="margin: 0; font-size: 12px; color: #999;">
                                        <svg style="width: 14px; height: 14px; display: inline-block; vertical-align: middle;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Reported: {{ date('M d, Y h:i A', strtotime($req->created_at)) }}
                                    </p>
                                </div>
                                
                                <div style="display: flex; gap: 8px; align-items: center; margin-left: 15px;">
                                    @if($req->photo)
                                        <button onclick="viewImage('{{ asset('storage/' . $req->photo) }}')" 
                                                style="padding: 6px 12px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; white-space: nowrap;">
                                            View Image
                                        </button>
                                    @endif
                                    
                                    <form method="POST" action="{{ route('admin.update-maintenance', $req->requestID) }}" style="display: flex; gap: 8px;">
                                        @csrf
                                        <select name="status" style="padding: 6px 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 12px;">
                                            <option value="pending" {{ $req->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="scheduled" {{ $req->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                        </select>
                                        <button type="submit" 
                                                style="padding: 6px 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; white-space: nowrap;">
                                            Update
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 60px 20px; color: #999;">
                        <svg style="width: 64px; height: 64px; margin: 0 auto 15px; opacity: 0.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p style="font-size: 16px; margin: 0;">No maintenance requests found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Image Viewer Modal -->
<div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.85); z-index: 1000; align-items: center; justify-content: center;">
    <div style="position: relative; max-width: 90%; max-height: 90%;">
        <button onclick="closeImageModal()" 
                style="position: absolute; top: -40px; right: 0; background: white; border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; font-size: 20px; color: #333;">
            ×
        </button>
        <img id="modalImage" src="" style="max-width: 100%; max-height: 90vh; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
    </div>
</div>

<script>
function viewImage(imageUrl) {
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('imageModal').style.display = 'flex';
}

function closeImageModal() {
    document.getElementById('imageModal').style.display = 'none';
}

// Close modal when clicking outside the image
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});
</script>

@endsection