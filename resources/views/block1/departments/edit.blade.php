<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>تعديل قسم</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>


:root{
    --bg1:#eef2f7;
    --bg2:#e3e9f3;
    --card:#ffffff;
    --text:#1f2937;
    --primary:#4f6aa8;
    --shadow:0 20px 50px rgba(0,0,0,0.08);
}

body.dark{
    --bg1:#0f172a;
    --bg2:#111827;
    --card:#1f2937;
    --text:#f9fafb;
    --primary:#3b4f7a;
    --shadow:0 20px 50px rgba(0,0,0,0.4);
}


body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: linear-gradient(135deg,var(--bg1),var(--bg2));
    font-family: system-ui;
    transition:0.4s;
}


.card-box{
    width:520px;
    background:var(--card);
    color:var(--text);
    border-radius:20px;
    padding:30px;
    box-shadow:var(--shadow);
    position:relative;
    overflow:hidden;
}


.card-box::before{
    content:"";
    position:absolute;
    width:160px;
    height:160px;
    background:var(--primary);
    opacity:0.08;
    border-radius:50%;
    top:-50px;
    left:-50px;
}


.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.title{
    font-size:22px;
    font-weight:700;
}


.toggle-btn{
    border:none;
    padding:8px 12px;
    border-radius:12px;
    background:var(--primary);
    color:white;
    cursor:pointer;
}


.form-control{
    border-radius:12px;
    padding:12px;
    border:1px solid #e5e7eb;
    background:transparent;
    color:var(--text);
}

body.dark .form-control,
body.dark .form-control:focus{
    background:#0f172a !important;
    color:#f9fafb !important;
    border:1px solid #475569 !important;
    box-shadow:none !important;
}


body.dark .form-control::placeholder{
    color:#94a3b8 !important;
}


.btn-primary-custom{
    background:var(--primary);
    border:none;
    width:100%;
    padding:12px;
    border-radius:12px;
    font-weight:600;
    color:white;
    transition:0.3s;
}

.btn-primary-custom:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(79,106,168,0.25);
}

.btn-secondary{
    width:100%;
    border-radius:12px;
     box-shadow:0 10px 20px rgba(37,99,235,0.3);
}


.error-box{
    background:#ef4444;
    color:white;
    padding:10px;
    border-radius:12px;
    margin-bottom:15px;
    font-size:14px;
}

</style>
</head>

<body>

<div class="card-box">

    <div class="header">
        <div class="title">✏️ تعديل القسم</div>


    </div>

    @if($errors->any())
        <div class="error-box">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('hr.departments.update', $department->department_id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">اسم القسم</label>
            <input type="text"
                   name="department_name"
                   class="form-control"
                   value="{{ $department->department_name }}"
                   required>
        </div>

        <button type="submit" class="btn-primary-custom mb-2">
            حفظ التعديل
        </button>

        <a href="{{ route('hr.departments.index') }}"
           class="btn btn-light btn-secondary">
            رجوع
        </a>
    </form>

</div>

<script>
function toggleTheme(){
    document.body.classList.toggle("dark");
    localStorage.setItem(
        "theme",
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
