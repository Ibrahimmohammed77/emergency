@extends('layouts.user')

@section('content')
<div class="container" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>مركباتي</span>
                    <a href="{{ route('user.vehicles.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> إضافة مركبة
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($vehicles->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>النوع</th>
                                        <th>رقم اللوحة</th>
                                        <th>معرف الجهاز</th>
                                        <th>تاريخ التسجيل</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vehicles as $vehicle)
                                    <tr>
                                        <td>{{ ucfirst($vehicle->type) }}</td>
                                        <td>{{ $vehicle->plate_number }}</td>
                                        <td><code>{{ $vehicle->device_id }}</code></td>
                                        <td>{{ $vehicle->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('user.vehicles.edit', $vehicle->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('user.vehicles.destroy', $vehicle->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد؟')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            لا توجد مركبات مسجلة بعد. <a href="{{ route('user.vehicles.create') }}">أضف مركبتك الأولى</a>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-responsive {
        direction: rtl;
    }
    .table th, .table td {
        text-align: right;
    }
    .btn-sm i {
        margin-left: 3px;
    }
    .card-header {
        padding-right: 1.25rem;
    }
    body {
        font-family: 'Tahoma', 'Arial', sans-serif;
    }
</style>
@endpush