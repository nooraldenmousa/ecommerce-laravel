

<?php $__env->startSection('title', 'تعديل مستودع'); ?>
<?php $__env->startSection('page-title', 'تعديل بيانات المستودع'); ?>

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
        <li class="breadcrumb-item active">تعديل</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit me-2 text-warning"></i>
                تعديل بيانات: <strong><?php echo e($warehouse->warehouse_name); ?></strong>
            </div>
            <div class="card-body p-4">

                <form action="<?php echo e(route('warehouse.update', $warehouse->warehouse_id)); ?>"
                      method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row g-4">

                        <!-- اسم المستودع -->
                        <div class="col-md-6">
                            <label class="form-label">
                                اسم المستودع <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-warehouse text-primary"></i>
                                </span>
                                <input type="text" name="warehouse_name"
                                       class="form-control <?php $__errorArgs = ['warehouse_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('warehouse_name', $warehouse->warehouse_name)); ?>">
                            </div>
                            <?php $__errorArgs = ['warehouse_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1" style="font-size:0.82rem;">
                                    <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- المدينة -->
                        <div class="col-md-6">
                            <label class="form-label">
                                المدينة <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-map-marker-alt text-danger"></i>
                                </span>
                                <input type="text" name="city"
                                       class="form-control <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('city', $warehouse->city)); ?>">
                            </div>
                            <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1" style="font-size:0.82rem;">
                                    <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- العنوان -->
                        <div class="col-md-6">
                            <label class="form-label">
                                العنوان <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-map-pin text-warning"></i>
                                </span>
                                <input type="text" name="address"
                                       class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('address', $warehouse->address)); ?>">
                            </div>
                            <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1" style="font-size:0.82rem;">
                                    <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- الهاتف -->
                        <div class="col-md-6">
                            <label class="form-label">
                                رقم الهاتف <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-phone text-success"></i>
                                </span>
                                <input type="text" name="phone"
                                       class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       value="<?php echo e(old('phone', $warehouse->phone)); ?>">
                            </div>
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-1" style="font-size:0.82rem;">
                                    <i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- المدير -->
                        <div class="col-md-6">
                            <label class="form-label">المدير المسؤول</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user-tie text-info"></i>
                                </span>
                                <select name="manager_id" class="form-select">
                                    <option value="">— اختر المدير —</option>
                                    <?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($manager->personal_id); ?>"
                                            <?php echo e(old('manager_id', $warehouse->manager_id) == $manager->personal_id ? 'selected' : ''); ?>>
                                            <?php echo e($manager->full_name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <!-- ملف البروشور -->
                        <div class="col-md-6">
                            <label class="form-label">ملف البروشور</label>

                            <!-- الملف الحالي -->
                            <?php if($warehouse->upload_file): ?>
                            <div class="mb-2 p-2 rounded-2" style="background:#f0f4f8;">
                                <small class="text-muted">الملف الحالي:</small>
                                <a href="<?php echo e(asset('uploads/warehouses/' . $warehouse->upload_file)); ?>"
                                   target="_blank" class="btn btn-sm btn-outline-info ms-2">
                                    <i class="fas fa-eye me-1"></i>عرض
                                </a>
                            </div>
                            <?php endif; ?>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-file-upload text-secondary"></i>
                                </span>
                                <input type="file" name="upload_file"
                                       class="form-control"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       onchange="previewFile(this)">
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                اتركه فارغاً للإبقاء على الملف الحالي
                            </small>
                            <div id="filePreview" class="mt-2 d-none">
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>
                                    <span id="fileName"></span>
                                </span>
                            </div>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <hr class="my-4">
                    <div class="d-flex gap-3 justify-content-end">
                        <a href="<?php echo e(route('warehouse.index')); ?>"
                           class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>إلغاء
                        </a>
                        <a href="<?php echo e(route('warehouse.show', $warehouse->warehouse_id)); ?>"
                           class="btn btn-outline-info">
                            <i class="fas fa-eye me-2"></i>عرض التفاصيل
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>حفظ التعديلات
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    function previewFile(input) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            $('#fileName').text(fileName);
            $('#filePreview').removeClass('d-none');
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/warehouse/edit.blade.php ENDPATH**/ ?>