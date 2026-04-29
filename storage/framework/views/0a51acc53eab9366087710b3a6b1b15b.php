<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>تعديل بيانات المتجر: <?php echo e($store->store_name); ?>

                    </h5>
                    <a href="<?php echo e(route('block3.stores.index')); ?>" class="btn btn-sm btn-light">عودة للقائمة</a>
                </div>

                <div class="card-body p-4">
                    
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    
                    <form action="<?php echo e(route('block3.stores.update', $store->store_id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <label class="form-label fw-bold">اسم المتجر</label>
                            <input type="text" name="store_name" class="form-control" value="<?php echo e(old('store_name', $store->store_name)); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">المدينة</label>
                            <input type="text" name="city" class="form-control" value="<?php echo e(old('city', $store->city)); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">العنوان التفصيلي</label>
                            <input type="text" name="address" class="form-control" value="<?php echo e(old('address', $store->address)); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">رقم الهاتف</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone', $store->phone)); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">ملف البروشور (اختياري)</label>
                            <input type="file" name="brochure" class="form-control">
                            <?php if($store->upload_file): ?>
                                <small class="text-muted">الملف الحالي: <?php echo e($store->upload_file); ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">المنتجات المتوفرة في هذا الفرع</label>
                            <select name="products[]" class="form-select" multiple size="5">
                                <?php $__currentLoopData = $all_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($product->product_id); ?>"
                                        <?php echo e($store->products->contains('product_id', $product->product_id) ? 'selected' : ''); ?>>
                                        <?php echo e($product->product_name); ?> - (<?php echo e($product->price); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>حفظ التغييرات
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/block3/stores/edit.blade.php ENDPATH**/ ?>