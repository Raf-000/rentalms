<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bedspace;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use App\Models\ViewingBooking;
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
    
//================================== User Account Creation ==================================//
    // Show the create account form
    public function showCreateAccount()
    {
        $bedspaces = Bedspace::where('status', 'available')
            ->orderBy('houseNo')
            ->orderBy('floor')
            ->orderBy('roomNo')
            ->orderBy('bedspaceNo')
            ->get();
        
        return view('admin.create-account', compact('bedspaces'));
    }

    // Handle creating the account
    public function createAccount(Request $request)
    {
        // Custom validation for lease dates
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'role' => 'required|in:admin,tenant',
            'phone' => 'nullable|string|max:20',
            'bedspace_id' => 'nullable|exists:bedspaces,unitID',
            'leaseStart' => 'nullable|date|required_with:bedspace_id',
            'leaseEnd' => 'nullable|date|after:leaseStart|required_with:bedspace_id'
        ], [
            'leaseEnd.after' => 'The lease end date must be after the lease start date.',
            'leaseStart.required_with' => 'Lease start date is required when assigning a bedspace.',
            'leaseEnd.required_with' => 'Lease end date is required when assigning a bedspace.'
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
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

        // Return with user data for the modal
        return redirect()->route('admin.create-account')->with([
            'success' => true,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'password' => $request->password,
                'role' => ucfirst($user->role),
                'bedspace' => $request->bedspace_id ? Bedspace::find($request->bedspace_id)->unitCode : null
            ]
        ]);
    }

//================================== Tenants Management ==================================//
    //view tenants
    public function viewTenants()
    {
        $tenants = User::where('role', 'tenant')
            ->with('bedspace')
            ->get();
        
        return view('admin.view-tenants', compact('tenants'));
    }

    //edit tenant account
    public function editTenant($id)
    {
        $tenant = User::findOrFail($id);
        $bedspaces = Bedspace::where('status', 'available')
            ->orWhere('unitID', $tenant->bedspace?->unitID)
            ->get();
        
        return view('admin.edit-tenant', compact('tenant', 'bedspaces'));
    }

    public function updateTenant(Request $request, $id)
    {
        $tenant = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'emergencyContact' => 'nullable|string|max:20',
            'bedspace_id' => 'nullable|exists:bedspaces,unitID',
            'leaseStart' => 'nullable|date',
            'leaseEnd' => 'nullable|date|after:leaseStart',
            'password' => 'nullable|min:3'
        ]);
        
        // Handle bedspace change
        $oldBedspace = $tenant->bedspace;
        
        // Free old bedspace if changing
        if ($oldBedspace && $oldBedspace->unitID != $request->bedspace_id) {
            $oldBedspace->tenantID = null;
            $oldBedspace->status = 'available';
            $oldBedspace->save();
        }
        
        // Update tenant
        $tenant->name = $request->name;
        $tenant->email = $request->email;
        $tenant->phone = $request->phone;
        $tenant->emergencyContact = $request->emergencyContact;
        $tenant->leaseStart = $request->leaseStart;
        $tenant->leaseEnd = $request->leaseEnd;
        
        if ($request->filled('password')) {
            $tenant->password = Hash::make($request->password);
        }
        
        $tenant->save();
        
        // Assign new bedspace
        if ($request->bedspace_id) {
            $newBedspace = Bedspace::find($request->bedspace_id);
            $newBedspace->tenantID = $tenant->id;
            $newBedspace->status = 'occupied';
            $newBedspace->save();
        }
        
        return redirect()->route('admin.view-tenants');
    }

    //delete tenant account
    public function deleteTenant($id)
    {
        $tenant = User::findOrFail($id);
        
        // Free up the bedspace if assigned
        if ($tenant->bedspace) {
            $bedspace = Bedspace::find($tenant->bedspace->unitID);
            $bedspace->tenantID = null;
            $bedspace->status = 'available';
            $bedspace->save();
        }
        
        // Delete related records
        \App\Models\Bill::where('tenantID', $id)->delete();
        \App\Models\Payment::where('tenantID', $id)->delete();
        \App\Models\MaintenanceRequest::where('tenantID', $id)->delete();
        
        // Delete the tenant
        $tenant->delete();
        
        return redirect()->route('admin.view-tenants');
    }


