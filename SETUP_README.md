# 🏪 مشروع إدارة متجر إلكتروني متعدد الفروع
## برمجة الويب 2 — الجامعة العربية الدولية

---

## 📁 هيكل المشروع الموحد

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   └── LoginController.php      ← تسجيل الدخول الموحد
│   │   ├── Block1/
│   │   │   ├── EmployeeController.php   ← الموارد البشرية
│   │   │   └── DepartmentController.php ← الأقسام
│   │   ├── Block2/
│   │   │   ├── CustomerController.php   ← الزبائن
│   │   │   ├── OfferController.php      ← العروض
│   │   │   └── MarketingController.php  ← Dashboard التسويق
│   │   ├── Api/
│   │   │   └── WarehouseApiController.php ← API المستودعات
│   │   ├── HRController.php             ← Dashboard HR
│   │   ├── WarehouseController.php      ← المستودعات
│   │   ├── WarehouseStoreController.php ← ربط المتاجر
│   │   └── WarehouseProductController.php ← ربط المنتجات
│   └── Middleware/
│       ├── CheckAuth.php
│       └── CheckRole.php
├── Models/ (جميع الموديلز مدمجة)
resources/views/
├── auth/login.blade.php    ← صفحة الدخول الموحدة الجديدة
├── hr/dashboard.blade.php
├── block1/ (موظفين + أقسام)
├── marketing/dashboard.blade.php
├── customers/
├── offers/
├── warehouse/
└── layouts/app.blade.php
routes/web.php              ← ملف الروابط الموحد
```

---

## 🚀 خطوات التشغيل

```bash
# 1. انتقل لمجلد المشروع
cd C:\xampp\htdocs\wp2 project\wp2_project

# 2. ثبّت الاعتماديات
composer install

# 3. انسخ ملف البيئة وعدّله
copy .env.example .env
# عدّل DB_HOST و DB_USERNAME و DB_PASSWORD

# 4. مسح الكاش
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 5. شغّل السيرفر
php artisan serve
```

---

## 🔐 منطق تسجيل الدخول الموحد

عند إدخال Username + Password:

| role_id | نوع الدور | يذهب إلى |
|---------|-----------|-----------|
| 1, 2 | HR (موارد بشرية) | `/hr/dashboard` |
| 3, 4 | Marketing (تسويق) | `/marketing/dashboard` |
| 7, 8 | Warehouse (مستودعات) | `/warehouse/dashboard` |
| 5, 6 | Store (متاجر) | `/warehouse/dashboard` مؤقتاً |

---

## 🔗 مسارات كل كتلة

### الكتلة 1 — HR
- `/hr/dashboard`
- `/hr/employees`
- `/hr/departments`

### الكتلة 2 — التسويق
- `/marketing/dashboard`
- `/marketing/customers`
- `/marketing/offers`

### الكتلة 4 — المستودعات
- `/warehouse/dashboard`
- `/warehouse/`
- `/api/warehouse/`

---

## ⚙️ إعداد قاعدة البيانات

```
DB_CONNECTION=sqlsrv
DB_HOST=NOUR\SQLEXPRESS
DB_PORT=1433
DB_DATABASE=STORE_DB
DB_USERNAME=sa
DB_PASSWORD=123
DB_TRUST_SERVER_CERTIFICATE=true
```

