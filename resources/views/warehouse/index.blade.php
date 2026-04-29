@extends('layouts.app')

@section('title', 'المستودعات')
@section('page-title', 'إدارة المستودعات')

@section('content')

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('warehouse.dashboard') }}">لوحة التحكم</a>
        </li>
        <li class="breadcrumb-item active">المستودعات</li>
    </ol>
</nav>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold" style="color:#1a365d;">
        <i class="fas fa-warehouse me-2"></i>قائمة المستودعات
    </h5>
    @if(session('user.role') === 'manager')
    <a href="{{ route('warehouse.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>إضافة مستودع
    </a>
    @endif
</div>

<!-- Search & Filter -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label">
                    <i class="fas fa-search me-1"></i>بحث باسم المستودع
                </label>
                <input type="text" id="searchInput" class="form-control"
                       placeholder="اكتب اسم المستودع..."
                       value="{{ $search }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">
                    <i class="fas fa-map-marker-alt me-1"></i>تصفية بالمدينة
                </label>
                <select id="cityFilter" class="form-select">
                    <option value="">كل المدن</option>
                    @foreach($cities as $c)
                        <option value="{{ $c->city }}"
                            {{ $city === $c->city ? 'selected' : '' }}>
                            {{ $c->city }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button onclick="resetSearch()" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-redo me-2"></i>إعادة تعيين
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Results Count -->
<div class="mb-3">
    <small class="text-muted">
        <i class="fas fa-info-circle me-1"></i>
        عدد النتائج: <span id="resultsCount" class="fw-bold text-primary">{{ count($warehouses) }}</span>
    </small>
</div>

<!-- Table -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0" id="warehouseTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المستودع</th>
                        <th>المدينة</th>
                        <th>العنوان</th>
                        <th>الهاتف</th>
                        <th>المدير</th>
                        <th>البروشور</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="warehouseTableBody">
                    @forelse($warehouses as $warehouse)
                    <tr>
                        <td>{{ $warehouse->warehouse_id }}</td>
                        <td>
                            <i class="fas fa-warehouse text-primary me-2"></i>
                            <strong>{{ $warehouse->warehouse_name }}</strong>
                        </td>
                        <td>
                            <i class="fas fa-map-marker-alt text-danger me-1"></i>
                            {{ $warehouse->city ?? '—' }}
                        </td>
                        <td>{{ $warehouse->address ?? '—' }}</td>
                        <td>
                            <i class="fas fa-phone text-success me-1"></i>
                            {{ $warehouse->phone ?? '—' }}
                        </td>
                        <td>
                            @if($warehouse->manager_name)
                                <span class="badge bg-primary">
                                    <i class="fas fa-user me-1"></i>
                                    {{ $warehouse->manager_name }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($warehouse->upload_file)
                                <a href="{{ asset('uploads/warehouses/' . $warehouse->upload_file) }}"
                                   target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-download me-1"></i>تحميل
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <!-- عرض التفاصيل -->
                                <a href="{{ route('warehouse.show', $warehouse->warehouse_id) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="عرض التفاصيل">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- تعديل -->
                                <a href="{{ route('warehouse.edit', $warehouse->warehouse_id) }}"
                                   class="btn btn-sm btn-outline-warning"
                                   title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- ربط المتاجر -->
                                <a href="{{ route('warehouse.stores', $warehouse->warehouse_id) }}"
                                   class="btn btn-sm btn-outline-info"
                                   title="ربط المتاجر">
                                    <i class="fas fa-store"></i>
                                </a>

                                <!-- ربط المنتجات -->
                                <a href="{{ route('warehouse.products', $warehouse->warehouse_id) }}"
                                   class="btn btn-sm btn-outline-success"
                                   title="ربط المنتجات">
                                    <i class="fas fa-boxes"></i>
                                </a>

                                <!-- حذف - للمانجر فقط -->
                                @if(session('user.role') === 'manager')
                                <form action="{{ route('warehouse.destroy', $warehouse->warehouse_id) }}"
                                      method="POST"
                                      onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            لا توجد مستودعات
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // البحث الديناميكي بدون reload
    let searchTimer;

    function doSearch() {
        const search = $('#searchInput').val();
        const city   = $('#cityFilter').val();

        $.ajax({
            url: '/api/warehouse/search',
            method: 'GET',
            data: { search, city },
            success: function(response) {
                const warehouses = response.data;
                $('#resultsCount').text(warehouses.length);
                renderTable(warehouses);
            }
        });
    }

    function renderTable(warehouses) {
        let html = '';

        if (warehouses.length === 0) {
            html = `
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="fas fa-search fa-3x mb-3 d-block"></i>
                        لا توجد نتائج مطابقة
                    </td>
                </tr>`;
        } else {
            warehouses.forEach(w => {
                const managerBadge = w.manager_name
                    ? `<span class="badge bg-primary"><i class="fas fa-user me-1"></i>${w.manager_name}</span>`
                    : '—';

                const fileBttn = w.upload_file
                    ? `<a href="/uploads/warehouses/${w.upload_file}" target="_blank" class="btn btn-sm btn-outline-info"><i class="fas fa-download me-1"></i>تحميل</a>`
                    : '—';

                const deleteBtn = @json(session('user.role') === 'manager')
                    ? `<form action="/warehouse/${w.warehouse_id}" method="POST" onsubmit="return confirmDelete()" style="display:inline">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                            <i class="fas fa-trash"></i>
                        </button>
                       </form>`
                    : '';

                html += `
                <tr>
                    <td>${w.warehouse_id}</td>
                    <td><i class="fas fa-warehouse text-primary me-2"></i><strong>${w.warehouse_name}</strong></td>
                    <td><i class="fas fa-map-marker-alt text-danger me-1"></i>${w.city ?? '—'}</td>
                    <td>${w.address ?? '—'}</td>
                    <td><i class="fas fa-phone text-success me-1"></i>${w.phone ?? '—'}</td>
                    <td>${managerBadge}</td>
                    <td>${fileBttn}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="/warehouse/${w.warehouse_id}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                            <a href="/warehouse/${w.warehouse_id}/edit" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                            <a href="/warehouse/${w.warehouse_id}/stores" class="btn btn-sm btn-outline-info"><i class="fas fa-store"></i></a>
                            <a href="/warehouse/${w.warehouse_id}/products" class="btn btn-sm btn-outline-success"><i class="fas fa-boxes"></i></a>
                            ${deleteBtn}
                        </div>
                    </td>
                </tr>`;
            });
        }

        $('#warehouseTableBody').html(html);
    }

    function resetSearch() {
        $('#searchInput').val('');
        $('#cityFilter').val('');
        doSearch();
    }

    function confirmDelete() {
        return confirm('هل أنت متأكد من حذف هذا المستودع؟');
    }

    // البحث عند الكتابة
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(doSearch, 400);
    });

    // البحث عند تغيير المدينة
    $('#cityFilter').on('change', function() {
        doSearch();
    });
</script>
@endsection