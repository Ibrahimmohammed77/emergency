@extends('layouts.auth')

@section('content')
<div class="container" dir="rtl">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h3 class="fw-bold mb-0">
                        @if($type === 'user')
                            إعادة تعيين كلمة المرور
                        @else
                            إعادة تعيين كلمة المرور للمركز الصحي
                        @endif
                    </h3>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('password.update', ['type' => $type]) }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">البريد الإلكتروني</label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" style="text-align: right;">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">كلمة المرور الجديدة</label>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password" style="text-align: right;">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label fw-bold">تأكيد كلمة المرور</label>
                            <input id="password-confirm" type="password" class="form-control form-control-lg" 
                                   name="password_confirmation" required autocomplete="new-password" style="text-align: right;">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                إعادة تعيين كلمة المرور
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection