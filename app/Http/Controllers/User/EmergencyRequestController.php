<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EmergencyRequest;
use App\Models\MedicalCenter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class EmergencyRequestController extends Controller
{
    /**
     * Display emergency request form
     */
    public function create()
    {
        return view('user.emergency-request.create', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Submit new emergency request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'urgency_level' => 'required|in:low,medium,high,critical',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        /** @var User $user */
        $user = Auth::user();

        $emergencyRequest = $user->emergencyRequests()->create([
            'message' => $validated['message'],
            'urgency_level' => $validated['urgency_level'],
            'status' => 'pending',
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ]);

        // Find nearest medical center if coordinates provided
        if ($validated['latitude'] && $validated['longitude']) {
            $nearestCenter = $this->findNearestMedicalCenter(
                $validated['latitude'],
                $validated['longitude']
            );
            
            if ($nearestCenter) {
                $emergencyRequest->update([
                    'medical_center_id' => $nearestCenter->id
                ]);
                
                $this->notifyMedicalCenter($emergencyRequest, $nearestCenter);
            }
        }

        return redirect()->route('user.emergency-requests.show', $emergencyRequest)
            ->with('success', 'Emergency request submitted successfully');
    }

    /**
     * Display emergency request details
     */
    public function show(EmergencyRequest $emergencyRequest)
    {
        // $this->authorize('view', $emergencyRequest);

        return view('user.emergency-request.show', [
            'request' => $emergencyRequest->load(['medicalCenter', 'admin'])
        ]);
    }

    /**
     * List user's emergency requests
     */
    public function index()
    {
        $requests = Auth::guard('user')->user()
            ->emergencyRequests()
            ->with(['medicalCenter'])
            ->latest()
            ->paginate(10);

        return view('user.emergency-request.index', compact('requests'));
    }

    /**
     * Cancel pending emergency request
     */
    public function cancel(EmergencyRequest $emergencyRequest)
    {
        // $this->authorize('update', $emergencyRequest);

        if ($emergencyRequest->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be cancelled');
        }

        $emergencyRequest->update([
            'status' => 'cancelled',
            'cancelled_at' => now()
        ]);

        return back()->with('success', 'Emergency request cancelled');
    }

    /**
     * Find nearest medical center to coordinates
     */
    protected function findNearestMedicalCenter($latitude, $longitude): ?MedicalCenter
    {
        return MedicalCenter::selectRaw('*, ST_Distance_Sphere(
            point(longitude, latitude), 
            point(?, ?)
        ) as distance', [$longitude, $latitude])
            ->where('status', 'active')
            ->orderBy('distance')
            ->first();
    }

    /**
     * Notify medical center about emergency
     */
    protected function notifyMedicalCenter(EmergencyRequest $request, MedicalCenter $center): void
    {
        // Send SMS notification
        $message = "🚨 EMERGENCY REQUEST\n"
                 . "Urgency: {$request->urgency_level}\n"
                 . "From: {$request->user->name} ({$request->user->phone})\n"
                 . "Message: {$request->message}\n"
                 . "Location: " . ($request->latitude ? "{$request->latitude}, {$request->longitude}" : "Not specified");

        // Example using Twilio (configure in services.php)
        Http::withHeaders([
            'Authorization' => 'Bearer '.config('services.twilio.token'),
        ])->post('https://api.twilio.com/2010-04-01/Accounts/'.config('services.twilio.sid').'/Messages.json', [
            'To' => $center->phone,
            'From' => config('services.twilio.from'),
            'Body' => $message
        ]);

        // You could also trigger a notification to the admin dashboard
    }
}