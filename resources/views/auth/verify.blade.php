@extends('layouts.auth')

@section('content')
<div class="container" dir="rtl">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h3 class="fw-bold mb-0">تحقق من بريدك الإلكتروني</h3>
                </div>

                <div class="card-body p-4 text-center">
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success mb-4">
                            تم إرسال رابط تحقق جديد إلى بريدك الإلكتروني.
                        </div>
                    @endif

                    <p class="mb-4">قبل المتابعة، يرجى التحقق من بريدك الإلكتروني للحصول على رابط التحقق.</p>
                    <p class="mb-4">إذا لم تستلم البريد الإلكتروني،</p>

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            انقر هنا لطلب رابط آخر
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger">
                            تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection