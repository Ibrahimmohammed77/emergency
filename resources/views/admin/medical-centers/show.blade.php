@extends('layouts.admin')

@section('content')
<div class="container-fluid" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-hospital ms-2"></i> تفاصيل المركز الطبي
        </h1>
        <div>
            <a href="{{ route('admin.medical-centers.edit', $center->id) }}" class="btn btn-warning">
                <i class="fas fa-edit ms-1"></i> تعديل
            </a>
            <a href="{{ route('admin.medical-centers.index') }}" class="btn btn-secondary">
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
                            <th width="30%">اسم المركز</th>
                            <td>{{ $center->name }}</td>
                        </tr>
                        <tr>
                            <th>البريد الإلكتروني</th>
                            <td>{{ $center->email }}</td>
                        </tr>
                        <tr>
                            <th>رقم الهاتف</th>
                            <td>{{ $center->phone }}</td>
                        </tr>
                        <tr>
                            <th>التخصص</th>
                            <td>{{ $center->specialization }}</td>
                        </tr>
                        <tr>
                            <th>العنوان</th>
                            <td>{{ $center->address }}</td>
                        </tr>
                        <tr>
                            <th>الحالة</th>
                            <td>
                                <span class="badge bg-{{ $center->status == 'active' ? 'success' : 'warning' }}">
                                    {{ $center->status == 'active' ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>تاريخ الإضافة</th>
                            <td>{{ $center->created_at->format('Y/m/d H:i') }}</td>
                        </tr>
                        <tr>
                            <th>آخر تحديث</th>
                            <td>{{ $center->updated_at->format('Y/m/d H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4 text-center">
                    <div class="profile-image-container mb-3">
                        @if($center->logo)
                            <img src="{{ Storage::url($center->logo) }}" 
                                 alt="شعار المركز" class="img-thumbnail" 
                                 style="width: 200px; height: 200px; object-fit: cover;">
                        @else
                            <img src="{{ asset('images/default-medical-center.png') }}" 
                                 alt="شعار المركز" class="img-thumbnail" 
                                 style="width: 200px; height: 200px; object-fit: cover;">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection