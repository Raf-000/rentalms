<?php

    namespace App\Http\Controllers;

    use Carbon\Carbon;
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
            
            // Auto-generate bill if needed
            $this->autoGenerateBillIfNeeded($tenant);
            
            $bills = Bill::where('tenantID', $tenant->id)
                ->orderBy('dueDate', 'desc')
                ->get();
            
            return view('tenant.view-bills', compact('bills'));
        }

        // Helper method to auto-generate bills
        private function autoGenerateBillIfNeeded($tenant)
        {
            // Only generate if tenant has a bedspace and lease start date
            if (!$tenant->bedspace || !$tenant->leaseStart) {
                return;
            }
            
            $today = now();
            
            // Get the billing day from lease start (e.g., if lease starts June 11, billing day is 11)
            $billingDay = \Carbon\Carbon::parse($tenant->leaseStart)->day;
            
            // Calculate this month's billing date
            $currentBillingDate = \Carbon\Carbon::create($today->year, $today->month, $billingDay);
            
            // If billing day already passed this month, calculate for next month
            if ($currentBillingDate->isPast()) {
                $currentBillingDate->addMonth();
            }
            
            // Check if we're within 7 days before the billing date
            $sevenDaysBefore = $currentBillingDate->copy()->subDays(7);
            
            if ($today->greaterThanOrEqualTo($sevenDaysBefore) && $today->lessThanOrEqualTo($currentBillingDate)) {
                // Check if bill already exists for this month
                $existingBill = Bill::where('tenantID', $tenant->id)
                    ->whereYear('dueDate', $currentBillingDate->year)
                    ->whereMonth('dueDate', $currentBillingDate->month)
                    ->first();
                
                // Create bill if it doesn't exist yet
                if (!$existingBill) {
                    Bill::create([
                        'tenantID' => $tenant->id,
                        'amount' => $tenant->bedspace->price,
                        'dueDate' => $currentBillingDate,
                        'status' => 'pending'
                    ]);
                }
            }
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
            try {
                $validated = $request->validate([
                    'description' => 'required|string|max:500',
                    'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000000' // 10MB max
                ]);
                
                $photoPath = null;
                
                if ($request->hasFile('photo')) {
                    $file = $request->file('photo');
                    
                    // Generate unique filename
                    $filename = time() . '_' . $file->getClientOriginalName();
                    
                    // Store in storage/app/public/maintenance_photos
                    $photoPath = $file->storeAs('maintenance_photos', $filename, 'public');
                }
                
                MaintenanceRequest::create([
                    'tenantID' => Auth::id(),
                    'description' => $validated['description'],
                    'photo' => $photoPath,
                    'status' => 'pending'
                ]);
                
                return redirect()->route('tenant.view-maintenance')
                    ->with('success', 'Maintenance request submitted successfully!');
                    
            } catch (\Illuminate\Validation\ValidationException $e) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($e->errors());
                    
            } catch (\Exception $e) {
                \Log::error('Maintenance creation error: ' . $e->getMessage());
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Failed to submit maintenance request. Please try again.');
            }
        }

        public function storeMaintenanceRequest(Request $request)
        {
            $validated = $request->validate([
                'description' => 'required|string|max:500',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120' // 5MB max
            ]);
            
            $photoPath = null;
            
            if ($request->hasFile('photo')) {
                // Store in storage/app/public/maintenance_photos
                $photoPath = $request->file('photo')->store('maintenance_photos', 'public');
            }
            
            MaintenanceRequest::create([
                'tenantID' => Auth::id(),
                'description' => $validated['description'],
                'photo' => $photoPath,
                'status' => 'pending'
            ]);
            
            return redirect()->route('tenant.view-maintenance')
                ->with('success', 'Maintenance request submitted successfully!');
        }

        public function viewMaintenance()
        {
            $requests = MaintenanceRequest::where('tenantID', Auth::id())
                ->orderBy('created_at', 'desc')
                ->get();
            
            return view('tenant.view-maintenance', compact('requests'));
        }

        // Old method (for fallback)
        public function completeMaintenance($requestID)
        {
            $request = MaintenanceRequest::where('requestID', $requestID)
                ->where('tenantID', Auth::id())
                ->firstOrFail();

            $request->update(['status' => 'completed']);

            return redirect()->route('tenant.view-maintenance')
                ->with('success', 'Maintenance request marked as completed!');
        }

        // New AJAX method
        public function completeMaintenanceAjax($requestID)
        {
            try {
                $request = MaintenanceRequest::where('requestID', $requestID)
                    ->where('tenantID', Auth::id())
                    ->firstOrFail();

                if ($request->status === 'completed') {
                    return response()->json([
                        'success' => false,
                        'message' => 'This request is already marked as completed.'
                    ], 400);
                }

                $request->update(['status' => 'completed']);

                return response()->json([
                    'success' => true,
                    'message' => 'Maintenance request marked as completed!',
                    'request' => [
                        'id' => $request->requestID,
                        'status' => 'completed'
                    ]
                ]);

            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maintenance request not found.'
                ], 404);
            } catch (\Exception $e) {
                \Log::error('Complete maintenance error: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while updating the request.'
                ], 500);
            }
        }
    }