<?php

namespace App\Http\Controllers;

use App\Models\Bedspace;
use App\Models\ViewingBooking;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function availableRooms()
    {
        // Get bedspace data grouped by house, floor, room
        $bedspaces = Bedspace::orderBy('houseNo')
            ->orderBy('floor', 'desc')
            ->orderBy('roomNo')
            ->get()
            ->groupBy(['houseNo', 'floor', 'roomNo']);
        
        return view('available-rooms', compact('bedspaces'));
    }

    public function bookViewing()
{
    // Get available bedspaces grouped by unique room combinations
    // We only need one representative bedspace per room for the form
    $bedspaces = Bedspace::selectRaw('MIN(unitID) as unitID, houseNo, floor, roomNo, price, restriction')
        ->where('status', 'available')
        ->groupBy('houseNo', 'floor', 'roomNo', 'price', 'restriction')
        ->orderBy('houseNo')
        ->orderByDesc('floor')
        ->orderBy('roomNo')
        ->get();
    
    return view('book-viewing', compact('bedspaces'));
}

    public function storeBooking(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:male,female',
            'bedspace_id' => 'required|exists:bedspaces,unitID',
            'preferred_date' => 'required|date|after:today',
            'preferred_time' => 'nullable|string|max:50',
            'message' => 'nullable|string|max:500',
        ]);

        ViewingBooking::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'bedspace_id' => $request->bedspace_id,
            'preferred_date' => $request->preferred_date,
            'preferred_time' => $request->preferred_time,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return redirect()->route('book-viewing')->with('success', 'Booking request submitted successfully! We will contact you soon.');
    }

    public function storeBookingAjax(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'gender' => 'required|in:male,female',
                'bedspace_id' => 'required|exists:bedspaces,unitID',
                'preferred_date' => 'required|date|after:today',
                'preferred_time' => 'nullable|string|max:50',
                'message' => 'nullable|string|max:500',
            ]);

            ViewingBooking::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'gender' => $validated['gender'],
                'bedspace_id' => $validated['bedspace_id'],
                'preferred_date' => $validated['preferred_date'],
                'preferred_time' => $validated['preferred_time'],
                'message' => $validated['message'],
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking request submitted successfully! We will contact you soon.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again.'
            ], 500);
        }
    }
}