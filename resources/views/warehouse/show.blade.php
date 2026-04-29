@extends('layouts.app')

@section('title', 'تفاصيل المستودع')
@section('page-title', 'تفاصيل المستودع')

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
        <li class="breadcrumb-item active">تفاصيل</li>
    </ol>
</nav>

<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold" style="color:#1a365d;">
        <i class="fas fa-warehouse me-2"></i>{{ $warehouse->warehouse_name }}
    </h5>
    <div class="d-flex gap-2">
        <a href="{{ route('warehouse.edit', $warehouse->warehouse_id) }}"
           class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>تعديل
        </a>
        @if(session('user.role') === 'manager')
        <form action="{{ route('warehouse.destroy', $warehouse->warehouse_id) }}"
              method="POST" onsubmit="return confirmDelete()">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash me-2"></i>حذف
            </button>
        </form>
        @endif
        <a href="{{ route('warehouse.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right me-2"></i>رجوع
        </a>
    </div>
</div>

<div class="row g-4">

    <!-- معلومات المستودع -->
    <div class="col-xl-6">
        <div class="card h-100">
            <div class="card-header">
                <i class="fas fa-info-circle me-2 text-primary"></i>
                معلومات المستودع
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="fw-bold text-muted" style="width:40%">
                                <i class="fas fa-hashtag me-2"></i>الرقم
                            </td>
                            <td>{{ $warehouse->warehouse_id }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-warehouse me-2"></i>الاسم
                            </td>
                            <td><strong>{{ $warehouse->warehouse_name }}</strong></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-map-marker-alt me-2"></i>المدينة
                            </td>
                            <td>{{ $warehouse->city ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-map-pin me-2"></i>العنوان
                            </td>
                            <td>{{ $warehouse->address ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-phone me-2"></i>الهاتف
                            </td>
                            <td>{{ $warehouse->phone ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-user-tie me-2"></i>المدير
                            </td>
                            <td>
                                @if($warehouse->manager_name)
                                    <span class="badge bg-primary">
                                        {{ $warehouse->manager_name }}
                                    </span>
                                @else
                                    <span class="text-muted">غير محدد</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-file me-2"></i>البروشور
                            </td>
                            <td>
                                @if($warehouse->upload_file)
                                    <a href="{{ asset('uploads/warehouses/' . $warehouse->upload_file) }}"
                                       target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-download me-1"></i>تحميل البروشور
                                    </a>
                                @else
                                    <span class="text-muted">لا يوجد</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- الموظفين -->
    <div class="col-xl-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    <i class="fas fa-users me-2 text-info"></i>
                    الموظفين ({{ count($employees) }})
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>الدور</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $emp)
                            <tr>
                                <td>
                                    <i class="fas fa-user-circle text-info me-2"></i>
                                    {{ $emp->full_name }}
                                </td>
                                <td>
                                    @if(strtolower($emp->role) === 'manager')
                                        <span class="badge bg-danger">مدير</span>
                                    @else
                                        <span class="badge bg-secondary">موظف</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-3">
                                    <i class="fas fa-users-slash me-2"></i>
                                    لا يوجد موظفون
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- المتاجر المرتبطة -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    <i class="fas fa-store me-2 text-warning"></i>
                    المتاجر المرتبطة ({{ count($stores) }})
                </span>
                <a href="{{ route('warehouse.stores', $warehouse->warehouse_id) }}"
                   class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-cog me-1"></i>إدارة
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>اسم المتجر</th>
                                <th>المدينة</th>
                                <th>الهاتف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stores as $store)
                            <tr>
                                <td>
                                    <i class="fas fa-store text-warning me-2"></i>
                                    {{ $store->store_name }}
                                </td>
                                <td>{{ $store->city ?? '—' }}</td>
                                <td>{{ $store->phone ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    <i class="fas fa-store-slash me-2"></i>
                                    لا توجد متاجر مرتبطة
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- المنتجات المرتبطة -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    <i class="fas fa-boxes me-2 text-success"></i>
                    المنتجات المخزنة ({{ count($products) }})
                </span>
                <a href="{{ route('warehouse.products', $warehouse->warehouse_id) }}"
                   class="btn btn-sm btn-outline-success">
                    <i class="fas fa-cog me-1"></i>إدارة
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>اسم المنتج</th>
                                <th>السعر</th>
                                <th>الوصف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td>
                                    <i class="fas fa-box text-success me-2"></i>
                                    {{ $product->product_name }}
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
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    <i class="fas fa-box-open me-2"></i>
                                    لا توجد منتجات مخزنة
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

@section('scripts')
<script>
    function confirmDelete() {
        return confirm('هل أنت متأكد من حذف هذا المستودع؟');
    }
</script>
@endsection