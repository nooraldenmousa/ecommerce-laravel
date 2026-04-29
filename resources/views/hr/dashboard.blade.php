<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم — الموارد البشرية</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Tajawal', sans-serif; }
        body { background: #f0f4f8; }
        .sidebar {
            width: 260px; min-height: 100vh;
            background: linear-gradient(160deg, #1a365d, #2b6cb0);
            position: fixed; top: 0; right: 0;
            color: white; padding: 0;
            box-shadow: -4px 0 20px rgba(0,0,0,0.2);
            z-index: 100;
        }
        .sidebar-header {
            background: rgba(0,0,0,0.2);
            padding: 25px 20px;
            text-align: center;
        }
        .sidebar-header .icon { font-size: 2.5rem; margin-bottom: 8px; }
        .sidebar-header h5 { margin: 0; font-size: 1rem; font-weight: 700; }
        .sidebar-header small { opacity: 0.8; font-size: 0.78rem; }
        .nav-link {
            color: rgba(255,255,255,0.85) !important;
            padding: 12px 20px !important;
            border-radius: 0 !important;
            display: flex; align-items: center; gap: 12px;
            transition: all 0.2s;
            font-size: 0.9rem;
        }
        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.15) !important;
            color: white !important;
            padding-right: 28px !important;
        }
        .nav-link i { width: 18px; text-align: center; }
        .nav-section {
            padding: 15px 20px 5px;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.6;
        }
        .main-content {
            margin-right: 260px;
            padding: 30px;
        }
        .topbar {
            background: white;
            border-radius: 16px;
            padding: 16px 25px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        }
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-4px); }
        .stat-icon {
            width: 60px; height: 60px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem;
            margin: 0 auto 15px;
        }
        .stat-number { font-size: 2rem; font-weight: 900; color: #1a365d; }
        .stat-label { color: #718096; font-size: 0.88rem; margin-top: 4px; }
        .btn-logout {
            background: rgba(229,62,62,0.1);
            color: #c53030;
            border: none;
            border-radius: 10px;
            padding: 8px 16px;
            font-family: 'Tajawal', sans-serif;
            font-size: 0.88rem;
            cursor: pointer;
            display: flex; align-items: center; gap: 8px;
            transition: all 0.2s;
        }
        .btn-logout:hover { background: #e53e3e; color: white; }
    </style>
</head>
<body>

{{-- Sidebar --}}
<div class="sidebar">
    <div class="sidebar-header">
        <div class="icon">👥</div>
        <h5>الموارد البشرية</h5>
        <small>مرحباً، {{ session('user.name') ?? session('username') }}</small>
    </div>

    <div class="nav-section">القائمة الرئيسية</div>
    <a href="{{ route('hr.dashboard') }}" class="nav-link active">
        <i class="fas fa-home"></i> لوحة التحكم
    </a>

    <div class="nav-section">إدارة الموظفين</div>
    <a href="{{ route('hr.employees.index') }}" class="nav-link">
        <i class="fas fa-user-tie"></i> قائمة الموظفين
    </a>
    <a href="{{ route('hr.employees.create') }}" class="nav-link">
        <i class="fas fa-user-plus"></i> إضافة موظف
    </a>

    <div class="nav-section">إدارة الأقسام</div>
    <a href="{{ route('hr.departments.index') }}" class="nav-link">
        <i class="fas fa-sitemap"></i> الأقسام
    </a>
    <a href="{{ route('hr.departments.create') }}" class="nav-link">
        <i class="fas fa-plus-circle"></i> إضافة قسم
    </a>
</div>

{{-- Main Content --}}
<div class="main-content">

    <div class="topbar">
        <div>
            <h4 style="margin:0; color:#1a365d; font-weight:800;">لوحة التحكم — الموارد البشرية</h4>
            <small class="text-muted">{{ now()->format('l، d F Y') }}</small>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> خروج
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-3 mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#ebf8ff;">👨‍💼</div>
                <div class="stat-number">{{ $totalEmployees ?? 0 }}</div>
                <div class="stat-label">إجمالي الموظفين</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#f0fff4;">🏢</div>
                <div class="stat-number">{{ $totalDepartments ?? 0 }}</div>
                <div class="stat-label">الأقسام</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fff5f5;">🎯</div>
                <div class="stat-number">
                    {{ session('user.role') === 'manager' ? 'مدير' : 'موظف' }}
                </div>
                <div class="stat-label">صلاحيتك في النظام</div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-md-6">
            <div class="stat-card text-start">
                <h5 style="color:#1a365d; font-weight:700; margin-bottom:15px;">
                    <i class="fas fa-bolt text-warning me-2"></i> إجراءات سريعة
                </h5>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('hr.employees.create') }}" class="btn btn-primary rounded-3">
                        <i class="fas fa-user-plus me-2"></i> إضافة موظف جديد
                    </a>
                    <a href="{{ route('hr.departments.index') }}" class="btn btn-outline-primary rounded-3">
                        <i class="fas fa-sitemap me-2"></i> إدارة الأقسام
                    </a>
                    <a href="{{ route('hr.employees.index') }}" class="btn btn-outline-secondary rounded-3">
                        <i class="fas fa-search me-2"></i> البحث عن موظف
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card text-start">
                <h5 style="color:#1a365d; font-weight:700; margin-bottom:15px;">
                    <i class="fas fa-info-circle text-info me-2"></i> معلومات الحساب
                </h5>
                <table class="table table-borderless mb-0" style="font-size:0.9rem;">
                    <tr>
                        <td class="text-muted">اسم المستخدم:</td>
                        <td><strong>{{ session('user.username') ?? session('username') }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">الاسم الكامل:</td>
                        <td><strong>{{ session('user.name') ?? '—' }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">الصلاحية:</td>
                        <td>
                            @if(session('user.role') === 'manager')
                                <span class="badge bg-danger">مدير القسم</span>
                            @else
                                <span class="badge bg-primary">موظف القسم</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">القسم:</td>
                        <td><strong>الموارد البشرية</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
