<?php $__env->startSection('title', 'تخزين المنتج في المستودعات'); ?>
<?php $__env->startSection('page-title', 'إدارة المستودعات'); ?>

<?php $__env->startSection('content'); ?>
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('product.dashboard')); ?>">لوحة التحكم</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('product.index')); ?>">المنتجات</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('product.show', $product->product_id)); ?>"><?php echo e($product->product_name); ?></a></li>
        <li class="breadcrumb-item active">تخزين في المستودعات</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold" style="color:#1a472a;">
        <i class="fas fa-warehouse me-2"></i>
        تخزين: <?php echo e($product->product_name); ?>

    </h5>
    <a href="<?php echo e(route('product.show', $product->product_id)); ?>" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-right me-2"></i>رجوع
    </a>
</div>

<div class="row g-4">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus-circle me-2 text-success"></i>تخزين في مستودع جديد
            </div>
            <div class="card-body">
                <?php if(count($availableWarehouses) > 0): ?>
                <form action="<?php echo e(route('product.warehouses.attach', $product->product_id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label">اختر المستودع</label>
                        <select name="warehouse_id" class="form-select">
                            <option value="">— اختر مستودع —</option>
                            <?php $__currentLoopData = $availableWarehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($warehouse->warehouse_id); ?>">
                                    <?php echo e($warehouse->warehouse_name); ?>

                                    <?php if($warehouse->city): ?>(<?php echo e($warehouse->city); ?>)<?php endif; ?>
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-plus me-2"></i>تخزين المنتج
                    </button>
                </form>
                <?php else: ?>
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-check-circle fa-2x text-success mb-2 d-block"></i>
                        المنتج مخزن في كل المستودعات المتاحة
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- معلومات المنتج -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="fas fa-box me-2 text-success"></i>معلومات المنتج
            </div>
            <div class="card-body">
                <?php if($product->upload_file): ?>
                <div class="text-center mb-3">
                    <img src="<?php echo e(asset('uploads/products/' . $product->upload_file)); ?>"
                         style="width:80px;height:80px;object-fit:cover;border-radius:10px;">
                </div>
                <?php endif; ?>
                <div class="mb-2">
                    <small class="text-muted">الاسم</small>
                    <div class="fw-bold"><?php echo e($product->product_name); ?></div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">السعر</small>
                    <div><span class="badge bg-success">$<?php echo e(number_format($product->price, 2)); ?></span></div>
                </div>
                <div>
                    <small class="text-muted">الوصف</small>
                    <div class="text-muted" style="font-size:0.85rem;"><?php echo e($product->description ?? '—'); ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-warehouse me-2 text-primary"></i>
                المستودعات التي يخزن فيها المنتج (<?php echo e(count($linkedWarehouses)); ?>)
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th><th>اسم المستودع</th><th>المدينة</th>
                                <th>العنوان</th><th>الهاتف</th>
                                <?php if(session('user.role') === 'manager'): ?><th>إلغاء التخزين</th><?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $linkedWarehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($warehouse->warehouse_id); ?></td>
                                <td><i class="fas fa-warehouse text-primary me-2"></i><strong><?php echo e($warehouse->warehouse_name); ?></strong></td>
                                <td><?php echo e($warehouse->city ?? '—'); ?></td>
                                <td><?php echo e($warehouse->address ?? '—'); ?></td>
                                <td><?php echo e($warehouse->phone ?? '—'); ?></td>
                                <?php if(session('user.role') === 'manager'): ?>
                                <td>
                                    <form action="<?php echo e(route('product.warehouses.detach', [$product->product_id, $warehouse->warehouse_id])); ?>"
                                          method="POST"
                                          onsubmit="return confirm('هل أنت متأكد من إلغاء تخزين المنتج؟')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-minus-circle me-1"></i>إلغاء
                                        </button>
                                    </form>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="fas fa-warehouse fa-3x mb-3 d-block"></i>
                                    المنتج غير مخزن في أي مستودع بعد
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/product/warehouses.blade.php ENDPATH**/ ?>