<?php $__env->startSection('title', 'عرض المنتج في المتاجر'); ?>
<?php $__env->startSection('page-title', 'إدارة المتاجر'); ?>

<?php $__env->startSection('content'); ?>
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('product.dashboard')); ?>">لوحة التحكم</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('product.index')); ?>">المنتجات</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('product.show', $product->product_id)); ?>"><?php echo e($product->product_name); ?></a></li>
        <li class="breadcrumb-item active">عرض في المتاجر</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold" style="color:#1a472a;">
        <i class="fas fa-store me-2"></i>
        عرض: <?php echo e($product->product_name); ?>

    </h5>
    <a href="<?php echo e(route('product.show', $product->product_id)); ?>" class="btn btn-outline-secondary">
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
                <?php if(count($availableStores) > 0): ?>
                <form action="<?php echo e(route('product.stores.attach', $product->product_id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label">اختر المتجر</label>
                        <select name="store_id" class="form-select">
                            <option value="">— اختر متجر —</option>
                            <?php $__currentLoopData = $availableStores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($store->store_id); ?>">
                                    <?php echo e($store->store_name); ?>

                                    <?php if($store->city): ?>(<?php echo e($store->city); ?>)<?php endif; ?>
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="fas fa-store me-2"></i>عرض في المتجر
                    </button>
                </form>
                <?php else: ?>
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-check-circle fa-2x text-success mb-2 d-block"></i>
                        المنتج معروض في كل المتاجر المتاحة
                    </div>
                <?php endif; ?>
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
                    <div class="fs-3 fw-bold text-warning"><?php echo e(count($linkedStores)); ?></div>
                </div>
                <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="background:#f0f7f4;">
                    <div>
                        <div class="fw-bold" style="color:#1a472a;">متاجر متاحة</div>
                        <small class="text-muted">للإضافة</small>
                    </div>
                    <div class="fs-3 fw-bold text-success"><?php echo e(count($availableStores)); ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-store me-2 text-warning"></i>
                المتاجر التي يعرض فيها المنتج (<?php echo e(count($linkedStores)); ?>)
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th><th>اسم المتجر</th><th>المدينة</th>
                                <th>العنوان</th><th>الهاتف</th>
                                <?php if(session('user.role') === 'manager'): ?><th>إلغاء العرض</th><?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $linkedStores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($store->store_id); ?></td>
                                <td><i class="fas fa-store text-warning me-2"></i><strong><?php echo e($store->store_name); ?></strong></td>
                                <td><?php echo e($store->city ?? '—'); ?></td>
                                <td><?php echo e($store->address ?? '—'); ?></td>
                                <td><?php echo e($store->phone ?? '—'); ?></td>
                                <?php if(session('user.role') === 'manager'): ?>
                                <td>
                                    <form action="<?php echo e(route('product.stores.detach', [$product->product_id, $store->store_id])); ?>"
                                          method="POST"
                                          onsubmit="return confirm('هل أنت متأكد من إلغاء عرض المنتج في هذا المتجر؟')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-times me-1"></i>إلغاء
                                        </button>
                                    </form>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="fas fa-store-slash fa-3x mb-3 d-block"></i>
                                    المنتج غير معروض في أي متجر بعد
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/product/stores.blade.php ENDPATH**/ ?>