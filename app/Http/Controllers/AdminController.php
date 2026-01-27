<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bedspace;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Total Stats
        $totalTenants = \App\Models\User::where('role', 'tenant')->count();
        $totalBedspaces = \App\Models\Bedspace::count();
        $occupiedBedspaces = \App\Models\Bedspace::where('status', 'occupied')->count();
        $availableBedspaces = \App\Models\Bedspace::where('status', 'available')->count();
        
        // Revenue Stats
        $currentMonth = now()->format('F Y');
        $verifiedPaymentsThisMonth = \App\Models\Payment::with('bill')
            ->whereNotNull('verifiedAt')
            ->whereYear('verifiedAt', now()->year)
            ->whereMonth('verifiedAt', now()->month)
            ->get()
            ->sum(function($payment) {
                return $payment->bill->amount;
            });
        
        $pendingPayments = \App\Models\Payment::with('bill')
            ->whereNull('verifiedBy')
            ->whereNull('rejectedBy')
            ->get()
            ->sum(function($payment) {
                return $payment->bill->amount;
            });
        
        $outstandingBills = \App\Models\Bill::where('status', 'pending')->sum('amount');
        
        // Maintenance Stats
        $pendingMaintenance = \App\Models\MaintenanceRequest::where('status', 'pending')->count();
        $scheduledMaintenance = \App\Models\MaintenanceRequest::where('status', 'scheduled')->count();
        $completedMaintenance = \App\Models\MaintenanceRequest::where('status', 'completed')->count();
        
        // Recent Activity
        $recentPayments = \App\Models\Payment::with(['tenant', 'bill'])
            ->whereNotNull('verifiedAt')
            ->orderBy('verifiedAt', 'desc')
            ->take(5)
            ->get();
        
        $recentMaintenance = \App\Models\MaintenanceRequest::with('tenant')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Pending Viewing Bookings
        $pendingBookings = \App\Models\ViewingBooking::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Tenant Payment Status Chart Data
        $tenantsFullyPaid = \App\Models\User::where('role', 'tenant')
            ->whereDoesntHave('bills', function($query) {
                $query->whereIn('status', ['pending', 'paid']);
            })
            ->count();

        $tenantsWithPending = \App\Models\User::where('role', 'tenant')
            ->whereHas('bills', function($query) {
                $query->whereIn('status', ['pending', 'paid']);
            })
            ->count();

        $paymentStatusData = [
            'total' => $totalTenants,
            'fullyPaid' => $tenantsFullyPaid,
            'withPending' => $tenantsWithPending
        ];
        
        return view('admin.dashboard', compact(
            'totalTenants',
            'totalBedspaces',
            'occupiedBedspaces',
            'availableBedspaces',
            'currentMonth',
            'verifiedPaymentsThisMonth',
            'pendingPayments',
            'outstandingBills',
            'pendingMaintenance',
            'scheduledMaintenance',
            'completedMaintenance',
            'recentPayments',
            'recentMaintenance',
            'pendingBookings',
            'paymentStatusData' 
        ));
    }
    // Show the create account form
    public function showCreateAccount()
    {
        $bedspaces = Bedspace::where('status', 'available')->get();
        return view('admin.create-account', compact('bedspaces'));
    }

    // Handle creating the account
    public function createAccount(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'role' => 'required|in:admin,tenant',
            'bedspace_id' => 'nullable|exists:bedspaces,unitID',
            'leaseStart' => 'nullable|date',
            'leaseEnd' => 'nullable|date|after:leaseStart'
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'leaseStart' => $request->leaseStart,
            'leaseEnd' => $request->leaseEnd,
        ]);

        // If tenant and bedspace selected, assign them
        if ($request->role === 'tenant' && $request->bedspace_id) {
            $bedspace = Bedspace::find($request->bedspace_id);
            $bedspace->tenantID = $user->id;
            $bedspace->status = 'occupied';
            $bedspace->save();
        }

        // Return with user data for the popup
        return redirect()->route('admin.create-account')->with([
            'success' => true,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $request->password, // Plain password for display
                'role' => ucfirst($user->role)
            ]
        ]);
    }

    public function viewTenants()
    {
        $tenants = User::where('role', 'tenant')
            ->with('bedspace')
            ->get();
        
        return view('admin.view-tenants', compact('tenants'));
    }

    public function deleteTenant($tenantId)
    {
        $tenant = User::findOrFail($tenantId);
        
        // Free up the bedspace if assigned
        if ($tenant->bedspace) {
            $bedspace = Bedspace::find($tenant->bedspace->unitID);
            $bedspace->tenantID = null;
            $bedspace->status = 'available';
            $bedspace->save();
        }
        
        // Delete the tenant (bills, payments, maintenance will be kept for records)
        $tenant->delete();
        
        return redirect()->route('admin.view-tenants')->with('success', 'Tenant deleted successfully');
    }

    public function showIssueBill()
    {
        $tenants = User::where('role', 'tenant')->with('bedspace')->get();
        return view('admin.issue-bill', compact('tenants'));
    }

    public function issueBill(Request $request)
    {
        $request->validate([
            'tenantID' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'dueDate' => 'required|date'
        ]);

        Bill::create([
            'tenantID' => $request->tenantID,
            'amount' => $request->amount,
            'dueDate' => $request->dueDate,
            'status' => 'pending'
        ]);

        return redirect()->route('admin.issue-bill')->with('success', 'Bill issued successfully!');
    }

    // View all bills with filters
    public function viewBills(Request $request)
    {
        $query = Bill::with(['tenant', 'payments']);
        
        // Filter by tenant
        if ($request->tenant_id) {
            $query->where('tenantID', $request->tenant_id);
        }
        
        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by due date range
        if ($request->date_from) {
            $query->whereDate('dueDate', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('dueDate', '<=', $request->date_to);
        }
        
        $bills = $query->orderBy('dueDate', 'desc')->get();
        $tenants = User::where('role', 'tenant')->orderBy('name')->get();
        
        return view('admin.bills.index', compact('bills', 'tenants'));
    }

    // Show create bill form
    public function createBill()
    {
        $tenants = User::where('role', 'tenant')->with('bedspace')->orderBy('name')->get();
        return view('admin.bills.create', compact('tenants'));
    }

    // Store new bill
    public function storeBill(Request $request)
    {
        $validated = $request->validate([
            'tenantID' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'dueDate' => 'required|date',
            'status' => 'required|in:pending,paid,verified,rejected,void'
        ]);
        
        Bill::create($validated);
        
        return redirect()->route('admin.bills.index')
            ->with('success', 'Bill issued successfully!');
    }

    // Show edit bill form
    public function editBill($billID)
    {
        $bill = Bill::with('tenant')->findOrFail($billID);
        $tenants = User::where('role', 'tenant')->orderBy('name')->get();
        
        return view('admin.bills.edit', compact('bill', 'tenants'));
    }

    // Update bill
    public function updateBill(Request $request, $billID)
    {
        $bill = Bill::findOrFail($billID);
        
        $validated = $request->validate([
            'tenantID' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'dueDate' => 'required|date',
            'status' => 'required|in:pending,paid,verified,rejected,void'
        ]);
        
        $bill->update($validated);
        
        return redirect()->route('admin.bills.index')
            ->with('success', 'Bill updated successfully!');
    }

    // Void bill (soft delete)
    public function voidBill($billID)
    {
        $bill = Bill::findOrFail($billID);
        
        // Mark as void instead of deleting
        $bill->update(['status' => 'void']);
        
        return redirect()->route('admin.bills.index')
            ->with('success', 'Bill voided successfully!');
    }

    public function getTenantBills($tenantId)
    {
        $bills = Bill::where('tenantID', $tenantId)->get();
        return response()->json($bills);
    }

    public function viewPayments()
    {
        $payments = Payment::with(['bill', 'tenant'])
            ->whereNull('verifiedBy')
            ->orderBy('paidAt', 'desc')
            ->get();
        
        return view('admin.view-payments', compact('payments'));
    }

    public function verifyPaymentAjax(Payment $payment)
    {
        try {
            if ($payment->verifiedBy !== null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment already verified.'
                ], 400);
            }

            $payment->update([
                'verifiedBy' => auth()->id(),
                'verifiedAt' => now(),
            ]);

            // Update bill status
            $payment->bill->update(['status' => 'paid']);

            // Refresh payment to get updated timestamps
            $payment->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully!',
                'payment' => [
                    'id' => $payment->paymentID,
                    'status' => 'verified',
                    'verifiedBy' => auth()->user()->name,
                    'verifiedAt' => $payment->verifiedAt ? $payment->verifiedAt->format('M d, Y g:i A') : null
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Verify payment error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while verifying payment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function rejectPaymentAjax(Request $request, Payment $payment)
    {
        try {
            $validated = $request->validate([
                'rejection_reason' => 'required|string|max:500'
            ]);

            if ($payment->verifiedBy !== null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot reject a verified payment.'
                ], 400);
            }

            $payment->update([
                'rejectionReason' => $validated['rejection_reason'],
                'rejectedBy' => auth()->id(),
                'rejectedAt' => now(),
            ]);

            // Update bill status
            $payment->bill->update(['status' => 'rejected']);

            // Refresh payment to get updated timestamps
            $payment->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Payment rejected successfully!',
                'payment' => [
                    'id' => $payment->paymentID,
                    'status' => 'rejected',
                    'rejectedBy' => auth()->user()->name,
                    'rejectedAt' => $payment->rejectedAt ? $payment->rejectedAt->format('M d, Y g:i A') : null,
                    'rejectionReason' => $payment->rejectionReason
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Reject payment error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while rejecting payment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function rejectPayment(Request $request, $paymentID)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $payment = Payment::findOrFail($paymentID);
        
        $payment->rejectedBy = auth()->id();
        $payment->rejectedAt = now();
        $payment->rejectionReason = $request->reason;
        $payment->save();
        
        // Update bill status to rejected
        $bill = Bill::find($payment->billID);
        $bill->status = 'rejected';
        $bill->save();
        
        return redirect()->route('admin.view-payments')->with('success', 'Payment rejected successfully');
    }

    public function viewMaintenanceRequests()
    {
        $requests = MaintenanceRequest::with('tenant')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.view-maintenance', compact('requests'));
    }

    public function updateMaintenanceStatus(Request $request, $requestID)
    {
        $maintenanceRequest = MaintenanceRequest::findOrFail($requestID);
        
        $request->validate([
            'status' => 'required|in:pending,scheduled,completed'
        ]);
        
        $maintenanceRequest->status = $request->status;
        $maintenanceRequest->save();
        
        return redirect()->route('admin.view-maintenance')->with('success', 'Status updated successfully!');
    }
}