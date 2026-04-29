

<?php $__env->startSection('title', 'تفاصيل المستودع'); ?>
<?php $__env->startSection('page-title', 'تفاصيل المستودع'); ?>

<?php $__env->startSection('content'); ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('warehouse.dashboard')); ?>">لوحة التحكم</a>
        </li>
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('warehouse.index')); ?>">المستودعات</a>
        </li>
        <li class="breadcrumb-item active">تفاصيل</li>
    </ol>
</nav>

<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold" style="color:#1a365d;">
        <i class="fas fa-warehouse me-2"></i><?php echo e($warehouse->warehouse_name); ?>

    </h5>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('warehouse.edit', $warehouse->warehouse_id)); ?>"
           class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>تعديل
        </a>
        <?php if(session('user.role') === 'manager'): ?>
        <form action="<?php echo e(route('warehouse.destroy', $warehouse->warehouse_id)); ?>"
              method="POST" onsubmit="return confirmDelete()">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash me-2"></i>حذف
            </button>
        </form>
        <?php endif; ?>
        <a href="<?php echo e(route('warehouse.index')); ?>" class="btn btn-outline-secondary">
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
                            <td><?php echo e($warehouse->warehouse_id); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-warehouse me-2"></i>الاسم
                            </td>
                            <td><strong><?php echo e($warehouse->warehouse_name); ?></strong></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-map-marker-alt me-2"></i>المدينة
                            </td>
                            <td><?php echo e($warehouse->city ?? '—'); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-map-pin me-2"></i>العنوان
                            </td>
                            <td><?php echo e($warehouse->address ?? '—'); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-phone me-2"></i>الهاتف
                            </td>
                            <td><?php echo e($warehouse->phone ?? '—'); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-user-tie me-2"></i>المدير
                            </td>
                            <td>
                                <?php if($warehouse->manager_name): ?>
                                    <span class="badge bg-primary">
                                        <?php echo e($warehouse->manager_name); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">غير محدد</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-file me-2"></i>البروشور
                            </td>
                            <td>
                                <?php if($warehouse->upload_file): ?>
                                    <a href="<?php echo e(asset('uploads/warehouses/' . $warehouse->upload_file)); ?>"
                                       target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-download me-1"></i>تحميل البروشور
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">لا يوجد</span>
                                <?php endif; ?>
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
                    الموظفين (<?php echo e(count($employees)); ?>)
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
                            <?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <i class="fas fa-user-circle text-info me-2"></i>
                                    <?php echo e($emp->full_name); ?>

                                </td>
                                <td>
                                    <?php if(strtolower($emp->role) === 'manager'): ?>
                                        <span class="badge bg-danger">مدير</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">موظف</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="2" class="text-center text-muted py-3">
                                    <i class="fas fa-users-slash me-2"></i>
                                    لا يوجد موظفون
                                </td>
                            </tr>
                            <?php endif; ?>
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
                    المتاجر المرتبطة (<?php echo e(count($stores)); ?>)
                </span>
                <a href="<?php echo e(route('warehouse.stores', $warehouse->warehouse_id)); ?>"
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
                            <?php $__empty_1 = true; $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <i class="fas fa-store text-warning me-2"></i>
                                    <?php echo e($store->store_name); ?>

                                </td>
                                <td><?php echo e($store->city ?? '—'); ?></td>
                                <td><?php echo e($store->phone ?? '—'); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    <i class="fas fa-store-slash me-2"></i>
                                    لا توجد متاجر مرتبطة
                                </td>
                            </tr>
                            <?php endif; ?>
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
                    المنتجات المخزنة (<?php echo e(count($products)); ?>)
                </span>
                <a href="<?php echo e(route('warehouse.products', $warehouse->warehouse_id)); ?>"
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
                            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <i class="fas fa-box text-success me-2"></i>
                                    <?php echo e($product->product_name); ?>

                                </td>
                                <td>
                                    <span class="badge bg-success">
                                        $<?php echo e(number_format($product->price, 2)); ?>

                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?php echo e(Str::limit($product->description, 40) ?? '—'); ?>

                                    </small>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    <i class="fas fa-box-open me-2"></i>
                                    لا توجد منتجات مخزنة
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function confirmDelete() {
        return confirm('هل أنت متأكد من حذف هذا المستودع؟');
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/warehouse/show.blade.php ENDPATH**/ ?>