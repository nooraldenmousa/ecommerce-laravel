@extends('layouts.app')
@section('title', 'تفاصيل المنتج')
@section('page-title', 'تفاصيل المنتج')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('product.dashboard') }}">لوحة التحكم</a></li>
        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">المنتجات</a></li>
        <li class="breadcrumb-item active">تفاصيل</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold" style="color:#1a472a;">
        <i class="fas fa-box me-2"></i>{{ $product->product_name }}
    </h5>
    <div class="d-flex gap-2">
        <a href="{{ route('product.edit', $product->product_id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>تعديل
        </a>
        @if(session('user.role') === 'manager')
        <form action="{{ route('product.destroy', $product->product_id) }}"
              method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash me-2"></i>حذف
            </button>
        </form>
        @endif
        <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right me-2"></i>رجوع
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- معلومات المنتج -->
    <div class="col-xl-5">
        <div class="card h-100">
            <div class="card-header">
                <i class="fas fa-info-circle me-2 text-success"></i>معلومات المنتج
            </div>
            <div class="card-body">
                <!-- صورة المنتج -->
                <div class="text-center mb-4">
                    @if($product->upload_file)
                        <img src="{{ asset('uploads/products/' . $product->upload_file) }}"
                             alt="{{ $product->product_name }}"
                             style="width:180px;height:180px;object-fit:cover;border-radius:15px;border:3px solid #40916c;box-shadow:0 5px 20px rgba(64,145,108,0.2);">
                    @else
                        <div style="width:180px;height:180px;background:#f0f7f4;border-radius:15px;display:flex;align-items:center;justify-content:center;margin:0 auto;border:3px solid #d8f3dc;">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                    @endif
                </div>

                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="fw-bold text-muted" style="width:35%">
                                <i class="fas fa-hashtag me-2"></i>الرقم
                            </td>
                            <td>{{ $product->product_id }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-box me-2"></i>الاسم
                            </td>
                            <td><strong>{{ $product->product_name }}</strong></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-dollar-sign me-2"></i>السعر
                            </td>
                            <td>
                                <span class="badge bg-success fs-6">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-align-left me-2"></i>الوصف
                            </td>
                            <td>{{ $product->description ?? '—' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-7">
        <!-- المستودعات -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-warehouse me-2 text-primary"></i>المستودعات التي تخزن المنتج ({{ count($warehouses) }})</span>
                <a href="{{ route('product.warehouses', $product->product_id) }}"
                   class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-cog me-1"></i>إدارة
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr><th>اسم المستودع</th><th>المدينة</th><th>الهاتف</th></tr>
                        </thead>
                        <tbody>
                            @forelse($warehouses as $warehouse)
                            <tr>
                                <td><i class="fas fa-warehouse text-primary me-2"></i>{{ $warehouse->warehouse_name }}</td>
                                <td>{{ $warehouse->city ?? '—' }}</td>
                                <td>{{ $warehouse->phone ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    <i class="fas fa-warehouse me-2"></i>لا توجد مستودعات مرتبطة
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- المتاجر -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-store me-2 text-warning"></i>المتاجر التي تعرض المنتج ({{ count($stores) }})</span>
                <a href="{{ route('product.stores', $product->product_id) }}"
                   class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-cog me-1"></i>إدارة
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr><th>اسم المتجر</th><th>المدينة</th><th>الهاتف</th></tr>
                        </thead>
                        <tbody>
                            @forelse($stores as $store)
                            <tr>
                                <td><i class="fas fa-store text-warning me-2"></i>{{ $store->store_name }}</td>
                                <td>{{ $store->city ?? '—' }}</td>
                                <td>{{ $store->phone ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    <i class="fas fa-store me-2"></i>لا توجد متاجر مرتبطة
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
