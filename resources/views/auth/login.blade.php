<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول — متجر إلكتروني متعدد الفروع</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Tajawal', sans-serif; box-sizing: border-box; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            display: flex; align-items: center; justify-content: center;
            padding: 20px; position: relative; overflow: hidden;
        }
        .bg-shapes span {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,0.04);
            animation: floatBubble linear infinite;
        }
        .bg-shapes span:nth-child(1){ width:80px;height:80px;left:10%;animation-duration:7s; }
        .bg-shapes span:nth-child(2){ width:140px;height:140px;left:30%;animation-duration:10s;animation-delay:2s; }
        .bg-shapes span:nth-child(3){ width:60px;height:60px;left:60%;animation-duration:6s;animation-delay:1s; }
        .bg-shapes span:nth-child(4){ width:100px;height:100px;left:80%;animation-duration:9s;animation-delay:3s; }
        .bg-shapes span:nth-child(5){ width:50px;height:50px;left:50%;animation-duration:5s;animation-delay:0.5s; }
        @keyframes floatBubble {
            0%   { bottom:-150px; transform:translateX(0) rotate(0deg); opacity:0; }
            10%  { opacity:1; }
            90%  { opacity:1; }
            100% { bottom:110%; transform:translateX(100px) rotate(360deg); opacity:0; }
        }
        .login-wrapper {
            display: flex; width: 100%; max-width: 950px;
            background: rgba(255,255,255,0.97); border-radius: 24px;
            overflow: hidden; box-shadow: 0 30px 80px rgba(0,0,0,0.5);
            position: relative; z-index: 10;
        }
        .login-sidebar {
            width: 40%;
            background: linear-gradient(160deg, #1a365d 0%, #2b6cb0 60%, #3182ce 100%);
            padding: 50px 35px; display: flex; flex-direction: column;
            justify-content: center; color: white;
            position: relative; overflow: hidden;
        }
        .login-sidebar::before {
            content:''; position:absolute; width:300px; height:300px;
            border-radius:50%; background:rgba(255,255,255,0.05);
            bottom:-100px; left:-100px;
        }
        .sidebar-logo { font-size: 3rem; margin-bottom: 20px; }
        .sidebar-title { font-size: 1.6rem; font-weight: 900; margin-bottom: 10px; }
        .sidebar-subtitle { font-size: 0.9rem; opacity: 0.85; margin-bottom: 35px; line-height: 1.7; }
        .sidebar-blocks { display: flex; flex-direction: column; gap: 10px; }
        .block-badge {
            display: flex; align-items: center; gap: 12px;
            background: rgba(255,255,255,0.12); border-radius: 10px;
            padding: 10px 14px; font-size: 0.82rem;
            border: 1px solid rgba(255,255,255,0.15);
        }
        .block-badge i { font-size: 1rem; width: 20px; text-align: center; }
        .login-form-area {
            flex: 1; padding: 50px 45px;
            display: flex; flex-direction: column; justify-content: center;
        }
        .form-header { margin-bottom: 30px; }
        .form-header h2 { font-size: 1.8rem; font-weight: 800; color: #1a365d; margin-bottom: 6px; }
        .form-header p { color: #718096; font-size: 0.9rem; }
        .form-group { margin-bottom: 20px; }
        .form-label { font-weight: 600; color: #2d3748; font-size: 0.88rem; margin-bottom: 8px; display: block; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: #a0aec0; font-size: 0.9rem; pointer-events: none; }
        .form-control {
            width: 100%; padding: 13px 42px; border: 2px solid #e2e8f0;
            border-radius: 12px; font-size: 0.93rem; font-family: 'Tajawal', sans-serif;
            transition: all 0.25s; background: #f8fafc; color: #2d3748;
        }
        .form-control:focus { border-color: #2b6cb0; background: #fff; box-shadow: 0 0 0 3px rgba(43,108,176,0.12); outline: none; }
        .form-control.is-invalid { border-color: #fc8181; background: #fff5f5; }
        .toggle-pass {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #a0aec0; cursor: pointer; background: none; border: none;
            font-size: 0.9rem; padding: 0; transition: color 0.2s;
        }
        .toggle-pass:hover { color: #2b6cb0; }
        .error-msg { color: #e53e3e; font-size: 0.82rem; margin-top: 5px; display: flex; align-items: center; gap: 5px; }
        .alert-error {
            background: #fff5f5; border: 1px solid #fed7d7; color: #c53030;
            border-radius: 12px; padding: 12px 16px; font-size: 0.88rem;
            margin-bottom: 20px; display: flex; align-items: center; gap: 10px;
        }
        .btn-login {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #1a365d, #2b6cb0);
            border: none; border-radius: 12px; color: white;
            font-size: 1rem; font-weight: 700; font-family: 'Tajawal', sans-serif;
            cursor: pointer; transition: all 0.3s;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(26,54,93,0.35); }
        .spinner { display:none; width:18px; height:18px; border:2px solid rgba(255,255,255,0.4); border-top-color:white; border-radius:50%; animation:spin 0.7s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .form-footer { text-align:center; margin-top:20px; padding-top:18px; border-top:1px solid #e2e8f0; color:#a0aec0; font-size:0.8rem; }
        @media (max-width: 700px) { .login-sidebar { display: none; } .login-form-area { padding: 35px 25px; } }
    </style>
</head>
<body>
<div class="bg-shapes"><span></span><span></span><span></span><span></span><span></span></div>

<div class="login-wrapper">
    <div class="login-sidebar">
        <div class="sidebar-logo">🏪</div>
        <div class="sidebar-title">متجر إلكتروني<br>متعدد الفروع</div>
        <div class="sidebar-subtitle">نظام متكامل لإدارة المتجر —<br>أدخل بياناتك وسيتم توجيهك تلقائياً</div>
        <div class="sidebar-blocks">
            <div class="block-badge"><i class="fas fa-users"></i><span>الكتلة الأولى — الموارد البشرية</span></div>
            <div class="block-badge"><i class="fas fa-bullhorn"></i><span>الكتلة الثانية — التسويق والزبائن</span></div>
            <div class="block-badge"><i class="fas fa-store"></i><span>الكتلة الثالثة — إدارة الفروع</span></div>
            <div class="block-badge"><i class="fas fa-warehouse"></i><span>الكتلة الرابعة — المستودعات</span></div>
            <div class="block-badge"><i class="fas fa-box"></i><span>الكتلة الخامسة — المنتجات</span></div>
        </div>
    </div>

    <div class="login-form-area">
        <div class="form-header">
            <h2>مرحباً بك 👋</h2>
            <p>أدخل بيانات حسابك للدخول إلى قسمك</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" id="loginForm">
            @csrf
            <div class="form-group">
                <label class="form-label">اسم المستخدم</label>
                <div class="input-wrap">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="username"
                        class="form-control @error('username') is-invalid @enderror"
                        placeholder="أدخل اسم المستخدم"
                        value="{{ old('username') }}" autocomplete="off">
                </div>
                @error('username')
                    <div class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">كلمة المرور</label>
                <div class="input-wrap">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" id="passInput"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="أدخل كلمة المرور">
                    <button type="button" class="toggle-pass" onclick="togglePass()">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="error-msg"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-login" id="loginBtn">
                <div class="spinner" id="spinner"></div>
                <i class="fas fa-sign-in-alt" id="loginIcon"></i>
                <span id="loginText">تسجيل الدخول</span>
            </button>
        </form>

        <div class="form-footer">🎓 الجامعة العربية الدولية — برمجة الويب 2</div>
    </div>
</div>

<script>
function togglePass() {
    const input = document.getElementById('passInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
document.getElementById('loginForm').addEventListener('submit', function() {
    const u = document.querySelector('[name=username]').value.trim();
    const p = document.getElementById('passInput').value.trim();
    if (!u || !p) return;
    document.getElementById('spinner').style.display = 'block';
    document.getElementById('loginIcon').style.display = 'none';
    document.getElementById('loginText').textContent = 'جارٍ الدخول...';
    document.getElementById('loginBtn').disabled = true;
});
</script>
</body>
</html>
