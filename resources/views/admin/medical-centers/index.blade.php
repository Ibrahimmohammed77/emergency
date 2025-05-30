@extends('layouts.admin')

@section('content')
<div class="container-fluid" dir="rtl">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 text-right">المراكز الطبية</h1>
        <a href="{{ route('admin.medical-centers.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 ms-2"></i> إضافة مركز جديد
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-right" id="medicalCentersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>الهاتف</th>
                            <th>التخصص</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($centers as $center)
                        <tr>
                            <td>{{ $center->name }}</td>
                            <td>{{ $center->email }}</td>
                            <td>{{ $center->phone }}</td>
                            <td>{{ $center->specialization }}</td>
                            <td>
                                <span class="badge bg-{{ $center->status == 'active' ? 'success' : 'warning' }}">
                                    {{ $center->status == 'active' ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.medical-centers.show', $center->id) }}" 
                                       class="btn btn-info" title="عرض التفاصيل">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.medical-centers.edit', $center->id) }}" 
                                       class="btn btn-warning" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.medical-centers.update-status', $center->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="{{ $center->status == 'active' ? 'inactive' : 'active' }}">
                                        <button type="submit" class="btn btn-{{ $center->status == 'active' ? 'danger' : 'success' }}" 
                                                title="{{ $center->status == 'active' ? 'تعطيل' : 'تفعيل' }}"
                                                onclick="return confirm('هل أنت متأكد من تغيير حالة المركز؟')">
                                            <i class="fas fa-{{ $center->status == 'active' ? 'times' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.medical-centers.destroy', $center->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" 
                                                title="حذف"
                                                onclick="return confirm('هل أنت متأكد من حذف هذا المركز؟')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
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
        $('#medicalCentersTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/ar.json'
            },
            columnDefs: [
                { orderable: false, targets: [5] }
            ]
        });
    });
</script>
@endsection