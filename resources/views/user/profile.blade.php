@extends('layouts.user')

@section('content')
<div class="container" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white py-3 text-right">
                    <h4 class="fw-bold mb-0">ملفي الشخصي</h4>
                </div>

                <div class="card-body p-4">
                    <!-- Success Alert -->
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show text-right" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.profile.update') }}" id="profileForm">
                        @csrf
                        @method('PUT')

                        <!-- Name Field -->
                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end fw-bold">الاسم</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end fw-bold">البريد الإلكتروني</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone Field -->
                        <div class="mb-3 row">
                            <label for="phone" class="col-md-4 col-form-label text-md-end fw-bold">الهاتف</label>
                            <div class="col-md-6">
                                <input id="phone" type="tel" class="form-control form-control-lg @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->phone) }}" required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Current Password Field -->
                        <div class="mb-3 row">
                            <label for="current_password" class="col-md-4 col-form-label text-md-end fw-bold">كلمة المرور الحالية</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="current_password" type="password" class="form-control form-control-lg @error('current_password') is-invalid @enderror" name="current_password" style="border-radius: 0 0.375rem 0.375rem 0 !important;">
                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#current_password" style="border-radius: 0.375rem 0 0 0.375rem !important; border-right: 1px solid #ced4da !important; border-left: none !important;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- New Password Field -->
                        <div class="mb-3 row">
                            <label for="new_password" class="col-md-4 col-form-label text-md-end fw-bold">كلمة المرور الجديدة</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="new_password" type="password" class="form-control form-control-lg @error('new_password') is-invalid @enderror" name="new_password" style="border-radius: 0 0.375rem 0.375rem 0 !important;">
                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#new_password" style="border-radius: 0.375rem 0 0 0.375rem !important; border-right: 1px solid #ced4da !important; border-left: none !important;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-3 row">
                            <label for="new_password_confirmation" class="col-md-4 col-form-label text-md-end fw-bold">تأكيد كلمة المرور</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input id="new_password_confirmation" type="password" class="form-control form-control-lg" name="new_password_confirmation" style="border-radius: 0 0.375rem 0.375rem 0 !important;">
                                    <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#new_password_confirmation" style="border-radius: 0.375rem 0 0 0.375rem !important; border-right: 1px solid #ced4da !important; border-left: none !important;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    تحديث الملف الشخصي
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const target = document.querySelector(this.getAttribute('data-target'));
            if (target.type === 'password') {
                target.type = 'text';
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                target.type = 'password';
                this.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
    });
</script>
@endsection