<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    /**
     * Display a listing of the user's vehicles
     */
    public function index()
    {
        $vehicles = Auth::user()->vehicles()->latest()->get();
        return view('user.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new vehicle
     */
    public function create()
    {
        return view('user.vehicles.create');
    }

    /**
     * Store a newly created vehicle
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'plate_number' => 'required|string|max:20|unique:vehicles',
            'device_id' => 'required|string|max:255|unique:vehicles',
            'model_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'nullable|string|max:50',
        ]);

        Auth::user()->vehicles()->create($request->all());

        return redirect()->route('user.vehicles.index')
            ->with('success', 'Vehicle added successfully');
    }

    /**
     * Display the specified vehicle
     */
    public function show(Vehicle $vehicle)
    {
        $this->authorize('view', $vehicle);
        
        return view('user.vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified vehicle
     */
    public function edit(Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);
        
        return view('user.vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified vehicle
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);

        $request->validate([
            'type' => 'required|string|max:255',
            'plate_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('vehicles')->ignore($vehicle->id)
            ],
            'device_id' => [
                'required',
                'string',
                'max:255',
                Rule::unique('vehicles')->ignore($vehicle->id)
            ],
            'model_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'nullable|string|max:50',
        ]);

        $vehicle->update($request->all());

        return redirect()->route('user.vehicles.index')
            ->with('success', 'Vehicle updated successfully');
    }

    /**
     * Remove the specified vehicle
     */
    public function destroy(Vehicle $vehicle)
    {
        $this->authorize('delete', $vehicle);
        
        $vehicle->delete();

        return redirect()->route('user.vehicles.index')
            ->with('success', 'Vehicle removed successfully');
    }

    /**
     * Link vehicle device (API endpoint)
     */
    public function linkDevice(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:vehicles,device_id',
            'user_id' => 'required|exists:users,id',
        ]);

        $vehicle = Vehicle::where('device_id', $request->device_id)->first();
        
        if ($vehicle->user_id != $request->user_id) {
            return response()->json(['error' => 'Device not assigned to this user'], 403);
        }

        return response()->json([
            'status' => 'success',
            'vehicle' => $vehicle->load('user')
        ]);
    }
}