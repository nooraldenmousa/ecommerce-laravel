<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="card shadow-sm border-0">
        
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-store me-2"></i>تفاصيل المتجر: <?php echo e($store->store_name); ?></h5>
            <a href="<?php echo e(route('block3.stores.index')); ?>" class="btn btn-sm btn-light">
                <i class="fas fa-arrow-right me-1"></i> عودة للقائمة
            </a>
        </div>

        <div class="card-body p-4">
            <div class="row">
                
                <div class="col-md-6">
                    <h6 class="text-primary border-bottom pb-2 mb-3"><i class="fas fa-info-circle me-1"></i> البيانات الأساسية</h6>
                    <table class="table table-bordered align-middle">
                        <tr>
                            <th class="bg-light w-25">رقم المتجر</th>
                            <td class="fw-bold">#<?php echo e($store->store_id); ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">اسم المتجر</th>
                            <td><?php echo e($store->store_name); ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">المدينة</th>
                            <td>
                                <span class="badge bg-info text-dark"><?php echo e($store->city); ?></span>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">العنوان</th>
                            <td><?php echo e($store->address ?? 'غير محدد'); ?></td>
                        </tr>
                    </table>
                </div>

                
                <div class="col-md-6">
                    <h6 class="text-primary border-bottom pb-2 mb-3"><i class="fas fa-user-tie me-1"></i> الإدارة والتواصل</h6>
                    <table class="table table-bordered align-middle">
                        <tr>
                            <th class="bg-light w-25">الهاتف</th>
                            <td><?php echo e($store->phone ?? 'لا يوجد هاتف'); ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">المدير المسؤول</th>
                            <td class="fw-bold text-success">
                                <i class="fas fa-user-shield me-1"></i>
                                <?php echo e($store->manager ? $store->manager->firstName . ' ' . $store->manager->lastName : 'غير محدد'); ?>

                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">البروشور</th>
                            <td>
                                <?php if($store->upload_file): ?>
                                    <a href="<?php echo e(asset('storage/' . $store->upload_file)); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-file-download"></i> عرض ملف المتجر
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small">لا يوجد ملف مرفق</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            
            <div class="row mt-4">
                <div class="col-12">
                    <h6 class="text-primary border-bottom pb-2 mb-3"><i class="fas fa-users me-1"></i> كادر موظفي المتجر</h6>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm border text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم الكامل</th>
                                    <th>رقم الهاتف</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $store->employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td class="fw-bold"><?php echo e($employee->firstName); ?> <?php echo e($employee->lastName); ?></td>
                                        <td><?php echo e($employee->phone ?? '---'); ?></td>
                                        <td><span class="badge bg-success opacity-75">موظف نشط</span></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="py-4 text-muted italic">
                                            <i class="fas fa-user-slash d-block mb-2 fa-2x opacity-25"></i>
                                            لا يوجد موظفون مربوطون بهذا المتجر حالياً.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
    <div class="col-12">
        <h6 class="text-success border-bottom pb-2 mb-3"><i class="fas fa-boxes me-1"></i> المنتجات المعروضة في هذا الفرع</h6>
        <div class="row">
            <?php $__empty_1 = true; $__currentLoopData = $store->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-md-4 mb-3">
                    <div class="card border-info h-100 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title fw-bold text-dark"><?php echo e($product->product_name); ?></h6>
                            <p class="card-text text-muted small"><?php echo e(Str::limit($product->description, 50)); ?></p>
                            <span class="badge bg-primary">السعر: <?php echo e($product->price); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12 text-center py-3 text-muted">
                    لا توجد منتجات معروضة في هذا المتجر حالياً.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
            
            <div class="mt-4 pt-3 border-top d-flex gap-2">
                <a href="<?php echo e(route('block3.stores.edit', $store->store_id)); ?>" class="btn btn-primary px-4 shadow-sm">
                    <i class="fas fa-edit me-1"></i> تعديل بيانات المتجر
                </a>
                <a href="<?php echo e(route('block3.stores.index')); ?>" class="btn btn-outline-secondary px-4">
                    إلغاء
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .table th { font-size: 0.9rem; }
    .card { border-radius: 12px; overflow: hidden; }
    .badge { font-weight: 500; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/block3/stores/show.blade.php ENDPATH**/ ?>