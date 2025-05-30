@extends('layouts.auth')

@section('content')
<div class="container" dir="rtl">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h3 class="fw-bold mb-0">تسجيل الدخول</h3>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">البريد الإلكتروني</label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="أدخل بريدك الإلكتروني">
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
                                <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="أدخل كلمة المرور">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#password">
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
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
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
                        {{-- <div class="text-center mt-3">
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none text-primary fw-bold" href="{{ route('password.request') }}">
                                    نسيت كلمة المرور؟
                                </a>
                            @endif
                        </div> --}}
                    </form>
                </div>
            </div>
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
    .input-group > .form-control {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }
    .input-group > .btn {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }
    .form-check-input {
        margin-right: 0;
        margin-left: 0.5em;
    }
    .invalid-feedback {
        text-align: right;
    }
    .toggle-password {
        border-right: none;
        border-left: 1px solid #ced4da;
    }
</style>
@endpush

@push('scripts')
<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const target = document.querySelector(this.getAttribute('data-target'));
            const icon = this.querySelector('i');
            if (target.type === 'password') {
                target.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                target.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });
</script>
@endpush