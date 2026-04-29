

<?php $__env->startSection('title', 'ربط المتاجر'); ?>
<?php $__env->startSection('page-title', 'إدارة المتاجر المرتبطة'); ?>

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
        <li class="breadcrumb-item">
            <a href="<?php echo e(route('warehouse.show', $warehouse->warehouse_id)); ?>">
                <?php echo e($warehouse->warehouse_name); ?>

            </a>
        </li>
        <li class="breadcrumb-item active">ربط المتاجر</li>
    </ol>
</nav>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold" style="color:#1a365d;">
        <i class="fas fa-store me-2"></i>
        المتاجر المرتبطة بـ: <?php echo e($warehouse->warehouse_name); ?>

    </h5>
    <a href="<?php echo e(route('warehouse.show', $warehouse->warehouse_id)); ?>"
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
                <?php if(count($availableStores) > 0): ?>
                <form action="<?php echo e(route('warehouse.stores.attach', $warehouse->warehouse_id)); ?>"
                      method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label">اختر المتجر</label>
                        <select name="store_id" class="form-select">
                            <option value="">— اختر متجر —</option>
                            <?php $__currentLoopData = $availableStores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($store->store_id); ?>">
                                    <?php echo e($store->store_name); ?>

                                    <?php if($store->city): ?>
                                        (<?php echo e($store->city); ?>)
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-link me-2"></i>ربط المتجر
                    </button>
                </form>
                <?php else: ?>
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-check-circle fa-2x text-success mb-2 d-block"></i>
                        جميع المتاجر مرتبطة بهذا المستودع
                    </div>
                <?php endif; ?>
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
                    <div class="fw-bold"><?php echo e($warehouse->warehouse_name); ?></div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">المدينة</small>
                    <div><?php echo e($warehouse->city ?? '—'); ?></div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">العنوان</small>
                    <div><?php echo e($warehouse->address ?? '—'); ?></div>
                </div>
                <div>
                    <small class="text-muted">الهاتف</small>
                    <div><?php echo e($warehouse->phone ?? '—'); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- المتاجر المرتبطة -->
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-store me-2 text-warning"></i>
                المتاجر المرتبطة (<?php echo e(count($linkedStores)); ?>)
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
                                <?php if(session('user.role') === 'manager'): ?>
                                <th>إلغاء الربط</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $linkedStores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($store->store_id); ?></td>
                                <td>
                                    <i class="fas fa-store text-warning me-2"></i>
                                    <strong><?php echo e($store->store_name); ?></strong>
                                </td>
                                <td><?php echo e($store->city ?? '—'); ?></td>
                                <td><?php echo e($store->address ?? '—'); ?></td>
                                <td><?php echo e($store->phone ?? '—'); ?></td>
                                <?php if(session('user.role') === 'manager'): ?>
                                <td>
                                    <form action="<?php echo e(route('warehouse.stores.detach', [$warehouse->warehouse_id, $store->store_id])); ?>"
                                          method="POST"
                                          onsubmit="return confirm('هل أنت متأكد من إلغاء ربط هذا المتجر؟')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-unlink me-1"></i>إلغاء
                                        </button>
                                    </form>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="fas fa-store-slash fa-3x mb-3 d-block"></i>
                                    لا توجد متاجر مرتبطة بهذا المستودع
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/warehouse/stores.blade.php ENDPATH**/ ?>