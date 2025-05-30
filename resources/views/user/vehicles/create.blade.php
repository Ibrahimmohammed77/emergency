@extends('layouts.user')

@section('content')
<div class="container" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-right">
                    {{ isset($vehicle) ? 'تعديل بيانات المركبة' : 'تسجيل مركبة جديدة' }}
                </div>

                <div class="card-body text-right">
                    <form method="POST" action="{{ isset($vehicle) ? route('user.vehicles.update', $vehicle->id) : route('user.vehicles.store') }}">
                        @csrf
                        @if(isset($vehicle)) @method('PUT') @endif

                        <div class="row mb-3">
                            <label for="type" class="col-md-4 col-form-label text-md-end">نوع المركبة</label>
                            <div class="col-md-6">
                                <select id="type" class="form-control @error('type') is-invalid @enderror" name="type" required>
                                    <option value="">اختر النوع</option>
                                    <option value="car" {{ old('type', isset($vehicle) ? $vehicle->type : '') == 'car' ? 'selected' : '' }}>سيارة</option>
                                    <option value="truck" {{ old('type', isset($vehicle) ? $vehicle->type : '') == 'truck' ? 'selected' : '' }}>شاحنة</option>
                                    <option value="motorcycle" {{ old('type', isset($vehicle) ? $vehicle->type : '') == 'motorcycle' ? 'selected' : '' }}>دراجة نارية</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="plate_number" class="col-md-4 col-form-label text-md-end">رقم اللوحة</label>
                            <div class="col-md-6">
                                <input id="plate_number" type="text" class="form-control @error('plate_number') is-invalid @enderror" name="plate_number" value="{{ old('plate_number', isset($vehicle) ? $vehicle->plate_number : '') }}" required>
                                @error('plate_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="device_id" class="col-md-4 col-form-label text-md-end">رقم الجهاز</label>
                            <div class="col-md-6">
                                <input id="device_id" type="text" class="form-control @error('device_id') is-invalid @enderror" name="device_id" value="{{ old('device_id', isset($vehicle) ? $vehicle->device_id : '') }}" required>
                                @error('device_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="model_year" class="col-md-4 col-form-label text-md-end">سنة الصنع</label>
                            <div class="col-md-6">
                                <input id="model_year" type="number" min="1900" max="{{ date('Y') + 1 }}" class="form-control @error('model_year') is-invalid @enderror" name="model_year" value="{{ old('model_year', isset($vehicle) ? $vehicle->model_year : '') }}">
                                @error('model_year')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="color" class="col-md-4 col-form-label text-md-end">اللون</label>
                            <div class="col-md-6">
                                <input id="color" type="text" class="form-control @error('color') is-invalid @enderror" name="color" value="{{ old('color', isset($vehicle) ? $vehicle->color : '') }}">
                                @error('color')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    {{ isset($vehicle) ? 'تحديث البيانات' : 'تسجيل المركبة' }}
                                </button>
                                <a href="{{ route('user.vehicles.index') }}" class="btn btn-outline-secondary px-4">
                                    إلغاء
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection