<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم — التسويق والزبائن</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Tajawal', sans-serif; }
        body { background: #f0f4f8; }
        .sidebar {
            width: 260px; min-height: 100vh;
            background: linear-gradient(160deg, #276749, #38a169);
            position: fixed; top: 0; right: 0;
            color: white; padding: 0;
            box-shadow: -4px 0 20px rgba(0,0,0,0.2);
            z-index: 100;
        }
        .sidebar-header { background: rgba(0,0,0,0.2); padding: 25px 20px; text-align: center; }
        .sidebar-header .icon { font-size: 2.5rem; margin-bottom: 8px; }
        .sidebar-header h5 { margin: 0; font-size: 1rem; font-weight: 700; }
        .nav-link {
            color: rgba(255,255,255,0.85) !important;
            padding: 12px 20px !important;
            display: flex; align-items: center; gap: 12px;
            transition: all 0.2s; font-size: 0.9rem;
        }
        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.15) !important;
            color: white !important;
            padding-right: 28px !important;
        }
        .nav-link i { width: 18px; text-align: center; }
        .nav-section { padding: 15px 20px 5px; font-size: 0.72rem; opacity: 0.6; }
        .main-content { margin-right: 260px; padding: 30px; }
        .topbar {
            background: white; border-radius: 16px; padding: 16px 25px;
            margin-bottom: 25px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }
        .stat-card {
            background: white; border-radius: 16px; padding: 25px;
            text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-4px); }
        .stat-icon { width: 60px; height: 60px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin: 0 auto 15px; }
        .stat-number { font-size: 2rem; font-weight: 900; color: #276749; }
        .stat-label { color: #718096; font-size: 0.88rem; margin-top: 4px; }
        .btn-logout { background: rgba(229,62,62,0.1); color: #c53030; border: none; border-radius: 10px; padding: 8px 16px; font-family: 'Tajawal', sans-serif; font-size: 0.88rem; cursor: pointer; display: flex; align-items: center; gap: 8px; }
        .btn-logout:hover { background: #e53e3e; color: white; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">
        <div class="icon">📣</div>
        <h5>التسويق والزبائن</h5>
        <small>مرحباً، <?php echo e(session('user.name')); ?></small>
    </div>

    <div class="nav-section">القائمة الرئيسية</div>
    <a href="<?php echo e(route('marketing.dashboard')); ?>" class="nav-link active">
        <i class="fas fa-home"></i> لوحة التحكم
    </a>

    <div class="nav-section">إدارة الزبائن</div>
    <a href="<?php echo e(route('marketing.customers.index')); ?>" class="nav-link">
        <i class="fas fa-users"></i> قائمة الزبائن
    </a>
    <a href="<?php echo e(route('marketing.customers.create')); ?>" class="nav-link">
        <i class="fas fa-user-plus"></i> إضافة زبون
    </a>

    <?php if(session('user.role') === 'manager'): ?>
    <div class="nav-section">العروض والهدايا</div>
    <a href="<?php echo e(route('marketing.offers.index')); ?>" class="nav-link">
        <i class="fas fa-gift"></i> العروض
    </a>
    <a href="<?php echo e(route('marketing.offers.create')); ?>" class="nav-link">
        <i class="fas fa-plus-circle"></i> إضافة عرض
    </a>
    <?php endif; ?>
</div>

<div class="main-content">
    <div class="topbar">
        <div>
            <h4 style="margin:0; color:#276749; font-weight:800;">لوحة التحكم — التسويق والزبائن</h4>
            <small class="text-muted"><?php echo e(now()->format('l، d F Y')); ?></small>
        </div>
        <form action="<?php echo e(route('logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> خروج
            </button>
        </form>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#f0fff4;">👥</div>
                <div class="stat-number"><?php echo e($totalCustomers ?? 0); ?></div>
                <div class="stat-label">إجمالي الزبائن</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fffff0;">⭐</div>
                <div class="stat-number"><?php echo e($vipCustomers ?? 0); ?></div>
                <div class="stat-label">زبائن VIP</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fff5f5;">🎯</div>
                <div class="stat-number"><?php echo e(session('user.role') === 'manager' ? 'مدير' : 'موظف'); ?></div>
                <div class="stat-label">صلاحيتك</div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-md-6">
            <div class="stat-card text-start">
                <h5 style="color:#276749; font-weight:700; margin-bottom:15px;">
                    <i class="fas fa-bolt text-warning me-2"></i> إجراءات سريعة
                </h5>
                <div class="d-flex flex-column gap-2">
                    <a href="<?php echo e(route('marketing.customers.create')); ?>" class="btn btn-success rounded-3">
                        <i class="fas fa-user-plus me-2"></i> إضافة زبون
                    </a>
                    <?php if(session('user.role') === 'manager'): ?>
                    <a href="<?php echo e(route('marketing.offers.create')); ?>" class="btn btn-outline-success rounded-3">
                        <i class="fas fa-gift me-2"></i> إضافة عرض
                    </a>
                    <?php endif; ?>
                    <a href="<?php echo e(route('marketing.customers.index')); ?>" class="btn btn-outline-secondary rounded-3">
                        <i class="fas fa-search me-2"></i> البحث عن زبون
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card text-start">
                <h5 style="color:#276749; font-weight:700; margin-bottom:15px;">
                    <i class="fas fa-info-circle text-info me-2"></i> معلومات الحساب
                </h5>
                <table class="table table-borderless mb-0" style="font-size:0.9rem;">
                    <tr>
                        <td class="text-muted">اسم المستخدم:</td>
                        <td><strong><?php echo e(session('user.username')); ?></strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">الاسم الكامل:</td>
                        <td><strong><?php echo e(session('user.name')); ?></strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">الصلاحية:</td>
                        <td>
                            <?php if(session('user.role') === 'manager'): ?>
                                <span class="badge bg-danger">مدير القسم</span>
                            <?php else: ?>
                                <span class="badge bg-success">موظف القسم</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">القسم:</td>
                        <td><strong>التسويق والزبائن</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/marketing/dashboard.blade.php ENDPATH**/ ?>