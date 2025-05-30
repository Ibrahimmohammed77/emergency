@extends('layouts.admin')

@section('title', 'تعديل حادث')

@section('content')
<div class="container-fluid" dir="rtl">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">تعديل الحادث رقم #{{ $accident->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.accidents.show', $accident->id) }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-right ms-1"></i> رجوع
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.accidents.update', $accident->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">الحالة</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="pending" {{ $accident->status === 'pending' ? 'selected' : '' }}>معلق</option>
                                        <option value="resolved" {{ $accident->status === 'resolved' ? 'selected' : '' }}>تم الحل</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="medical_center_id">المركز الطبي</label>
                                    <select name="medical_center_id" id="medical_center_id" class="form-control">
                                        <option value="">اختر مركز طبي</option>
                                        @foreach($medicalCenters as $center)
                                        <option value="{{ $center->id }}" 
                                            {{ $accident->medical_center_id == $center->id ? 'selected' : '' }}>
                                            {{ $center->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">وصف الحادث</label>
                            <textarea name="description" id="description" class="form-control" rows="5" style="text-align: right;">{{ $accident->description }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="notes">ملاحظات المسؤول</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3" style="text-align: right;">{{ $accident->notes }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer text-left">
                        <button type="submit" class="btn btn-primary">تحديث الحادث</button>
                    </div>
                </form>
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
    .card-header {
        padding-right: 1.25rem;
    }
    .ms-1 {
        margin-right: 0.25rem !important;
        margin-left: 0 !important;
    }
    select.form-control {
        padding-right: 10px;
        padding-left: 24px;
    }
    textarea.form-control {
        direction: rtl;
    }
</style>
@endpush