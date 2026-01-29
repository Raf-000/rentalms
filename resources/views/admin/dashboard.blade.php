@extends('layouts.admin-layout')

@section('extra-css')
<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    border-left: 4px solid;
    transition: transform 0.2s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.stat-card.primary { border-left-color: #007bff; }
.stat-card.success { border-left-color: #28a745; }
.stat-card.warning { border-left-color: #ffc107; }
.stat-card.danger { border-left-color: #dc3545; }
.stat-card.info { border-left-color: #17a2b8; }
.stat-card.secondary { border-left-color: #6c757d; }

.stat-header {
    display: flex;
    align-items: center;
    gap: 12px;
}

.stat-icon {
    width: 45px;
    height: 45px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-icon.primary { background-color: #e3f2fd; color: #007bff; }
.stat-icon.success { background-color: #d4edda; color: #28a745; }
.stat-icon.warning { background-color: #fff3cd; color: #ffc107; }
.stat-icon.danger { background-color: #f8d7da; color: #dc3545; }
.stat-icon.info { background-color: #d1ecf1; color: #17a2b8; }
.stat-icon.secondary { background-color: #e2e3e5; color: #6c757d; }

.stat-icon svg {
    width: 24px;
    height: 24px;
}

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 28px;
    font-weight: bold;
    margin: 0;
    line-height: 1;
}

.stat-label {
    font-size: 12px;
    color: #666;
    margin: 5px 0 0 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.chart-card {
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.chart-card h3 {
    margin: 0 0 20px 0;
    font-size: 16px;
    color: #333;
    font-weight: 600;
}

.activity-card {
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    max-height: 600px;
    overflow-y: auto;
}

.activity-card h3 {
    margin: 0 0 20px 0;
    font-size: 16px;
    color: #333;
    font-weight: 600;
}

.activity-card h4 {
    font-size: 13px;
    color: #666;
    margin: 15px 0 10px 0;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.activity-item {
    padding: 12px;
    border-bottom: 1px solid #f0f0f0;
    transition: background-color 0.2s;
}

.activity-item:hover {
    background-color: #f8f9fa;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-item strong {
    font-size: 14px;
    color: #333;
}

.activity-item p {
    font-size: 13px;
    margin: 5px 0 0 0;
}

.activity-meta {
    font-size: 11px;
    color: #999;
    margin-top: 5px;
}

.quick-actions {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    margin-top: 15px;
    width: 100%;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    background: white;
    border: 2px solid #e0e0e0;
    border-radius: 6px;
    text-decoration: none;
    color: #333;
    transition: all 0.2s;
    font-size: 14px;
}

.action-btn:hover {
    border-color: #007bff;
    background-color: #f8f9fa;
    transform: translateY(-2px);
}

.action-btn svg {
    width: 20px;
    height: 20px;
    color: #007bff;
    flex-shrink: 0;
}

.empty-state {
    text-align: center;
    padding: 30px 20px;
    color: #999;
}

.empty-state svg {
    width: 40px;
    height: 40px;
    margin-bottom: 10px;
    opacity: 0.3;
}

.empty-state p {
    font-size: 13px;
    margin: 5px 0 0 0;
}

.status-badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

@media (max-width: 1024px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
    
    .quick-actions {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="content-header">
    <h1>Dashboard</h1>
    <p>Overview of your boarding house management</p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <!-- Total Tenants -->
    <div class="stat-card primary">
        <div class="stat-header">
            <div class="stat-icon primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-value">{{ $totalTenants }}</p>
                <p class="stat-label">Total Tenants</p>
            </div>
        </div>
    </div>

    <!-- Occupied Bedspaces -->
    <div class="stat-card success">
        <div class="stat-header">
            <div class="stat-icon success">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-value">{{ $occupiedBedspaces }}/{{ $totalBedspaces }}</p>
                <p class="stat-label">Occupied Beds</p>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue -->
    <div class="stat-card success">
        <div class="stat-header">
            <div class="stat-icon success">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-value">₱{{ number_format($verifiedPaymentsThisMonth, 0) }}</p>
                <p class="stat-label">Revenue ({{ $currentMonth }})</p>
            </div>
        </div>
    </div>

    <!-- Pending Payments -->
    <div class="stat-card info">
        <div class="stat-header">
            <div class="stat-icon info">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-value">₱{{ number_format($pendingPayments, 0) }}</p>
                <p class="stat-label">Pending Verification</p>
            </div>
        </div>
    </div>

    <!-- Outstanding Bills -->
    <div class="stat-card warning">
        <div class="stat-header">
            <div class="stat-icon warning">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-value">₱{{ number_format($outstandingBills, 0) }}</p>
                <p class="stat-label">Outstanding Bills</p>
            </div>
        </div>
    </div>

    <!-- Pending Maintenance -->
    <div class="stat-card danger">
        <div class="stat-header">
            <div class="stat-icon danger">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <p class="stat-value">{{ $pendingMaintenance }}</p>
                <p class="stat-label">Pending Maintenance</p>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Chart & Quick Actions -->
<div class="dashboard-grid">
    <div class="chart-card">
        <h3>Tenant Payment Status</h3>
        

        <div style="position: relative; height: 200px; width: 100%;">
            <canvas id="paymentStatusChart"></canvas>
        </div>
        
        <div style="margin-top: 20px; display: flex; gap: 20px; justify-content: center;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <div style="width: 12px; height: 12px; background-color: #007bff; border-radius: 3px;"></div>
                <span style="font-size: 13px; color: #666;">Total Tenants</span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <div style="width: 12px; height: 12px; background-color: #28a745; border-radius: 3px;"></div>
                <span style="font-size: 13px; color: #666;">Fully Paid</span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <div style="width: 12px; height: 12px; background-color: #ffc107; border-radius: 3px;"></div>
                <span style="font-size: 13px; color: #666;">With Pending Bills</span>
            </div>
    </div>
    </div>
    
    <div class="chart-card">
        <h3>Quick Actions</h3>
        <div class="quick-actions">
            <a href="{{ route('admin.create-account') }}" class="action-btn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <span>Add Tenant</span>
            </a>
            
            <a href="{{ route('admin.issue-bill') }}" class="action-btn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>Issue Bill</span>
            </a>
            
            <a href="{{ route('admin.view-payments') }}" class="action-btn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <span>View Payments</span>
            </a>
            
            <a href="{{ route('admin.view-maintenance') }}" class="action-btn">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span>Maintenance</span>
            </a>
        </div>
    </div>
</div>

<!-- Recent Activity Section -->
<div class="dashboard-grid">
    <!-- Recent Payments -->
    <div class="activity-card">
        <h3>Recent Verified Payments</h3>
        @if($recentPayments->count() > 0)
            @foreach($recentPayments as $payment)
            <div class="activity-item">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <strong>{{ $payment->tenant->name }}</strong>
                        <p class="activity-meta">₱{{ number_format($payment->bill->amount, 2) }} • {{ $payment->verifiedAt->diffForHumans() }}</p>
                    </div>
                    <span style="padding: 4px 10px; background-color: #d4edda; color: #155724; border-radius: 12px; font-size: 11px; font-weight: 600;">VERIFIED</span>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p>No recent payments</p>
            </div>
        @endif
    </div>

    <!-- Pending Maintenance & Bookings -->
    <div class="activity-card">
        <h3>Pending Items</h3>
        
        <h4 style="font-size: 14px; color: #666; margin: 15px 0 10px 0;">Maintenance Requests</h4>
        @if($recentMaintenance->count() > 0)
            @foreach($recentMaintenance as $request)
            <div class="activity-item">
                <strong>{{ $request->tenant->name }}</strong>
                <p style="font-size: 13px; color: #555; margin: 5px 0;">{{ Str::limit($request->description, 50) }}</p>
                <p class="activity-meta">{{ $request->created_at->diffForHumans() }}</p>
            </div>
            @endforeach
        @else
            <p style="font-size: 13px; color: #999; font-style: italic;">No pending maintenance</p>
        @endif
        
        <h4 style="font-size: 14px; color: #666; margin: 20px 0 10px 0;">Viewing Bookings</h4>
        @if($pendingBookings->count() > 0)
            @foreach($pendingBookings as $booking)
            <div class="activity-item">
                <strong>{{ $booking->name }}</strong>
                <p style="font-size: 13px; color: #555; margin: 5px 0;">{{ $booking->email }} • {{ $booking->phone }}</p>
                <p class="activity-meta">{{ $booking->created_at->diffForHumans() }}</p>
            </div>
            @endforeach
        @else
            <p style="font-size: 13px; color: #999; font-style: italic;">No pending bookings</p>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Loaded');
    
    const ctx = document.getElementById('paymentStatusChart');
    console.log('Canvas element:', ctx);
    console.log('Chart available:', typeof Chart);
    
    if (!ctx) {
        console.error('Canvas not found!');
        return;
    }
    
    if (typeof Chart === 'undefined') {
        console.error('Chart.js not loaded!');
        return;
    }
    
    const paymentStatusData = @json($paymentStatusData);
    console.log('Data:', paymentStatusData);
    
    try {
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Tenants', 'Fully Paid', 'With Pending Bills'],
                datasets: [{
                    label: 'Number of Tenants',
                    data: [
                        paymentStatusData.total,
                        paymentStatusData.fullyPaid,
                        paymentStatusData.withPending
                    ],
                    backgroundColor: [
                        'rgba(0, 123, 255, 0.8)',
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(255, 193, 7, 0.8)'
                    ],
                    borderColor: [
                        'rgb(0, 123, 255)',
                        'rgb(40, 167, 69)',
                        'rgb(255, 193, 7)'
                    ],
                    borderWidth: 2,
                    borderRadius: 6,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                return 'Count: ' + context.parsed.y + ' tenant(s)';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                if (Math.floor(value) === value) {
                                    return value;
                                }
                            }
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        
        console.log('Chart created successfully:', chart);
        
    } catch (error) {
        console.error('Chart creation error:', error);
    }
});
</script>
@endsection