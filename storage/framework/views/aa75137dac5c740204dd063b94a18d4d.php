<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Enter New Customer</title>
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
            max-width: 900px;
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
             
body.dark {
    background: linear-gradient(135deg, #121826, #1a1f2e);
}

body.dark .dashboard-container {
    background: transparent;
}

body.dark h1 {
    color: #e0e7ff;
}

body.dark .subtitle {
    color: #94a3b8;
}

body.dark .function-card {
    background: #1e293b;
    border-color: #334155;
    color: #f1f5f9;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
}

body.dark .function-card p {
    color: #94a3b8;
}

body.dark .card-blue {
    background: #2d3a4f;
}

body.dark .card-light {
    background: #263445;
}

body.dark .first-card {
    background: linear-gradient(135deg, #2563eb, #1e4a9e);
}

body.dark .logout-btn a {
    background: #b91c1c;
}

body.dark .logout-btn a:hover {
    background: #991b1b;
}

body.dark .badge-first {
    background: #fbbf24;
    color: #0f172a;
}
/* متغيرات الألوان للوضع الفاتح */
:root {
    --bg-color: linear-gradient(135deg, #f5f7fa 0%, #e9ecf5 100%);
    --card-bg: white;
    --text-color: #1e3a5f;
    --input-bg: white;
    --input-border: #e2e8f0;
    --label-color: #1e3a5f;
    --btn-bg: #1e3a5f;
    --btn-hover: #15304d;
    --shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

/* متغيرات الألوان للوضع الداكن - الخلفية والمربع الخارجي فقط */
body.dark {
    --bg-color: linear-gradient(135deg, #0f172a, #1a1f2e);
    --card-bg: #1e293b;  
    --text-color: #f1f5f9;
    --input-bg: white;   
    --input-border: #e2e8f0; 
    --label-color: #cbd5e1;
    --btn-bg: #051d50;
    --btn-hover: #091c42;
    --shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
}

body {
    background: var(--bg-color);
    color: var(--text-color);
    transition: background 0.3s, color 0.3s;
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
    padding: 40px 20px;
}

.form-card {
    background: var(--card-bg);
    box-shadow: var(--shadow);
    border-radius: 30px;
    padding: 40px;
    max-width: 900px;
    margin: auto;
    transition: background 0.3s, box-shadow 0.3s;
}

h2 {
    color: var(--text-color);
    margin-bottom: 30px;
    text-align: center;
    transition: color 0.3s;
}

label {
    font-weight: 600;
    color: var(--label-color);
    transition: color 0.3s;
}

.form-control, .form-select {
    background: white !important;  
    border: 1px solid #e2e8f0;
    color: #1e3a5f;
    border-radius: 10px;
    padding: 10px 15px;
}

.form-control:focus, .form-select:focus {
    border-color: #03193b;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    outline: none;
}


.btn-submit {
    background: var(--btn-bg);
    color: rgb(255, 255, 255);
    padding: 12px 30px;
    border-radius: 50px;
    border: none;
    transition: background 0.3s, transform 0.2s;
}

.btn-submit:hover {
    background: var(--btn-hover);
    transform: scale(1.02);
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
    transition: all 0.3s;
}

.top-controls button:hover {
    background: #f8fafc;
    transform: scale(1.05);
}

body.dark .top-controls button {
    background: #2d3a4f;
    border-color: #4a5568;
    color: #f1f5f9;
}

body.dark .top-controls button:hover {
    background: #3a4a62;
}

/* رسالة النجاح */
.alert-success {
    background: #28a745;
    color: white;
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 20px;
    text-align: center;
}
    </style>
</head>
<body>

<div class="form-card">
    <h2>➕ Add New Customer</h2>

    <?php if(session('success')): ?>
        <div class="alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

<form method="POST" action="<?php echo e(route('marketing.customers.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="row g-4">
            <div class="col-md-6">
                <label>First Name</label>
                <input type="text" name="firstNmae" class="form-control" placeholder="First Name" required>
            </div>

            <div class="col-md-6">
                <label>Last Name</label>
                <input type="text" name="lastName" class="form-control" placeholder="Last Name" required>
            </div>

            <div class="col-md-6">
                <label>Father Name</label>
                <input type="text" name="father" class="form-control" placeholder="Father Name">
            </div>

            <div class="col-md-6">
                <label>ID Number (National Number)</label>
                <input type="number" name="national_number" class="form-control" placeholder="1234567890" required>
            </div>

            <div class="col-md-6">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" placeholder="+963" required>
            </div>

            <div class="col-md-6">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="customer@example.com" required>
            </div>

            <div class="col-md-6">
                <label>Birthday</label>
                <input type="date" name="birthday" class="form-control">
            </div>

            <div class="col-md-6">
                <label>Upload File (ID Image)</label>
             <input type="file" name="upload_file" class="form-control" accept="image/*">
            </div>

            <div class="col-md-4">
                <label>Customer Type</label>
                <select name="customer_type_id" class="form-control" required>
                    <option value="1">Normal</option>
                    <option value="2">VIP</option>
                </select>
            </div>

            <div class="col-md-4">
                <label>Customer Status</label>
                <select name="customer_status_id" class="form-control" required>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                </select>
            </div>

            <div class="col-12">
                <label>Notes / Address</label>
                <textarea name="address" class="form-control" rows="3" placeholder="Address or Additional Notes..."></textarea>
            </div>

            <div class="col-12 text-center mt-4">
                <button type="submit" class="btn-submit px-5 py-2">💾 Save Customer</button>
            </div>
        </div>
    </form>
</div>

<div class="top-controls">
    <button onclick="toggleLanguage()">AR / EN</button>
    <button onclick="toggleTheme()">Dark / Light</button>
</div>

<script>
    function toggleTheme() {
        document.body.classList.toggle('dark');
        localStorage.setItem('theme', 
            document.body.classList.contains('dark') ? 'dark' : 'light');
    }

    let currentLang = localStorage.getItem('lang') || 'en';

    function toggleLanguage() {
        currentLang = currentLang === 'en' ? 'ar' : 'en';
        localStorage.setItem('lang', currentLang);
        applyLanguage();
    }
    
    function applyLanguage() {
        const html = document.documentElement;
        
        if(currentLang === 'ar') {
            html.setAttribute('dir', 'rtl');
            document.querySelector('h2').textContent = '➕ إدخال عميل جديد';
            // يمكنك إضافة المزيد من الترجمة هنا
        } else {
            html.setAttribute('dir', 'ltr');
            document.querySelector('h2').textContent = '➕ Add New Customer';
        }
    }
    
    window.onload = function() {
        if(localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark');
        }
        applyLanguage();
    }
</script>
</body>
</html><?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/customers/create.blade.php ENDPATH**/ ?>