

<?php $__env->startSection('title', 'ربط المنتجات'); ?>
<?php $__env->startSection('page-title', 'إدارة المنتجات المخزنة'); ?>

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
        <li class="breadcrumb-item active">ربط المنتجات</li>
    </ol>
</nav>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold" style="color:#1a365d;">
        <i class="fas fa-boxes me-2"></i>
        المنتجات المخزنة في: <?php echo e($warehouse->warehouse_name); ?>

    </h5>
    <a href="<?php echo e(route('warehouse.show', $warehouse->warehouse_id)); ?>"
       class="btn btn-outline-secondary">
        <i class="fas fa-arrow-right me-2"></i>رجوع
    </a>
</div>

<div class="row g-4">

    <!-- إضافة منتج -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus-circle me-2 text-success"></i>
                تخزين منتج جديد
            </div>
            <div class="card-body">
                <?php if(count($availableProducts) > 0): ?>
                <form action="<?php echo e(route('warehouse.products.attach', $warehouse->warehouse_id)); ?>"
                      method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label">اختر المنتج</label>
                        <select name="product_id" class="form-select">
                            <option value="">— اختر منتج —</option>
                            <?php $__currentLoopData = $availableProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->product_id); ?>">
                                    <?php echo e($product->product_name); ?>

                                    <?php if($product->price): ?>
                                        — $<?php echo e(number_format($product->price, 2)); ?>

                                    <?php endif; ?>
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
                        جميع المنتجات مخزنة في هذا المستودع
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- إحصائيات -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="fas fa-chart-bar me-2 text-primary"></i>
                إحصائيات
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded-3"
                     style="background:#f0f4f8;">
                    <div>
                        <div class="fw-bold" style="color:#1a365d;">المنتجات المخزنة</div>
                        <small class="text-muted">في هذا المستودع</small>
                    </div>
                    <div class="fs-3 fw-bold text-success">
                        <?php echo e(count($linkedProducts)); ?>

                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center p-3 rounded-3"
                     style="background:#f0f4f8;">
                    <div>
                        <div class="fw-bold" style="color:#1a365d;">منتجات متاحة</div>
                        <small class="text-muted">للإضافة</small>
                    </div>
                    <div class="fs-3 fw-bold text-warning">
                        <?php echo e(count($availableProducts)); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- المنتجات المرتبطة -->
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-boxes me-2 text-success"></i>
                المنتجات المخزنة (<?php echo e(count($linkedProducts)); ?>)
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المنتج</th>
                                <th>السعر</th>
                                <th>الوصف</th>
                                <th>الصورة</th>
                                <?php if(session('user.role') === 'manager'): ?>
                                <th>إلغاء التخزين</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $linkedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($product->product_id); ?></td>
                                <td>
                                    <i class="fas fa-box text-success me-2"></i>
                                    <strong><?php echo e($product->product_name); ?></strong>
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
                                <td>
                                    <?php if($product->upload_file): ?>
                                        <img src="<?php echo e(asset('uploads/products/' . $product->upload_file)); ?>"
                                             alt="<?php echo e($product->product_name); ?>"
                                             style="width:40px; height:40px; object-fit:cover; border-radius:8px;">
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <?php if(session('user.role') === 'manager'): ?>
                                <td>
                                    <form action="<?php echo e(route('warehouse.products.detach', [$warehouse->warehouse_id, $product->product_id])); ?>"
                                          method="POST"
                                          onsubmit="return confirm('هل أنت متأكد من إلغاء تخزين هذا المنتج؟')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
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
                                    <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                                    لا توجد منتجات مخزنة في هذا المستودع
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/warehouse/products.blade.php ENDPATH**/ ?>