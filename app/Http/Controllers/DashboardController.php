<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Booking::query();

        // Filter bookings based on user role
        if ($user->role === 'staff') {
            $query->where('staff_id', $user->id);
        } elseif ($user->role === 'vendor') {
            // For now, let's assume vendor_id on the booking directly relates to the vendor's ID
            $query->whereHas('service.vendor', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }
        // If the user is an admin, no additional filtering is applied, so they see all bookings

        // Get recent bookings
        $recentBookings = $query->with(['service', 'staff'])
            ->latest()
            ->take(5)
            ->get();

        // Get booking statistics
        $todayBookingsCount = (clone $query)
            ->whereDate('booking_date', today())
            ->count();

        $confirmedBookingsCount = (clone $query)
            ->where('status', 'confirmed')
            ->count();

        $pendingBookingsCount = (clone $query)
            ->where('status', 'pending')
            ->count();

        return view('dashboard', compact(
            'recentBookings',
            'todayBookingsCount',
            'confirmedBookingsCount',
            'pendingBookingsCount'
        ));
    }
} 