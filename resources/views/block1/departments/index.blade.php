<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>إدارة الأقسام</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body {
    background: linear-gradient(135deg, #edf4ff, #f8fbff);
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
}


.container-custom {
    max-width: 1150px;
    margin: 40px auto;
    padding: 20px;
    animation: fadeIn 0.6s ease;
}


.title {
    text-align: center;
    font-weight: 700;
    font-size: 28px;
    margin-bottom: 25px;
    background: linear-gradient(90deg, #3b82f6, #60a5fa);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}


.top-controls {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 25px;
}

.btn-custom {
    background: linear-gradient(135deg, #1f2a3a, #38bdf8);
    border: none;
    color: white;
    border-radius: 25px;
    padding: 10px 22px;
    font-weight: 600;
    transition: 0.3s;
    box-shadow: 0 6px 15px rgba(58,134,255,0.3);
}

.btn-custom:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 25px rgba(58,134,255,0.4);
}


.table-container {
    background: rgba(255,255,255,0.4);
    backdrop-filter: blur(25px);
    border-radius: 30px;
    padding: 25px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
}


.table {
    border-radius: 20px;
    overflow: hidden;
}

.table thead {
    background: linear-gradient(135deg, #3A86FF, #00c6ff);
    color: white;
}

.table th {
    padding: 15px;
    font-weight: 600;
    border: none;
}

.table td {
    padding: 15px;
    border: none;
    vertical-align: middle;
}

.table tbody tr {
    transition: 0.3s;
}

.table tbody tr:hover {
    background: rgba(58,134,255,0.08);
    transform: scale(1.01);
}


.dept-name {
    font-weight: 600;
    color: #2c3e50;
}


.badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    background: linear-gradient(135deg, #3A86FF, #00c6ff);
}


.btn-action {
    border-radius: 10px;
    padding: 6px 12px;
    transition: 0.2s;
}

.btn-action:hover {
    transform: scale(1.15);
}


.alert {
    border-radius: 15px;
    font-weight: 500;
}


body.dark {
    background: linear-gradient(135deg, #0f172a, #1e293b);
    color: #f1f5f9;
}

body.dark .table-container {
    background: rgba(30,40,60,0.6);
    box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}

body.dark .table thead {
    background: linear-gradient(135deg, #1e40af, #2563eb);
}

body.dark .table tbody tr:hover {
    background: rgba(255,255,255,0.05);
}

body.dark .dept-name {
    color: #2a2b2c;
}

body.dark .btn-custom {
    background: linear-gradient(135deg, #385696, #3b82f6);
}

body.dark .badge {
    background: linear-gradient(135deg, #2563eb, #3b82f6);
}

@keyframes fadeIn {
    from {opacity:0; transform: translateY(20px);}
    to {opacity:1; transform: translateY(0);}
}

body.dark .table-container{
    background: rgba(15,23,42,0.55) !important;
    backdrop-filter: blur(25px);
}


body.dark table,
body.dark thead,
body.dark tbody,
body.dark tr,
body.dark th,
body.dark td{
    background: transparent !important;
}

body.dark td{
    color: #e2e8f0 !important;
}

body.dark thead th{
    background: linear-gradient(135deg, #354066, #304572) !important;
    color: white !important;
}

body.dark tbody tr:hover{
    background: rgba(255,255,255,0.05) !important;
}


.table-bordered{
    border: none !important;
}
</style>
</head>

<body>

<div class="container-custom">


    @if(session('success'))
        <div class="alert text-center" style="background:#22c55e;color:white;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert text-center" style="background:#ef4444;color:white;">
            {{ session('error') }}
        </div>
    @endif

    <div class="top-controls">

    <button onclick="toggleTheme()" class="btn btn-custom">
        🌙 / ☀️
    </button>

    @if(session('role_id') == 1)
        <a href="{{ route('hr.departments.create') }}" class="btn btn-custom">
            <i class="fas fa-plus"></i> إضافة قسم
        </a>
    @endif

<a href="{{ route('hr.dashboard') }}" class="btn btn-custom">        <i class="fas fa-home"></i> Dashboard
    </a>

</div>

    <div class="title">
        <i class="fas fa-sitemap"></i> إدارة الأقسام
    </div>

    <div class="table-container">

        <table class="table text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم القسم</th>
                    <th>عدد الموظفين</th>
                    <th>إجراءات</th>
                </tr>
            </thead>

            <tbody>
                @forelse($departments as $i => $d)
                <tr>

                    <td>{{ $i + 1 }}</td>

                    <td class="dept-name">{{ $d->department_name }}</td>

                    <td>
                        <span class="badge">
                            {{ DB::table('PERSONAL_INFORMATION')->where('department_id', $d->department_id)->count() }}
                        </span>
                    </td>

                    <td>

                        <a href="{{ route('hr.departments.employees', $d->department_id) }}"
                           class="btn btn-info btn-sm btn-action">
                            <i class="fas fa-users"></i>
                        </a>

                        @if(session('role_id') == 1)

                        <a href="{{ route('hr.departments.edit', $d->department_id) }}"
                           class="btn btn-warning btn-sm btn-action">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('hr.departments.destroy', $d->department_id) }}"
                              method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm btn-action"
                                    onclick="return confirm('هل أنت متأكد؟')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                        @endif

                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4">لا توجد أقسام</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4 text-center">
            {{ $departments->links() }}
        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 <script>
function toggleTheme() {
    document.body.classList.toggle("dark");

    localStorage.setItem(
        "theme",
        document.body.classList.contains("dark") ? "dark" : "light"
    );
}

window.onload = function () {
    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark");
    }
};
</script>
</body>
</html>
