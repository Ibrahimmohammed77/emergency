@extends('layouts.user')

@section('content')
<div class="container" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold">تفاصيل المركبة</span>
                    <div>
                        <a href="{{ route('user.vehicles.edit', $vehicle->id) }}" class="btn btn-sm btn-light">
                            <i class="fas fa-edit ms-2"></i> تعديل
                        </a>
                    </div>
                </div>

                <div class="card-body text-right">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="fw-bold">المعلومات الأساسية</h5>
                            <p><strong>النوع:</strong> 
                                @if($vehicle->type == 'car')
                                    سيارة
                                @elseif($vehicle->type == 'truck')
                                    شاحنة
                                @else
                                    دراجة نارية
                                @endif
                            </p>
                            <p><strong>رقم اللوحة:</strong> {{ $vehicle->plate_number }}</p>
                            <p><strong>رقم الجهاز:</strong> <code>{{ $vehicle->device_id }}</code></p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="fw-bold">تفاصيل إضافية</h5>
                            <p><strong>سنة الصنع:</strong> {{ $vehicle->model_year ?? 'غير محدد' }}</p>
                            <p><strong>اللون:</strong> {{ $vehicle->color ?? 'غير محدد' }}</p>
                            <p><strong>تاريخ التسجيل:</strong> {{ $vehicle->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="alert alert-info text-right">
                        <i class="fas fa-info-circle ms-2"></i> هذه المركبة 
                        @if($vehicle->accidents->count() > 0)
                            مشاركة في {{ $vehicle->accidents->count() }} تقارير حوادث.
                        @else
                            غير مشاركة في أي تقارير حوادث.
                        @endif
                    </div>

                    <div class="d-flex gap-2 justify-content-start">
                        <a href="{{ route('user.vehicles.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-right ms-2"></i> العودة للقائمة
                        </a>
                        <form action="{{ route('user.vehicles.destroy', $vehicle->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('هل أنت متأكد من رغبتك في حذف هذه المركبة؟')">
                                <i class="fas fa-trash ms-2"></i> حذف المركبة
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection