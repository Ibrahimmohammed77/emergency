@extends('layouts.medical-center')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4 text-right">لوحة تحكم المركز الطبي</h1>
    
    <!-- Stats Cards -->
    <div class="row mt-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                        <div class="col mr-2 text-right">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                حوادث قيد الانتظار</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_accidents'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <i class="fas fa-ambulance fa-2x text-gray-300"></i>
                        </div>
                        <div class="col mr-2 text-right">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                حالات قيد المعالجة</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['processing_accidents'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                        <div class="col mr-2 text-right">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                حالات تم حلها</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['resolved_accidents'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Accidents -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary text-right">حالات الطوارئ النشطة</h6>
            <a href="{{ route('medical-center.accidents') }}" class="btn btn-sm btn-primary">عرض الكل</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-right" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>رقم الحالة</th>
                            <th>السائق</th>
                            <th>المركبة</th>
                            <th>الموقع</th>
                            <th>وقت الاستلام</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activeAccidents as $accident)
                        <tr>
                            <td>#{{ $accident->id }}</td>
                            <td>{{ $accident->user->name }}</td>
                            <td>{{ $accident->vehicle->plate_number }}</td>
                            <td>{{ Str::limit($accident->location_description, 20) }}</td>
                            <td>{{ $accident->created_at->diffForHumans() }}</td>
                            <td>
                                <span class="badge bg-{{ $accident->status == 'processing' ? 'warning' : 'danger' }}">
                                    @if($accident->status == 'processing')
                                        قيد المعالجة
                                    @else
                                        قيد الانتظار
                                    @endif
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('medical-center.accidents.show', $accident->id) }}" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> الرد
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

<script>
    $(document).ready(function() {
        // Initialize DataTable with RTL support
        $('table').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json'
            }
        });
    });
</script>
@endsection