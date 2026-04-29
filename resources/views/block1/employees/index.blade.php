<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الموظفين</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
body {
    background: linear-gradient(135deg, #e3eaf5 0%, #d9e4f5 100%);
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    color: #1e293b;
}
.container-custom {
    max-width: 1300px;
    margin: 40px auto;
    padding: 20px;
    animation: fadeIn 0.6s ease;
}
h2 {
    text-align: center;
    font-weight: 700;
    font-size: 28px;
    margin-bottom: 25px;
    background: linear-gradient(90deg, #2563eb, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
label { color: #334155; font-weight: 500; }
h5 { color: #1e293b; font-weight: 600; }
.form-control, .form-select {
    color: #0f172a;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
}
.form-control::placeholder { color: #64748b; }
.top-controls {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-bottom: 25px;
}
.top-controls button, .btn-search {
    background: linear-gradient(135deg, #2563eb, #06b6d4);
    border: none;
    color: white;
    border-radius: 25px;
    padding: 10px 22px;
    font-weight: 600;
    transition: 0.3s;
    box-shadow: 0 6px 15px rgba(37,99,235,0.25);
}
.top-controls button:hover, .btn-search:hover {
    transform: translateY(-3px) scale(1.05);
}
.filter-card {
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(20px);
    border-radius: 25px;
    padding: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.10);
    border: none;
    margin-bottom: 25px;
}
.table-container {
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(20px);
    border-radius: 25px;
    padding: 25px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.10);
}
.table { border-radius: 15px; overflow: hidden; }
.table thead {
    background: linear-gradient(135deg, #2563eb, #06b6d4);
    color: white;
}
.table th { padding: 15px; border: none; }
.table td { padding: 15px; border: none; vertical-align: middle; color: #1e293b; }
.table tbody tr { transition: 0.25s; }
.table tbody tr:hover { background: rgba(37,99,235,0.08); transform: scale(1.01); }
.badge-active { background: #22c55e; }
.badge-inactive { background: #ef4444; }
.badge-leave { background: #f59e0b; }
.badge-active, .badge-inactive, .badge-leave {
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
.alert { border-radius: 15px; font-weight: 500; }
@keyframes fadeIn {
    from {opacity:0; transform: translateY(20px);}
    to {opacity:1; transform: translateY(0);}
}
body.dark {
    background: linear-gradient(135deg, #0f172a, #1e293b);
    color: #f1f5f9;
}
body.dark label, body.dark h5, body.dark h2 {
    color: #e2e8f0;
    -webkit-text-fill-color: unset;
    background: none;
}
body.dark .filter-card, body.dark .table-container {
    background: rgba(30,40,60,0.6);
    box-shadow: 0 20px 50px rgba(0,0,0,0.5);
}
body.dark .table thead { background: linear-gradient(135deg, #1e40af, #2563eb); }
body.dark .table tbody tr:hover { background: rgba(255,255,255,0.05); }
body.dark .form-control, body.dark .form-select {
    background-color: #0f172a !important;
    color: #f1f5f9 !important;
    border: 1px solid #334155 !important;
}
body.dark .table td { background-color: transparent !important; color: #e2e8f0 !important; }
body.dark .form-control::placeholder { color: #94a3b8; }
    </style>
</head>
<body>

<div class="container-custom">

    @if(session('success'))
        <div class="alert alert-success text-center m-3" style="background:#28a745;color:white;padding:12px;border-radius:10px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center m-3" style="background:#dc3545;color:white;padding:12px;border-radius:10px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="top-controls">
        <button onclick="toggleTheme()">🌙 Dark / 🌞 Light</button>
        <a href="{{ route('hr.employees.create') }}" class="btn btn-search">
            <i class="fas fa-user-plus"></i> إضافة موظف
        </a>
        <a href="{{ route('hr.dashboard') }}" class="btn btn-search" style="text-decoration:none;">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
    </div>

    <h2 class="text-center mb-4"><i class="fas fa-users"></i> Employee Management 👥</h2>

    <div class="card filter-card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter"></i> Search Filter▼</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('hr.employees.index') }}">
                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="nameInput" class="form-control"
                               value="{{ request('name') }}" placeholder="Search by Name">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" class="form-control"
                               value="{{ request('email') }}" placeholder="Search by Email">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Department</label>
                        <select name="department_id" class="form-select">
                            <option value="">All Department</option>
                            @foreach($departments as $d)
                                <option value="{{ $d->department_id }}"
                                    {{ request('department_id') == $d->department_id ? 'selected' : '' }}>
                                    {{ $d->department_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status_id" class="form-select">
                            <option value="">All Status</option>
                            @foreach($statuses as $s)
                                <option value="{{ $s->employee_status_id }}"
                                    {{ request('status_id') == $s->employee_status_id ? 'selected' : '' }}>
                                    {{ $s->status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Position</label>
                        <select name="role_id" class="form-select">
                            <option value="">All Position</option>
                            @foreach($roles as $r)
                                <option value="{{ $r->role_id }}"
                                    {{ request('role_id') == $r->role_id ? 'selected' : '' }}>
                                    {{ $r->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-search w-100">
                            <i class="fas fa-search"></i> search
                        </button>
                    </div>
                </div>
            </form>

            @if(request('name') || request('email') || request('department_id') || request('status_id') || request('role_id'))
                <div class="text-center mt-3">
                    <a href="{{ route('hr.employees.index') }}" class="btn btn-secondary">إلغاء الفلتر</a>
                </div>
            @endif
        </div>
    </div>

    <div class="table-container">
        <div class="d-flex justify-content-between mb-3">
            <h5><i class="fas fa-list"></i> Employee List </h5>
            <span class="badge bg-secondary">Namber of Results : {{ $employees->count() }}</span>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="employeeTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $i => $e)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <img src="{{ $e->upload_file ? asset('storage/'.$e->upload_file) : 'https://via.placeholder.com/50' }}"
                                 width="50" style="border-radius:50%; object-fit:cover; height:50px;">
                        </td>
                        <td>{{ $e->firstNmae }} {{ $e->lastName }}</td>
                        <td>{{ $e->email }}</td>
                        <td>{{ $e->department->department_name ?? '-' }}</td>
                        <td>{{ $e->role->type ?? '-' }}</td>
                        <td>
                            @php $status = $e->employeeStatus->status ?? ''; @endphp
                            @if($status == 'active' || $status == 'موظف حالي')
                                <span class="badge-active">موظف حالي</span>
                            @elseif($status == 'inactive' || $status == 'مفصول')
                                <span class="badge-inactive">مفصول</span>
                            @else
                                <span class="badge-leave">{{ $status ?: '-' }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('hr.employees.show', $e->personal_id) }}"
                               class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('hr.employees.edit', $e->personal_id) }}"
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(session('user.role') == 'manager')
                                <button class="btn btn-sm btn-success"
                                        onclick="openStatusModal({{ $e->personal_id }}, {{ $e->employee_status_id ?? 1 }})">
                                    <i class="fas fa-toggle-on"></i>
                                </button>
                                <form action="{{ route('hr.employees.destroy', $e->personal_id) }}"
                                      method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا الموظف؟')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">NO matching results</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $employees->links() }}
    </div>
</div>

{{-- Modal تغيير الحالة --}}
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background:#2c3e50; color:white;">
                <h5 class="modal-title">Change Employee Status</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="statusForm" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Select New Status</label>
                        <select name="employee_status_id" id="statusSelect" class="form-select">
                            @foreach($statuses as $s)
                                <option value="{{ $s->employee_status_id }}">{{ $s->status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn w-100" style="background:#2c3e50; color:white;">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleTheme() {
        document.body.classList.toggle("dark");
        localStorage.setItem("theme", document.body.classList.contains("dark") ? "dark" : "light");
    }

    function openStatusModal(employeeId, currentStatus) {
        document.getElementById('statusForm').action = '/hr/employees/' + employeeId + '/status';
        document.getElementById('statusSelect').value = currentStatus;
        new bootstrap.Modal(document.getElementById('statusModal')).show();
    }

    window.onload = function () {
        if (localStorage.getItem("theme") === "dark") {
            document.body.classList.add("dark");
        }
    }
</script>

<script>
$('#nameInput').on('input', function() {
    const name = $(this).val();
    if (name.length < 1) { location.reload(); return; }
    $.get('{{ route("hr.employees.search") }}', { name: name }, function(data) {
        let rows = '';
        if (data.length === 0) {
            rows = '<tr><td colspan="8" class="text-center">NO matching results</td></tr>';
        } else {
            data.forEach((e, i) => {
                const photo = e.upload_file ? `/storage/${e.upload_file}` : 'https://via.placeholder.com/50';
                const dept  = e.department ? e.department.department_name : '-';
                const role  = e.role ? e.role.type : '-';
                const status = e.employee_status ? e.employee_status.status : '-';
                rows += `<tr>
                    <td>${i+1}</td>
                    <td><img src="${photo}" width="50" style="border-radius:50%;height:50px;object-fit:cover;" onerror="this.src='https://via.placeholder.com/50'"></td>
                    <td>${e.firstNmae} ${e.lastName}</td>
                    <td>${e.email || '-'}</td>
                    <td>${dept}</td>
                    <td>${role}</td>
                    <td><span class="badge-active">${status}</span></td>
                    <td>-</td>
                </tr>`;
            });
        }
        $('#employeeTable tbody').html(rows);
    });
});
</script>

</body>
</html>