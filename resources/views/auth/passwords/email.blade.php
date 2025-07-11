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
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email', ['type' => $type]) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">البريد الإلكتروني</label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" style="text-align: right;">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                إرسال رابط إعادة التعيين
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-light text-center py-3">
                    <p class="mb-0">تذكرت كلمة المرور؟ <a href="{{ route('login') }}" class="text-primary fw-bold">تسجيل الدخول</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection