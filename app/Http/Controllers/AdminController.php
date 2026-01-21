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

    public function viewPayments()
    {
        $payments = Payment::with(['bill', 'tenant'])
            ->whereNull('verifiedBy')
            ->orderBy('paidAt', 'desc')
            ->get();
        
        return view('admin.view-payments', compact('payments'));
    }

    public function verifyPayment($paymentID)
    {
        $payment = Payment::findOrFail($paymentID);
        
        $payment->verifiedBy = auth()->id();
        $payment->verifiedAt = now();
        $payment->save();
        
        // Update bill status to verified
        $bill = Bill::find($payment->billID);
        $bill->status = 'verified';
        $bill->save();
        
        return redirect()->route('admin.view-payments')->with('success', 'Payment verified successfully!');
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