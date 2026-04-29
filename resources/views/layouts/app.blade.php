<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'نظام المتجر الإلكتروني')</title>

    <!-- Bootstrap RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Tajawal', sans-serif; }

        body {
            background-color: #f0f4f8;
            color: #2d3748;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1a365d 0%, #2a4a7f 100%);
            position: fixed;
            right: 0;
            top: 0;
            z-index: 1000;
            box-shadow: -4px 0 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }

        .sidebar-brand h4 {
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 10px 0 0;
        }

        .sidebar-brand .brand-icon {
            width: 55px;
            height: 55px;
            background: rgba(255,255,255,0.15);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 1.5rem;
            color: #63b3ed;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu .menu-title {
            color: rgba(255,255,255,0.4);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 20px 5px;
            font-weight: 600;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,0.75);
            padding: 12px 20px;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.92rem;
            border-right: 3px solid transparent;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border-right-color: #63b3ed;
        }

        .sidebar-menu a i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        /* Main Content */
        .main-content {
            margin-right: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .top-navbar {
            background: #fff;
            padding: 15px 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .top-navbar .page-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1a365d;
            margin: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #1a365d, #63b3ed);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
        }

        .role-badge {
            font-size: 0.75rem;
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* Page Content */
        .page-content {
            padding: 25px;
            flex: 1;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #e2e8f0;
            padding: 18px 20px;
            font-weight: 700;
            color: #1a365d;
            border-radius: 15px 15px 0 0 !important;
        }

        /* Stats Cards */
        .stat-card {
            border-radius: 15px;
            padding: 25px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
        }

        .stat-card .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }

        .stat-card .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin: 10px 0 5px;
        }

        .stat-card .stat-label {
            font-size: 0.85rem;
            opacity: 0.85;
        }

        .bg-warehouse { background: linear-gradient(135deg, #1a365d, #2b6cb0); }
        .bg-products  { background: linear-gradient(135deg, #276749, #38a169); }
        .bg-stores    { background: linear-gradient(135deg, #744210, #d69e2e); }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #1a365d, #2b6cb0);
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2b6cb0, #1a365d);
            transform: translateY(-1px);
        }

        .btn-danger {
            border-radius: 8px;
        }

        /* Table */
        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead th {
            background: #1a365d;
            color: white;
            border: none;
            padding: 14px 16px;
            font-weight: 600;
            font-size: 0.88rem;
        }

        .table tbody tr {
            transition: background 0.2s ease;
        }

        .table tbody tr:hover {
            background: #ebf8ff;
        }

        .table tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            border-color: #e2e8f0;
            font-size: 0.9rem;
        }

        /* Form Controls */
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 10px 15px;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #63b3ed;
            box-shadow: 0 0 0 3px rgba(99,179,237,0.15);
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            font-size: 0.88rem;
            margin-bottom: 6px;
        }

        /* Alerts */
        .alert {
            border-radius: 10px;
            border: none;
            padding: 14px 18px;
        }

        /* Breadcrumb */
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
            font-size: 0.85rem;
        }

        .breadcrumb-item a {
            color: #63b3ed;
            text-decoration: none;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f0f4f8; }
        ::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 3px; }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { width: 0; overflow: hidden; }
            .sidebar.open { width: 260px; }
            .main-content { margin-right: 0; }
        }
    </style>

    @yield('styles')
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <i class="fas fa-warehouse"></i>
        </div>
        <h4>نظام المتجر الإلكتروني</h4>
    </div>

    <div class="sidebar-menu">
        <div class="menu-title">القائمة الرئيسية</div>

        <a href="{{ route('warehouse.dashboard') }}"
           class="{{ request()->routeIs('warehouse.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i>
            لوحة التحكم
        </a>

        <a href="{{ route('warehouse.index') }}"
           class="{{ request()->routeIs('warehouse.index') ? 'active' : '' }}">
            <i class="fas fa-warehouse"></i>
            المستودعات
        </a>

        @if(session('user.role') === 'manager')
        <div class="menu-title">صلاحيات المدير</div>
        <a href="{{ route('warehouse.create') }}"
           class="{{ request()->routeIs('warehouse.create') ? 'active' : '' }}">
            <i class="fas fa-plus-circle"></i>
            إضافة مستودع
        </a>
        @endif

        <div class="menu-title">الروابط</div>
        <a href="#" onclick="event.preventDefault()">
            <i class="fas fa-store"></i>
            ربط المتاجر
        </a>
        <a href="#" onclick="event.preventDefault()">
            <i class="fas fa-boxes"></i>
            ربط المنتجات
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">

    <!-- Top Navbar -->
    <div class="top-navbar">
        <h5 class="page-title">
            <i class="fas fa-warehouse me-2 text-primary"></i>
            @yield('page-title', 'لوحة التحكم')
        </h5>

        <div class="user-info">
            <div>
                <div style="font-weight:600; font-size:0.9rem;">
                    {{ session('user.name') }}
                </div>
                <div>
                    @if(session('user.role') === 'manager')
                        <span class="badge bg-danger role-badge">مدير</span>
                    @else
                        <span class="badge bg-info role-badge">موظف</span>
                    @endif
                </div>
            </div>
            <div class="user-avatar">
                {{ mb_substr(session('user.name'), 0, 1) }}
            </div>
            <form action="{{ route('logout') }}" method="POST" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-sign-out-alt"></i>
                    خروج
                </button>
            </form>
        </div>
    </div>

    <!-- Page Content -->
    <div class="page-content">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

@yield('scripts')
@stack('scripts')
</body>
</html>