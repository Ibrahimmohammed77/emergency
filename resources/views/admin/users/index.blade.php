@extends('layouts.admin')

@section('content')
<div class="container-fluid" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users-cog ms-2"></i> إدارة المستخدمين
        </h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus ms-1"></i> مستخدم جديد
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-list ms-2"></i> قائمة المستخدمين
            </h6>
            <div class="input-group" style="width: 300px;">
                <input type="text" id="searchInput" class="form-control" placeholder="ابحث عن مستخدم...">
                <div class="input-group-append">
                    <button class="btn btn-light" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center" id="usersTable" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%">#</th>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>الهاتف</th>
                            <th width="8%">المركبات</th>
                            <th width="10%">الحالة</th>
                            <th width="18%">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?? 'غير متوفر' }}</td>
                            <td>
                                <span class="badge bg-info text-dark p-2">
                                    <i class="fas fa-car ms-1"></i> {{ $user->vehicles_count }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'danger' }} p-2">
                                    <i class="fas fa-{{ $user->status == 'active' ? 'check-circle' : 'times-circle' }} ms-1"></i>
                                    {{ $user->status == 'active' ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.users.show', $user->id) }}" 
                                       class="btn btn-info" title="عرض التفاصيل">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="btn btn-warning" title="تعديل">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.update-status', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="{{ $user->status == 'active' ? 'inactive' : 'active' }}">
                                        <button type="submit" class="btn btn-{{ $user->status == 'active' ? 'danger' : 'success' }}" 
                                                title="{{ $user->status == 'active' ? 'تعطيل' : 'تفعيل' }}"
                                                onclick="return confirm('هل أنت متأكد من تغيير حالة المستخدم؟')">
                                            <i class="fas fa-{{ $user->status == 'active' ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" 
                                                title="حذف"
                                                onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
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

@section('styles')
<style>
    body {
        font-family: 'Tajawal', sans-serif;
    }
    .table {
        text-align: right;
    }
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .btn-group .btn {
        border-radius: 0;
    }
    .btn-group .btn:first-child {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }
    .btn-group .btn:last-child {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }
    .ms-1 {
        margin-right: 0.25rem !important;
        margin-left: 0 !important;
    }
    .badge {
        font-size: 0.85rem;
        padding: 0.35em 0.65em;
    }
    .input-group-append {
        margin-right: -1px;
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var table = $('#usersTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json'
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            columnDefs: [
                { orderable: false, targets: [6] },
                { className: "text-center", targets: [0, 4, 5, 6] }
            ],
            responsive: true,
            initComplete: function() {
                $('.dataTables_filter input').attr('placeholder', 'ابحث...');
            }
        });

        // Custom search functionality
        $('#searchInput').keyup(function(){
            table.search($(this).val()).draw();
        });
    });
</script>
@endsection