@extends('layouts.admin')

@section('content')
<div class="container-fluid" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user ms-2"></i> تفاصيل المستخدم
        </h1>
        <div>
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                <i class="fas fa-edit ms-1"></i> تعديل
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-right ms-1"></i> رجوع
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-info-circle ms-2"></i> المعلومات الأساسية
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">الاسم الكامل</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>البريد الإلكتروني</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>رقم الهاتف</th>
                            <td>{{ $user->phone ?? 'غير متوفر' }}</td>
                        </tr>
                        <tr>
                            <th>الحالة</th>
                            <td>
                                <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'danger' }}">
                                    {{ $user->status == 'active' ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>تاريخ التسجيل</th>
                            <td>{{ $user->created_at->format('Y/m/d H:i') }}</td>
                        </tr>
                        <tr>
                            <th>آخر تحديث</th>
                            <td>{{ $user->updated_at->format('Y/m/d H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4 text-center">
                    <div class="profile-image-container mb-3">
                        <img src="{{ asset('images/default-user.png') }}" 
                             alt="صورة المستخدم" class="img-thumbnail rounded-circle" 
                             style="width: 200px; height: 200px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-car ms-2"></i> المركبات المسجلة
            </h6>
        </div>
        <div class="card-body">
            @if($user->vehicles->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نوع المركبة</th>
                                <th>الموديل</th>
                                <th>رقم اللوحة</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->vehicles as $vehicle)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $vehicle->type }}</td>
                                <td>{{ $vehicle->model }}</td>
                                <td>{{ $vehicle->plate_number }}</td>
                                <td>
                                    <span class="badge bg-{{ $vehicle->status == 'active' ? 'success' : 'danger' }}">
                                        {{ $vehicle->status == 'active' ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    لا توجد مركبات مسجلة لهذا المستخدم
                </div>
            @endif
        </div>
    </div>
</div>
@endsection