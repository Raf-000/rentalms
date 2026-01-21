@extends('layouts.tenant-layout')

@section('content')
<div class="content-header">
    <h1>Maintenance Report</h1>
    <p>Report and track maintenance issues</p>
</div>

@if(session('success'))
    <div style="background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #28a745;">
        {{ session('success') }}
    </div>
@endif

<!-- Report New Issue Card -->
<div class="card" style="margin-bottom: 30px; border-left: 4px solid #007bff;">
    <h3 style="margin-bottom: 20px; font-size: 18px; color: #333;">Report New Issue</h3>
    
    <form method="POST" action="{{ route('tenant.store-maintenance') }}" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Describe the Issue</label>
            <textarea name="description" rows="4" required 
                      placeholder="E.g., Bathroom sink is clogged, WiFi not working, light bulb broken..."
                      style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-family: Arial, sans-serif;"></textarea>
            @error('description')
                <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px;">Upload Photo (Optional)</label>
            <input type="file" name="photo" accept="image/*" 
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            <p style="font-size: 12px; color: #666; margin: 5px 0 0 0;">Upload a photo of the issue if applicable</p>
            @error('photo')
                <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" 
                style="padding: 12px 30px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 15px; font-weight: 500;">
            Submit Report
        </button>
    </form>
</div>

<!-- My Maintenance Requests -->
<div style="margin-top: 30px;">
    <h3 style="margin-bottom: 15px; font-size: 18px; color: #333;">My Maintenance Requests</h3>
    
    @php
        $requests = \App\Models\MaintenanceRequest::where('tenantID', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    @endphp

    <div style="background: white; border-radius: 8px; border: 1px solid #e0e0e0; height: 350px; overflow-y: auto; padding: 15px;">
        @if($requests->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 15px;">
                @foreach($requests as $req)
                <div style="border: 1px solid #e0e0e0; border-radius: 8px; padding: 16px;
                    {{ $req->status === 'completed' ? 'background-color: #f0f9f4;' : 
                       ($req->status === 'scheduled' ? 'background-color: #f0f7ff;' : 'background-color: #fffbf0;') }}">
                    
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                <span style="padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 500;
                                    {{ $req->status === 'completed' ? 'background-color: #d4edda; color: #155724;' : 
                                       ($req->status === 'scheduled' ? 'background-color: #cfe2ff; color: #084298;' : 'background-color: #fff3cd; color: #856404;') }}">
                                    {{ ucfirst($req->status) }}
                                </span>
                                <p style="font-size: 12px; color: #999; margin: 0;">
                                    {{ date('M d, Y h:i A', strtotime($req->created_at)) }}
                                </p>
                            </div>
                            
                            <p style="margin: 0 0 10px 0; color: #333; font-size: 14px; line-height: 1.6;">{{ $req->description }}</p>
                            
                            @if($req->status === 'pending')
                                <p style="font-size: 13px; color: #856404; background-color: #fff3cd; padding: 8px 12px; border-radius: 4px; margin: 0;">
                                    ⏳ Waiting for admin to schedule maintenance
                                </p>
                            @elseif($req->status === 'scheduled')
                                <p style="font-size: 13px; color: #084298; background-color: #cfe2ff; padding: 8px 12px; border-radius: 4px; margin: 0;">
                                    📅 Maintenance has been scheduled. Mark as completed once fixed.
                                </p>
                            @else
                                <p style="font-size: 13px; color: #155724; background-color: #d4edda; padding: 8px 12px; border-radius: 4px; margin: 0;">
                                    ✓ Issue resolved and completed
                                </p>
                            @endif
                        </div>
                        
                        <div style="display: flex; gap: 8px; align-items: start; margin-left: 15px;">
                            @if($req->photo)
                                <button onclick="viewIssuePhoto('{{ asset('storage/' . $req->photo) }}')" 
                                        style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; white-space: nowrap;">
                                    View Photo
                                </button>
                            @endif
                            
                            @if($req->status === 'scheduled')
                                <form method="POST" action="{{ route('tenant.complete-maintenance', $req->requestID) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure the issue has been fixed?')"
                                            style="padding: 8px 15px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 13px; white-space: nowrap;">
                                        Mark as Completed
                                    </button>
                                </form>
                            @endif
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
                <p style="font-size: 16px; margin: 0;">No maintenance requests yet</p>
            </div>
        @endif
    </div>
</div>

<!-- Photo Viewer Modal -->
<div id="photoModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.85); z-index: 1000; align-items: center; justify-content: center;">
    <div style="position: relative; max-width: 90%; max-height: 90%;">
        <button onclick="closePhotoModal()" 
                style="position: absolute; top: -40px; right: 0; background: white; border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; font-size: 20px; color: #333;">
            ×
        </button>
        <img id="modalPhoto" src="" style="max-width: 100%; max-height: 90vh; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
    </div>
</div>

<script>
function viewIssuePhoto(photoUrl) {
    document.getElementById('modalPhoto').src = photoUrl;
    document.getElementById('photoModal').style.display = 'flex';
}

function closePhotoModal() {
    document.getElementById('photoModal').style.display = 'none';
}

// Close modal when clicking outside the image
document.getElementById('photoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePhotoModal();
    }
});
</script>

@endsection