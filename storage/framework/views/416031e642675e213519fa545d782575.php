<?php $__env->startSection('content'); ?>

<div class="container mt-4">

    
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-bold text-dark mb-0">إدارة المتاجر | <span class="text-primary">MyStore</span></h2>
            <p class="text-muted small">عرض وإدارة كافة المتاجر المسجلة في النظام</p>
        </div>
        <a href="<?php echo e(route('block3.stores.create')); ?>" class="btn btn-primary px-4 shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> إضافة متجر جديد
        </a>
    </div>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
            <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
            <i class="fas fa-exclamation-circle me-2"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('block3.stores.index')); ?>">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-bold">بحث باسم المتجر</label>
                        <input type="text" name="search" class="form-control"
                               placeholder="اكتب اسم المتجر..."
                               value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">تصفية بالمدينة</label>
                        <select name="city" class="form-select">
                            <option value="">كل المدن</option>
                            <?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($province); ?>"
                                    <?php echo e(request('city') == $province ? 'selected' : ''); ?>>
                                    <?php echo e($province); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-dark w-100">
                            <i class="fas fa-search me-1"></i> بحث
                        </button>
                        <a href="<?php echo e(route('block3.stores.index')); ?>" class="btn btn-secondary w-100">
                            <i class="fas fa-redo me-1"></i> إعادة
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <div class="mb-2">
        <span class="badge bg-secondary">عدد النتائج: <?php echo e($stores->count()); ?></span>
    </div>

    
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="py-3">المعرف</th>
                        <th class="py-3">اسم المتجر</th>
                        <th class="py-3">المدينة</th>
                        <th class="py-3">الهاتف</th>
                        <th class="py-3">البروشور</th>
                        <th class="py-3">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="fw-bold text-secondary">#<?php echo e($store->store_id); ?></td>
                            <td class="fw-bold"><?php echo e($store->store_name); ?></td>
                            <td>
                                <span class="badge bg-light text-primary border">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    <?php echo e($store->city); ?>

                                </span>
                            </td>
                            <td class="text-muted"><?php echo e($store->phone ?? '—'); ?></td>
                            <td>
                                <?php if($store->upload_file): ?>
                                    <a href="<?php echo e(route('block3.stores.download', $store->store_id)); ?>"
                                       class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-download me-1"></i> تحميل
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="<?php echo e(route('block3.stores.show', $store->store_id)); ?>"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i> عرض
                                    </a>
                                    <a href="<?php echo e(route('block3.stores.edit', $store->store_id)); ?>"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>
                                    <?php if(session('user.role') == 'manager'): ?>
                                        <form action="<?php echo e(route('block3.stores.destroy', $store->store_id)); ?>"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="py-5 text-muted">
                                <i class="fas fa-box-open d-block mb-2 fa-2x"></i>
                                لا توجد متاجر حالياً
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    $('input[name="search"]').on('input', function () {
        const search = $(this).val();
        const city = $('select[name="city"]').val();
        $.get('<?php echo e(route("block3.stores.index")); ?>', { search: search, city: city }, function (html) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTbody = doc.querySelector('tbody');
            const newCount = doc.querySelector('.badge.bg-secondary');
            if (newTbody) $('tbody').html(newTbody.innerHTML);
            if (newCount) $('.badge.bg-secondary').html(newCount.innerHTML);
        });
    });

    $('select[name="city"]').on('change', function () {
        const search = $('input[name="search"]').val();
        const city = $(this).val();
        $.get('<?php echo e(route("block3.stores.index")); ?>', { search: search, city: city }, function (html) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTbody = doc.querySelector('tbody');
            const newCount = doc.querySelector('.badge.bg-secondary');
            if (newTbody) $('tbody').html(newTbody.innerHTML);
            if (newCount) $('.badge.bg-secondary').html(newCount.innerHTML);
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/block3/stores/index.blade.php ENDPATH**/ ?>