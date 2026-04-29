@extends('layouts.app')
@section('title', 'تخزين المنتج في المستودعات')
@section('page-title', 'إدارة المستودعات')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('product.dashboard') }}">لوحة التحكم</a></li>
        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">المنتجات</a></li>
        <li class="breadcrumb-item"><a href="{{ route('product.show', $product->product_id) }}">{{ $product->product_name }}</a></li>
        <li class="breadcrumb-item active">تخزين في المستودعات</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold" style="color:#1a472a;">
        <i class="fas fa-warehouse me-2"></i>
        تخزين: {{ $product->product_name }}
    </h5>
    <a href="{{ route('product.show', $product->product_id) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-right me-2"></i>رجوع
    </a>
</div>

<div class="row g-4">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus-circle me-2 text-success"></i>تخزين في مستودع جديد
            </div>
            <div class="card-body">
                @if(count($availableWarehouses) > 0)
                <form action="{{ route('product.warehouses.attach', $product->product_id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">اختر المستودع</label>
                        <select name="warehouse_id" class="form-select">
                            <option value="">— اختر مستودع —</option>
                            @foreach($availableWarehouses as $warehouse)
                                <option value="{{ $warehouse->warehouse_id }}">
                                    {{ $warehouse->warehouse_name }}
                                    @if($warehouse->city)({{ $warehouse->city }})@endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-plus me-2"></i>تخزين المنتج
                    </button>
                </form>
                @else
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-check-circle fa-2x text-success mb-2 d-block"></i>
                        المنتج مخزن في كل المستودعات المتاحة
                    </div>
                @endif
            </div>
        </div>

        <!-- معلومات المنتج -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="fas fa-box me-2 text-success"></i>معلومات المنتج
            </div>
            <div class="card-body">
                @if($product->upload_file)
                <div class="text-center mb-3">
                    <img src="{{ asset('uploads/products/' . $product->upload_file) }}"
                         style="width:80px;height:80px;object-fit:cover;border-radius:10px;">
                </div>
                @endif
                <div class="mb-2">
                    <small class="text-muted">الاسم</small>
                    <div class="fw-bold">{{ $product->product_name }}</div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">السعر</small>
                    <div><span class="badge bg-success">${{ number_format($product->price, 2) }}</span></div>
                </div>
                <div>
                    <small class="text-muted">الوصف</small>
                    <div class="text-muted" style="font-size:0.85rem;">{{ $product->description ?? '—' }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-warehouse me-2 text-primary"></i>
                المستودعات التي يخزن فيها المنتج ({{ count($linkedWarehouses) }})
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th><th>اسم المستودع</th><th>المدينة</th>
                                <th>العنوان</th><th>الهاتف</th>
                                @if(session('user.role') === 'manager')<th>إلغاء التخزين</th>@endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($linkedWarehouses as $warehouse)
                            <tr>
                                <td>{{ $warehouse->warehouse_id }}</td>
                                <td><i class="fas fa-warehouse text-primary me-2"></i><strong>{{ $warehouse->warehouse_name }}</strong></td>
                                <td>{{ $warehouse->city ?? '—' }}</td>
                                <td>{{ $warehouse->address ?? '—' }}</td>
                                <td>{{ $warehouse->phone ?? '—' }}</td>
                                @if(session('user.role') === 'manager')
                                <td>
                                    <form action="{{ route('product.warehouses.detach', [$product->product_id, $warehouse->warehouse_id]) }}"
                                          method="POST"
                                          onsubmit="return confirm('هل أنت متأكد من إلغاء تخزين المنتج؟')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-minus-circle me-1"></i>إلغاء
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="fas fa-warehouse fa-3x mb-3 d-block"></i>
                                    المنتج غير مخزن في أي مستودع بعد
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
