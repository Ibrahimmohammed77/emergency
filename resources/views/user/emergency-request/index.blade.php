@extends('layouts.user')

@section('content')
<div class="container" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>طلبات الطوارئ الخاصة بي</span>
                    <a href="{{ route('user.emergency-request.create') }}" class="btn btn-sm btn-danger">
                        <i class="fas fa-plus"></i> طلب جديد
                    </a>
                </div>

                <div class="card-body">
                    @if($requests->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>التاريخ</th>
                                        <th>درجة الاستعجال</th>
                                        <th>الرسالة</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requests as $request)
                                    <tr>
                                        <td>{{ $request->created_at->translatedFormat('Y-m-d H:i') }}</td>
                                        <td>
                                            <span class="badge bg-{{ 
                                                $request->urgency_level == 'critical' ? 'danger' : 
                                                ($request->urgency_level == 'high' ? 'warning' : 'info') 
                                            }}">
                                                @if($request->urgency_level == 'critical')
                                                    حرج
                                                @elseif($request->urgency_level == 'high')
                                                    عالي
                                                @else
                                                    عادي
                                                @endif
                                            </span>
                                        </td>
                                        <td>{{ Str::limit($request->message, 50) }}</td>
                                        <td>
                                            <span class="badge bg-{{ 
                                                $request->status == 'resolved' ? 'success' : 
                                                ($request->status == 'processing' ? 'warning' : 'secondary') 
                                            }}">
                                                @if($request->status == 'resolved')
                                                    تم الحل
                                                @elseif($request->status == 'processing')
                                                    قيد المعالجة
                                                @else
                                                    معلق
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-info" title="عرض التفاصيل">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($request->status == 'pending')
                                            <form action="{{ route('user.emergency-requests.cancel', $request->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('هل أنت متأكد من إلغاء هذا الطلب؟')" title="إلغاء الطلب">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $requests->links() }}
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            لا توجد طلبات طوارئ. يمكنك إنشاء طلب جديد باستخدام الزر بالأعلى.
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
    .pagination {
        justify-content: center;
    }
    .page-item:not(:first-child) .page-link {
        margin-right: -1px;
        margin-left: 0;
    }
    .badge {
        font-weight: 500;
    }
</style>
@endpush