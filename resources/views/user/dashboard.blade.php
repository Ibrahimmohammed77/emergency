@extends('layouts.user')

@section('content')
<div class="container" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white py-3 text-right">
                    <h4 class="fw-bold mb-0">لوحة التحكم</h4>
                </div>

                <div class="card-body p-4">
                    <!-- Success Alert -->
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show text-right" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
                        </div>
                    @endif

                    <!-- Quick Stats -->
                    <div class="row mb-4">
                        <!-- Registered Vehicles -->
                        <div class="col-md-4">
                            <div class="card text-white bg-primary shadow-sm h-100">
                                <div class="card-body d-flex flex-column justify-content-between text-right">
                                    <div>
                                        <h5 class="card-title">المركبات المسجلة</h5>
                                        <p class="card-text display-4">{{ $user->vehicles_count }}</p>
                                    </div>
                                    <a href="{{ route('user.vehicles.index') }}" class="text-white text-decoration-none">
                                        <i class="fas fa-arrow-left me-2"></i> عرض المركبات
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Accident Reports -->
                        <div class="col-md-4">
                            <div class="card text-white bg-success shadow-sm h-100">
                                <div class="card-body d-flex flex-column justify-content-between text-right">
                                    <div>
                                        <h5 class="card-title">تقارير الحوادث</h5>
                                        <p class="card-text display-4">{{ $user->accidents_count }}</p>
                                    </div>
                                    <a href="{{ route('user.accidents.index') }}" class="text-white text-decoration-none">
                                        <i class="fas fa-arrow-left me-2"></i> عرض السجل
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Requests -->
                        <div class="col-md-4">
                            <div class="card text-white bg-danger shadow-sm h-100">
                                <div class="card-body d-flex flex-column justify-content-between text-right">
                                    <div>
                                        <h5 class="card-title">طلبات الطوارئ</h5>
                                        <p class="card-text display-4">0</p>
                                    </div>
                                    <a href="{{ route('user.emergency-requests.index') }}" class="text-white text-decoration-none">
                                        <i class="fas fa-arrow-left me-2"></i> طلب مساعدة
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Accidents -->
                    <div class="card shadow-sm border-0 rounded-lg mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-3">
                            <h5 class="fw-bold mb-0 text-right">آخر الحوادث</h5>
                            <a href="{{ route('user.accidents.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i> عرض الكل
                            </a>
                        </div>
                        <div class="card-body">
                            @if($recentAccidents->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered text-right">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">التاريخ</th>
                                                <th scope="col">المركبة</th>
                                                <th scope="col">الموقع</th>
                                                <th scope="col">الحالة</th>
                                                <th scope="col">الإجراءات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentAccidents as $accident)
                                                <tr>
                                                    <td>{{ $accident->created_at->format('M d, Y H:i') }}</td>
                                                    <td>{{ $accident->vehicle?->plate_number ?? 'غير متاح' }}</td>
                                                    <td>{{ Str::limit($accident->location_description, 30) }}</td>
                                                    <td>
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
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('user.accidents.show', $accident->id) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye" aria-hidden="true"></i>
                                                            <span class="visually-hidden">عرض التفاصيل</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info text-center">
                                    <i class="fas fa-info-circle me-2"></i>لا توجد سجلات حوادث
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection