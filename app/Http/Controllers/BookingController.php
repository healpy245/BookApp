<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BookingController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $bookings = Booking::with(['service', 'staff'])->latest()->get();
        } elseif ($user->role === 'vendor') {
            // For vendors, show bookings related to their services' vendors
            $bookings = Booking::whereHas('service.vendor', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['service', 'staff'])->latest()->get();
        } else { // Staff members and others
            $bookings = Booking::where('staff_id', $user->id)->with(['service', 'staff'])->latest()->get();
        }
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->role === 'staff')
        {
            $staff = Auth::user()->vendor->staffs;
            $services = Auth::user()->vendor->services;

        }
        else{
            $vendor = Vendor::where('user_id', Auth::id())->first();
            $services = $vendor->services;
            $staff = $vendor->staffs;
        }

        return view('bookings.create', compact('services', 'staff'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'required|exists:users,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        
        // Calculate end time based on service duration
        $startTime = \Carbon\Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'service_id' => $validated['service_id'],
            'staff_id' => $validated['staff_id'],
            'booking_date' => $validated['booking_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $endTime->format('H:i'),
            'total_price' => $service->price,
            'status' => 'pending',
            'notes' => $validated['notes'],
            'client_name' => $validated['client_name'],
            'client_email' => $validated['client_email'],
            'client_phone' => $validated['client_phone'],
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $this->authorize('update', $booking);
        $services = Service::where('status', 'active')->get();
        $staff = User::where('role', 'staff')->get();
        return view('bookings.edit', compact('booking', 'services', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
            'staff_id' => 'required|exists:users,id',
            'booking_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        
        // Calculate end time based on service duration
        $startTime = \Carbon\Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);

        $booking->update([
            'service_id' => $validated['service_id'],
            'staff_id' => $validated['staff_id'],
            'booking_date' => $validated['booking_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $endTime->format('H:i'),
            'total_price' => $service->price,
            'notes' => $validated['notes'],
            'status' => $validated['status'],
            'client_name' => $validated['client_name'],
            'client_email' => $validated['client_email'],
            'client_phone' => $validated['client_phone'],
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);
        
        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }
}
