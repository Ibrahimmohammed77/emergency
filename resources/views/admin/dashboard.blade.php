@extends('layouts.admin')

@section('content')
<div class="container-fluid" dir="rtl">
    <h1 class="mt-4">لوحة التحكم</h1>
    
    <!-- Stats Cards -->
    <div class="row mt-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                إجمالي المستخدمين</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_users'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                المراكز الطبية النشطة</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active_centers'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hospital fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                الحوادث المعلقة</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_accidents'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-car-crash fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                الحوادث المغلقة</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['resolved_accidents'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Accidents -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">أحدث الحوادث</h6>
            <a href="{{ route('admin.accidents.index') }}" class="btn btn-sm btn-primary">عرض الكل</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>رقم</th>
                            <th>المركبة</th>
                            <th>الموقع</th>
                            <th>المركز الطبي</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentAccidents as $accident)
                        <tr>
                            <td>{{ $accident->id }}</td>
                            <td>{{ $accident->vehicle->plate_number }}</td>
                            <td>{{ Str::limit($accident->location_description, 30) }}</td>
                            <td>{{ $accident->medicalCenter->name ?? 'غير محدد' }}</td>
                            <td>
                                <span class="badge bg-{{ $accident->status == 'resolved' ? 'success' : ($accident->status == 'processing' ? 'warning' : 'danger') }}">
                                    @if($accident->status == 'resolved')
                                        تم الحل
                                    @elseif($accident->status == 'processing')
                                        قيد المعالجة
                                    @else
                                        معلق
                                    @endif
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.accidents.show', $accident->id) }}" class="btn btn-sm btn-info" title="عرض التفاصيل">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        font-family: 'Tahoma', 'Arial', sans-serif;
    }
    .table-responsive {
        direction: rtl;
    }
    .table th, .table td {
        text-align: right;
    }
    .card-header {
        padding-right: 1.25rem;
    }
    .text-xs {
        font-size: 0.8rem;
    }
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
    .col-auto {
        padding-left: 0;
        padding-right: 15px;
    }
    .mr-2 {
        margin-right: 0.5rem !important;
        margin-left: 0 !important;
    }
</style>
@endpush