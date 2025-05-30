<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Accident;
use App\Models\EmergencyRequest;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Show user dashboard
     */
    public function dashboard()
    {
        /** @var User $user */
        $user = auth()->user();
        
        $user->loadCount(['vehicles', 'accidents']);
        
        $recentAccidents = $user->accidents()
            ->with(['medicalCenter'])
            ->latest()
            ->take(3)
            ->get();

        return view('user.dashboard', [
            'user' => $user,
            'recentAccidents' => $recentAccidents
        ]);
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        return view('user.profile', ['user' => auth()->user()]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users')->ignore($user->id)
            ],
            'current_password' => ['nullable', 'required_with:new_password', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'new_password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];

        if ($request->filled('new_password')) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully');
    }

    /**
     * List user's vehicles
     */
    public function vehicles()
    {
        $vehicles = auth()->user()->vehicles()->latest()->get();
        return view('user.vehicles.index', compact('vehicles'));
    }

    /**
     * Show vehicle creation form
     */
    public function createVehicle()
    {
        return view('user.vehicles.create');
    }

    /**
     * Store new vehicle
     */
    public function storeVehicle(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'plate_number' => 'required|string|max:20|unique:vehicles',
            'device_id' => 'required|string|max:255|unique:vehicles',
        ]);

        auth()->user()->vehicles()->create($validated);

        return redirect()->route('user.vehicles.index')
            ->with('success', 'Vehicle added successfully');
    }

    /**
     * Show vehicle edit form
     */
    public function editVehicle(Vehicle $vehicle)
    {
        // $this->authorize('update', $vehicle);
        
        return view('user.vehicles.edit', compact('vehicle'));
    }

    /**
     * Update vehicle
     */
    public function updateVehicle(Request $request, Vehicle $vehicle)
    {
        // $this->authorize('update', $vehicle);

        $validated = $request->validate([
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
        ]);

        $vehicle->update($validated);

        return redirect()->route('user.vehicles.index')
            ->with('success', 'Vehicle updated successfully');
    }

    /**
     * List user's accidents
     */
    public function accidents()
    {
        $accidents = auth()->user()->accidents()
            ->with(['medicalCenter', 'vehicle'])
            ->latest()
            ->paginate(10);

        return view('user.accidents.index', compact('accidents'));
    }

    /**
     * Show accident details
     */
    public function showAccident(Accident $accident)
    {
        // $this->authorize('view', $accident);
        
        $accident->load(['medicalCenter', 'vehicle']);
        return view('user.accidents.show', compact('accident'));
    }

    /**
     * Show emergency request form
     */
    public function showEmergencyRequestForm()
    {
        return view('user.emergency-request.create');
    }

    /**
     * Submit emergency request
     */
    public function submitEmergencyRequest(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'urgency_level' => 'required|in:low,medium,high,critical',
        ]);

        EmergencyRequest::create([
            'user_id' => auth()->id(),
            'message' => $validated['message'],
            'urgency_level' => $validated['urgency_level'],
            'status' => 'pending',
        ]);

        return redirect()->route('user.dashboard')
            ->with('success', 'Emergency request submitted successfully');
    }

    /**
     * List emergency requests
     */
    public function emergencyRequests()
    {
        $requests = auth()->user()->emergencyRequests()
            ->latest()
            ->paginate(10);

        return view('user.emergency-requests.index', compact('requests'));
    }
}