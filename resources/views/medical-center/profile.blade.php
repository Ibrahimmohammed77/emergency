@extends('layouts.medical-center')

@section('content')
<div class="container" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-right">
                    <h3 class="mb-0">الملف الشخصي للمركز الطبي</h3>
                </div>

                <div class="card-body text-right">
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
                        </div>
                    @endif

                    <!-- Profile Update Form -->
                    <form method="POST" action="{{ route('medical-center.profile.update') }}">
                        @csrf
                        @method("put")

                        <!-- Medical Center Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم المركز الطبي</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name', $medicalCenter->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email', $medicalCenter->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">رقم الهاتف</label>
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   name="phone" value="{{ old('phone', $medicalCenter->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">العنوان</label>
                            <textarea id="address" class="form-control @error('address') is-invalid @enderror" 
                                      name="address" rows="3" required>{{ old('address', $medicalCenter->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Specialization -->
                        <div class="mb-3">
                            <label for="specialization" class="form-label">التخصص</label>
                            <input id="specialization" type="text" class="form-control @error('specialization') is-invalid @enderror" 
                                   name="specialization" value="{{ old('specialization', $medicalCenter->specialization) }}" required>
                            @error('specialization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Latitude and Longitude -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">خط العرض</label>
                                <input id="latitude" type="number" step="0.000001" 
                                       class="form-control @error('latitude') is-invalid @enderror" 
                                       name="latitude" value="{{ old('latitude', $medicalCenter->latitude) }}" required>
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="longitude" class="form-label">خط الطول</label>
                                <input id="longitude" type="number" step="0.000001" 
                                       class="form-control @error('longitude') is-invalid @enderror" 
                                       name="longitude" value="{{ old('longitude', $medicalCenter->longitude) }}" required>
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label">كلمة المرور الحالية (اتركها فارغة إذا لم ترد التغيير)</label>
                            <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="new_password" class="form-label">كلمة المرور الجديدة</label>
                            <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                   name="new_password">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">تأكيد كلمة المرور الجديدة</label>
                            <input id="new_password_confirmation" type="password" class="form-control" 
                                   name="new_password_confirmation">
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save ms-2"></i> تحديث الملف الشخصي
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection