<?php $__env->startSection('title', 'المنتجات'); ?>
<?php $__env->startSection('page-title', 'إدارة المنتجات'); ?>

<?php $__env->startSection('content'); ?>
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('product.dashboard')); ?>">لوحة التحكم</a></li>
        <li class="breadcrumb-item active">المنتجات</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold" style="color:#1a472a;"><i class="fas fa-boxes me-2"></i>قائمة المنتجات</h5>
    <?php if(session('user.role') === 'manager'): ?>
    <a href="<?php echo e(route('product.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>إضافة منتج
    </a>
    <?php endif; ?>
</div>

<!-- Search -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label"><i class="fas fa-search me-1"></i>بحث باسم المنتج</label>
                <input type="text" id="searchInput" class="form-control"
                       placeholder="اكتب اسم المنتج..." value="<?php echo e($search); ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label"><i class="fas fa-dollar-sign me-1"></i>السعر من</label>
                <input type="number" id="minPrice" class="form-control" placeholder="0" value="<?php echo e($minPrice); ?>" min="0">
            </div>
            <div class="col-md-3">
                <label class="form-label"><i class="fas fa-dollar-sign me-1"></i>السعر إلى</label>
                <input type="number" id="maxPrice" class="form-control" placeholder="99999" value="<?php echo e($maxPrice); ?>" min="0">
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
        عدد النتائج: <span id="resultsCount" class="fw-bold text-success"><?php echo e(count($products)); ?></span>
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
                    <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($product->product_id); ?></td>
                        <td>
                            <?php if($product->upload_file): ?>
                                <img src="<?php echo e(asset('uploads/products/' . $product->upload_file)); ?>"
                                     style="width:45px;height:45px;object-fit:cover;border-radius:10px;">
                            <?php else: ?>
                                <div style="width:45px;height:45px;background:#f0f7f4;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td><strong><?php echo e($product->product_name); ?></strong></td>
                        <td><small class="text-muted"><?php echo e(Str::limit($product->description, 40) ?? '—'); ?></small></td>
                        <td><span class="badge bg-success fs-6">$<?php echo e(number_format($product->price, 2)); ?></span></td>
                        <td>
                            <a href="<?php echo e(route('product.warehouses', $product->product_id)); ?>"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-warehouse me-1"></i>مستودعات
                            </a>
                        </td>
                        <td>
                            <a href="<?php echo e(route('product.stores', $product->product_id)); ?>"
                               class="btn btn-sm btn-outline-warning">
                                <i class="fas fa-store me-1"></i>متاجر
                            </a>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?php echo e(route('product.show', $product->product_id)); ?>"
                                   class="btn btn-sm btn-outline-primary" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('product.edit', $product->product_id)); ?>"
                                   class="btn btn-sm btn-outline-warning" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if(session('user.role') === 'manager'): ?>
                                <form action="<?php echo e(route('product.destroy', $product->product_id)); ?>"
                                      method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>لا توجد منتجات
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
        const isManager = <?php echo json_encode(session('user.role') === 'manager', 15, 512) ?>;
        products.forEach(p => {
            const img = p.upload_file
                ? `<img src="/uploads/products/${p.upload_file}" style="width:45px;height:45px;object-fit:cover;border-radius:10px;">`
                : `<div style="width:45px;height:45px;background:#f0f7f4;border-radius:10px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-image text-muted"></i></div>`;
            const deleteBtn = isManager
                ? `<form action="/product/${p.product_id}" method="POST" onsubmit="return confirm('هل أنت متأكد؟')" style="display:inline">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/product/index.blade.php ENDPATH**/ ?>