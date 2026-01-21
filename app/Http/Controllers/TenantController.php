<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{
    public function dashboard()
    {
        $tenant = Auth::user();
        $bedspace = $tenant->bedspace;
        
        return view('tenant.dashboard', compact('tenant', 'bedspace'));
    }

    public function viewBills()
    {
        $tenant = Auth::user();
        $bills = \App\Models\Bill::where('tenantID', $tenant->id)
            ->orderBy('dueDate', 'desc')
            ->get();
        
        return view('tenant.view-bills', compact('bills'));
    }

    public function uploadPayment(Request $request, $billID)
    {
            $request->validate([
                'paymentMethod' => 'required|in:cash,gcash',
                'receiptImage' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);
        $bill = Bill::findOrFail($billID);
        
        // Store the receipt image if uploaded
        $receiptPath = null;
        if ($request->hasFile('receiptImage')) {
            $receiptPath = $request->file('receiptImage')->store('receipts', 'public');
        }

        // Create payment record
        Payment::create([
            'billID' => $billID,
            'tenantID' => Auth::id(),
            'receiptImage' => $receiptPath,
            'paymentMethod' => $request->paymentMethod,
            'paidAt' => now(),
        ]);

        // Update bill status to 'paid'
        $bill->status = 'paid';
        $bill->save();

        return redirect()->route('tenant.view-bills')->with('success', 'Payment submitted successfully! Awaiting admin verification.');
    }

    public function showCreateMaintenance()
    {
        return view('tenant.create-maintenance');
    }

    public function createMaintenance(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('maintenance', 'public');
        }

        MaintenanceRequest::create([
            'tenantID' => Auth::id(),
            'description' => $request->description,
            'photo' => $photoPath,
            'status' => 'pending'
        ]);

        return redirect()->route('tenant.view-maintenance')->with('success', 'Maintenance request submitted successfully!');
    }

    public function viewMaintenance()
    {
        $requests = MaintenanceRequest::where('tenantID', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('tenant.view-maintenance', compact('requests'));
    }

}