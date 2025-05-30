@extends('layouts.admin')

@section('title', 'إنشاء تقرير حادث')

@section('content')
<div class="container-fluid" dir="rtl">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title text-right">إنشاء تقرير حادث جديد</h3>
                </div>
                <form action="{{ route('admin.accidents.store') }}" method="POST">
                    @csrf
                    <div class="card-body text-right">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vehicle_id">المركبة *</label>
                                    <select name="vehicle_id" id="vehicle_id" class="form-control select2" required>
                                        <option value="">اختر المركبة</option>
                                        @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}">
                                            {{ $vehicle->plate_number }} ({{ $vehicle->user->name }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="medical_center_id">المركز الطبي *</label>
                                    <select name="medical_center_id" id="medical_center_id" class="form-control select2" required>
                                        <option value="">اختر المركز الطبي</option>
                                        @foreach($medicalCenters as $center)
                                        <option value="{{ $center->id }}">
                                            {{ $center->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="latitude">خط العرض *</label>
                                    <input type="number" step="any" name="latitude" id="latitude" 
                                           class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude">خط الطول *</label>
                                    <input type="number" step="any" name="longitude" id="longitude" 
                                           class="form-control" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">الوصف</label>
                            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div id="map" style="height: 400px; width: 100%;" class="mb-3"></div>
                    </div>
                    <div class="card-footer d-flex gap-2 justify-content-start">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save ms-2"></i> حفظ التقرير
                        </button>
                        <a href="{{ route('admin.accidents.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-times ms-2"></i> إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Initialize map
    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: -1.2921, lng: 36.8219 }, // Default to Nairobi
            zoom: 12,
        });
        
        let marker;
        
        // Add click listener
        google.maps.event.addListener(map, 'click', function(event) {
            if (marker) {
                marker.setMap(null);
            }
            
            marker = new google.maps.Marker({
                position: event.latLng,
                map: map,
                draggable: true
            });
            
            // Update form fields
            document.getElementById('latitude').value = event.latLng.lat();
            document.getElementById('longitude').value = event.latLng.lng();
            
            // Reverse geocode
            fetch(`/admin/api/reverse-geocode?lat=${event.latLng.lat()}&lng=${event.latLng.lng()}`)
                .then(response => response.json())
                .then(data => {
                    if (data.address) {
                        document.getElementById('description').value = 
                            `وقع الحادث في ${data.address}`;
                    }
                });
        });
        
        // Initialize Select2 with RTL support
        $('.select2').select2({
            theme: 'bootstrap4',
            dir: 'rtl'
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&callback=initMap" 
        async defer></script>
@endsection