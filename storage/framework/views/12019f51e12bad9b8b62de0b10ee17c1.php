<?php $__env->startSection('title', 'تفاصيل المنتج'); ?>
<?php $__env->startSection('page-title', 'تفاصيل المنتج'); ?>

<?php $__env->startSection('content'); ?>
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('product.dashboard')); ?>">لوحة التحكم</a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('product.index')); ?>">المنتجات</a></li>
        <li class="breadcrumb-item active">تفاصيل</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold" style="color:#1a472a;">
        <i class="fas fa-box me-2"></i><?php echo e($product->product_name); ?>

    </h5>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('product.edit', $product->product_id)); ?>" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>تعديل
        </a>
        <?php if(session('user.role') === 'manager'): ?>
        <form action="<?php echo e(route('product.destroy', $product->product_id)); ?>"
              method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash me-2"></i>حذف
            </button>
        </form>
        <?php endif; ?>
        <a href="<?php echo e(route('product.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right me-2"></i>رجوع
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- معلومات المنتج -->
    <div class="col-xl-5">
        <div class="card h-100">
            <div class="card-header">
                <i class="fas fa-info-circle me-2 text-success"></i>معلومات المنتج
            </div>
            <div class="card-body">
                <!-- صورة المنتج -->
                <div class="text-center mb-4">
                    <?php if($product->upload_file): ?>
                        <img src="<?php echo e(asset('uploads/products/' . $product->upload_file)); ?>"
                             alt="<?php echo e($product->product_name); ?>"
                             style="width:180px;height:180px;object-fit:cover;border-radius:15px;border:3px solid #40916c;box-shadow:0 5px 20px rgba(64,145,108,0.2);">
                    <?php else: ?>
                        <div style="width:180px;height:180px;background:#f0f7f4;border-radius:15px;display:flex;align-items:center;justify-content:center;margin:0 auto;border:3px solid #d8f3dc;">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="fw-bold text-muted" style="width:35%">
                                <i class="fas fa-hashtag me-2"></i>الرقم
                            </td>
                            <td><?php echo e($product->product_id); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-box me-2"></i>الاسم
                            </td>
                            <td><strong><?php echo e($product->product_name); ?></strong></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-dollar-sign me-2"></i>السعر
                            </td>
                            <td>
                                <span class="badge bg-success fs-6">
                                    $<?php echo e(number_format($product->price, 2)); ?>

                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">
                                <i class="fas fa-align-left me-2"></i>الوصف
                            </td>
                            <td><?php echo e($product->description ?? '—'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-7">
        <!-- المستودعات -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-warehouse me-2 text-primary"></i>المستودعات التي تخزن المنتج (<?php echo e(count($warehouses)); ?>)</span>
                <a href="<?php echo e(route('product.warehouses', $product->product_id)); ?>"
                   class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-cog me-1"></i>إدارة
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr><th>اسم المستودع</th><th>المدينة</th><th>الهاتف</th></tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><i class="fas fa-warehouse text-primary me-2"></i><?php echo e($warehouse->warehouse_name); ?></td>
                                <td><?php echo e($warehouse->city ?? '—'); ?></td>
                                <td><?php echo e($warehouse->phone ?? '—'); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    <i class="fas fa-warehouse me-2"></i>لا توجد مستودعات مرتبطة
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- المتاجر -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-store me-2 text-warning"></i>المتاجر التي تعرض المنتج (<?php echo e(count($stores)); ?>)</span>
                <a href="<?php echo e(route('product.stores', $product->product_id)); ?>"
                   class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-cog me-1"></i>إدارة
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr><th>اسم المتجر</th><th>المدينة</th><th>الهاتف</th></tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><i class="fas fa-store text-warning me-2"></i><?php echo e($store->store_name); ?></td>
                                <td><?php echo e($store->city ?? '—'); ?></td>
                                <td><?php echo e($store->phone ?? '—'); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">
                                    <i class="fas fa-store me-2"></i>لا توجد متاجر مرتبطة
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/product/show.blade.php ENDPATH**/ ?>