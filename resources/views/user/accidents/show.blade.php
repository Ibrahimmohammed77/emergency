@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Accident Report #{{ $accident->id }}</span>
                    <span class="badge bg-{{ 
                        $accident->status == 'resolved' ? 'success' : 
                        ($accident->status == 'processing' ? 'warning' : 'danger') 
                    }}">
                        {{ ucfirst($accident->status) }}
                    </span>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Vehicle Information</h5>
                            <p><strong>Plate Number:</strong> {{ $accident->vehicle->plate_number }}</p>
                            <p><strong>Vehicle Type:</strong> {{ ucfirst($accident->vehicle->type) }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Accident Details</h5>
                            <p><strong>Reported At:</strong> {{ $accident->created_at->format('M d, Y H:i') }}</p>
                            <p><strong>Location:</strong> {{ $accident->location_description }}</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Medical Center</h5>
                            @if($accident->medicalCenter)
                                <p><strong>Name:</strong> {{ $accident->medicalCenter->name }}</p>
                                <p><strong>Status:</strong> 
                                    @if($accident->status == 'resolved')
                                        Responded at: {{ $accident->responded_at->format('M d, Y H:i') }}
                                    @elseif($accident->status == 'processing')
                                        Responding...
                                    @else
                                        Pending response
                                    @endif
                                </p>
                            @else
                                <p class="text-muted">No medical center assigned yet</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div id="accidentMap" style="height: 200px; background: #eee; border-radius: 5px;"></div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('user.accidents.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Initialize map (example using Leaflet)
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('accidentMap').setView([
            {{ $accident->latitude }}, 
            {{ $accident->longitude }}
        ], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([
            {{ $accident->latitude }}, 
            {{ $accident->longitude }}
        ]).addTo(map)
          .bindPopup('Accident Location');
    });
</script>
@endsection
@endsection