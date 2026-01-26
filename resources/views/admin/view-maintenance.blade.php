@extends('layouts.admin-layout')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/maintenance.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/maintenance-modal.js') }}" defer></script>
@endpush

@section('content')

@php
    $pendingCount   = $requests->where('status', 'pending')->count();
    $scheduledCount = $requests->where('status', 'scheduled')->count();
    $completedCount = $requests->where('status', 'completed')->count();
@endphp

<div class="content-header">
    <h1>Maintenance Requests</h1>
    <p>Manage and track all maintenance issues</p>
</div>

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="layout">

    {{-- LEFT COLUMN --}}
    <div class="left-column">
        <div class="stats">
            <div class="stat-card pending">
                <p class="stat-label">Pending Request</p>
                <p class="stat-number">{{ $pendingCount }}</p>
            </div>

            <div class="stat-card scheduled">
                <p class="stat-label">In Progress</p>
                <p class="stat-number">{{ $scheduledCount }}</p>
            </div>

            <div class="stat-card completed">
                <p class="stat-label">Completed (This Month)</p>
                <p class="stat-number">{{ $completedCount }}</p>
            </div>
        </div>
    </div>

    {{-- RIGHT COLUMN --}}
    <div class="completed-placeholder">
        <div class="completed-placeholder-header">
            Completed Maintenance
        </div>
    </div>

</div>

        {{-- ALL REQUESTS (UNDER COMPLETED) --}}
        <div class="requests">
            <div class="requests-header">
                <h3>All Requests</h3>
            </div>

            <div class="requests-body">
                @forelse($requests as $req)
                    <div class="request-card {{ $req->status }}">
                        <h4>{{ $req->tenant->name }}</h4>
                        <p class="description">{{ $req->description }}</p>

                        @if($req->photo)
                            <button
                                type="button"
                                class="btn view"
                                onclick="viewImage('{{ asset('storage/' . $req->photo) }}')">
                                View Image
                            </button>
                        @endif

                        <form
                            method="POST"
                            action="{{ route('admin.update-maintenance', $req->requestID) }}"
                            class="update-form">
                            @csrf

                            <select name="status">
                                <option value="pending" {{ $req->status === 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="scheduled" {{ $req->status === 'scheduled' ? 'selected' : '' }}>
                                    Scheduled
                                </option>
                                <option value="completed" {{ $req->status === 'completed' ? 'selected' : '' }}>
                                    Completed
                                </option>
                            </select>

                            <button type="submit" class="btn update">Update</button>
                        </form>
                    </div>
                @empty
                    <p class="empty">No maintenance requests found</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

{{-- IMAGE MODAL --}}
<div id="imageModal" class="image-modal">
    <div class="image-box">
        <button class="close-btn" onclick="closeImageModal()">×</button>
        <img id="modalImage" alt="Maintenance Image">
    </div>
</div>

@endsection