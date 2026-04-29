

<?php $__env->startSection('title', 'المستودعات'); ?>
<?php $__env->startSection('page-title', 'إدارة المستودعات'); ?>

<?php $__env->startSection('content'); ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('warehouse.dashboard')); ?>">لوحة التحكم</a>
        </li>
        <li class="breadcrumb-item active">المستودعات</li>
    </ol>
</nav>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold" style="color:#1a365d;">
        <i class="fas fa-warehouse me-2"></i>قائمة المستودعات
    </h5>
    <?php if(session('user.role') === 'manager'): ?>
    <a href="<?php echo e(route('warehouse.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>إضافة مستودع
    </a>
    <?php endif; ?>
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
                       value="<?php echo e($search); ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">
                    <i class="fas fa-map-marker-alt me-1"></i>تصفية بالمدينة
                </label>
                <select id="cityFilter" class="form-select">
                    <option value="">كل المدن</option>
                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($c->city); ?>"
                            <?php echo e($city === $c->city ? 'selected' : ''); ?>>
                            <?php echo e($c->city); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        عدد النتائج: <span id="resultsCount" class="fw-bold text-primary"><?php echo e(count($warehouses)); ?></span>
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
                    <?php $__empty_1 = true; $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($warehouse->warehouse_id); ?></td>
                        <td>
                            <i class="fas fa-warehouse text-primary me-2"></i>
                            <strong><?php echo e($warehouse->warehouse_name); ?></strong>
                        </td>
                        <td>
                            <i class="fas fa-map-marker-alt text-danger me-1"></i>
                            <?php echo e($warehouse->city ?? '—'); ?>

                        </td>
                        <td><?php echo e($warehouse->address ?? '—'); ?></td>
                        <td>
                            <i class="fas fa-phone text-success me-1"></i>
                            <?php echo e($warehouse->phone ?? '—'); ?>

                        </td>
                        <td>
                            <?php if($warehouse->manager_name): ?>
                                <span class="badge bg-primary">
                                    <i class="fas fa-user me-1"></i>
                                    <?php echo e($warehouse->manager_name); ?>

                                </span>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($warehouse->upload_file): ?>
                                <a href="<?php echo e(asset('uploads/warehouses/' . $warehouse->upload_file)); ?>"
                                   target="_blank" class="btn btn-sm btn-outline-info">
                                    <i class="fas fa-download me-1"></i>تحميل
                                </a>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <!-- عرض التفاصيل -->
                                <a href="<?php echo e(route('warehouse.show', $warehouse->warehouse_id)); ?>"
                                   class="btn btn-sm btn-outline-primary"
                                   title="عرض التفاصيل">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- تعديل -->
                                <a href="<?php echo e(route('warehouse.edit', $warehouse->warehouse_id)); ?>"
                                   class="btn btn-sm btn-outline-warning"
                                   title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- ربط المتاجر -->
                                <a href="<?php echo e(route('warehouse.stores', $warehouse->warehouse_id)); ?>"
                                   class="btn btn-sm btn-outline-info"
                                   title="ربط المتاجر">
                                    <i class="fas fa-store"></i>
                                </a>

                                <!-- ربط المنتجات -->
                                <a href="<?php echo e(route('warehouse.products', $warehouse->warehouse_id)); ?>"
                                   class="btn btn-sm btn-outline-success"
                                   title="ربط المنتجات">
                                    <i class="fas fa-boxes"></i>
                                </a>

                                <!-- حذف - للمانجر فقط -->
                                <?php if(session('user.role') === 'manager'): ?>
                                <form action="<?php echo e(route('warehouse.destroy', $warehouse->warehouse_id)); ?>"
                                      method="POST"
                                      onsubmit="return confirmDelete()">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            title="حذف">
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
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            لا توجد مستودعات
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

                const deleteBtn = <?php echo json_encode(session('user.role') === 'manager', 15, 512) ?>
                    ? `<form action="/warehouse/${w.warehouse_id}" method="POST" onsubmit="return confirmDelete()" style="display:inline">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/warehouse/index.blade.php ENDPATH**/ ?>