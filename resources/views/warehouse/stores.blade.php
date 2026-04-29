@extends('layouts.app')

@section('title', 'ربط المتاجر')
@section('page-title', 'إدارة المتاجر المرتبطة')

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
        <li class="breadcrumb-item active">ربط المتاجر</li>
    </ol>
</nav>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold" style="color:#1a365d;">
        <i class="fas fa-store me-2"></i>
        المتاجر المرتبطة بـ: {{ $warehouse->warehouse_name }}
    </h5>
    <a href="{{ route('warehouse.show', $warehouse->warehouse_id) }}"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-right me-2"></i>رجوع
    </a>
</div>

<div class="row g-4">

    <!-- إضافة متجر جديد -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus-circle me-2 text-success"></i>
                ربط متجر جديد
            </div>
            <div class="card-body">
                @if(count($availableStores) > 0)
                <form action="{{ route('warehouse.stores.attach', $warehouse->warehouse_id) }}"
                      method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">اختر المتجر</label>
                        <select name="store_id" class="form-select">
                            <option value="">— اختر متجر —</option>
                            @foreach($availableStores as $store)
                                <option value="{{ $store->store_id }}">
                                    {{ $store->store_name }}
                                    @if($store->city)
                                        ({{ $store->city }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-link me-2"></i>ربط المتجر
                    </button>
                </form>
                @else
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-check-circle fa-2x text-success mb-2 d-block"></i>
                        جميع المتاجر مرتبطة بهذا المستودع
                    </div>
                @endif
            </div>
        </div>

        <!-- معلومات المستودع -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="fas fa-info-circle me-2 text-primary"></i>
                معلومات المستودع
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <small class="text-muted">الاسم</small>
                    <div class="fw-bold">{{ $warehouse->warehouse_name }}</div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">المدينة</small>
                    <div>{{ $warehouse->city ?? '—' }}</div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">العنوان</small>
                    <div>{{ $warehouse->address ?? '—' }}</div>
                </div>
                <div>
                    <small class="text-muted">الهاتف</small>
                    <div>{{ $warehouse->phone ?? '—' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- المتاجر المرتبطة -->
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-store me-2 text-warning"></i>
                المتاجر المرتبطة ({{ count($linkedStores) }})
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المتجر</th>
                                <th>المدينة</th>
                                <th>العنوان</th>
                                <th>الهاتف</th>
                                @if(session('user.role') === 'manager')
                                <th>إلغاء الربط</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($linkedStores as $store)
                            <tr>
                                <td>{{ $store->store_id }}</td>
                                <td>
                                    <i class="fas fa-store text-warning me-2"></i>
                                    <strong>{{ $store->store_name }}</strong>
                                </td>
                                <td>{{ $store->city ?? '—' }}</td>
                                <td>{{ $store->address ?? '—' }}</td>
                                <td>{{ $store->phone ?? '—' }}</td>
                                @if(session('user.role') === 'manager')
                                <td>
                                    <form action="{{ route('warehouse.stores.detach', [$warehouse->warehouse_id, $store->store_id]) }}"
                                          method="POST"
                                          onsubmit="return confirm('هل أنت متأكد من إلغاء ربط هذا المتجر؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-unlink me-1"></i>إلغاء
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="fas fa-store-slash fa-3x mb-3 d-block"></i>
                                    لا توجد متاجر مرتبطة بهذا المستودع
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