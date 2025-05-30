@extends('layouts.user')

@section('content')
<div class="container" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>تقارير الحوادث</span>
                    <a href="#" class="btn btn-sm btn-outline-primary disabled">
                        <i class="fas fa-history"></i> السجل
                    </a>
                </div>

                <div class="card-body">
                    @if($accidents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>التاريخ</th>
                                        <th>المركبة</th>
                                        <th>الموقع</th>
                                        <th>المركز الطبي</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($accidents as $accident)
                                    <tr>
                                        <td>{{ $accident->created_at->translatedFormat('Y-m-d H:i') }}</td>
                                        <td>{{ $accident->vehicle->plate_number }}</td>
                                        <td>{{ Str::limit($accident->location_description, 25) }}</td>
                                        <td>{{ $accident->medicalCenter->name ?? 'غير محدد' }}</td>
                                        <td>
                                            <span class="badge bg-{{ 
                                                $accident->status == 'resolved' ? 'success' : 
                                                ($accident->status == 'processing' ? 'warning' : 'danger') 
                                            }}">
                                                @if($accident->status == 'resolved')
                                                    تم الحل
                                                @elseif($accident->status == 'processing')
                                                    قيد المعالجة
                                                @else
                                                    غير محلول
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('user.accidents.show', $accident->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> التفاصيل
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $accidents->links() }}
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            لا توجد تقارير حوادث. ستظهر جميع الحوادث التي تم الإبلاغ عنها هنا.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-responsive {
        direction: rtl;
    }
    .table th, .table td {
        text-align: right;
    }
    .btn-sm i {
        margin-left: 3px;
    }
    .card-header {
        padding-right: 1.25rem;
    }
    body {
        font-family: 'Tahoma', 'Arial', sans-serif;
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