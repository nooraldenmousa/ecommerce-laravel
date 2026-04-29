<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>موظفو القسم</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>


:root{
    --bg1:#eef2f7;
    --bg2:#e3e9f3;
    --card:#ffffff;
    --text:#1f2937;
    --muted:#6b7280;
    --primary:#2563eb;
    --shadow:0 20px 50px rgba(0,0,0,0.08);
}

body.dark{
    --bg1:#0f172a;
    --bg2:#111827;
    --card:#1f2937;
    --text:#f9fafb;
    --muted:#9ca3af;
    --shadow:0 20px 50px rgba(0,0,0,0.4);
}


body{
    min-height:100vh;
    background: linear-gradient(135deg,var(--bg1),var(--bg2));
    font-family: system-ui;
    transition:0.4s;
}


.container-custom{
    max-width:1100px;
    margin:40px auto;
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
    color:var(--text);
}

.btn-back{
    background:var(--primary);
    color:white;
    border:none;
    padding:10px 14px;
    border-radius:12px;
    transition:0.3s;
}

.btn-back:hover{
    transform:translateY(-2px);
}


.toggle-btn{
    border:none;
    padding:8px 12px;
    border-radius:12px;
    background:var(--primary);
    color:white;
}


.card-box{
    background:var(--card);
    color:var(--text);
    border-radius:18px;
    padding:20px;
    box-shadow:var(--shadow);
    margin-bottom:20px;
}


.emp-card{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px;
    border-radius:15px;
    background:rgba(255,255,255,0.03);
    border:1px solid rgba(0,0,0,0.05);
    margin-bottom:10px;
    transition:0.3s;
}

.emp-card:hover{
    transform:translateY(-3px);
}

.badge-role{
    padding:6px 12px;
    border-radius:20px;
    background:var(--primary);
    color:white;
    font-size:13px;
}


.icon-btn{
    width:38px;
    height:38px;
    border-radius:10px;
    border:none;
    color:white;
}

.remove{ background:#ef4444; }
.save{ background:#22c55e; }


.form-select, .form-control{
    border-radius:12px;
}


.empty{
    text-align:center;
    color:var(--muted);
    padding:20px;
}

</style>
</head>

<body>

<div class="container-custom">


    <div class="header">

        <div class="title">
            <i class="fas fa-sitemap"></i>
            قسم: {{ $department->department_name }}
        </div>

        <div style="display:flex;gap:10px;">
            <button class="toggle-btn" onclick="toggleTheme()">🌙 / ☀️</button>

            <a href="{{ route('hr.departments.index') }}" class="btn-back">
                <i class="fas fa-arrow-right"></i> رجوع
            </a>
        </div>

    </div>


    @if(session('success'))
        <div class="alert text-center bg-success text-white rounded-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert text-center bg-danger text-white rounded-3">
            {{ session('error') }}
        </div>
    @endif


    <div class="card-box">

        <h5 class="mb-3">👥 موظفو القسم</h5>

        @forelse($employees as $e)

        <div class="emp-card">

            <div>
                <div style="font-weight:700;">
                    {{ $e->firstNmae }} {{ $e->lastName }}
                </div>

                <span class="badge-role">
                    {{ $e->role_name }}
                </span>
            </div>

            @if(session('role_id') == 1)

            <div style="display:flex;gap:8px;align-items:center;">


                <form action="{{ route('hr.departments.remove', $department->department_id) }}"
                      method="POST">
                    @csrf
                    <input type="hidden" name="personal_id" value="{{ $e->personal_id }}">

                    <button class="icon-btn remove"
                            onclick="return confirm('إزالة الموظف؟')">
                        <i class="fas fa-user-minus"></i>
                    </button>
                </form>

                <form action="{{ route('hr.departments.changeRole', $department->department_id) }}"
                      method="POST" style="display:flex;gap:5px;">
                    @csrf

                    <input type="hidden" name="personal_id" value="{{ $e->personal_id }}">

                    <select name="role_id" class="form-select form-select-sm" style="width:110px;">
                        <option value="1" {{ $e->role_id == 1 ? 'selected' : '' }}>مدير</option>
                        <option value="2" {{ $e->role_id == 2 ? 'selected' : '' }}>موظف</option>
                    </select>

                    <button class="icon-btn save">
                        <i class="fas fa-check"></i>
                    </button>
                </form>

            </div>

            @endif

        </div>

        @empty
            <div class="empty">لا يوجد موظفون في هذا القسم</div>
        @endforelse

    </div>


    @if(session('role_id') == 1 && count($availableEmployees) > 0)

    <div class="card-box">

        <h5 class="mb-3">➕ تعيين موظف</h5>

        <form action="{{ route('hr.departments.assign', $department->department_id) }}"
              method="POST" style="display:flex;gap:10px;">
            @csrf

            <select name="personal_id" class="form-select">
                <option value="">اختر موظف</option>
                @foreach($availableEmployees as $emp)
                    <option value="{{ $emp->personal_id }}">
                        {{ $emp->firstNmae }} {{ $emp->lastName }}
                    </option>
                @endforeach
            </select>

            <button class="btn btn-primary">
                <i class="fas fa-plus"></i> تعيين
            </button>

        </form>

    </div>

    @endif

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
