<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الزبائن - GridView</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        * { transition: background 0.3s, color 0.2s, border-color 0.2s; }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecf5 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            transition: all 0.3s;
        }
        .container-custom { max-width: 1300px; margin: 40px auto; padding: 20px; }
        .filter-card { border-radius: 20px; box-shadow: 0 10px 30px rgba(0,51,102,0.15); margin-bottom: 30px; border: none; overflow: hidden; }
        .filter-card .card-header { background: linear-gradient(135deg, #4285f4, #5a9cff); color: white; border-radius: 20px 20px 0 0; padding: 18px 25px; font-weight: 600; border: none; }
        .filter-card .card-body { background: white; }
        .table-container { background: white; border-radius: 20px; padding: 25px; box-shadow: 0 10px 30px rgba(0,51,102,0.15); }
        .table th { background: #2c3e50; color: white; text-align: center; padding: 12px; font-weight: 600; }
        .table td { text-align: center; vertical-align: middle; padding: 12px; }
        .badge-vip { background: #f1c40f; color: #856404; padding: 5px 15px; border-radius: 25px; font-weight: 600; font-size: 12px; }
        .badge-regular { background: #17a2b8; color: white; padding: 5px 15px; border-radius: 25px; font-weight: 600; font-size: 12px; }
        .badge-active { background: #28a745; color: white; padding: 5px 15px; border-radius: 25px; font-weight: 600; font-size: 12px; }
        .badge-inactive { background: #dc3545; color: white; padding: 5px 15px; border-radius: 25px; font-weight: 600; font-size: 12px; }
        .btn-search { background: #2c3e50; color: white; padding: 8px 25px; border-radius: 25px; border: none; transition: 0.3s; }
        .btn-search:hover { background: #1a252f; transform: translateY(-2px); }
        .btn-secondary { border-radius: 25px; padding: 8px 25px; }
        .top-controls { text-align: center; margin-bottom: 30px; display: flex; gap: 15px; justify-content: center; }
        .top-controls button { background: #2c3e50; color: white; border: none; padding: 8px 20px; border-radius: 25px; cursor: pointer; transition: 0.3s; }
        .top-controls button:hover { background: #1a252f; transform: scale(1.02); }
        body.dark { background: linear-gradient(135deg, #121826, #1a1f2e); }
        body.dark .filter-card .card-body { background: #1e293b; }
        body.dark .filter-card { box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        body.dark .table-container { background: #1e293b; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        body.dark .table { color: #e2e8f0; }
        body.dark .table th { background: #0f172a; color: #e0e7ff; }
        body.dark .table td { background: #1e293b; border-color: #334155; color: #e2e8f0; }
        body.dark .form-control, body.dark .form-select { background: #334155; border-color: #475569; color: #f1f5f9; }
        body.dark .form-control:focus, body.dark .form-select:focus { background: #475569; color: white; }
        body.dark .form-label { color: #cbd5e1; }
        body.dark .btn-search { background: #0f172a; }
        body.dark .btn-search:hover { background: #1e293b; }
        body.dark .badge-secondary { background: #334155; }
        body.dark h2, body.dark h5 { color: #f1f5f9; }
        body.dark .text-center { color: #e2e8f0; }
        body.dark .btn-secondary { background: #475569; border-color: #475569; }
        body.dark .btn-secondary:hover { background: #334155; }
        body.dark .btn-info { background: #0e6b9e; border-color: #0e6b9e; color: white; }
        body.dark .btn-warning { background: #b45309; border-color: #b45309; color: white; }
        body.dark .btn-success { background: #15803d; border-color: #15803d; color: white; }
        body.dark .btn-danger { background: #b91c1c; border-color: #b91c1c; color: white; }
        body.dark .alert-success { background: #166534; color: white; }
        body.dark .alert-danger { background: #991b1b; color: white; }
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
    @if($errors->any())
        <div class="alert alert-danger text-center m-3" style="background:#dc3545;color:white;padding:12px;border-radius:10px;">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <div class="top-controls">
        <button onclick="toggleTheme()">🌙 Dark / 🌞 Light</button>
        <button onclick="toggleLanguage()">🌐 AR / EN</button>
        <a href="{{ route('marketing.dashboard') }}" class="btn btn-search" style="text-decoration:none;">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
    </div>

    <h2 class="text-center mb-4" id="pageTitle"><i class="fas fa-users"></i> إدارة الزبائن</h2>

    <div class="card filter-card">
        <div class="card-header">
            <h5 class="mb-0" id="filterTitle"><i class="fas fa-filter"></i> فلتر البحث</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('marketing.customers.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label" id="nameLabel">الاسم</label>
                        <input type="text" name="search_name" id="searchName" class="form-control"
                               value="{{ request('search_name') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" id="emailLabel">الإيميل</label>
                        <input type="text" name="search_email" class="form-control"
                               value="{{ request('search_email') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" id="typeLabel">نوع الزبون</label>
                        <select name="search_type" class="form-select">
                            <option value="" id="allOption">الكل</option>
                            <option value="vip" {{ request('search_type')=='vip' ? 'selected' : '' }}>VIP</option>
                            <option value="regular" {{ request('search_type')=='regular' ? 'selected' : '' }}>عادي</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" id="statusLabel">الحالة</label>
                        <select name="search_status" class="form-select">
                            <option value="" id="allStatusOption">الكل</option>
                            <option value="active" {{ request('search_status')=='active' ? 'selected' : '' }}>فعال</option>
                            <option value="inactive" {{ request('search_status')=='inactive' ? 'selected' : '' }}>غير فعال</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-search w-100" id="searchBtn">
                            <i class="fas fa-search"></i> بحث
                        </button>
                    </div>
                </div>
            </form>
            @if(request('search_name') || request('search_email') || request('search_type') || request('search_status'))
                <div class="text-center mt-3">
                    <a href="{{ route('marketing.customers.index') }}" class="btn btn-secondary" id="resetBtn">إلغاء الفلتر</a>
                </div>
            @endif
        </div>
    </div>

    <div class="table-container">
        <div class="d-flex justify-content-between mb-3">
            <h5 id="customersTitle"><i class="fas fa-list"></i> قائمة الزبائن</h5>
            <span class="badge bg-secondary" id="countBadge">عدد النتائج: {{ $customers->count() }}</span>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th id="thNum">#</th>
                        <th id="thName">الاسم</th>
                        <th id="thEmail">الإيميل</th>
                        <th id="thPhone">الهاتف</th>
                        <th id="thType">النوع</th>
                        <th id="thStatus">الحالة</th>
                        <th id="thActions">إجراءات</th>
                    </tr>
                </thead>
                <tbody id="customersTable">
                    @forelse($customers as $i => $c)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $c->firstNmae }} {{ $c->lastName }}</td>
                        <td>{{ $c->email }}</td>
                        <td>{{ $c->phone }}</td>
                        <td>
                            @php $typeId = $c->customer_type_id ?? 1; @endphp
                            <span class="{{ $typeId == 2 ? 'badge-vip' : 'badge-regular' }}">
                                {{ $typeId == 2 ? 'VIP' : 'عادي' }}
                            </span>
                        </td>
                        <td>
                            @php $statusId = $c->customer_status_id ?? 1; @endphp
                            <span class="{{ $statusId == 1 ? 'badge-active' : 'badge-inactive' }}">
                                {{ $statusId == 1 ? 'فعال' : 'غير فعال' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('marketing.customers.show', $c->personal_id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('marketing.customers.edit', $c->personal_id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            @if(session('user.role') === 'manager')
                                <a href="{{ route('marketing.customers.changeStatus', [$c->personal_id, 1]) }}" class="btn btn-sm btn-success">تفعيل</a>
                                <a href="{{ route('marketing.customers.changeStatus', [$c->personal_id, 2]) }}" class="btn btn-sm btn-danger">تعطيل</a>
                                <form action="{{ route('marketing.customers.destroy', $c->personal_id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد؟')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">لا توجد بيانات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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

    let currentLang = localStorage.getItem("lang") || "ar";

    function toggleLanguage() {
        currentLang = currentLang === "en" ? "ar" : "en";
        localStorage.setItem("lang", currentLang);
        applyLanguage();
    }

    function applyLanguage() {
        const html = document.documentElement;
        if (currentLang === "ar") {
            html.setAttribute("dir", "rtl");
            document.getElementById("pageTitle").innerHTML = '<i class="fas fa-users"></i> إدارة الزبائن';
            document.getElementById("filterTitle").innerHTML = '<i class="fas fa-filter"></i> فلتر البحث';
            document.getElementById("nameLabel").textContent = "الاسم";
            document.getElementById("emailLabel").textContent = "الإيميل";
            document.getElementById("typeLabel").textContent = "نوع الزبون";
            document.getElementById("statusLabel").textContent = "الحالة";
            document.getElementById("allOption").textContent = "الكل";
            document.getElementById("allStatusOption").textContent = "الكل";
            document.getElementById("searchBtn").innerHTML = '<i class="fas fa-search"></i> بحث';
            if (document.getElementById("resetBtn")) document.getElementById("resetBtn").innerHTML = "إلغاء الفلتر";
            document.getElementById("customersTitle").innerHTML = '<i class="fas fa-list"></i> قائمة الزبائن';
            document.getElementById("thNum").textContent = "#";
            document.getElementById("thName").textContent = "الاسم";
            document.getElementById("thEmail").textContent = "الإيميل";
            document.getElementById("thPhone").textContent = "الهاتف";
            document.getElementById("thType").textContent = "النوع";
            document.getElementById("thStatus").textContent = "الحالة";
            document.getElementById("thActions").textContent = "إجراءات";
        } else {
            html.setAttribute("dir", "ltr");
            document.getElementById("pageTitle").innerHTML = '<i class="fas fa-users"></i> Customer Management';
            document.getElementById("filterTitle").innerHTML = '<i class="fas fa-filter"></i> Search Filter';
            document.getElementById("nameLabel").textContent = "Name";
            document.getElementById("emailLabel").textContent = "Email";
            document.getElementById("typeLabel").textContent = "Customer Type";
            document.getElementById("statusLabel").textContent = "Status";
            document.getElementById("allOption").textContent = "All";
            document.getElementById("allStatusOption").textContent = "All";
            document.getElementById("searchBtn").innerHTML = '<i class="fas fa-search"></i> Search';
            if (document.getElementById("resetBtn")) document.getElementById("resetBtn").innerHTML = "Reset Filter";
            document.getElementById("customersTitle").innerHTML = '<i class="fas fa-list"></i> Customers List';
            document.getElementById("thNum").textContent = "#";
            document.getElementById("thName").textContent = "Name";
            document.getElementById("thEmail").textContent = "Email";
            document.getElementById("thPhone").textContent = "Phone";
            document.getElementById("thType").textContent = "Type";
            document.getElementById("thStatus").textContent = "Status";
            document.getElementById("thActions").textContent = "Actions";
        }
    }

    window.onload = function () {
        if (localStorage.getItem("theme") === "dark") document.body.classList.add("dark");
        applyLanguage();
    }

    // البحث التلقائي
    $('#searchName').on('input', function () {
        const name = $(this).val();
        if (name.length < 1) { location.reload(); return; }
        $.get('{{ route("marketing.customers.index") }}', { search_name: name }, function (html) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTbody = doc.querySelector('#customersTable');
            const newCount = doc.querySelector('#countBadge');
            if (newTbody) $('#customersTable').html(newTbody.innerHTML);
            if (newCount) $('#countBadge').html(newCount.innerHTML);
        });
    });

    setTimeout(function () {
        let alerts = document.querySelectorAll('.alert');
        alerts.forEach(function (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(function () { alert.remove(); }, 500);
        });
    }, 3000);
</script>

</body>
</html>