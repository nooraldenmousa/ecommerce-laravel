<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>تعديل موظف</title>

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


body.dark{
    background: linear-gradient(135deg, #0f172a, #1e293b);
    color:#f1f5f9;
}


.form-container{
    max-width:800px;
    margin:50px auto;
    padding:25px;
    background: rgba(255,255,255,0.4);
    backdrop-filter: blur(25px);
    border-radius:30px;
    box-shadow:0 20px 50px rgba(0,0,0,0.15);
    animation: fadeIn 0.6s ease;
}

body.dark .form-container{
    background: rgba(30,40,60,0.6);
    box-shadow:0 20px 50px rgba(0,0,0,0.5);
}

h3{
    text-align:center;
    font-weight:700;
    margin-bottom:25px;
    color:#2c3e50;
}

body.dark h3{
    color:#e2e8f0;
}


label{
    font-weight:600;
    font-size:14px;
    color:#2c3e50;
}

body.dark label{
    color:#e2e8f0;
}

.form-control,
.form-select{
    border-radius:14px;
    padding:10px;
    border:1px solid #dbe3f0;
    background:#fff;
    color:#111827;
}

body.dark .form-control,
body.dark .form-select{
    background:#0f172a !important;
    color:#f1f5f9 !important;
    border:1px solid #334155 !important;
}

body.dark .form-control::placeholder{
    color:#94a3b8;
}


.btn-save{
    background: linear-gradient(135deg, #3A86FF, #00c6ff);
    color:white;
    border-radius:25px;
    padding:10px 30px;
    border:none;
    font-weight:600;
    transition:0.3s;
}

.btn-save:hover{
    transform:scale(1.05);
}

.btn-secondary{
    border-radius:25px;
    padding:10px 25px;
}


.error-box{
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


.toggle-btn{
    position:absolute;
    top:20px;
    left:20px;
    border:none;
    padding:8px 12px;
    border-radius:12px;
    background:#3A86FF;
    color:white;
    cursor:pointer;
}

</style>
</head>

<body>

<div class="form-container">

    <button class="toggle-btn" onclick="toggleTheme()">🌙</button>

    <h3>✏️ تعديل معلومات الموظف</h3>

    @if($errors->any())
    <div class="error-box">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('hr.employees.update', $employee->personal_id) }}">
        @csrf
        @method('PUT')

        <div class="row g-3">

            <div class="col-md-6">
                <label>الاسم</label>
                <input type="text" name="firstNmae" class="form-control"
                       value="{{ $employee->firstNmae }}">
            </div>

            <div class="col-md-6">
                <label>الكنية</label>
                <input type="text" name="lastName" class="form-control"
                       value="{{ $employee->lastName }}">
            </div>

            <div class="col-md-6">
                <label>اسم الأب</label>
                <input type="text" name="father" class="form-control"
                       value="{{ $employee->father }}">
            </div>

            <div class="col-md-6">
                <label>اسم الأم</label>
                <input type="text" name="mother" class="form-control"
                       value="{{ $employee->mother }}">
            </div>

            <div class="col-md-6">
                <label>رقم الهاتف</label>
                <input type="text" name="phone" class="form-control"
                       value="{{ $employee->phone }}">
            </div>

            <div class="col-md-6">
                <label>الراتب</label>
                <input type="number" name="salary" class="form-control"
                       value="{{ $employee->salary }}">
            </div>

            <div class="col-md-12">
                <label>العنوان</label>
                <input type="text" name="address" class="form-control"
                       value="{{ $employee->address }}">
            </div>

            <div class="col-md-6">
                <label>القسم</label>
                <select name="department_id" class="form-select">
                    @foreach($departments as $d)
                        <option value="{{ $d->department_id }}"
                            {{ $employee->department_id == $d->department_id ? 'selected' : '' }}>
                            {{ $d->department_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label>الدور</label>
                <select name="role_id" class="form-select">
                    @foreach($roles as $r)
                        <option value="{{ $r->role_id }}"
                            {{ $employee->role_id == $r->role_id ? 'selected' : '' }}>
                            {{ $r->type }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-save">💾 حفظ التعديل</button>
            <a href="{{ route('hr.employees.index') }}" class="btn btn-secondary">رجوع</a>
        </div>

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
    if(localStorage.getItem("theme") === "dark"){
        document.body.classList.add("dark");
    }
}
</script>

</body>
</html>
