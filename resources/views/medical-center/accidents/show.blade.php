@extends('layouts.medical-center')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 text-right">حالة الطوارئ رقم #{{ $accident->id }}</h1>
        <a href="{{ route('medical-center.accidents') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> العودة للحالات
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary text-right">تفاصيل الحالة</h6>
                    <span class="badge bg-{{ 
                        $accident->status == 'resolved' ? 'success' : 
                        ($accident->status == 'processing' ? 'warning' : 'danger') 
                    }}">
                        @if($accident->status == 'pending')
                            قيد الانتظار
                        @elseif($accident->status == 'processing')
                            قيد المعالجة
                        @else
                            تم الحل
                        @endif
                    </span>
                </div>
                <div class="card-body text-right">
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">وقت الإبلاغ:</div>
                        <div class="col-sm-8">{{ $accident->created_at->format('M d, Y H:i:s') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">الموقع:</div>
                        <div class="col-sm-8">{{ $accident->location_description }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">الإحداثيات:</div>
                        <div class="col-sm-8">{{ $accident->latitude }}, {{ $accident->longitude }}</div>
                    </div>
                    <div id="accidentMap" style="height: 250px; background: #eee; border-radius: 5px;" class="mb-3"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary text-right">معلومات المريض</h6>
                </div>
                <div class="card-body text-right">
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">اسم السائق:</div>
                        <div class="col-sm-8">{{ $accident->user->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">رقم الاتصال:</div>
                        <div class="col-sm-8">
                            <a href="tel:{{ $accident->user->phone }}">{{ $accident->user->phone }}</a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">المركبة:</div>
                        <div class="col-sm-8">
                            {{ $accident->vehicle->plate_number }} ({{ $accident->vehicle->type == 'car' ? 'سيارة' : 'دراجة نارية' }})
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary text-right">لوحة الاستجابة</h6>
                </div>
                <div class="card-body text-right">
                    <form method="POST" action="{{ route('medical-center.accidents.update-status', $accident->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="status">تحديث حالة الحالة</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="processing" {{ $accident->status == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                                <option value="resolved" {{ $accident->status == 'resolved' ? 'selected' : '' }}>تم الحل</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="notes">الملاحظات الطبية</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $accident->medical_center_notes) }}</textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> تحديث الحالة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Initialize map
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('accidentMap').setView([
            {{ $accident->latitude }}, 
            {{ $accident->longitude }}
        ], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Medical Center Marker
        L.marker([
            {{ $medicalCenter->latitude }}, 
            {{ $medicalCenter->longitude }}
        ]).addTo(map)
          .bindPopup('موقعك: {{ $medicalCenter->name }}')
          .openPopup();

        // Accident Marker
        L.marker([
            {{ $accident->latitude }}, 
            {{ $accident->longitude }}
        ]).addTo(map)
          .bindPopup('موقع الحادث');

        // Draw route between points
        L.polyline([
            [{{ $medicalCenter->latitude }}, {{ $medicalCenter->longitude }}],
            [{{ $accident->latitude }}, {{ $accident->longitude }}]
        ], {color: 'red'}).addTo(map);
    });
</script>
@endsection