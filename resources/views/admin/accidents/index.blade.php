@extends('layouts.admin')

@section('title', 'إدارة الحوادث')

@section('content')
<div class="container-fluid" dir="rtl">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <!-- Card Header -->
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h3 class="card-title mb-0">جميع الحوادث</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.accidents.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus ms-1"></i> إضافة جديد
                        </a>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <!-- Status Filters -->
                    <div class="mb-4">
                        <div class="btn-group">
                            <a href="{{ route('admin.accidents.index') }}" 
                               class="btn btn-{{ !request('status') ? 'primary' : 'secondary' }}">
                                جميع الحوادث
                            </a>
                            <a href="{{ route('admin.accidents.index', ['status' => 'pending']) }}" 
                               class="btn btn-{{ request('status') === 'pending' ? 'primary' : 'secondary' }}">
                                معلقة
                            </a>
                            <a href="{{ route('admin.accidents.index', ['status' => 'processing']) }}" 
                               class="btn btn-{{ request('status') === 'processing' ? 'primary' : 'secondary' }}">
                                قيد المعالجة
                            </a>
                            <a href="{{ route('admin.accidents.index', ['status' => 'resolved']) }}" 
                               class="btn btn-{{ request('status') === 'resolved' ? 'primary' : 'secondary' }}">
                                مغلقة
                            </a>
                        </div>
                    </div>

                    <!-- Accidents Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>رقم</th>
                                    <th>المستخدم</th>
                                    <th>المركبة</th>
                                    <th>الموقع</th>
                                    <th>المركز الطبي</th>
                                    <th>التاريخ</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($accidents as $accident)
                                <tr>
                                    <td>{{ $accident->id }}</td>
                                    <td>{{ $accident->user->name }}</td>
                                    <td>{{ $accident->vehicle->plate_number ?? 'غير متاح' }}</td>
                                    <td>{{ Str::limit($accident->location_description, 30) }}</td>
                                    <td>{{ $accident->medicalCenter->name ?? 'غير متاح' }}</td>
                                    <td>{{ $accident->created_at->translatedFormat('d/m/Y H:i') }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'processing' => 'info',
                                                'resolved' => 'success'
                                            ];
                                            $statusLabels = [
                                                'pending' => 'معلقة',
                                                'processing' => 'قيد المعالجة',
                                                'resolved' => 'مغلقة'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$accident->status] ?? 'secondary' }} text-uppercase">
                                            {{ $statusLabels[$accident->status] ?? $accident->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.accidents.show', $accident->id) }}" 
                                               class="btn btn-sm btn-info" title="عرض">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.accidents.edit', $accident->id) }}" 
                                               class="btn btn-sm btn-warning" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">لا توجد حوادث مسجلة</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="card-footer">
                    {{ $accidents->links('pagination::bootstrap-5') }}
                </div>
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
    .btn-group > .btn:not(:first-child) {
        margin-right: -1px;
        margin-left: 0;
        border-radius: 0.25rem 0 0 0.25rem;
    }
    .btn-group > .btn:not(:last-child) {
        border-radius: 0 0.25rem 0.25rem 0;
    }
    .card-header {
        padding-right: 1.25rem;
    }
    .ms-1 {
        margin-right: 0.25rem !important;
        margin-left: 0 !important;
    }
    .pagination {
        justify-content: center;
    }
    .page-item:not(:first-child) .page-link {
        margin-right: -1px;
        margin-left: 0;
    }
</style>
@endpush