<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة العروض</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        * { transition: background 0.3s, color 0.2s, border-color 0.2s; }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecf5 100%);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }
        
        .container-custom {
            max-width: 1300px;
            margin: 40px auto;
            padding: 20px;
        }
        
        .card-header-custom {
            background: linear-gradient(135deg, #4285f4, #5a9cff);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 18px 25px;
            font-weight: 600;
            font-size: 1.2rem;
        }
        
        .table-container {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 51, 102, 0.15);
        }
        
        .table th {
            background: #2c3e50;
            color: white;
            text-align: center;
            padding: 12px;
        }
        
        .table td {
            text-align: center;
            vertical-align: middle;
            padding: 12px;
        }
        
        .btn-search {
            background: #2c3e50;
            color: white;
            padding: 8px 25px;
            border-radius: 25px;
            border: none;
        }
        
        .top-controls {
            text-align: center;
            margin-bottom: 30px;
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        
        .top-controls button {
            background: #2c3e50;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 25px;
            cursor: pointer;
        }
        
        /* ========== Dark Mode (فقط للكتابات) ========== */
        body.dark {
            background: linear-gradient(135deg, #121826, #1a1f2e);
        }
        
        body.dark .table-container {
            background: #1e293b;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        
        body.dark .table {
            color: #f1f5f9;
        }
        
        body.dark .table th {
            background: #0f172a;
            color: #e0e7ff;
        }
        
        body.dark .table td {
            background: #1e293b;
            border-color: #334155;
            color: #cbd5e1;
        }
        
        body.dark h2, body.dark h5 {
            color: #f1f5f9;
        }
        
        body.dark .text-center {
            color: #e2e8f0;
        }
    </style>
</head>
<body>

<div class="container-custom">
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <div class="top-controls">
        <button onclick="toggleTheme()">🌙 Dark / 🌞 Light</button>
        <button onclick="toggleLanguage()">🌐 AR / EN</button>
        <a href="{{ route('dashboard') }}" class="btn btn-search" style="text-decoration:none;">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
        <a href="{{ route('marketing.offers.create') }}" class="btn btn-search" style="text-decoration:none;">
            <i class="fas fa-plus"></i> إضافة عرض
        </a>
    </div>

    <h2 class="text-center mb-4" id="pageTitle"><i class="fas fa-gift"></i> إدارة العروض والهدايا</h2>

    <div class="table-container">
        <h5 id="offersTitle"><i class="fas fa-list"></i> قائمة العروض</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th id="thNum">#</th>
                        <th id="thName">اسم العرض</th>
                        <th id="thDetails">التفاصيل</th>
                        <th id="thStart">تاريخ البداية</th>
                        <th id="thEnd">تاريخ النهاية</th>
                        <th id="thStatus">الحالة</th>
                        <th id="thActions">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($offers as $i => $offer)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $offer->offer_name }}</td>
                        <td>{{ $offer->offer_details ?? '-' }}</td>
                        <td>{{ $offer->start_date ?? '-' }}</td>
                        <td>{{ $offer->end_date ?? '-' }}</td>
                        <td>{{ $offer->status ?? 'نشط' }}</td>
                        <td>
                            <a href="{{ route('marketing.offers.show', $offer->offer_id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('marketing.offers.edit', $offer->offer_id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('marketing.offers.destroy', $offer->offer_id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد؟')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">لا توجد عروض حالياً</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

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
            document.getElementById("pageTitle").innerHTML = '<i class="fas fa-gift"></i> إدارة العروض والهدايا';
            document.getElementById("offersTitle").innerHTML = '<i class="fas fa-list"></i> قائمة العروض';
            document.getElementById("thNum").textContent = "#";
            document.getElementById("thName").textContent = "اسم العرض";
            document.getElementById("thDetails").textContent = "التفاصيل";
            document.getElementById("thStart").textContent = "تاريخ البداية";
            document.getElementById("thEnd").textContent = "تاريخ النهاية";
            document.getElementById("thStatus").textContent = "الحالة";
            document.getElementById("thActions").textContent = "إجراءات";
        } else {
            html.setAttribute("dir", "ltr");
            document.getElementById("pageTitle").innerHTML = '<i class="fas fa-gift"></i> Offers Management';
            document.getElementById("offersTitle").innerHTML = '<i class="fas fa-list"></i> Offers List';
            document.getElementById("thNum").textContent = "#";
            document.getElementById("thName").textContent = "Offer Name";
            document.getElementById("thDetails").textContent = "Details";
            document.getElementById("thStart").textContent = "Start Date";
            document.getElementById("thEnd").textContent = "End Date";
            document.getElementById("thStatus").textContent = "Status";
            document.getElementById("thActions").textContent = "Actions";
        }
    }

    window.onload = function() {
        if (localStorage.getItem("theme") === "dark") {
            document.body.classList.add("dark");
        }
        applyLanguage();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>