@extends('layouts.tenant-layout')

@section('content')
<div class="content-header">
    <h1>Welcome Back!</h1>
    <p>Here's an overview of your rental information</p>
</div>

@php
    $tenant = Auth::user();
    $bedspace = $tenant->bedspace;
    
    // Calculate unpaid due
    $unpaidDue = \App\Models\Bill::where('tenantID', $tenant->id)
        ->whereIn('status', ['pending', 'paid'])
        ->sum('amount');
    
    // Calculate days left before lease end
    $daysLeft = $tenant->leaseEnd ? 
        now()->diffInDays(\Carbon\Carbon::parse($tenant->leaseEnd), false) : 
        null;
    
    // Get open maintenance requests count
    $openRequests = \App\Models\MaintenanceRequest::where('tenantID', $tenant->id)
        ->whereIn('status', ['pending', 'scheduled'])
        ->count();
    
    // Get next bill for payment reminder
    $nextBill = \App\Models\Bill::where('tenantID', $tenant->id)
        ->where('status', 'pending')
        ->orderBy('dueDate', 'asc')
        ->first();
@endphp

<!-- Quick Stats -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 25px;">
    <div class="card" style="border-left: 4px solid #dc3545;">
        <p style="font-size: 12px; color: #666; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">UNPAID DUE</p>
        <p style="font-size: 32px; font-weight: bold; color: #dc3545;">₱{{ number_format($unpaidDue, 2) }}</p>
    </div>
    
    <div class="card" style="border-left: 4px solid {{ $daysLeft !== null ? ($daysLeft > 30 ? '#28a745' : ($daysLeft > 0 ? '#ffc107' : '#dc3545')) : '#6c757d' }};">
        <p style="font-size: 12px; color: #666; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">DAYS LEFT</p>
        @if($daysLeft !== null)
            @if($daysLeft > 0)
                <p style="font-size: 32px; font-weight: bold; color: #333;">{{ $daysLeft }} <span style="font-size: 16px; color: #999;">days</span></p>
            @else
                <p style="font-size: 24px; font-weight: bold; color: #dc3545;">Lease Expired</p>
            @endif
        @else
            <p style="font-size: 24px; font-weight: bold; color: #999;">Not Set</p>
        @endif
        <p style="font-size: 11px; color: #999; margin-top: 3px;">Before lease ends</p>
    </div>
    
    <div class="card" style="border-left: 4px solid #007bff;">
        <p style="font-size: 12px; color: #666; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">OPEN REQUESTS</p>
        <p style="font-size: 32px; font-weight: bold; color: #333;">{{ $openRequests }}</p>
        <p style="font-size: 11px; color: #999; margin-top: 3px;">Maintenance issues</p>
    </div>
</div>

<!-- Bedspace Details -->
@if($bedspace)
<div class="card">
    <h3 style="margin-bottom: 15px; font-size: 18px;">My Bedspace Details</h3>
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
        <div>
            <p style="font-size: 12px; color: #666; margin-bottom: 5px;">Unit Code</p>
            <p style="font-size: 16px; font-weight: 500;">{{ $bedspace->unitCode }}</p>
        </div>
        <div>
            <p style="font-size: 12px; color: #666; margin-bottom: 5px;">Monthly Rent</p>
            <p style="font-size: 16px; font-weight: 500; color: #007bff;">₱{{ number_format($bedspace->price, 2) }}</p>
        </div>
        <div>
            <p style="font-size: 12px; color: #666; margin-bottom: 5px;">Restriction</p>
            <p style="font-size: 16px; font-weight: 500;">{{ ucfirst($bedspace->restriction) }} only</p>
        </div>
        <div>
            <p style="font-size: 12px; color: #666; margin-bottom: 5px;">Status</p>
            <span style="background-color: #d4edda; color: #155724; padding: 4px 10px; border-radius: 4px; font-size: 13px; font-weight: 500;">
                {{ ucfirst($bedspace->status) }}
            </span>
        </div>
    </div>
    
    @if($tenant->leaseStart && $tenant->leaseEnd)
        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e0e0e0;">
            <p style="font-size: 12px; color: #666; margin-bottom: 5px;">Lease Period</p>
            <p style="font-size: 16px; font-weight: 500;">
                {{ date('M d, Y', strtotime($tenant->leaseStart)) }} - 
                {{ date('M d, Y', strtotime($tenant->leaseEnd)) }}
            </p>
        </div>
    @endif
</div>
@endif

<!-- Next Payment Due -->
@if($nextBill)
<div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <p style="font-size: 13px; opacity: 0.9; margin-bottom: 5px;">NEXT PAYMENT DUE</p>
            <p style="font-size: 28px; font-weight: bold; margin-bottom: 5px;">{{ date('M d, Y', strtotime($nextBill->dueDate)) }}</p>
            <p style="font-size: 20px; font-weight: 600;">₱{{ number_format($nextBill->amount, 2) }}</p>
        </div>
        <a href="{{ route('tenant.view-bills') }}" 
           style="padding: 12px 25px; background: white; color: #667eea; text-decoration: none; border-radius: 6px; font-weight: 500;">
            Pay Now
        </a>
    </div>
</div>
@endif

@endsection