<!DOCTYPE html>
<html lang="en" id="htmlTag">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Block 3 Dashboard')</title>

    <link href="[fonts.googleapis.com](https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap)" rel="stylesheet">
    <link rel="stylesheet" href="[cdnjs.cloudflare.com](https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css)"/>
    <link rel="stylesheet" href="[cdn.jsdelivr.net](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css)"/>
    <link rel="stylesheet" href="[cdnjs.cloudflare.com](https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css)"/>

    <style>
        :root {
            --primary: #3A86FF;
            --primary-light: #e6f0ff;
            --bg-gradient: linear-gradient(135deg, #edf4ff, #f8fbff);
            --card-bg: rgba(255,255,255,0.80);
            --text-color: #2c3e50;
            --shadow: 0 10px 30px rgba(58,134,255,0.15);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-gradient);
            color: var(--text-color);
            min-height: 100vh;
        }

        .navbar-custom {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(16px);
            box-shadow: var(--shadow);
        }

        .sidebar-card, .content-card, .stat-card {
            background: var(--card-bg);
            backdrop-filter: blur(18px);
            border-radius: 18px;
            box-shadow: var(--shadow);
            border: none;
        }

        .stat-card {
            padding: 22px;
            transition: 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            border-radius: 10px;
        }

        .btn-primary:hover {
            background-color: #2f6fe0;
            border-color: #2f6fe0;
        }

        .table thead {
            background-color: #eaf2ff;
        }

        .page-title {
            color: var(--primary);
            font-weight: 700;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 10px 14px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(58,134,255,0.15);
        }
    </style>

    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ route('block3.dashboard') }}">
            <i class="fa-solid fa-warehouse me-2"></i>MyStore Block 3
        </a>

        <div class="d-flex gap-2">
            <a href="{{ route('block3.dashboard') }}" class="btn btn-sm btn-outline-primary">Dashboard</a>
            <a href="{{ route('block3.stores.index') }}" class="btn btn-sm btn-outline-primary">Stores</a>
            <a href="{{ route('block3.transfer.form') }}" class="btn btn-sm btn-primary">Transfer</a>
        </div>
    </div>
</nav>

<div class="container pb-5">
    @if(session('success'))
        <div class="alert alert-success animate__animated animate__fadeInDown">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger animate__animated animate__fadeInDown">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</div>

<script src="[cdn.jsdelivr.net](https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js)"></script>
@stack('scripts')
</body>
</html>
