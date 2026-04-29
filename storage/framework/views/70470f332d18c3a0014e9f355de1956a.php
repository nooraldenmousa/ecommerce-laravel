<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تفاصيل العرض</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { transition: background 0.3s, color 0.2s, border-color 0.2s; }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecf5 100%);
            font-family: 'Segoe UI', sans-serif;
            padding: 40px;
        }
        
        .card { border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: none; overflow: hidden; }
        .card-header { background: linear-gradient(135deg, #4285f4, #5a9cff); color: white; font-weight: 600; font-size: 1.5rem; padding: 20px; }
        .info-row { padding: 12px 0; border-bottom: 1px solid #eee; }
        .info-label { font-weight: 600; color: #2c3e50; }
        .info-value { color: #555; }
        .btn-back { background: #2c3e50; color: white; border-radius: 25px; padding: 8px 25px; text-decoration: none; }
        .btn-back:hover { background: #1a252f; color: white; }
        .top-controls { text-align: center; margin-bottom: 30px; display: flex; gap: 15px; justify-content: center; }
        .top-controls button { background: #2c3e50; color: white; border: none; padding: 8px 20px; border-radius: 25px; cursor: pointer; }
        .form-check { margin: 10px 0; }
        
        /* ========== Dark Mode ========== */
        body.dark {
            background: linear-gradient(135deg, #121826, #1a1f2e);
        }
        
        body.dark .card {
            background: #1e293b;
        }
        
        body.dark .info-label {
            color: #cbd5e1;
        }
        
        body.dark .info-value {
            color: #94a3b8;
        }
        
        body.dark .info-row {
            border-bottom-color: #334155;
        }
        
        body.dark .top-controls button {
            background: #0f172a;
        }
        
        body.dark .card-header {
            background: linear-gradient(135deg, #1e4a9e, #2563eb);
        }
        
        body.dark .btn-back {
            background: #0f172a;
        }
        
        body.dark .btn-back:hover {
            background: #1e293b;
        }
        
        /* تحسين قسم توزيع العرض في الوضع الداكن */
        body.dark .bg-warning {
            background-color: #b45309 !important;
            color: white;
        }
        
        body.dark .form-check-label {
            color: #e2e8f0;
        }
        
        body.dark .btn-primary {
            background-color: #2563eb;
            border-color: #2563eb;
            color: white;
        }
        
        body.dark .btn-primary:hover {
            background-color: #1d4ed8;
        }
    </style>
</head>
<body>

<div class="top-controls">
    <button onclick="toggleTheme()">🌙 Dark / 🌞 Light</button>
    <button onclick="toggleLanguage()">🌐 AR / EN</button>
    <a href="<?php echo e(route('dashboard')); ?>" class="btn-back" style="text-decoration:none;"><i class="bi bi-house-door"></i> Dashboard</a>
</div>

<div class="container">
    <div class="card">
        <div class="card-header"><i class="fas fa-gift"></i> <span id="cardTitle">تفاصيل العرض</span></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6"><div class="info-row"><span class="info-label" id="nameLabel">اسم العرض:</span><span class="info-value"><?php echo e($offer->offer_name); ?></span></div></div>
                <div class="col-md-6"><div class="info-row"><span class="info-label" id="detailsLabel">التفاصيل:</span><span class="info-value"><?php echo e($offer->offer_details ?? '-'); ?></span></div></div>
                <div class="col-md-6"><div class="info-row"><span class="info-label" id="startLabel">تاريخ البداية:</span><span class="info-value"><?php echo e($offer->start_date ? \Carbon\Carbon::parse($offer->start_date)->format('d/m/Y') : '-'); ?></span></div></div>
                <div class="col-md-6"><div class="info-row"><span class="info-label" id="endLabel">تاريخ النهاية:</span><span class="info-value"><?php echo e($offer->end_date ? \Carbon\Carbon::parse($offer->end_date)->format('d/m/Y') : '-'); ?></span></div></div>
                <div class="col-md-6"><div class="info-row"><span class="info-label" id="statusLabel">الحالة:</span><span class="info-value"><?php echo e($offer->status ?? 'نشط'); ?></span></div></div>
            </div>
        </div>

        <!-- قسم توزيع العرض على VIP (للمدير فقط) -->
        <?php if(session('user.role') === 'manager'): ?>
            <div class="card mt-3" style="margin: 20px;">
                <div class="card-header bg-warning">🎁 توزيع العرض على VIP</div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('marketing.offers.assign.store', $offer->offer_id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php $__empty_1 = true; $__currentLoopData = $vipCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="form-check">
                                <input type="checkbox" name="customer_ids[]" value="<?php echo e($customer->personal_id); ?>" class="form-check-input" id="cust<?php echo e($customer->personal_id); ?>"
                                    <?php echo e($offer->customers->contains($customer->personal_id) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="cust<?php echo e($customer->personal_id); ?>"><?php echo e($customer->firstNmae); ?> <?php echo e($customer->lastName); ?> (<?php echo e($customer->email); ?>)</label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p id="noVipText">لا يوجد زبائن من نوع VIP حالياً</p>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary mt-3" id="saveAssignBtn">💾 حفظ التوزيع</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <div class="card-footer text-center">
            <a href="<?php echo e(route('marketing.offers.index')); ?>" class="btn-back"><i class="fas fa-arrow-right"></i> <span id="backText">العودة إلى القائمة</span></a>
        </div>
    </div>
</div>

<script>
    function toggleTheme() { 
        document.body.classList.toggle("dark"); 
        localStorage.setItem("theme", document.body.classList.contains("dark") ? "dark" : "light"); 
    }
    
    let currentLang = localStorage.getItem("lang") || "ar";
    
    function toggleLanguage() { 
        currentLang = currentLang === "en" ? "ar" : "en"; 
        localStorage.setItem("lang", currentLang); 
        applyLanguage(); 
    }
    
    function applyLanguage() {
        if (currentLang === "ar") {
            document.documentElement.setAttribute("dir", "rtl");
            document.getElementById("cardTitle").innerHTML = "تفاصيل العرض";
            document.getElementById("nameLabel").innerHTML = "اسم العرض:";
            document.getElementById("detailsLabel").innerHTML = "التفاصيل:";
            document.getElementById("startLabel").innerHTML = "تاريخ البداية:";
            document.getElementById("endLabel").innerHTML = "تاريخ النهاية:";
            document.getElementById("statusLabel").innerHTML = "الحالة:";
            document.getElementById("backText").innerHTML = "العودة إلى القائمة";
            document.getElementById("saveAssignBtn").innerHTML = "💾 حفظ التوزيع";
            if(document.getElementById("noVipText")) document.getElementById("noVipText").innerHTML = "لا يوجد زبائن من نوع VIP حالياً";
        } else {
            document.documentElement.setAttribute("dir", "ltr");
            document.getElementById("cardTitle").innerHTML = "Offer Details";
            document.getElementById("nameLabel").innerHTML = "Offer Name:";
            document.getElementById("detailsLabel").innerHTML = "Details:";
            document.getElementById("startLabel").innerHTML = "Start Date:";
            document.getElementById("endLabel").innerHTML = "End Date:";
            document.getElementById("statusLabel").innerHTML = "Status:";
            document.getElementById("backText").innerHTML = "Back to List";
            document.getElementById("saveAssignBtn").innerHTML = "💾 Save Distribution";
            if(document.getElementById("noVipText")) document.getElementById("noVipText").innerHTML = "No VIP customers available";
        }
    }
    
    window.onload = function() { 
        if (localStorage.getItem("theme") === "dark") document.body.classList.add("dark"); 
        applyLanguage(); 
    }
</script>
</body>
</html><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/offers/show.blade.php ENDPATH**/ ?>