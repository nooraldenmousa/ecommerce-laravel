<?php $__env->startSection('content'); ?>
<div class="container py-4">
    
    <?php if($errors->any()): ?>
        <div class="alert alert-danger shadow-sm border-0 mb-4">
            <h6 class="fw-bold"><i class="fas fa-exclamation-circle me-2"></i> خطأ في إدخال البيانات:</h6>
            <ul class="mb-0 small">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white py-3">
            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> إضافة متجر جديد</h5>
        </div>
        <div class="card-body p-4">
            <form action="<?php echo e(route('block3.stores.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">اسم المتجر <span class="text-danger">*</span></label>
                        <input type="text" name="store_name" class="form-control" value="<?php echo e(old('store_name')); ?>" placeholder="أدخل اسم المتجر" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">المحافظة <span class="text-danger">*</span></label>
                        <select name="city" class="form-select" required>
                            <option value="" disabled selected>اختر المحافظة...</option>
                            <?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($province); ?>" <?php echo e(old('city') == $province ? 'selected' : ''); ?>><?php echo e($province); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">العنوان التفصيلي</label>
                        <input type="text" name="address" class="form-control" value="<?php echo e(old('address')); ?>" placeholder="مثال: جانب حديقة الجاحظ">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone')); ?>" placeholder="أدخل رقم التواصل">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">إرفاق بروشور أو ملف المتجر</label>
                        <input type="file" name="brochure" class="form-control" accept=".pdf,.jpg,.png">
                        <small class="text-muted">الأنواع المسموحة: PDF, JPG, PNG (بحد أقصى 5MB)</small>
                    </div>
                </div>

                <div class="mt-5 text-end">
                    <a href="<?php echo e(route('block3.stores.index')); ?>" class="btn btn-light border px-4 me-2">إلغاء</a>
                    <button type="submit" class="btn btn-success px-4 shadow-sm">
                        <i class="fas fa-save me-1"></i> حفظ بيانات المتجر
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/block3/stores/create.blade.php ENDPATH**/ ?>