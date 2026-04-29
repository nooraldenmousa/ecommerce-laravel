@extends('layouts.app')

@section('title', 'لوحة التحكم - إدارة المستودعات')
@section('page-title', 'لوحة التحكم')

@section('content')

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">لوحة التحكم</li>
    </ol>
</nav>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="stat-card bg-warehouse">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">إجمالي المستودعات</div>
                    <div class="stat-number">{{ $totalWarehouses }}</div>
                    <small style="opacity:0.8">مستودع مسجل في النظام</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-warehouse"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="stat-card bg-products">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">المنتجات المخزنة</div>
                    <div class="stat-number">{{ $totalProducts }}</div>
                    <small style="opacity:0.8">منتج في المستودعات</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="stat-card bg-stores">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">المتاجر المرتبطة</div>
                    <div class="stat-number">{{ $totalStores }}</div>
                    <small style="opacity:0.8">متجر مرتبط بالمستودعات</small>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-store"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Warehouses + Quick Actions -->
<div class="row g-4">

    <!-- Recent Warehouses -->
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clock me-2 text-primary"></i>آخر المستودعات المضافة</span>
                <a href="{{ route('warehouse.index') }}" class="btn btn-primary btn-sm">
                    عرض الكل
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المستودع</th>
                                <th>المدينة</th>
                                <th>الهاتف</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentWarehouses as $warehouse)
                            <tr>
                                <td>{{ $warehouse->warehouse_id }}</td>
                                <td>
                                    <i class="fas fa-warehouse text-primary me-2"></i>
                                    {{ $warehouse->warehouse_name }}
                                </td>
                                <td>
                                    <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                    {{ $warehouse->city ?? '—' }}
                                </td>
                                <td>{{ $warehouse->phone ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('warehouse.show', $warehouse->warehouse_id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    لا توجد مستودعات بعد
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bolt me-2 text-warning"></i>إجراءات سريعة
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">

                    <a href="{{ route('warehouse.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list me-2"></i>
                        عرض كل المستودعات
                    </a>

                    @if(session('user.role') === 'manager')
                    <a href="{{ route('warehouse.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        إضافة مستودع جديد
                    </a>
                    @endif

                </div>

                <!-- User Info Card -->
                <div class="mt-4 p-3 rounded-3" style="background:#f0f4f8;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="
                            width:45px; height:45px;
                            background: linear-gradient(135deg, #1a365d, #63b3ed);
                            border-radius:50%;
                            display:flex; align-items:center; justify-content:center;
                            color:white; font-weight:700; font-size:1.1rem;
                        ">
                            {{ mb_substr(session('user.name'), 0, 1) }}
                        </div>
                        <div>
                            <div style="font-weight:700; color:#1a365d;">
                                {{ session('user.name') }}
                            </div>
                            <div>
                                @if(session('user.role') === 'manager')
                                    <span class="badge bg-danger">مدير المستودعات</span>
                                @else
                                    <span class="badge bg-info">موظف المستودعات</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr style="border-color:#e2e8f0;">

                    <div style="font-size:0.82rem; color:#718096;">
                        <div class="mb-1">
                            <i class="fas fa-user-shield me-2 text-primary"></i>
                            @if(session('user.role') === 'manager')
                                صلاحيات كاملة (إضافة، تعديل، حذف)
                            @else
                                صلاحيات محدودة (إضافة، تعديل)
                            @endif
                        </div>
                        <div>
                            <i class="fas fa-clock me-2 text-success"></i>
                            {{ now()->format('Y/m/d — H:i') }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

@endsection