@extends('layouts.user')

@section('content')
<div class="container" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-danger text-white text-right">
                    طلب مساعدة طارئة
                </div>

                <div class="card-body text-right">
                    <form method="POST" action="{{ route('user.emergency-request.store') }}">
                        @csrf

                        <div class="alert alert-warning text-right">
                            <i class="fas fa-exclamation-triangle ms-2"></i> يُرجى استخدام هذا النموذج للحالات الطارئة الحقيقية فقط.
                        </div>

                        <div class="row mb-3">
                            <label for="urgency_level" class="col-md-4 col-form-label text-md-end">مستوى الاستعجال</label>
                            <div class="col-md-6">
                                <select id="urgency_level" class="form-control @error('urgency_level') is-invalid @enderror" name="urgency_level" required>
                                    <option value="">اختر مستوى الاستعجال</option>
                                    <option value="low">منخفض</option>
                                    <option value="medium">متوسط</option>
                                    <option value="high">عالي</option>
                                    <option value="critical">حرج (يهدد الحياة)</option>
                                </select>
                                @error('urgency_level')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="message" class="col-md-4 col-form-label text-md-end">تفاصيل الطوارئ</label>
                            <div class="col-md-6">
                                <textarea id="message" class="form-control @error('message') is-invalid @enderror" name="message" rows="5" required placeholder="يرجى وصف حالة الطوارئ بالتفصيل...">{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="share_location" id="share_location" checked>
                                    <label class="form-check-label" for="share_location">
                                        مشاركة موقعي الحالي
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="location-fields" style="display: none;">
                            <div class="row mb-3">
                                <label for="latitude" class="col-md-4 col-form-label text-md-end">خط العرض</label>
                                <div class="col-md-6">
                                    <input id="latitude" type="text" class="form-control" name="latitude" value="{{ old('latitude') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="longitude" class="col-md-4 col-form-label text-md-end">خط الطول</label>
                                <div class="col-md-6">
                                    <input id="longitude" type="text" class="form-control" name="longitude" value="{{ old('longitude') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-danger btn-lg">
                                    <i class="fas fa-exclamation-triangle ms-2"></i> إرسال طلب الطوارئ
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
    document.addEventListener('DOMContentLoaded', function() {
        const shareLocationCheckbox = document.getElementById('share_location');
        const locationFields = document.getElementById('location-fields');

        shareLocationCheckbox.addEventListener('change', function() {
            locationFields.style.display = this.checked ? 'block' : 'none';
            
            if (this.checked && navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        document.getElementById('latitude').value = position.coords.latitude;
                        document.getElementById('longitude').value = position.coords.longitude;
                    },
                    error => {
                        console.error('Error getting location:', error);
                        alert('تعذر الحصول على موقعك. يرجى إدخاله يدويًا.');
                    }
                );
            }
        });

        // Trigger change event on page load if checkbox is checked
        if (shareLocationCheckbox.checked) {
            shareLocationCheckbox.dispatchEvent(new Event('change'));
        }
    });
</script>
@endsection