{{-- @extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h3 class="fw-bold mb-0">{{ __('Register') }}</h3>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf

                        <!-- User Type Selection -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('Register As') }}</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="user_type" id="user_type_user" value="user" {{ old('user_type') == 'user' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="user_type_user">
                                        Regular User
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="user_type" id="user_type_medical_center" value="medical_center" {{ old('user_type') == 'medical_center' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="user_type_medical_center">
                                        Medical Center
                                    </label>
                                </div>
                            </div>
                            @error('user_type')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Common Fields -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">{{ __('Phone Number') }}</label>
                            <input id="phone" type="tel" class="form-control form-control-lg @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">{{ __('Password') }}</label>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
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

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label fw-bold">{{ __('Confirm Password') }}</label>
                            <div class="input-group">
                                <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required autocomplete="new-password">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#password-confirm">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Medical Center Specific Fields (Hidden by Default) -->
                        <div id="medical-center-fields" style="display: none;" class="mt-4">
                            <h5 class="fw-bold text-primary">Medical Center Details</h5>
                            <div class="mb-3">
                                <label for="address" class="form-label fw-bold">{{ __('Address') }}</label>
                                <textarea id="address" class="form-control form-control-lg @error('address') is-invalid @enderror" name="address">{{ old('address') }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="latitude" class="form-label fw-bold">{{ __('Latitude') }}</label>
                                    <input id="latitude" type="text" class="form-control form-control-lg @error('latitude') is-invalid @enderror" name="latitude" value="{{ old('latitude') }}">
                                    @error('latitude')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="longitude" class="form-label fw-bold">{{ __('Longitude') }}</label>
                                    <input id="longitude" type="text" class="form-control form-control-lg @error('longitude') is-invalid @enderror" name="longitude" value="{{ old('longitude') }}">
                                    @error('longitude')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="specialization" class="form-label fw-bold">{{ __('Specialization') }}</label>
                                <input id="specialization" type="text" class="form-control form-control-lg @error('specialization') is-invalid @enderror" name="specialization" value="{{ old('specialization') }}">
                                @error('specialization')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <button type="button" class="btn btn-outline-secondary btn-lg w-100" onclick="getCurrentLocation()">
                                    <i class="fas fa-location-arrow"></i> Use Current Location
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-light text-center py-3">
                    <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary fw-bold">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle medical center fields
    document.querySelectorAll('input[name="user_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const medicalCenterFields = document.getElementById('medical-center-fields');
            if (this.value === 'medical_center') {
                medicalCenterFields.style.display = 'block';
                ['address', 'latitude', 'longitude', 'specialization'].forEach(field => {
                    document.getElementById(field).required = true;
                });
            } else {
                medicalCenterFields.style.display = 'none';
                ['address', 'latitude', 'longitude', 'specialization'].forEach(field => {
                    document.getElementById(field).required = false;
                });
            }
        });
    });

    // Initialize display based on old input
    document.addEventListener('DOMContentLoaded', function() {
        const userType = '{{ old("user_type") }}';
        if (userType === 'medical_center') {
            document.getElementById('medical-center-fields').style.display = 'block';
        }
    });

    // Get current location
    function getCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    document.getElementById('latitude').value = position.coords.latitude.toFixed(6);
                    document.getElementById('longitude').value = position.coords.longitude.toFixed(6);
                },
                error => {
                    alert('Error getting location: ' + error.message);
                }
            );
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    }


</script>
@endsection --}}

@extends('layouts.auth')

@section('content')
<div class="container" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h3 class="fw-bold mb-0">تسجيل جديد</h3>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf

                        <!-- User Type Selection -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">التسجيل كـ</label>
                            <div class="d-flex gap-3" style="flex-direction: row-reverse;">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="user_type" id="user_type_user" value="user" {{ old('user_type') == 'user' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="user_type_user">
                                        مستخدم عادي
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="user_type" id="user_type_medical_center" value="medical_center" {{ old('user_type') == 'medical_center' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="user_type_medical_center">
                                        مركز طبي
                                    </label>
                                </div>
                            </div>
                            @error('user_type')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Common Fields -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">الاسم الكامل</label>
                            <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus style="text-align: right;">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">البريد الإلكتروني</label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" style="text-align: right;">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">رقم الهاتف</label>
                            <input id="phone" type="tel" class="form-control form-control-lg @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required style="text-align: right;">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">كلمة المرور</label>
                            <div class="input-group">
                                <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="text-align: right; border-radius: 0 0.25rem 0.25rem 0 !important;">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#password" style="border-radius: 0.25rem 0 0 0.25rem !important; border-right: 1px solid #ced4da !important; border-left: none !important;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label fw-bold">تأكيد كلمة المرور</label>
                            <div class="input-group">
                                <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" required autocomplete="new-password" style="text-align: right; border-radius: 0 0.25rem 0.25rem 0 !important;">
                                <button type="button" class="btn btn-outline-secondary toggle-password" data-target="#password-confirm" style="border-radius: 0.25rem 0 0 0.25rem !important; border-right: 1px solid #ced4da !important; border-left: none !important;">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Medical Center Specific Fields (Hidden by Default) -->
                        <div id="medical-center-fields" style="display: none;" class="mt-4">
                            <h5 class="fw-bold text-primary">تفاصيل المركز الطبي</h5>
                            <div class="mb-3">
                                <label for="address" class="form-label fw-bold">العنوان</label>
                                <textarea id="address" class="form-control form-control-lg @error('address') is-invalid @enderror" name="address" style="text-align: right;">{{ old('address') }}</textarea>
                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6" style="float: right;">
                                    <label for="latitude" class="form-label fw-bold">خط العرض</label>
                                    <input id="latitude" type="text" class="form-control form-control-lg @error('latitude') is-invalid @enderror" name="latitude" value="{{ old('latitude') }}" style="text-align: right;">
                                    @error('latitude')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6" style="float: right;">
                                    <label for="longitude" class="form-label fw-bold">خط الطول</label>
                                    <input id="longitude" type="text" class="form-control form-control-lg @error('longitude') is-invalid @enderror" name="longitude" value="{{ old('longitude') }}" style="text-align: right;">
                                    @error('longitude')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="specialization" class="form-label fw-bold">التخصص</label>
                                <input id="specialization" type="text" class="form-control form-control-lg @error('specialization') is-invalid @enderror" name="specialization" value="{{ old('specialization') }}" style="text-align: right;">
                                @error('specialization')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <button type="button" class="btn btn-outline-secondary btn-lg w-100" onclick="getCurrentLocation()">
                                    <i class="fas fa-location-arrow"></i> استخدام الموقع الحالي
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">
                                تسجيل
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-light text-center py-3">
                    <p class="mb-0">
                        هل لديك حساب بالفعل؟ 
                        <a href="{{ route('login') }}" class="text-primary fw-bold">سجل الدخول هنا</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle medical center fields
    document.querySelectorAll('input[name="user_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const medicalCenterFields = document.getElementById('medical-center-fields');
            if (this.value === 'medical_center') {
                medicalCenterFields.style.display = 'block';
                ['address', 'latitude', 'longitude', 'specialization'].forEach(field => {
                    document.getElementById(field).required = true;
                });
            } else {
                medicalCenterFields.style.display = 'none';
                ['address', 'latitude', 'longitude', 'specialization'].forEach(field => {
                    document.getElementById(field).required = false;
                });
            }
        });
    });

    // Initialize display based on old input
    document.addEventListener('DOMContentLoaded', function() {
        const userType = '{{ old("user_type") }}';
        if (userType === 'medical_center') {
            document.getElementById('medical-center-fields').style.display = 'block';
        }
        
        // Adjust RTL specific styles
        document.querySelectorAll('.form-control').forEach(input => {
            input.style.textAlign = 'right';
        });
        
        document.querySelectorAll('.input-group > .form-control').forEach(input => {
            input.style.borderRadius = '0 0.25rem 0.25rem 0';
        });
        
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.style.borderRadius = '0.25rem 0 0 0.25rem';
            button.style.borderRight = '1px solid #ced4da';
            button.style.borderLeft = 'none';
        });
    });

    // Get current location
    function getCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    document.getElementById('latitude').value = position.coords.latitude.toFixed(6);
                    document.getElementById('longitude').value = position.coords.longitude.toFixed(6);
                },
                error => {
                    alert('خطأ في الحصول على الموقع: ' + error.message);
                }
            );
        } else {
            alert('المتصفح لا يدعم خدمة تحديد الموقع');
        }
    }
</script>
@endsection