<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Employee</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>


:root{
    --bg1:#edf4ff;
    --bg2:#f8fbff;
    --card:rgba(255,255,255,0.45);
    --text:#1f2937;
    --muted:#6b7280;
    --primary:linear-gradient(135deg,#3A86FF,#00c6ff);
    --shadow:0 20px 50px rgba(0,0,0,0.10);
}


body.dark{
    --bg1:#0f172a;
    --bg2:#1e293b;
    --card:rgba(30,40,60,0.6);
    --text:#f1f5f9;
    --muted:#94a3b8;
    --shadow:0 20px 50px rgba(0,0,0,0.5);
}


body{
    margin:0;
    font-family:Poppins, sans-serif;
    background: linear-gradient(135deg,var(--bg1),var(--bg2));
    color:var(--text);
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    transition:0.3s;
}


.container{
    width:900px;
    background:var(--card);
    backdrop-filter:blur(25px);
    border-radius:30px;
    box-shadow:var(--shadow);
    padding:35px;
    animation:fadeIn 0.6s ease;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.header h2{
    margin:0;
    font-size:22px;
}

.back-btn{
    background:var(--primary);
    color:white;
    padding:10px 15px;
    border-radius:12px;
    text-decoration:none;
    font-size:13px;
}


.form-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:15px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.full{
    grid-column:span 2;
}

label{
    font-size:12px;
    font-weight:600;
    margin-bottom:6px;
    color:var(--muted);
}


input, select{
    padding:12px;
    border-radius:12px;
    border:1px solid #dbe3f0;
    outline:none;
    background:#fff;
    color:#111827;
    transition:0.3s;
}


body.dark input,
body.dark select{
    background:#0f172a !important;
    color:#f1f5f9 !important;
    border:1px solid #334155 !important;
}

input:focus, select:focus{
    border-color:#3A86FF;
    box-shadow:0 0 10px rgba(58,134,255,0.25);
}


button{
    width:100%;
    margin-top:20px;
    padding:14px;
    border:none;
    border-radius:15px;
    background:var(--primary);
    color:white;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:translateY(-3px);
}


.error{
    background:#ef4444;
    color:white;
    padding:10px;
    border-radius:12px;
    margin-bottom:15px;
}


@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}


.toggle{
    position:absolute;
    top:20px;
    left:20px;
    background:var(--primary);
    border:none;
    color:white;
    padding:8px 12px;
    border-radius:12px;
    cursor:pointer;
}

</style>
</head>

<body>



<div class="container">

    <div class="header">
        <h2><i class="fas fa-user-plus"></i> Add Employee</h2>

<a href="<?php echo e(route('hr.dashboard')); ?>" class="back-btn">            ⬅ Dashboard
        </a>
    </div>

    <?php if($errors->any()): ?>
        <div class="error">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div><?php echo e($error); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('hr.employees.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="form-grid">

            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="firstNmae" required>
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lastName" required>
            </div>

            <div class="form-group">
                <label>Birthday</label>
                <input type="date" name="birthday">
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone">
            </div>

            <div class="form-group">
                <label>Father Name</label>
                <input type="text" name="father">
            </div>

            <div class="form-group">
                <label>Mother Name</label>
                <input type="text" name="mother">
            </div>

               <div class="form-group full">
                <label>national_number</label>
                <input type="text" name="national_number">
            </div>

            <div class="form-group full">
                <label>Email</label>
                <input type="email" name="email">
            </div>

            <div class="form-group full">
                <label>Address</label>
                <input type="text" name="address">
            </div>

            <div class="form-group">
                <label>Department</label>
               <select name="department_id">
    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($d->department_id); ?>">
            <?php echo e($d->department_name); ?>

        </option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
            </div>

           <div class="form-group">
    <label>Position</label>
    <select name="role_id">
        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($role->role_id); ?>">
                <?php echo e($role->type); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

            <div class="form-group full">
                <label>Salary</label>
                <input type="number" name="salary">
            </div>

            <div class="form-group full">
                <label>Photo</label>
                <input type="file" name="upload_file">
            </div>

        </div>

        <button type="submit">
            <i class="fas fa-save"></i> Save Employee
        </button>

    </form>

</div>

<script>
function toggleTheme(){
    document.body.classList.toggle("dark");
    localStorage.setItem("theme",
        document.body.classList.contains("dark") ? "dark" : "light"
    );
}

window.onload = function(){
    if(localStorage.getItem("theme")==="dark"){
        document.body.classList.add("dark");
    }
}
</script>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\wp2 project\complete_project\resources\views/block1/employees/create.blade.php ENDPATH**/ ?>