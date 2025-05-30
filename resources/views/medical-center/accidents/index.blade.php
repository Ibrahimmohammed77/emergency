@extends('layouts.medical-center')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 text-right">جميع حالات الطوارئ</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                تصفية حسب الحالة
            </button>
            <ul class="dropdown-menu dropdown-menu-start">
                <li><a class="dropdown-item" href="?status=pending">قيد الانتظار</a></li>
                <li><a class="dropdown-item" href="?status=processing">قيد المعالجة</a></li>
                <li><a class="dropdown-item" href="?status=resolved">تم الحل</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('medical-center.accidents') }}">عرض الكل</a></li>
            </ul>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-right" id="accidentsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>رقم الحالة</th>
                            <th>السائق</th>
                            <th>رقم الاتصال</th>
                            <th>المركبة</th>
                            <th>الموقع</th>
                            <th>وقت الاستلام</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accidents as $accident)
                        <tr>
                            <td>#{{ $accident->id }}</td>
                            <td>{{ $accident->user->name }}</td>
                            <td>{{ $accident->user->phone }}</td>
                            <td>{{ $accident->vehicle->plate_number }}</td>
                            <td>{{ Str::limit($accident->location_description, 20) }}</td>
                            <td>{{ $accident->created_at->format('M d, H:i') }}</td>
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
                                <a href="{{ route('medical-center.accidents.show', $accident->id) }}" 
                                   class="btn btn-sm btn-primary">
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

@section('scripts')
<script>
    $(document).ready(function() {
        $('#accidentsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json'
            },
            order: [[5, 'desc']]
        });
    });
</script>
@endsection