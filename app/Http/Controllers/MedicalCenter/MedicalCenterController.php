<?php

namespace App\Http\Controllers\MedicalCenter;

use App\Http\Controllers\Controller;
use App\Models\Accident;
use App\Models\MedicalCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MedicalCenterController extends Controller
{
    /**
     * Show medical center dashboard
     */
    public function dashboard()
    {
        /** @var MedicalCenter $medicalCenter */
        $medicalCenter = auth('medical_center')->user();
        
        $stats = [
            'pending_accidents' => $medicalCenter->accidents()->where('status', 'pending')->count(),
            'processing_accidents' => $medicalCenter->accidents()->where('status', 'processing')->count(),
            'resolved_accidents' => $medicalCenter->accidents()->where('status', 'resolved')->count(),
        ];

        $activeAccidents = $medicalCenter->accidents()
            ->whereIn('status', ['pending', 'processing'])
            ->with(['user', 'vehicle'])
            ->latest()
            ->take(5)
            ->get();

        return view('medical-center.dashboard', [
            'medicalCenter' => $medicalCenter,
            'stats' => $stats,
            'activeAccidents' => $activeAccidents
        ]);
    }

    /**
     * Show medical center profile
     */
    public function profile()
    {
        return view('medical-center.profile', [
            'medicalCenter' => auth('medical_center')->user()
        ]);
    }

    /**
     * Update medical center profile
     */
    public function updateProfile(Request $request)
    {
        /** @var MedicalCenter $medicalCenter */
        $medicalCenter = auth('medical_center')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('medical_centers')->ignore($medicalCenter->id)
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('medical_centers')->ignore($medicalCenter->id)
            ],
            'address' => 'required|string|max:500',
            'specialization' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'current_password' => ['nullable', 'required_with:new_password', function ($attribute, $value, $fail) use ($medicalCenter) {
                if (!Hash::check($value, $medicalCenter->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'new_password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $medicalCenter->name = $validated['name'];
        $medicalCenter->email = $validated['email'];
        $medicalCenter->phone = $validated['phone'];
        $medicalCenter->address = $validated['address'];
        $medicalCenter->specialization = $validated['specialization'];
        $medicalCenter->latitude = $validated['latitude'];
        $medicalCenter->longitude = $validated['longitude'];

        if ($request->filled('new_password')) {
            $medicalCenter->password = Hash::make($validated['new_password']);
        }

        $medicalCenter->save();

        return back()->with('success', 'Profile updated successfully');
    }

    /**
     * List all accidents assigned to the medical center
     */
    public function accidents()
    {
        $accidents = auth('medical_center')->user()
            ->accidents()
            ->with(['user', 'vehicle'])
            ->latest()
            ->paginate(10);

        return view('medical-center.accidents.index', compact('accidents'));
    }

    /**
     * Show accident details
     */
    public function showAccident(Accident $accident)
    {
        // Verify the accident belongs to this medical center
        if ($accident->medical_center_id !== auth('medical_center')->id()) {
            abort(403);
        }

        $accident->load(['user', 'vehicle']);
        $medicalCenter=MedicalCenter::findOrFail($accident->medical_center_id);
        
        return view('medical-center.accidents.show', compact('accident','medicalCenter'));
    }

    /**
     * Update accident status
     */
    public function updateAccidentStatus(Request $request, Accident $accident)
    {
        // Verify the accident belongs to this medical center
        if ($accident->medical_center_id !== auth('medical_center')->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,processing,resolved',
            'notes' => 'nullable|string|max:1000',
        ]);

        $updateData = [
            'status' => $request->status,
            'medical_center_notes' => $request->notes,
        ];

        if ($request->status === 'processing' && is_null($accident->responded_at)) {
            $updateData['responded_at'] = now();
        }

        if ($request->status === 'resolved') {
            $updateData['resolved_at'] = now();
        }

        $accident->update($updateData);

        return back()->with('success', 'Accident status updated successfully');
    }

    /**
     * Show response form for an accident
     */
    public function showResponseForm(Accident $accident)
    {
        if ($accident->medical_center_id !== auth('medical_center')->id()) {
            abort(403);
        }

        return view('medical-center.accidents.response', compact('accident'));
    }
}