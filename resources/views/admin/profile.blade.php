@extends('layouts.admin')

@section('content')
<div class="container-fluid" dir="rtl">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 text-right">الملف الشخصي للمسؤول</h1>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-body text-center">
                    <img class="img-profile rounded-circle mb-3" 
                         src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&background=random" 
                         width="150" height="150">
                    <h4>{{ $admin->name }}</h4>
                    <p class="text-muted mb-1">
                        @if($admin->role == 'super_admin')
                            مدير عام
                        @elseif($admin->role == 'admin')
                            مسؤول
                        @else
                            {{ ucfirst(str_replace('_', ' ', $admin->role)) }}
                        @endif
                    </p>
                    <p class="text-muted mb-4">{{ $admin->email }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold text-right">معلومات الملف الشخصي</h6>
                </div>
                <div class="card-body text-right">
                    <form method="POST" action="{{ route('admin.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">الاسم</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name', $admin->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">البريد الإلكتروني</label>
                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email', $admin->email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="current_password" class="col-md-4 col-form-label text-md-end">كلمة المرور الحالية</label>
                            <div class="col-md-8">
                                <input id="current_password" type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       name="current_password">
                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="new_password" class="col-md-4 col-form-label text-md-end">كلمة المرور الجديدة</label>
                            <div class="col-md-8">
                                <input id="new_password" type="password" 
                                       class="form-control @error('new_password') is-invalid @enderror" 
                                       name="new_password">
                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="new_password_confirmation" class="col-md-4 col-form-label text-md-end">تأكيد كلمة المرور</label>
                            <div class="col-md-8">
                                <input id="new_password_confirmation" type="password" class="form-control" 
                                       name="new_password_confirmation">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save ms-2"></i> تحديث الملف
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection