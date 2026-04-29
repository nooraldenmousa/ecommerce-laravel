<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4 bg-light min-vh-100">
    
    <div class="d-flex justify-content-between align-items-center mb-4 px-3">
        <div>
            <h3 class="fw-bold text-dark mb-0">لوحة تحكم الكتلة الثالثة</h3>
            <p class="text-muted small">مرحباً بك مجدداً في نظام إدارة MyStore</p>
        </div>
        <div class="badge bg-primary p-2 px-3 shadow-sm" style="border-radius: 50px;">
            <i class="fas fa-user-shield me-1"></i> مدير النظام
        </div>
    </div>

    
    <div class="row g-3 mb-4 text-center">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 border-start border-primary border-4">
                <div class="card-body">
                    <div class="text-primary mb-2"><i class="fas fa-store fa-2x"></i></div>
                    <div class="h4 fw-bold mb-0"><?php echo e($stores_count ?? 6); ?></div>
                    <div class="text-muted small uppercase">إجمالي المتاجر</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 border-start border-success border-4">
                <div class="card-body">
                    <div class="text-success mb-2"><i class="fas fa-warehouse fa-2x"></i></div>
                    <div class="h4 fw-bold mb-0"><?php echo e($warehouses_count ?? 0); ?></div>
                    <div class="text-muted small">المستودعات النشطة</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 border-start border-warning border-4">
                <div class="card-body">
                    <div class="text-warning mb-2"><i class="fas fa-box fa-2x"></i></div>
                    <div class="h4 fw-bold mb-0"><?php echo e($products_count ?? 4); ?></div>
                    <div class="text-muted small">أنواع المنتجات</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 border-start border-danger border-4">
                <div class="card-body">
                    <div class="text-danger mb-2"><i class="fas fa-exclamation-triangle fa-2x"></i></div>
                    <div class="h4 fw-bold mb-0 text-danger">0</div>
                    <div class="text-muted small">منتجات ناقصة</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-chart-pie me-2 text-primary"></i>نظرة عامة على النظام</h6>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div style="width: 300px;">
                        <canvas id="overviewChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100 bg-dark text-white">
                <div class="card-header bg-transparent border-0 py-3">
                    <h6 class="mb-0 fw-bold text-white"><i class="fas fa-bolt me-2 text-warning"></i>إجراءات سريعة</h6>
                </div>
                <div class="card-body">
                    <a href="<?php echo e(route('block3.stores.index')); ?>" class="btn btn-outline-light w-100 mb-3 py-2 text-start d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-tasks me-2"></i> إدارة المتاجر</span>
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <a href="<?php echo e(route('block3.stores.create')); ?>" class="btn btn-primary w-100 py-2 text-start d-flex justify-content-between align-items-center shadow">
                        <span><i class="fas fa-plus-circle me-2"></i> إضافة متجر جديد</span>
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <hr class="opacity-25">
                    <div class="p-3 bg-secondary bg-opacity-25 rounded small mt-4">
                        <i class="fas fa-info-circle me-1 text-info"></i> نصيحة اليوم: تأكد من مراجعة مخزون الفروع بشكل دوري.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('overviewChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['المتاجر', 'المستودعات', 'المنتجات'],
            datasets: [{
                data: [6, 2, 15], // بيانات تجريبية
                backgroundColor: ['#0d6efd', '#198754', '#ffc107'],
                hoverOffset: 10,
                borderWidth: 0
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' }
            },
            cutout: '70%'
        }
    });
</script>

<style>
    .card { border-radius: 15px; transition: transform 0.2s; }
    .card:hover { transform: translateY(-5px); }
    .btn { border-radius: 10px; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/block3/dashboard.blade.php ENDPATH**/ ?>