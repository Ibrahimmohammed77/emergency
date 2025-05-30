@extends('layouts.admin')

@section('content')
<div class="container-fluid" dir="rtl">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">إنشاء مدير جديد</h1>
        <a href="{{ route('admin.admins.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-right fa-sm text-white-50 ms-1"></i> رجوع
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.admins.store') }}">
                @csrf

                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-start">الاسم</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-start">البريد الإلكتروني</label>
                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="role" class="col-md-4 col-form-label text-md-start">الدور</label>
                    <div class="col-md-6">
                        <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مدير</option>
                            <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>مدير عام</option>
                        </select>
                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-start">كلمة المرور</label>
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-start">تأكيد كلمة المرور</label>
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            إنشاء مدير
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        font-family: 'Tahoma', 'Arial', sans-serif;
    }
    .form-control {
        text-align: right;
    }
    .card-header {
        padding-right: 1.25rem;
    }
    .ms-1 {
        margin-right: 0.25rem !important;
        margin-left: 0 !important;
    }
    .invalid-feedback {
        text-align: right;
    }
    .col-form-label {
        text-align: right !important;
    }
    .offset-md-4 {
        margin-right: 33.333333% !important;
        margin-left: 0 !important;
    }
</style>
@endpush