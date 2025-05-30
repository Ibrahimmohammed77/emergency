@extends('layouts.admin')

@section('title', 'تفاصيل الحادث')

@section('content')
<div class="container-fluid" dir="rtl">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <!-- Card Header -->
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h3 class="card-title mb-0 text-right">تقرير الحادث #{{ $accident->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.accidents.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-right ms-1"></i> رجوع
                        </a>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body text-right">
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <h4 class="text-primary">المعلومات الأساسية</h4>
                            <table class="table table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th>رقم التقرير</th>
                                        <td>{{ $accident->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>تم الإبلاغ بواسطة</th>
                                        <td>{{ $accident->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>الهاتف</th>
                                        <td>{{ $accident->user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>تاريخ الإبلاغ</th>
                                        <td>{{ $accident->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>الحالة</th>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'pending' => 'warning',
                                                    'processing' => 'info',
                                                    'resolved' => 'success',
                                                ];
                                            @endphp
                                            <span class="badge bg-{{ $statusColors[$accident->status] ?? 'secondary' }} text-uppercase">
                                                @if($accident->status == 'pending')
                                                    قيد الانتظار
                                                @elseif($accident->status == 'processing')
                                                    قيد المعالجة
                                                @else
                                                    تم الحل
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    @if ($accident->resolved_at)
                                        <tr>
                                            <th>تم الحل في</th>
                                            <td>{{ $accident->resolved_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Accident Details -->
                        <div class="col-md-6">
                            <h4 class="text-primary">تفاصيل الحادث</h4>
                            <table class="table table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th>المركبة</th>
                                        <td>{{ $accident->vehicle->plate_number ?? 'غير متاح' }}</td>
                                    </tr>
                                    <tr>
                                        <th>المركز الطبي</th>
                                        <td>{{ $accident->medicalCenter->name ?? 'غير متاح' }}</td>
                                    </tr>
                                    <tr>
                                        <th>الموقع</th>
                                        <td>{{ $accident->location_description }}</td>
                                    </tr>
                                    <tr>
                                        <th>الإحداثيات</th>
                                        <td>{{ $accident->latitude }}, {{ $accident->longitude }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Admin Notes and Map -->
                    <div class="row mt-4">
                        <!-- Admin Notes -->
                        <div class="col-md-6">
                            <h4 class="text-primary">ملاحظات المسؤول</h4>
                            <div class="card">
                                <div class="card-body">
                                    {{ $accident->admin_notes ?? 'لا توجد ملاحظات متاحة' }}
                                </div>
                            </div>
                        </div>

                        <!-- Location Map -->
                        <div class="col-md-6">
                            <h4 class="text-primary">خريطة الموقع</h4>
                            <div id="map" style="height: 300px; width: 100%; border-radius: 0.5rem;"></div>
                        </div>
                    </div>

                    <!-- Emergency Alerts -->
                    @if ($accident->smsNotifications->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h4 class="text-primary">تنبيهات الطوارئ</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>أرسلت إلى</th>
                                                <th>الرسالة</th>
                                                <th>الحالة</th>
                                                <th>وقت الإرسال</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($accident->smsNotifications as $notification)
                                                <tr>
                                                    <td>{{ $notification->recipient_number }}</td>
                                                    <td>{{ Str::limit($notification->message, 100) }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $notification->status === 'sent' ? 'success' : 'warning' }} text-uppercase">
                                                            @if($notification->status === 'sent')
                                                                تم الإرسال
                                                            @else
                                                                معلق
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Card Footer -->
                <div class="card-footer">
                    <form action="{{ route('admin.accidents.update-status', $accident->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <select name="status" class="form-select">
                                    <option value="pending" {{ $accident->status === 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                    <option value="processing" {{ $accident->status === 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                                    <option value="resolved" {{ $accident->status === 'resolved' ? 'selected' : '' }}>تم الحل</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="admin_notes" class="form-control" placeholder="إضافة ملاحظات التحديث..." value="{{ $accident->admin_notes }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save ms-1"></i> تحديث
                                </button>
                            </div>
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
    function initMap() {
        const location = {
            lat: {{ $accident->latitude }},
            lng: {{ $accident->longitude }}
        };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: location,
        });
        new google.maps.Marker({
            position: location,
            map: map,
            title: "موقع الحادث"
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_key') }}&callback=initMap" async defer></script>
@endsection