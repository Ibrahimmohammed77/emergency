@extends('layouts.medical-center')

@section('content')
<div class="container" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0 text-right">الرد على الحادث رقم #{{ $accident->id }}</h3>
                </div>

                <div class="card-body text-right">
                    <form method="POST" action="{{ route('medical-center.accidents.update-status', $accident->id) }}">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="status" class="fw-bold">حالة الاستجابة</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="processing">قيد المعالجة</option>
                                <option value="resolved">تم الحل</option>
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label for="notes" class="fw-bold">الملاحظات الطبية</label>
                            <textarea name="notes" id="notes" class="form-control" rows="6" required
                                      placeholder="أدخل تفاصيل عن الاستجابة الطبية والعلاجات المقدمة وأي توصيات للمتابعة..."></textarea>
                        </div>

                        <div class="form-group d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-paper-plane ms-2"></i> إرسال الرد
                            </button>
                            <a href="{{ route('medical-center.accidents.show', $accident->id) }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times ms-2"></i> إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection