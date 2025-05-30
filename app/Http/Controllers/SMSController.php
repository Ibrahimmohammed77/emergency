<?php

namespace App\Http\Controllers;

use App\Models\Accident;
use App\Models\SmsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SMSController extends Controller
{
    /**
     * Send emergency SMS notification
     */
    public function sendEmergencyNotification(Accident $accident)
    {
        // Verify the accident exists and has a medical center
        if (!$accident->medicalCenter) {
            return response()->json([
                'status' => 'error',
                'message' => 'No medical center assigned to this accident'
            ], 400);
        }

        // Format the emergency message
        $message = $this->formatEmergencyMessage($accident);

        // Create notification record
        $smsNotification = SmsNotification::create([
            'accident_id' => $accident->id,
            'recipient_number' => $accident->medicalCenter->phone,
            'message' => $message,
            'status' => 'pending'
        ]);

        // Send via SMS gateway
        $response = $this->sendViaGateway($smsNotification);

        // Update notification status
        $smsNotification->update([
            'status' => $response['success'] ? 'sent' : 'failed',
            'gateway_response' => $response['response']
        ]);

        return response()->json([
            'status' => $response['success'] ? 'success' : 'error',
            'notification' => $smsNotification
        ]);
    }

    /**
     * Format the emergency message
     */
    protected function formatEmergencyMessage(Accident $accident): string
    {
        return "🚨 EMERGENCY ALERT 🚑\n"
             . "Vehicle: {$accident->vehicle->plate_number}\n"
             . "Location: {$accident->location_description}\n"
             . "Coordinates: {$accident->latitude}, {$accident->longitude}\n"
             . "Driver: {$accident->user->name} ({$accident->user->phone})\n"
             . "Time: {$accident->created_at->format('Y-m-d H:i:s')}";
    }

    /**
     * Send SMS via gateway (example using Twilio)
     */
    protected function sendViaGateway(SmsNotification $notification): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.config('services.twilio.token'),
            ])->post('https://api.twilio.com/2010-04-01/Accounts/'.config('services.twilio.sid').'/Messages.json', [
                'To' => $notification->recipient_number,
                'From' => config('services.twilio.from'),
                'Body' => $notification->message
            ]);

            return [
                'success' => $response->successful(),
                'response' => $response->json()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Handle SMS delivery reports (webhook)
     */
    public function deliveryReport(Request $request)
    {
        $validated = $request->validate([
            'MessageSid' => 'required|string',
            'MessageStatus' => 'required|string|in:delivered,failed,undelivered'
        ]);

        $notification = SmsNotification::where('gateway_id', $validated['MessageSid'])->first();

        if ($notification) {
            $notification->update([
                'status' => $validated['MessageStatus'],
                'delivered_at' => now()
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * List all SMS notifications
     */
    public function index()
    {
        $notifications = SmsNotification::with(['accident', 'accident.medicalCenter'])
            ->latest()
            ->paginate(20);

        return view('admin.sms.index', compact('notifications'));
    }

    /**
     * Show SMS notification details
     */
    public function show(SmsNotification $smsNotification)
    {
        return view('admin.sms.show', [
            'notification' => $smsNotification->load(['accident.user', 'accident.vehicle'])
        ]);
    }

    /**
     * Retry failed SMS notification
     */
    public function retry(SmsNotification $smsNotification)
    {
        if ($smsNotification->status !== 'failed') {
            return back()->with('error', 'Only failed notifications can be retried');
        }

        $response = $this->sendViaGateway($smsNotification);

        $smsNotification->update([
            'status' => $response['success'] ? 'sent' : 'failed',
            'gateway_response' => $response['response'],
            'retry_count' => $smsNotification->retry_count + 1
        ]);

        return back()->with(
            $response['success'] ? 'success' : 'error',
            $response['success'] ? 'SMS resent successfully' : 'Failed to resend SMS'
        );
    }
}