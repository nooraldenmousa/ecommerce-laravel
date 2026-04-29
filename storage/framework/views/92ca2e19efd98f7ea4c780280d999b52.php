<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة عرض جديد</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #e9ecf5);
            font-family: 'Segoe UI', sans-serif;
            padding: 40px 20px;
        }

        .form-card {
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            max-width: 800px;
            margin: auto;
        }

        h2 {
            color: #1a3b5d;
            margin-bottom: 30px;
            text-align: center;
        }

        label {
            font-weight: 600;
            color: #1e3a5f;
        }

        .btn-submit {
            background: #1e3a5f;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            border: none;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: #15304d;
        }

        .btn-back {
            background: #6c757d;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            border: none;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-back:hover {
            background: #5a6268;
            color: white;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 15px;
        }

        .top-controls {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
        }

        .top-controls button {
            background: white;
            border: 1px solid #e2e8f0;
            color: #1e3a5f;
            padding: 8px 16px;
            border-radius: 30px;
            margin-left: 10px;
            cursor: pointer;
        }

        body.dark {
            background: linear-gradient(135deg, #121826, #1a1f2e);
        }

        body.dark .form-card {
            background: #1e293b;
        }

        body.dark h2 {
            color: #f1f5f9;
        }

        body.dark label {
            color: #cbd5e1;
        }

        body.dark .form-control {
            background: #334155;
            border-color: #475569;
            color: #f1f5f9;
        }

        body.dark .btn-back {
            background: #475569;
        }

        body.dark .top-controls button {
            background: #2d3a4f;
            color: #f1f5f9;
        }
    </style>
</head>
<body>

<div class="top-controls">
    <button onclick="toggleTheme()">🌙 Dark / 🌞 Light</button>
    <button onclick="toggleLanguage()">🌐 AR / EN</button>
</div>

<div class="form-card">
    <h2 id="pageTitle">➕ إضافة عرض جديد</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($error); ?><br>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('marketing.offers.store')); ?>">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label id="nameLabel" class="form-label">اسم العرض</label>
            <input type="text" name="offer_name" class="form-control" value="<?php echo e(old('offer_name')); ?>" required>
        </div>

        <div class="mb-3">
            <label id="detailsLabel" class="form-label">تفاصيل العرض</label>
            <textarea name="offer_details" class="form-control" rows="3"><?php echo e(old('offer_details')); ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label id="startLabel" class="form-label">تاريخ البداية</label>
                <input type="date" name="start_date" class="form-control" value="<?php echo e(old('start_date')); ?>">
            </div>

            <div class="col-md-6 mb-3">
                <label id="endLabel" class="form-label">تاريخ النهاية</label>
                <input type="date" name="end_date" class="form-control" value="<?php echo e(old('end_date')); ?>">
            </div>
        </div>

        <div class="mb-3">
            <label id="statusLabel" class="form-label">الحالة</label>
            <select name="status" class="form-control">
                <option value="نشط" <?php echo e(old('status') == 'نشط' ? 'selected' : ''); ?>>نشط</option>
                <option value="منتهي" <?php echo e(old('status') == 'منتهي' ? 'selected' : ''); ?>>منتهي</option>
            </select>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn-submit px-5 py-2" id="saveBtn">💾 حفظ العرض</button>
            <a href="<?php echo e(route('marketing.offers.index')); ?>" class="btn-back px-4 py-2" id="cancelBtn">🔙 إلغاء</a>
        </div>
    </form>
</div>

<script>
    function toggleTheme() {
        document.body.classList.toggle('dark');
        localStorage.setItem('theme', document.body.classList.contains('dark') ? 'dark' : 'light');
    }

    let currentLang = localStorage.getItem('lang') || 'ar';

    function toggleLanguage() {
        currentLang = currentLang === 'en' ? 'ar' : 'en';
        localStorage.setItem('lang', currentLang);
        applyLanguage();
    }

    function applyLanguage() {
        const html = document.documentElement;

        if (currentLang === 'ar') {
            html.setAttribute('dir', 'rtl');
            document.getElementById('pageTitle').innerHTML = '➕ إضافة عرض جديد';
            document.getElementById('nameLabel').innerHTML = 'اسم العرض';
            document.getElementById('detailsLabel').innerHTML = 'تفاصيل العرض';
            document.getElementById('startLabel').innerHTML = 'تاريخ البداية';
            document.getElementById('endLabel').innerHTML = 'تاريخ النهاية';
            document.getElementById('statusLabel').innerHTML = 'الحالة';
            document.getElementById('saveBtn').innerHTML = '💾 حفظ العرض';
            document.getElementById('cancelBtn').innerHTML = '🔙 إلغاء';
        } else {
            html.setAttribute('dir', 'ltr');
            document.getElementById('pageTitle').innerHTML = '➕ Add New Offer';
            document.getElementById('nameLabel').innerHTML = 'Offer Name';
            document.getElementById('detailsLabel').innerHTML = 'Offer Details';
            document.getElementById('startLabel').innerHTML = 'Start Date';
            document.getElementById('endLabel').innerHTML = 'End Date';
            document.getElementById('statusLabel').innerHTML = 'Status';
            document.getElementById('saveBtn').innerHTML = '💾 Save Offer';
            document.getElementById('cancelBtn').innerHTML = '🔙 Cancel';
        }
    }

    window.onload = function() {
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark');
        }
        applyLanguage();
    }
</script>

</body>
</html><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/offers/create.blade.php ENDPATH**/ ?>