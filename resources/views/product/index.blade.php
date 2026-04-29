@extends('layouts.app')
@section('title', 'المنتجات')
@section('page-title', 'إدارة المنتجات')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('product.dashboard') }}">لوحة التحكم</a></li>
        <li class="breadcrumb-item active">المنتجات</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold" style="color:#1a472a;"><i class="fas fa-boxes me-2"></i>قائمة المنتجات</h5>
    @if(session('user.role') === 'manager')
    <a href="{{ route('product.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>إضافة منتج
    </a>
    @endif
</div>

<!-- Search -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-search me-1"></i>بحث باسم المنتج</label>
                <input type="text" id="searchInput" class="form-control"
                       placeholder="اكتب اسم المنتج..." value="{{ $search }}">
            </div>
            <div class="col-md-3">
                <label class="form-label"><i class="fas fa-dollar-sign me-1"></i>السعر من</label>
                <input type="number" id="minPrice" class="form-control" placeholder="0" value="{{ $minPrice }}" min="0">
            </div>
            <div class="col-md-3">
                <label class="form-label"><i class="fas fa-dollar-sign me-1"></i>السعر إلى</label>
                <input type="number" id="maxPrice" class="form-control" placeholder="99999" value="{{ $maxPrice }}" min="0">
            </div>
            <div class="col-md-2">
                <button onclick="resetSearch()" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-redo me-1"></i>إعادة
                </button>
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <small class="text-muted">
        <i class="fas fa-info-circle me-1"></i>
        عدد النتائج: <span id="resultsCount" class="fw-bold text-success">{{ count($products) }}</span>
    </small>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th><th>صورة</th><th>اسم المنتج</th><th>الوصف</th>
                        <th>السعر</th><th>المستودعات</th><th>المتاجر</th><th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->product_id }}</td>
                        <td>
                            @if($product->upload_file)
                                <img src="{{ asset('uploads/products/' . $product->upload_file) }}"
                                     style="width:45px;height:45px;object-fit:cover;border-radius:10px;">
                            @else
                                <div style="width:45px;height:45px;background:#f0f7f4;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td><strong>{{ $product->product_name }}</strong></td>
                        <td><small class="text-muted">{{ Str::limit($product->description, 40) ?? '—' }}</small></td>
                        <td><span class="badge bg-success fs-6">${{ number_format($product->price, 2) }}</span></td>
                        <td>
                            <a href="{{ route('product.warehouses', $product->product_id) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-warehouse me-1"></i>مستودعات
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('product.stores', $product->product_id) }}"
                               class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-store me-1"></i>متاجر
                            </a>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('product.show', $product->product_id) }}"
                                   class="btn btn-sm btn-outline-primary" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('product.edit', $product->product_id) }}"
                                   class="btn btn-sm btn-outline-warning" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(session('user.role') === 'manager')
                                <form action="{{ route('product.destroy', $product->product_id) }}"
                                      method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
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
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>لا توجد منتجات
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
let searchTimer;

function doSearch() {
    const search   = $('#searchInput').val();
    const minPrice = $('#minPrice').val();
    const maxPrice = $('#maxPrice').val();

    $.ajax({
url: '/product/search',
        method: 'GET',
        data: { search, min_price: minPrice, max_price: maxPrice },
        success: function(response) {
const products = Array.isArray(response) ? response : response.data;            $('#resultsCount').text(products.length);
            renderTable(products);
        }
    });
}

function renderTable(products) {
    let html = '';
    if (products.length === 0) {
        html = `<tr><td colspan="8" class="text-center py-5 text-muted">
            <i class="fas fa-search fa-3x mb-3 d-block"></i>لا توجد نتائج</td></tr>`;
    } else {
        const isManager = @json(session('user.role') === 'manager');
        products.forEach(p => {
            const img = p.upload_file
                ? `<img src="/uploads/products/${p.upload_file}" style="width:45px;height:45px;object-fit:cover;border-radius:10px;">`
                : `<div style="width:45px;height:45px;background:#f0f7f4;border-radius:10px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-image text-muted"></i></div>`;
            const deleteBtn = isManager
                ? `<form action="/product/${p.product_id}" method="POST" onsubmit="return confirm('هل أنت متأكد؟')" style="display:inline">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                   </form>` : '';
            html += `<tr>
                <td>${p.product_id}</td>
                <td>${img}</td>
                <td><strong>${p.product_name}</strong></td>
                <td><small class="text-muted">${p.description ? p.description.substring(0,40) : '—'}</small></td>
                <td><span class="badge bg-success fs-6">$${parseFloat(p.price).toFixed(2)}</span></td>
                <td><a href="/product/${p.product_id}/warehouses" class="btn btn-sm btn-outline-primary"><i class="fas fa-warehouse me-1"></i>مستودعات</a></td>
                <td><a href="/product/${p.product_id}/stores" class="btn btn-sm btn-outline-warning"><i class="fas fa-store me-1"></i>متاجر</a></td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="/product/${p.product_id}" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                        <a href="/product/${p.product_id}/edit" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i></a>
                        ${deleteBtn}
                    </div>
                </td>
            </tr>`;
        });
    }
    $('#productTableBody').html(html);
}

function resetSearch() {
    $('#searchInput').val('');
    $('#minPrice').val('');
    $('#maxPrice').val('');
    doSearch();
}

$('#searchInput').on('input', function() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(doSearch, 400);
});
$('#minPrice, #maxPrice').on('change', doSearch);
</script>
@endsection
