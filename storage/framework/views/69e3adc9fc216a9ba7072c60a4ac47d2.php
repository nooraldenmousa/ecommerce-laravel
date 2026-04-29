<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>تفاصيل الموظف</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>


body{
    margin:0;
    font-family:Poppins, sans-serif;
    background: linear-gradient(135deg, #edf4ff, #f8fbff);
    min-height:100vh;
    transition:0.3s;
}


.container-custom{
    max-width:1100px;
    margin:40px auto;
    padding:20px;
}


.profile-card{
    background: rgba(255,255,255,0.4);
    backdrop-filter: blur(25px);
    border-radius:30px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    overflow:hidden;
    animation: fadeIn 0.6s ease;
}

.card-header{
    background: linear-gradient(135deg, #3A86FF, #00c6ff);
    color:white;
    text-align:center;
    font-size:22px;
    font-weight:700;
    padding:20px;
}

.profile-img{
    width:130px;
    height:130px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #3A86FF;
    margin-top:20px;
}

.info-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:15px;
    padding:25px;
}

.info-box{
    background: rgba(255,255,255,0.5);
    border-radius:18px;
    padding:15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    transition:0.3s;
}

.info-box:hover{
    transform:translateY(-4px);
}

.label{
    font-weight:600;
    color:#2c3e50;
    font-size:14px;
}

.value{
    color:#555;
    margin-top:5px;
}

.btn-back{
    display:inline-block;
    background: linear-gradient(135deg, #3A86FF, #00c6ff);
    color:white;
    padding:10px 25px;
    border-radius:25px;
    text-decoration:none;
    font-weight:600;
    transition:0.3s;
}

.btn-back:hover{
    transform:scale(1.05);
}

body.dark{
    background: linear-gradient(135deg, #0f172a, #1e293b);
    color:#f1f5f9;
}

body.dark .profile-card{
    background: rgba(30,40,60,0.6);
    box-shadow:0 20px 50px rgba(0,0,0,0.5);
}

body.dark .info-box{
    background: rgba(15,23,42,0.7);
}

body.dark .label{
    color:#e2e8f0;
}

body.dark .value{
    color:#cbd5e1;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

</style>
</head>

<body>

<div class="container-custom">

<div class="profile-card">

    <div class="card-header">
        <i class="fas fa-user-circle"></i> تفاصيل الموظف
    </div>

    <div class="text-center">
        <img class="profile-img"
             src="<?php echo e($employee->upload_file ? asset('storage/'.$employee->upload_file) : 'https://via.placeholder.com/120'); ?>">
    </div>

    <div class="info-grid">

        <div class="info-box">
            <div class="label">الاسم الأول</div>
            <div class="value"><?php echo e($employee->firstNmae); ?></div>
        </div>

        <div class="info-box">
            <div class="label">الاسم الأخير</div>
            <div class="value"><?php echo e($employee->lastName); ?></div>
        </div>

        <div class="info-box">
            <div class="label">الأب</div>
            <div class="value"><?php echo e($employee->father); ?></div>
        </div>

        <div class="info-box">
            <div class="label">الأم</div>
            <div class="value"><?php echo e($employee->mother); ?></div>
        </div>

        <div class="info-box">
            <div class="label">الإيميل</div>
            <div class="value"><?php echo e($employee->email); ?></div>
        </div>

        <div class="info-box">
            <div class="label">الهاتف</div>
            <div class="value"><?php echo e($employee->phone); ?></div>
        </div>

        <div class="info-box">
            <div class="label">الرقم الوطني</div>
            <div class="value"><?php echo e($employee->national_number); ?></div>
        </div>

        <div class="info-box">
            <div class="label">تاريخ الميلاد</div>
            <div class="value"><?php echo e($employee->birthday); ?></div>
        </div>

        <div class="info-box">
            <div class="label">العنوان</div>
            <div class="value"><?php echo e($employee->address ?? 'غير محدد'); ?></div>
        </div>

        <div class="info-box">
            <div class="label">الراتب</div>
            <div class="value"><?php echo e($employee->salary); ?></div>
        </div>

        <div class="info-box">
            <div class="label">القسم</div>
            <div class="value"><?php echo e($employee->department->department_name ?? '-'); ?></div>
        </div>

        <div class="info-box">
            <div class="label">الوظيفة</div>
            <div class="value"><?php echo e($employee->role->type ?? '-'); ?></div>
        </div>

        <div class="info-box">
            <div class="label">الحالة</div>
            <div class="value">
                <?php echo e($employee->employeeStatus->status ?? '-'); ?>

            </div>
        </div>

    </div>

    <div class="text-center pb-4">
        <a href="<?php echo e(route('hr.employees.index')); ?>" class="btn-back">
            رجوع
        </a>
    </div>

</div>

</div>

<script>
function toggleTheme(){
    document.body.classList.toggle("dark");
    localStorage.setItem("theme",
        document.body.classList.contains("dark") ? "dark" : "light"
    );
}

window.onload = function(){
    if(localStorage.getItem("theme") === "dark"){
        document.body.classList.add("dark");
    }
}
</script>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/block1/employees/show.blade.php ENDPATH**/ ?>