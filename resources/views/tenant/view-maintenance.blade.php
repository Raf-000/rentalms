@extends('layouts.tenant-layout')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/tenant-maintenance.css') }}">
@endsection

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

@if(session('error'))
    <div style="background-color: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
        {{ session('error') }}
    </div>
@endif

<!-- Report New Issue Card -->
<div class="card" style="margin-bottom: 30px; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #007bff;">
    <h3 style="margin-bottom: 20px; font-size: 18px; color: #333;">Report New Issue</h3>
    
    <form method="POST" action="{{ route('tenant.store-maintenance') }}" enctype="multipart/form-data">
        @csrf

        <!-- ADD THIS DEBUG BLOCK -->
        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
                <strong>Errors:</strong>
                <ul style="margin: 10px 0 0 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- END DEBUG BLOCK -->
         
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px; color: #333;">Describe the Issue</label>
            <textarea name="description" rows="4" required 
                      placeholder="E.g., Bathroom sink is clogged, WiFi not working, light bulb broken..."
                      style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-family: Arial, sans-serif; font-size: 14px;"></textarea>
            @error('description')
                <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 14px; color: #333;">Upload Photo (Optional)</label>
            <input type="file" name="photo" accept="image/*" 
                   style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
            <p style="font-size: 12px; color: #666; margin: 5px 0 0 0;">Upload a photo of the issue if applicable</p>
            @error('photo')
                <p style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" 
                style="padding: 12px 30px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 15px; font-weight: 500; transition: all 0.3s;">
            Submit Report
        </button>
    </form>
</div>

<!-- My Maintenance Requests -->
<div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 25px;">
    <h3 style="margin-bottom: 20px; font-size: 18px; color: #333;">My Maintenance Requests</h3>
    
    @php
        $requests = \App\Models\MaintenanceRequest::where('tenantID', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    @endphp

    @if($requests->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 15px;">
            @foreach($requests as $req)
            <div id="request-card-{{ $req->requestID }}" style="border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; transition: all 0.3s;
                {{ $req->status === 'completed' ? 'background-color: #f0f9f4; border-left: 4px solid #28a745;' : 
                   ($req->status === 'scheduled' ? 'background-color: #f0f7ff; border-left: 4px solid #007bff;' : 'background-color: #fffbf0; border-left: 4px solid #ffc107;') }}">
                
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                            <span id="status-badge-{{ $req->requestID }}" class="status-badge status-{{ $req->status }}">
                                {{ ucfirst($req->status) }}
                            </span>
                            <p style="font-size: 12px; color: #999; margin: 0;">
                                {{ $req->created_at->format('M d, Y h:i A') }}
                            </p>
                        </div>
                        
                        <p style="margin: 0 0 15px 0; color: #333; font-size: 15px; line-height: 1.6; font-weight: 500;">{{ $req->description }}</p>
                        
                        <div id="status-message-{{ $req->requestID }}">
                            @if($req->status === 'pending')
                                <p style="font-size: 13px; color: #856404; background-color: #fff3cd; padding: 10px 15px; border-radius: 6px; margin: 0; display: inline-flex; align-items: center; gap: 8px;">
                                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Waiting for admin to schedule maintenance
                                </p>
                            @elseif($req->status === 'scheduled')
                                <p style="font-size: 13px; color: #084298; background-color: #cfe2ff; padding: 10px 15px; border-radius: 6px; margin: 0; display: inline-flex; align-items: center; gap: 8px;">
                                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Maintenance has been scheduled. Mark as completed once fixed.
                                </p>
                            @else
                                <p style="font-size: 13px; color: #155724; background-color: #d4edda; padding: 10px 15px; border-radius: 6px; margin: 0; display: inline-flex; align-items: center; gap: 8px;">
                                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Issue resolved and completed
                                </p>
                            @endif
                        </div>
                    </div>
                    
                    <div id="action-buttons-{{ $req->requestID }}" style="display: flex; gap: 10px; align-items: start; margin-left: 20px;">
                        @if($req->photo)
                            <button onclick="viewIssuePhoto('{{ asset('storage/' . $req->photo) }}')" 
                                    style="padding: 10px 18px; background-color: #6c757d; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; white-space: nowrap; transition: all 0.3s;">
                                View Photo
                            </button>
                        @endif
                        
                        @if($req->status === 'scheduled')
                            <button onclick="showConfirmModal({{ $req->requestID }})" class="btn-complete">
                                Mark as Completed
                            </button>
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
            <p style="font-size: 16px; margin: 0; font-weight: 500;">No maintenance requests yet</p>
            <p style="font-size: 14px; margin: 10px 0 0 0; color: #666;">Report an issue using the form above</p>
        </div>
    @endif
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="confirm-modal">
    <div class="confirm-modal-content">
        <div class="confirm-modal-header">
            <div class="confirm-modal-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="confirm-modal-title">Confirm Completion</h3>
        </div>
        
        <div class="confirm-modal-body">
            <p class="confirm-modal-text">Are you sure the maintenance issue has been completely fixed? This action will mark the request as completed.</p>
        </div>
        
        <div class="confirm-modal-actions">
            <button onclick="closeConfirmModal()" class="btn-cancel">Cancel</button>
            <button id="confirmCompleteBtn" onclick="completeMaintenanceAjax()" class="btn-confirm">
                <span class="btn-text">Yes, Mark as Completed</span>
                <span class="btn-loading" style="display: none;">
                    <span class="loading-spinner"></span> Processing...
                </span>
            </button>
        </div>
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

document.getElementById('photoModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closePhotoModal();
    }
});
</script>
@endsection

@section('scripts')
<script src="{{ asset('js/tenant-maintenance.js') }}"></script>
@endsection