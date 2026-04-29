<?php $__env->startSection('title', 'لوحة التحكم - إدارة المنتجات'); ?>
<?php $__env->startSection('page-title', 'لوحة التحكم'); ?>

<?php $__env->startSection('content'); ?>
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">لوحة التحكم</li>
    </ol>
</nav>

<div class="row g-4 mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="stat-card bg-products">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">إجمالي المنتجات</div>
                    <div class="stat-number"><?php echo e($totalProducts); ?></div>
                    <small style="opacity:0.8">منتج مسجل في النظام</small>
                </div>
                <div class="stat-icon"><i class="fas fa-boxes"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="stat-card bg-warehouse">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">المنتجات في المستودعات</div>
                    <div class="stat-number"><?php echo e($totalWarehouses); ?></div>
                    <small style="opacity:0.8">ربط منتج-مستودع</small>
                </div>
                <div class="stat-icon"><i class="fas fa-warehouse"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="stat-card bg-stores">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label">المنتجات في المتاجر</div>
                    <div class="stat-number"><?php echo e($totalStores); ?></div>
                    <small style="opacity:0.8">ربط منتج-متجر</small>
                </div>
                <div class="stat-icon"><i class="fas fa-store"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-clock me-2 text-success"></i>آخر المنتجات المضافة</span>
                <a href="<?php echo e(route('product.index')); ?>" class="btn btn-primary btn-sm">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr><th>#</th><th>اسم المنتج</th><th>السعر</th><th>الصورة</th><th>الإجراءات</th></tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $recentProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($product->product_id); ?></td>
                                <td><i class="fas fa-box text-success me-2"></i><strong><?php echo e($product->product_name); ?></strong></td>
                                <td><span class="badge bg-success">$<?php echo e(number_format($product->price, 2)); ?></span></td>
                                <td>
                                    <?php if($product->upload_file): ?>
                                        <img src="<?php echo e(asset('uploads/products/' . $product->upload_file)); ?>"
                                             style="width:35px;height:35px;object-fit:cover;border-radius:8px;">
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('product.show', $product->product_id)); ?>"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>لا توجد منتجات بعد
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card">
            <div class="card-header"><i class="fas fa-bolt me-2 text-warning"></i>إجراءات سريعة</div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="<?php echo e(route('product.index')); ?>" class="btn btn-outline-success">
                        <i class="fas fa-list me-2"></i>عرض كل المنتجات
                    </a>
                    <?php if(session('user.role') === 'manager'): ?>
                    <a href="<?php echo e(route('product.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>إضافة منتج جديد
                    </a>
                    <?php endif; ?>
                </div>

                <div class="mt-4 p-3 rounded-3" style="background:#f0f7f4;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:45px;height:45px;background:linear-gradient(135deg,#1a472a,#40916c);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:1.1rem;">
                            <?php echo e(mb_substr(session('user.name'), 0, 1)); ?>

                        </div>
                        <div>
                            <div style="font-weight:700;color:#1a472a;"><?php echo e(session('user.name')); ?></div>
                            <div>
                                <?php if(session('user.role') === 'manager'): ?>
                                    <span class="badge bg-danger">مدير المنتجات</span>
                                <?php else: ?>
                                    <span class="badge bg-info">موظف المنتجات</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <hr style="border-color:#d8f3dc;">
                    <div style="font-size:0.82rem;color:#718096;">
                        <div class="mb-1">
                            <i class="fas fa-user-shield me-2 text-success"></i>
                            <?php if(session('user.role') === 'manager'): ?>
                                صلاحيات كاملة (إضافة، تعديل، حذف)
                            <?php else: ?>
                                صلاحيات محدودة (إضافة، تعديل)
                            <?php endif; ?>
                        </div>
                        <div><i class="fas fa-clock me-2 text-success"></i><?php echo e(now()->format('Y/m/d — H:i')); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/product/dashboard.blade.php ENDPATH**/ ?>