//================================== Billing Management ==================================//
    
    /*public function showIssueBill()
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
    } */

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
        'status' => 'required|in:pending,paid,verified,rejected'
    ]);

    $validated['description'] = $validated['description'] ?? 'Monthly Rent';

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
            'amount' => 'required|numeric|min:0',
            'dueDate' => 'required|date',
            'status' => 'required|in:pending,paid,verified,rejected'
        ]);

        $bill->update($validated);

        return redirect()->route('admin.bills.index')
            ->with('success', 'Bill updated successfully!');
    }

    // Hard delete bill
    public function deleteBill($billID)
    {
        $bill = Bill::findOrFail($billID);

        // Prevent deleting bills with verified payments
        if ($bill->payments()->whereNotNull('verifiedAt')->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete a bill with verified payments.');
        }

        $bill->delete();

        return redirect()->route('admin.bills.index')
            ->with('success', 'Bill deleted successfully!');
    }

    // AJAX: Get bills for a tenant
    public function getTenantBills($tenantId)
    {
        $bills = Bill::where('tenantID', $tenantId)->get();
        return response()->json($bills);
    }

//================================== Payment Verification ==================================//
    //view payments pending verification
    public function viewPayments()
    {
        $payments = Payment::with(['bill', 'tenant'])
            ->whereNull('verifiedBy')
            ->orderBy('paidAt', 'desc')
            ->get();
        
        return view('admin.view-payments', compact('payments'));
    }

    // AJAX: Verify payment
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

    //================================== Maintenance Requests ==================================//
    //view maintenance requests
    public function viewMaintenanceRequests()
    {
        $requests = MaintenanceRequest::with('tenant')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.view-maintenance', compact('requests'));
    }

    // Update maintenance request status
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

//================================== Viewing Bookings ==================================//
    // View all bookings
    public function viewBookings(Request $request)
    {
        $query = ViewingBooking::query();
        
        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by date
        if ($request->date_from) {
            $query->whereDate('preferred_date', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('preferred_date', '<=', $request->date_to);
        }
        
        $bookings = $query->orderBy('created_at', 'desc')->get();
        
        // Stats for cards
        $stats = [
            'thisMonth' => ViewingBooking::whereMonth('preferred_date', now()->month)
                ->whereYear('preferred_date', now()->year)
                ->whereIn('status', ['pending', 'confirmed'])
                ->count(),
            'pending' => ViewingBooking::where('status', 'pending')->count(),
            'confirmed' => ViewingBooking::where('status', 'confirmed')->count()
        ];
        
        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    // Show create booking form
    public function createBooking()
    {
        $bedspaces = Bedspace::where('status', 'available')->get();
        return view('admin.bookings.create', compact('bedspaces'));
    }

    // Store new booking
    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:male,female',
            'bedspace_id' => 'required|exists:bedspaces,unitID',
            'preferred_date' => 'required|date',
            'preferred_time' => 'nullable|string|max:50',
            'message' => 'nullable|string|max:500',
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);
        
        ViewingBooking::create($validated);
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking created successfully!');
    }

    // Show edit booking form
    public function editBooking($id)
    {
        $booking = ViewingBooking::findOrFail($id);
        $bedspaces = Bedspace::where('status', 'available')
            ->orWhere('unitID', $booking->bedspace_id)
            ->get();
        
        return view('admin.bookings.edit', compact('booking', 'bedspaces'));
    }

    // Update booking
    public function updateBooking(Request $request, $id)
    {
        $booking = ViewingBooking::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:male,female',
            'bedspace_id' => 'required|exists:bedspaces,unitID',
            'preferred_date' => 'required|date',
            'preferred_time' => 'nullable|string|max:50',
            'message' => 'nullable|string|max:500',
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);
        
        // Update explicitly
        $booking->name = $validated['name'];
        $booking->email = $validated['email'];
        $booking->phone = $validated['phone'];
        $booking->gender = $validated['gender'];
        $booking->bedspace_id = $validated['bedspace_id'];
        $booking->preferred_date = $validated['preferred_date'];
        $booking->preferred_time = $validated['preferred_time'];
        $booking->message = $validated['message'];
        $booking->status = $validated['status'];
        $booking->save();
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking updated successfully!');
    }

    // Confirm booking
    public function confirmBooking($id)
    {
        $booking = ViewingBooking::findOrFail($id);
        $booking->status = 'confirmed';
        $booking->save();
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking confirmed successfully!');
    }

    // Complete booking
    public function completeBooking($id)
    {
        $booking = ViewingBooking::findOrFail($id);
        $booking->status = 'completed';
        $booking->save();
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking marked as completed!');
    }

    // Cancel booking
    public function cancelBooking($id)
    {
        $booking = ViewingBooking::findOrFail($id);
        $booking->status = 'cancelled';
        $booking->save();
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking cancelled successfully!');
    }

    // Delete booking permanently
    public function deleteBooking($id)
    {
        $booking = ViewingBooking::findOrFail($id);
        $booking->delete();
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted permanently!');
    }
}