<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title id="pageTitle">تعديل بيانات الزبون</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * { transition: background 0.3s, color 0.2s, border-color 0.2s; }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecf5 100%);
            font-family: 'Segoe UI', sans-serif;
            padding: 40px 20px;
            transition: all 0.3s;
        }
        .form-card {
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            max-width: 900px;
            margin: auto;
            transition: background 0.3s, box-shadow 0.3s;
        }
        h2 { color: #1a3b5d; margin-bottom: 30px; text-align: center; transition: color 0.3s; }
        label { font-weight: 600; color: #1e3a5f; transition: color 0.3s; }
        .btn-submit {
            background: #1e3a5f;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            border: none;
            transition: 0.3s;
        }
        .btn-submit:hover { background: #15304d; }
        .btn-back {
            background: #6c757d;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            border: none;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-back:hover { background: #5a6268; color: white; }
        .form-control, .form-select {
            background: white !important;
            border: 1px solid #e2e8f0;
            color: #1e3a5f;
            border-radius: 10px;
            padding: 10px 15px;
        }
        .top-controls {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
        }
        .top-controls button {
            background: white;
            border: 1px solid #e2e8f0;
            color: #1e3a5f;
            padding: 8px 16px;
            border-radius: 30px;
            margin-left: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .top-controls button:hover { background: #f8fafc; transform: scale(1.05); }

        /* صورة الزبون في التعديل */
        .current-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #1e3a5f;
            display: block;
            margin-bottom: 10px;
        }
        .img-placeholder {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #e9ecf5;
            border: 3px solid #1e3a5f;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #1e3a5f;
            margin-bottom: 10px;
        }

        /* Dark Mode */
        body.dark { background: linear-gradient(135deg, #121826, #1a1f2e); }
        body.dark .form-card { background: #1e293b; box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
        body.dark h2 { color: #f1f5f9; }
        body.dark label { color: #cbd5e1; }
        body.dark .form-control, body.dark .form-select { background: #334155 !important; border-color: #475569; color: #f1f5f9; }
        body.dark .btn-back { background: #475569; }
        body.dark .btn-back:hover { background: #334155; }
        body.dark .top-controls button { background: #2d3a4f; border-color: #4a5568; color: #f1f5f9; }
        body.dark .top-controls button:hover { background: #3a4a62; }
        body.dark .img-placeholder { background: #334155; color: #cbd5e1; border-color: #475569; }
    </style>
</head>
<body>

<div class="top-controls">
    <button onclick="toggleTheme()">🌙 Dark / 🌞 Light</button>
    <button onclick="toggleLanguage()">🌐 AR / EN</button>
</div>

<div class="form-card">
    <h2 id="pageTitleText">✏️ تعديل بيانات الزبون</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    {{-- enctype مهم لرفع الصور --}}
    <form method="POST"
          action="{{ route('marketing.customers.update', $customer->personal_id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-md-6">
                <label id="firstNameLabel">الاسم الأول</label>
                <input type="text" name="firstNmae" class="form-control" value="{{ old('firstNmae', $customer->firstNmae) }}" required>
            </div>

            <div class="col-md-6">
                <label id="lastNameLabel">الاسم الأخير</label>
                <input type="text" name="lastName" class="form-control" value="{{ old('lastName', $customer->lastName) }}" required>
            </div>

            <div class="col-md-6">
                <label id="fatherLabel">اسم الأب</label>
                <input type="text" name="father" class="form-control" value="{{ old('father', $customer->father) }}">
            </div>

            <div class="col-md-6">
                <label id="nationalLabel">الرقم الوطني</label>
                <input type="number" name="national_number" class="form-control" value="{{ old('national_number', $customer->national_number) }}" required>
            </div>

            <div class="col-md-6">
                <label id="phoneLabel">الهاتف</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}" required>
            </div>

            <div class="col-md-6">
                <label id="emailLabel">الإيميل</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}" required>
            </div>

            <div class="col-md-6">
                <label id="birthdayLabel">تاريخ الميلاد</label>
                <input type="date" name="birthday" class="form-control" value="{{ old('birthday', $customer->birthday) }}">
            </div>

            <div class="col-md-4">
                <label id="typeLabel">نوع الزبون</label>
                <select name="customer_type_id" class="form-control" required>
                    <option value="1" {{ $customer->customer_type_id == 1 ? 'selected' : '' }} id="normalOption">عادي</option>
                    <option value="2" {{ $customer->customer_type_id == 2 ? 'selected' : '' }} id="vipOption">VIP</option>
                </select>
            </div>

            <div class="col-md-4">
                <label id="statusLabel">الحالة</label>
                @if(session('user.role') === 'manager')
                    <select name="customer_status_id" class="form-control" required>
                        <option value="1" {{ $customer->customer_status_id == 1 ? 'selected' : '' }} id="activeOption">فعال</option>
                        <option value="2" {{ $customer->customer_status_id == 2 ? 'selected' : '' }} id="inactiveOption">غير فعال</option>
                    </select>
                @else
                    <input type="text" class="form-control" value="{{ $customer->customer_status_id == 1 ? 'فعال' : 'غير فعال' }}" disabled>
                    <input type="hidden" name="customer_status_id" value="{{ $customer->customer_status_id }}">
                @endif
            </div>

            @if(session('user.role') === 'manager')
            <div class="col-md-4">
                <label id="assignedToLabel">تخصيص موظف تسويق</label>
                <select name="assigned_to" class="form-control">
                    <option value="">غير مرتبط</option>
                    <option value="1" {{ $customer->assigned_to ? 'selected' : '' }}>مرتبط</option>
                </select>
            </div>
            @endif

            <div class="col-12">
                <label id="addressLabel">العنوان / ملاحظات</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address', $customer->address) }}</textarea>
            </div>

            {{-- ===== حقل الصورة ===== --}}
            <div class="col-12">
                <label id="imageLabel">صورة الزبون</label>
                <div class="mb-2">
                    @if($customer->upload_file)
                        <img src="{{ asset('storage/' . $customer->upload_file) }}"
                             alt="الصورة الحالية"
                             class="current-img">
                        <small class="text-muted d-block" id="currentImgText">الصورة الحالية — اترك الحقل فارغاً للإبقاء عليها</small>
                    @else
                        <div class="img-placeholder">
                            <i class="bi bi-person"></i>
                        </div>
                        <small class="text-muted d-block" id="noImgText">لا توجد صورة حالية</small>
                    @endif
                </div>
                <input type="file" name="upload_file" class="form-control" accept="image/*">
            </div>

            <div class="col-12 text-center mt-4">
                <button type="submit" class="btn-submit px-5 py-2" id="updateBtn">💾 تحديث البيانات</button>
                <a href="{{ route('marketing.customers.index') }}" class="btn-back px-4 py-2" id="cancelBtn">🔙 إلغاء</a>
            </div>
        </div>
    </form>
</div>

<script>
    function toggleTheme() {
        document.body.classList.toggle('dark');
        localStorage.setItem('theme', document.body.classList.contains('dark') ? 'dark' : 'light');
    }

    let currentLang = localStorage.getItem('lang') || 'ar';

    function toggleLanguage() {
        currentLang = currentLang === 'en' ? 'ar' : 'en';
        localStorage.setItem('lang', currentLang);
        applyLanguage();
    }

    function applyLanguage() {
        const html = document.documentElement;
        if (currentLang === 'ar') {
            html.setAttribute('dir', 'rtl');
            document.getElementById('pageTitleText').innerHTML = '✏️ تعديل بيانات الزبون';
            document.getElementById('firstNameLabel').textContent = 'الاسم الأول';
            document.getElementById('lastNameLabel').textContent = 'الاسم الأخير';
            document.getElementById('fatherLabel').textContent = 'اسم الأب';
            document.getElementById('nationalLabel').textContent = 'الرقم الوطني';
            document.getElementById('phoneLabel').textContent = 'الهاتف';
            document.getElementById('emailLabel').textContent = 'الإيميل';
            document.getElementById('birthdayLabel').textContent = 'تاريخ الميلاد';
            document.getElementById('typeLabel').textContent = 'نوع الزبون';
            document.getElementById('statusLabel').textContent = 'الحالة';
            document.getElementById('addressLabel').textContent = 'العنوان / ملاحظات';
            document.getElementById('imageLabel').textContent = 'صورة الزبون';
            document.getElementById('updateBtn').innerHTML = '💾 تحديث البيانات';
            document.getElementById('cancelBtn').innerHTML = '🔙 إلغاء';
            document.getElementById('assignedToLabel') && (document.getElementById('assignedToLabel').textContent = 'تخصيص موظف تسويق');
            if (document.getElementById('normalOption')) document.getElementById('normalOption').textContent = 'عادي';
            if (document.getElementById('vipOption')) document.getElementById('vipOption').textContent = 'VIP';
            if (document.getElementById('activeOption')) document.getElementById('activeOption').textContent = 'فعال';
            if (document.getElementById('inactiveOption')) document.getElementById('inactiveOption').textContent = 'غير فعال';
        } else {
            html.setAttribute('dir', 'ltr');
            document.getElementById('pageTitleText').innerHTML = '✏️ Edit Customer Data';
            document.getElementById('firstNameLabel').textContent = 'First Name';
            document.getElementById('lastNameLabel').textContent = 'Last Name';
            document.getElementById('fatherLabel').textContent = 'Father Name';
            document.getElementById('nationalLabel').textContent = 'National Number';
            document.getElementById('phoneLabel').textContent = 'Phone';
            document.getElementById('emailLabel').textContent = 'Email';
            document.getElementById('birthdayLabel').textContent = 'Birthday';
            document.getElementById('typeLabel').textContent = 'Customer Type';
            document.getElementById('statusLabel').textContent = 'Status';
            document.getElementById('addressLabel').textContent = 'Address / Notes';
            document.getElementById('imageLabel').textContent = 'Customer Image';
            document.getElementById('updateBtn').innerHTML = '💾 Update Data';
            document.getElementById('cancelBtn').innerHTML = '🔙 Cancel';
            document.getElementById('assignedToLabel') && (document.getElementById('assignedToLabel').textContent = 'Assign Marketing Employee');
            if (document.getElementById('normalOption')) document.getElementById('normalOption').textContent = 'Normal';
            if (document.getElementById('vipOption')) document.getElementById('vipOption').textContent = 'VIP';
            if (document.getElementById('activeOption')) document.getElementById('activeOption').textContent = 'Active';
            if (document.getElementById('inactiveOption')) document.getElementById('inactiveOption').textContent = 'Inactive';
        }
    }

    window.onload = function () {
        if (localStorage.getItem('theme') === 'dark') document.body.classList.add('dark');
        applyLanguage();
    }
</script>
</body>
</html>
