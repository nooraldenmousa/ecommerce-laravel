<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title id="pageTitle">تفاصيل الزبون</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * { transition: background 0.3s, color 0.2s, border-color 0.2s; }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecf5 100%);
            font-family: 'Segoe UI', sans-serif;
            padding: 40px;
            transition: all 0.3s;
        }
        .card {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: none;
            overflow: hidden;
            transition: background 0.3s, box-shadow 0.3s;
        }
        .card-header {
            background: linear-gradient(135deg, #4285f4, #5a9cff);
            color: white;
            font-weight: 600;
            font-size: 1.5rem;
            padding: 20px;
        }
        .info-row {
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
        .info-label { font-weight: 600; color: #2c3e50; }
        .info-value { color: #555; }
        .btn-back {
            background: #2c3e50;
            color: white;
            border-radius: 25px;
            padding: 8px 25px;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-back:hover { background: #1a252f; color: white; }
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
            transition: 0.3s;
        }
        .top-controls button:hover { background: #1a252f; transform: scale(1.02); }

        /* صورة الزبون */
        .customer-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #4285f4;
            display: block;
            margin: 0 auto 10px auto;
        }
        .customer-img-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: #e9ecf5;
            border: 4px solid #4285f4;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px auto;
            font-size: 3rem;
            color: #4285f4;
        }

        /* Dark Mode */
        body.dark { background: linear-gradient(135deg, #121826, #1a1f2e); }
        body.dark .card { background: #1e293b; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        body.dark .info-label { color: #cbd5e1; }
        body.dark .info-value { color: #94a3b8; }
        body.dark .info-row { border-bottom-color: #334155; }
        body.dark .top-controls button { background: #0f172a; }
        body.dark .top-controls button:hover { background: #1e293b; }
        body.dark .customer-img-placeholder { background: #334155; }
    </style>
</head>
<body>

<div class="top-controls">
    <button onclick="toggleTheme()">🌙 Dark / 🌞 Light</button>
    <button onclick="toggleLanguage()">🌐 AR / EN</button>
    <a href="{{ route('dashboard') }}" class="btn-back" style="text-decoration: none;">
        <i class="bi bi-house-door"></i> <span id="dashboardText">لوحة التحكم</span>
    </a>
</div>

<div class="container">
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-circle"></i> <span id="cardTitle">تفاصيل الزبون</span>
        </div>
        <div class="card-body">

            {{-- ===== صورة الزبون ===== --}}
            <div class="text-center mb-4">
                @if($customer->upload_file)
                    <img src="{{ asset('storage/' . $customer->upload_file) }}"
                         alt="صورة الزبون"
                         class="customer-img">
                @else
                    <div class="customer-img-placeholder">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label" id="firstNameLabel">الاسم الأول:</span>
                        <span class="info-value">{{ $customer->firstNmae }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label" id="lastNameLabel">الاسم الأخير:</span>
                        <span class="info-value">{{ $customer->lastName }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label" id="fatherLabel">اسم الأب:</span>
                        <span class="info-value">{{ $customer->father ?? 'غير محدد' }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label" id="emailLabel">البريد الإلكتروني:</span>
                        <span class="info-value">{{ $customer->email }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label" id="phoneLabel">رقم الهاتف:</span>
                        <span class="info-value">{{ $customer->phone }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label" id="nationalLabel">الرقم الوطني:</span>
                        <span class="info-value">{{ $customer->national_number }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label" id="birthdayLabel">تاريخ الميلاد:</span>
                        <span class="info-value">{{ $customer->birthday ?? 'غير محدد' }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label" id="addressLabel">العنوان:</span>
                        <span class="info-value">{{ $customer->address ?? 'غير محدد' }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label" id="typeLabel">نوع الزبون:</span>
                        <span class="info-value">
                            <span class="badge {{ $customer->customer_type_id == 2 ? 'bg-warning' : 'bg-info' }}">
                                <span id="typeValue">{{ $customer->customer_type_id == 2 ? 'VIP' : 'عادي' }}</span>
                            </span>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-row">
                        <span class="info-label" id="statusLabel">الحالة:</span>
                        <span class="info-value">
                            <span class="badge {{ $customer->customer_status_id == 1 ? 'bg-success' : 'bg-danger' }}">
                                <span id="statusValue">{{ $customer->customer_status_id == 1 ? 'فعال' : 'غير فعال' }}</span>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== عروض VIP ===== --}}
        @if($customer->customer_type_id == 2)
            <div class="card mt-3" style="margin: 20px;">
                <div class="card-header bg-warning">
                    <i class="fas fa-gift"></i> 🎁 العروض والهدايا
                </div>
                <div class="card-body">
                    @forelse($offers as $offer)
                        <div class="alert alert-info">
                            <strong>{{ $offer->offer_name }}</strong><br>
                            {{ $offer->offer_details ?? 'لا يوجد تفاصيل' }}
                            @if($offer->start_date && $offer->end_date)
                                <br><small>من {{ $offer->start_date }} إلى {{ $offer->end_date }}</small>
                            @endif
                        </div>
                    @empty
                        <p>لا توجد عروض متاحة حالياً</p>
                    @endforelse
                </div>
            </div>
        @endif

        <div class="card-footer text-center">
            <a href="{{ route('marketing.customers.index') }}" class="btn-back" id="backBtn">
                <i class="fas fa-arrow-right"></i> <span id="backText">العودة إلى القائمة</span>
            </a>
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
            document.getElementById("pageTitle").innerHTML = "تفاصيل الزبون";
            document.getElementById("cardTitle").innerHTML = "تفاصيل الزبون";
            document.getElementById("firstNameLabel").innerHTML = "الاسم الأول:";
            document.getElementById("lastNameLabel").innerHTML = "الاسم الأخير:";
            document.getElementById("fatherLabel").innerHTML = "اسم الأب:";
            document.getElementById("emailLabel").innerHTML = "البريد الإلكتروني:";
            document.getElementById("phoneLabel").innerHTML = "رقم الهاتف:";
            document.getElementById("nationalLabel").innerHTML = "الرقم الوطني:";
            document.getElementById("birthdayLabel").innerHTML = "تاريخ الميلاد:";
            document.getElementById("addressLabel").innerHTML = "العنوان:";
            document.getElementById("typeLabel").innerHTML = "نوع الزبون:";
            document.getElementById("statusLabel").innerHTML = "الحالة:";
            document.getElementById("typeValue").innerHTML = "{{ $customer->customer_type_id == 2 ? 'VIP' : 'عادي' }}";
            document.getElementById("statusValue").innerHTML = "{{ $customer->customer_status_id == 1 ? 'فعال' : 'غير فعال' }}";
            document.getElementById("backText").innerHTML = "العودة إلى القائمة";
            document.getElementById("dashboardText").innerHTML = "لوحة التحكم";
        } else {
            html.setAttribute("dir", "ltr");
            document.getElementById("pageTitle").innerHTML = "Customer Details";
            document.getElementById("cardTitle").innerHTML = "Customer Details";
            document.getElementById("firstNameLabel").innerHTML = "First Name:";
            document.getElementById("lastNameLabel").innerHTML = "Last Name:";
            document.getElementById("fatherLabel").innerHTML = "Father Name:";
            document.getElementById("emailLabel").innerHTML = "Email:";
            document.getElementById("phoneLabel").innerHTML = "Phone:";
            document.getElementById("nationalLabel").innerHTML = "National Number:";
            document.getElementById("birthdayLabel").innerHTML = "Birthday:";
            document.getElementById("addressLabel").innerHTML = "Address:";
            document.getElementById("typeLabel").innerHTML = "Customer Type:";
            document.getElementById("statusLabel").innerHTML = "Status:";
            document.getElementById("typeValue").innerHTML = "{{ $customer->customer_type_id == 2 ? 'VIP' : 'Normal' }}";
            document.getElementById("statusValue").innerHTML = "{{ $customer->customer_status_id == 1 ? 'Active' : 'Inactive' }}";
            document.getElementById("backText").innerHTML = "Back to List";
            document.getElementById("dashboardText").innerHTML = "Dashboard";
        }
    }

    window.onload = function() {
        if (localStorage.getItem("theme") === "dark") document.body.classList.add("dark");
        applyLanguage();
    }
</script>
</body>
</html>
