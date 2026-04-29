@extends('layouts.app')
@section('title', 'عرض المنتج في المتاجر')
@section('page-title', 'إدارة المتاجر')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('product.dashboard') }}">لوحة التحكم</a></li>
        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">المنتجات</a></li>
        <li class="breadcrumb-item"><a href="{{ route('product.show', $product->product_id) }}">{{ $product->product_name }}</a></li>
        <li class="breadcrumb-item active">عرض في المتاجر</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold" style="color:#1a472a;">
        <i class="fas fa-store me-2"></i>
        عرض: {{ $product->product_name }}
    </h5>
    <a href="{{ route('product.show', $product->product_id) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-right me-2"></i>رجوع
    </a>
</div>

<div class="row g-4">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus-circle me-2 text-warning"></i>عرض في متجر جديد
            </div>
            <div class="card-body">
                @if(count($availableStores) > 0)
                <form action="{{ route('product.stores.attach', $product->product_id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">اختر المتجر</label>
                        <select name="store_id" class="form-select">
                            <option value="">— اختر متجر —</option>
                            @foreach($availableStores as $store)
                                <option value="{{ $store->store_id }}">
                                    {{ $store->store_name }}
                                    @if($store->city)({{ $store->city }})@endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="fas fa-store me-2"></i>عرض في المتجر
                    </button>
                </form>
                @else
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-check-circle fa-2x text-success mb-2 d-block"></i>
                        المنتج معروض في كل المتاجر المتاحة
                    </div>
                @endif
            </div>
        </div>

        <!-- إحصائيات -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-2 text-success"></i>إحصائيات
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded-3" style="background:#f0f7f4;">
                    <div>
                        <div class="fw-bold" style="color:#1a472a;">المتاجر المعروض فيها</div>
                        <small class="text-muted">عدد المتاجر</small>
                    </div>
                    <div class="fs-3 fw-bold text-warning">{{ count($linkedStores) }}</div>
                </div>
                <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="background:#f0f7f4;">
                    <div>
                        <div class="fw-bold" style="color:#1a472a;">متاجر متاحة</div>
                        <small class="text-muted">للإضافة</small>
                    </div>
                    <div class="fs-3 fw-bold text-success">{{ count($availableStores) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-store me-2 text-warning"></i>
                المتاجر التي يعرض فيها المنتج ({{ count($linkedStores) }})
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th><th>اسم المتجر</th><th>المدينة</th>
                                <th>العنوان</th><th>الهاتف</th>
                                @if(session('user.role') === 'manager')<th>إلغاء العرض</th>@endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($linkedStores as $store)
                            <tr>
                                <td>{{ $store->store_id }}</td>
                                <td><i class="fas fa-store text-warning me-2"></i><strong>{{ $store->store_name }}</strong></td>
                                <td>{{ $store->city ?? '—' }}</td>
                                <td>{{ $store->address ?? '—' }}</td>
                                <td>{{ $store->phone ?? '—' }}</td>
                                @if(session('user.role') === 'manager')
                                <td>
                                    <form action="{{ route('product.stores.detach', [$product->product_id, $store->store_id]) }}"
                                          method="POST"
                                          onsubmit="return confirm('هل أنت متأكد من إلغاء عرض المنتج في هذا المتجر؟')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-times me-1"></i>إلغاء
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="fas fa-store-slash fa-3x mb-3 d-block"></i>
                                    المنتج غير معروض في أي متجر بعد
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
