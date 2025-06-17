<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ServiceController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $services = Service::all();
            return view('admin.services.index', compact('services'));
        } elseif ($user->role === 'vendor') {
            $vendor = Vendor::where('user_id', Auth::id())->first();
            if ($vendor) {
                $services = $vendor->services; // Access services through the vendor relationship
            } else {
                $services = collect([]); // No services if vendor not found
            }
            return view('vendor.services.index', compact('services'));
        } else {
            $services = $user->vendor->services; // Staff members or other roles do not directly view all services here
            return view('vendor.services.index', compact('services')); // Or redirect to a different view
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendor.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);
        $vendor = Vendor::where('user_id', Auth::id())->first();

        if ($vendor) {
            $vendor->services()->create($validated);
        } else {
            // Handle case where vendor is not found (e.g., if an admin tries to create service directly)
            return back()->withErrors(['vendor' => 'No vendor associated with this user.']);
        }

        return redirect()->route('services.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $this->authorize('view', $service);
        return view('vendor.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $this->authorize('update', $service);
        return view('vendor.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $this->authorize('update', $service);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $service->update($validated);

        return redirect()->route('services.index')
            ->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);
        
        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Service deleted successfully.');
    }
}
