@extends('layouts.auth')

@section('content')
    <div class="container" dir="rtl">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6">
                <div class="card shadow-lg border-0 rounded-lg">
                    <!-- Card Header -->
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h3 class="fw-bold mb-0">تسجيل الدخول</h3>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- User Type Selection -->
                            <div class="mb-3">
                                <label for="user_type" class="form-label fw-bold">أنا</label>
                                <select id="user_type"
                                    class="form-select form-select-lg @error('user_type') is-invalid @enderror"
                                    name="user_type" required autofocus style="text-align: right;">
                                    <option value="">اختر نوع المستخدم</option>
                                    <option value="user" {{ old('user_type') == 'user' ? 'selected' : '' }}>مستخدم عادي
                                    </option>
                                    <option value="medical_center"
                                        {{ old('user_type') == 'medical_center' ? 'selected' : '' }}>مركز طبي</option>
                                </select>
                                @error('user_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">البريد الإلكتروني</label>
                                <input id="email" type="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" style="text-align: right;">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">كلمة المرور</label>
                                <div class="input-group">
                                    <input id="password" type="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="current-password"
                                        style="text-align: right; border-radius: 0 0.25rem 0.25rem 0 !important;">
                                    <button type="button" class="btn btn-outline-secondary toggle-password"
                                        data-target="#password"
                                        style="border-radius: 0.25rem 0 0 0.25rem !important; border-right: 1px solid #ced4da !important; border-left: none !important;">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3 form-check" style="text-align: right;">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }} style="margin-left: 0.5rem; margin-right: 0;">
                                <label class="form-check-label fw-bold" for="remember">
                                    تذكرني
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                    تسجيل الدخول
                                </button>
                            </div>

                            <!-- Forgot Password Link -->
                            <div class="text-center mt-3">
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none text-primary fw-bold"
                                        href="{{ route('password.request', ['type' => old('user_type', 'user')]) }}">
                                        نسيت كلمة المرور؟
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer bg-light text-center py-3">
                        <p class="mb-0">ليس لديك حساب؟ <a href="{{ route('register') }}" class="text-primary fw-bold">سجل
                                هنا</a></p>
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

        // Adjust RTL specific styles on load
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure all form controls are right-aligned
            document.querySelectorAll('.form-control, .form-select').forEach(element => {
                element.style.textAlign = 'right';
            });

            // Adjust checkboxes position
            document.querySelectorAll('.form-check-input').forEach(checkbox => {
                checkbox.style.marginLeft = '0.5rem';
                checkbox.style.marginRight = '0';
            });
        });
    </script>
@endsection
