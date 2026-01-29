@extends('layouts.admin-layout')

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(to bottom, rgba(246, 248, 247, 0.85), rgba(226, 232, 231, 0.85)); backdrop-filter: blur(5px);">
    <div class="max-w-7xl mx-auto">
        <!-- Header with Quick Actions -->
        <div class="mb-8 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div>
                <h1 class="text-4xl font-bold text-[#135757] mb-2">Dashboard</h1>
                <p class="text-gray-700 text-lg font-medium">Overview of your boarding house management</p>
            </div>
            
            <!-- Quick Actions (Top Right) -->
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('admin.view-tenants') }}" 
                   class="flex items-center gap-3 px-6 py-3 bg-white/95 backdrop-blur-sm border-2 border-[#E2E8E7] rounded-xl text-[#135757] font-semibold hover:border-[#135757] hover:bg-[#135757] hover:text-white transition-all duration-300 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    View Tenants
                </a>
                
                <a href="{{ route('admin.bookings.index') }}" 
                   class="flex items-center gap-3 px-6 py-3 bg-white/95 backdrop-blur-sm border-2 border-[#E2E8E7] rounded-xl text-[#135757] font-semibold hover:border-[#135757] hover:bg-[#135757] hover:text-white transition-all duration-300 shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    See Viewings
                </a>
            </div>
        </div>

        <!-- Stats Grid with Chart -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-8">
            <!-- Stats Cards (4 cards - 2x2 taking 4/5 width) -->
            <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Occupied Bedspaces -->
                <div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-lg border-l-4 border-[#135757] hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #d4edda, #c3e6cb);">
                            <svg class="w-7 h-7 text-[#135757]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-3xl font-bold text-[#135757]">{{ $occupiedBedspaces }}/{{ $totalBedspaces }}</p>
                            <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider mt-1">Occupied Beds</p>
                        </div>
                    </div>
                </div>

                <!-- Monthly Revenue -->
                <div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-lg border-l-4 border-[#135757] hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #d4edda, #c3e6cb);">
                            <svg class="w-7 h-7 text-[#135757]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-3xl font-bold text-[#135757]">₱{{ number_format($verifiedPaymentsThisMonth, 0) }}</p>
                            <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider mt-1">Revenue ({{ $currentMonth }})</p>
                        </div>
                    </div>
                </div>

                <!-- Pending Payments -->
                <div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-lg border-l-4 border-[#17a2b8] hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #d1ecf1, #bee5eb);">
                            <svg class="w-7 h-7 text-[#17a2b8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-3xl font-bold text-[#17a2b8]">₱{{ number_format($pendingPayments, 0) }}</p>
                            <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider mt-1">Pending Verification</p>
                        </div>
                    </div>
                </div>

                <!-- Outstanding Bills -->
                <div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-lg border-l-4 border-[#ffc107] hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: linear-gradient(135deg, #fff3cd, #ffeaa7);">
                            <svg class="w-7 h-7 text-[#f39c12]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-3xl font-bold text-[#f39c12]">₱{{ number_format($outstandingBills, 0) }}</p>
                            <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider mt-1">Outstanding Bills</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart (1/5 width) -->
            <div class="lg:col-span-2">
                <div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-lg h-full flex flex-col">
                    <h3 class="text-lg font-bold text-[#135757] mb-4">Payment Status</h3>
                    <div class="flex-1 flex items-center justify-center">
                        <div style="position: relative; height: 200px; width: 200px;">
                            <canvas id="paymentPieChart"></canvas>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#28a745]"></div>
                            <span class="text-xs font-medium text-gray-600">Verified</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#ffc107]"></div>
                            <span class="text-xs font-medium text-gray-600">Unpaid</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Payments -->
            <div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-lg">
                <h3 class="text-xl font-bold text-[#135757] mb-6 pb-3 border-b-2 border-[#E2E8E7]">Recent Verified Payments</h3>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @if($recentPayments->count() > 0)
                        @foreach($recentPayments as $payment)
                        <div class="p-4 rounded-xl hover:bg-[#135757]/5 transition-all duration-200 border border-transparent hover:border-[#E2E8E7]">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-[#135757]">{{ $payment->tenant->name }}</p>
                                    <p class="text-sm text-gray-600 mt-1">₱{{ number_format($payment->bill->amount, 2) }} • {{ $payment->verifiedAt->diffForHumans() }}</p>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">VERIFIED</span>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-12 text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p>No recent payments</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pending Items -->
            <div class="bg-white/95 backdrop-blur-sm p-6 rounded-2xl shadow-lg">
                <h3 class="text-xl font-bold text-[#135757] mb-6 pb-3 border-b-2 border-[#E2E8E7]">Pending Items</h3>
                <div class="space-y-6 max-h-96 overflow-y-auto">
                    <!-- Maintenance Requests -->
                    <div>
                        <h4 class="text-sm font-bold text-[#135757] uppercase tracking-wider mb-3">Maintenance Requests</h4>
                        @if($recentMaintenance->count() > 0)
                            @foreach($recentMaintenance as $request)
                            <div class="p-4 rounded-xl hover:bg-[#135757]/5 transition-all duration-200 mb-2">
                                <p class="font-semibold text-[#135757]">{{ $request->tenant->name }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($request->description, 50) }}</p>
                                <p class="text-xs text-gray-400 mt-2">{{ $request->created_at->diffForHumans() }}</p>
                            </div>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-400 italic ml-2">No pending maintenance</p>
                        @endif
                    </div>

                    <!-- Viewing Bookings -->
                    <div>
                        <h4 class="text-sm font-bold text-[#135757] uppercase tracking-wider mb-3">Viewing Bookings</h4>
                        @if($pendingBookings->count() > 0)
                            @foreach($pendingBookings as $booking)
                            <div class="p-4 rounded-xl hover:bg-[#135757]/5 transition-all duration-200 mb-2">
                                <p class="font-semibold text-[#135757]">{{ $booking->name }}</p>
                                <p class="text-sm text-gray-600 mt-1">{{ $booking->email }} • {{ $booking->phone }}</p>
                                <p class="text-xs text-gray-400 mt-2">{{ $booking->created_at->diffForHumans() }}</p>
                            </div>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-400 italic ml-2">No pending bookings</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden data for JavaScript -->
<script id="chartData" type="application/json">
{
    "total": {{ $totalTenants }},
    "verified": {{ $totalTenants - ($paymentStatusData['withPending'] ?? 0) }},
    "unpaid": {{ $paymentStatusData['withPending'] ?? 0 }}
}
</script>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('paymentPieChart');
    
    if (!ctx) {
        console.error('Canvas not found!');
        return;
    }
    
    if (typeof Chart === 'undefined') {
        console.error('Chart.js not loaded!');
        return;
    }
    
    const dataElement = document.getElementById('chartData');
    const chartData = JSON.parse(dataElement.textContent);
    
    console.log('Chart Data:', chartData);
    
    try {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Verified', 'Unpaid'],
                datasets: [{
                    data: [chartData.verified, chartData.unpaid],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(255, 193, 7, 0.8)'
                    ],
                    borderColor: [
                        'rgb(40, 167, 69)',
                        'rgb(255, 193, 7)'
                    ],
                    borderWidth: 2
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
                        backgroundColor: 'rgba(19, 87, 87, 0.9)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = chartData.total;
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
        
        console.log('Pie chart created successfully');
        
    } catch (error) {
        console.error('Chart creation error:', error);
    }
});
</script>
@endsection