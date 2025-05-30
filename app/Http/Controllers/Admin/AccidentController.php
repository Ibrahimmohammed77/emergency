<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accident;
use App\Models\MedicalCenter;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AccidentController extends Controller
{
    /**
     * Display a listing of accidents
     */
    public function index()
    {
        $accidents = Accident::with(['user', 'vehicle', 'medicalCenter'])
            ->latest()
            ->paginate(10);

        return view('admin.accidents.index', compact('accidents'));
    }

    /**
     * Show the form for creating a new accident report
     */
    public function create()
    {
        $vehicles = Vehicle::with('user')->get();
        $medicalCenters = MedicalCenter::where('status', 'active')->get();
        
        return view('admin.accidents.create', compact('vehicles', 'medicalCenters'));
    }

    /**
     * Store a newly created accident report
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'medical_center_id' => 'required|exists:medical_centers,id',
            'description' => 'nullable|string|max:1000',
        ]);

        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        $accident = Accident::create([
            'user_id' => $vehicle->user_id,
            'vehicle_id' => $request->vehicle_id,
            'medical_center_id' => $request->medical_center_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'location_description' => $this->getLocationDescription($request->latitude, $request->longitude),
            'status' => 'pending',
            'admin_notes' => $request->description,
        ]);

        $this->sendEmergencyAlert($accident);

        return redirect()
            ->route('admin.accidents.show', $accident->id)
            ->with('success', 'Accident report created successfully');
    }

    /**
     * Display the specified accident
     */
    public function show(Accident $accident)
    {
        $accident->load(['user', 'vehicle', 'medicalCenter', 'smsNotifications']);
        
        return view('admin.accidents.show', compact('accident'));
    }

    /**
     * Update the accident status
     */
    public function updateStatus(Request $request, Accident $accident)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,resolved',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $accident->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'resolved_at' => $request->status === 'resolved' ? now() : null,
        ]);

        return back()->with('success', 'Accident status updated');
    }

    /**
     * Get location description from coordinates
     */
    private function getLocationDescription($latitude, $longitude): string
    {
        // Implement with Google Maps API or similar
        try {
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'latlng' => "$latitude,$longitude",
                'key' => config('services.google.maps_key'),
            ]);
            
            return $response->json()['results'][0]['formatted_address'] ?? "Near $latitude, $longitude";
        } catch (\Exception $e) {
            return "Near coordinates: $latitude, $longitude";
        }
    }

    /**
     * Send emergency alert to medical center
     */
    private function sendEmergencyAlert(Accident $accident): void
    {
        $message = "EMERGENCY: Accident reported for vehicle {$accident->vehicle->plate_number}\n"
                 . "Location: {$accident->location_description}\n"
                 . "Driver: {$accident->user->name} ({$accident->user->phone})";

        // Create SMS notification record
        $accident->smsNotifications()->create([
            'message' => $message,
            'recipient_number' => $accident->medicalCenter->phone,
            'status' => 'pending',
        ]);

        // Actual SMS sending implementation would go here
        // $this->sendSms($accident->medicalCenter->phone, $message);
    }
}