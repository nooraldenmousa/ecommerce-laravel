@extends('layouts.app')

@section('title', 'ربط المنتجات')
@section('page-title', 'إدارة المنتجات المخزنة')

@section('content')

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('warehouse.dashboard') }}">لوحة التحكم</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('warehouse.index') }}">المستودعات</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('warehouse.show', $warehouse->warehouse_id) }}">
                {{ $warehouse->warehouse_name }}
            </a>
        </li>
        <li class="breadcrumb-item active">ربط المنتجات</li>
    </ol>
</nav>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold" style="color:#1a365d;">
        <i class="fas fa-boxes me-2"></i>
        المنتجات المخزنة في: {{ $warehouse->warehouse_name }}
    </h5>
    <a href="{{ route('warehouse.show', $warehouse->warehouse_id) }}"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-right me-2"></i>رجوع
    </a>
</div>

<div class="row g-4">

    <!-- إضافة منتج -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus-circle me-2 text-success"></i>
                تخزين منتج جديد
            </div>
            <div class="card-body">
                @if(count($availableProducts) > 0)
                <form action="{{ route('warehouse.products.attach', $warehouse->warehouse_id) }}"
                      method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">اختر المنتج</label>
                        <select name="product_id" class="form-select">
                            <option value="">— اختر منتج —</option>
                            @foreach($availableProducts as $product)
                                <option value="{{ $product->product_id }}">
                                    {{ $product->product_name }}
                                    @if($product->price)
                                        — ${{ number_format($product->price, 2) }}
                                    @endif
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
                        جميع المنتجات مخزنة في هذا المستودع
                    </div>
                @endif
            </div>
        </div>

        <!-- إحصائيات -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-2 text-primary"></i>
                إحصائيات
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded-3"
                     style="background:#f0f4f8;">
                    <div>
                        <div class="fw-bold" style="color:#1a365d;">المنتجات المخزنة</div>
                        <small class="text-muted">في هذا المستودع</small>
                    </div>
                    <div class="fs-3 fw-bold text-success">
                        {{ count($linkedProducts) }}
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center p-3 rounded-3"
                     style="background:#f0f4f8;">
                    <div>
                        <div class="fw-bold" style="color:#1a365d;">منتجات متاحة</div>
                        <small class="text-muted">للإضافة</small>
                    </div>
                    <div class="fs-3 fw-bold text-warning">
                        {{ count($availableProducts) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- المنتجات المرتبطة -->
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-boxes me-2 text-success"></i>
                المنتجات المخزنة ({{ count($linkedProducts) }})
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المنتج</th>
                                <th>السعر</th>
                                <th>الوصف</th>
                                <th>الصورة</th>
                                @if(session('user.role') === 'manager')
                                <th>إلغاء التخزين</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($linkedProducts as $product)
                            <tr>
                                <td>{{ $product->product_id }}</td>
                                <td>
                                    <i class="fas fa-box text-success me-2"></i>
                                    <strong>{{ $product->product_name }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ Str::limit($product->description, 40) ?? '—' }}
                                    </small>
                                </td>
                                <td>
                                    @if($product->upload_file)
                                        <img src="{{ asset('uploads/products/' . $product->upload_file) }}"
                                             alt="{{ $product->product_name }}"
                                             style="width:40px; height:40px; object-fit:cover; border-radius:8px;">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                @if(session('user.role') === 'manager')
                                <td>
                                    <form action="{{ route('warehouse.products.detach', [$warehouse->warehouse_id, $product->product_id]) }}"
                                          method="POST"
                                          onsubmit="return confirm('هل أنت متأكد من إلغاء تخزين هذا المنتج؟')">
                                        @csrf
                                        @method('DELETE')
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
                                    <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                                    لا توجد منتجات مخزنة في هذا المستودع
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