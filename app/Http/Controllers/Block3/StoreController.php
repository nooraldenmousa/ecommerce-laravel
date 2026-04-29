<?php

namespace App\Http\Controllers\Block3;

use App\Http\Controllers\Controller;
use App\Models\PersonalInformation; // تأكد من مطابقة اسم الموديل لجدول PERSONAL_INFORMATION
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\Store;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    // =========================================================
    // DASHBOARD
    // =========================================================
    public function dashboard()
    {
        $storesCount     = Store::count();
        $warehousesCount = Warehouse::count();
        $productsCount   = Product::count();
        $lowStockItems   = 0;

        return view('block3.dashboard', compact(
            'storesCount',
            'warehousesCount',
            'productsCount',
            'lowStockItems'
        ));
    }

    // =========================================================
    // INDEX — عرض قائمة المتاجر مع المدير المسؤول
    // =========================================================
    public function index(Request $request)
    {
        // استخدام with('manager') لجلب بيانات المدير بطلب واحد (Eager Loading)
        $query = Store::with('manager');

        if ($request->filled('search')) {
            $query->where('store_name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('city')) {
            $query->where('city', 'LIKE', '%' . trim($request->city) . '%');
        }

        $stores = $query->get();
        $provinces = ['دمشق', 'ريف دمشق', 'حلب', 'حمص', 'حماة', 'اللاذقية', 'طرطوس'];

        return view('block3.stores.index', compact('stores', 'provinces'));
    }

    // =========================================================
    // CREATE — تجهيز قائمة المدراء والموظفين
    // =========================================================
  public function create()
{
    // جلب كافة الموظفين ليتم اختيار أحدهم كمدير للمتجر
    $all_employees = \App\Models\PersonalInformation::all();

    // تعريف قائمة المحافظات
    $provinces = ['دمشق', 'حلب', 'حمص', 'اللاذقية', 'طرطوس', 'حماة', 'إدلب', 'دير الزور', 'الرقة', 'الحسكة', 'درعا', 'السويداء', 'القنيطرة'];

    return view('block3.stores.create', compact('all_employees', 'provinces'));
}

    // =========================================================
    // STORE — حفظ المتجر مع المدير المختار
    // =========================================================
    public function store(Request $request)
    {
      // 1. التحقق من البيانات (تأكد أن الأسماء تطابق الـ name في الـ input)
    $request->validate([
        'store_name' => 'required|string|max:255',
        'city'       => 'required',
        'manager_id' => 'nullable|exists:PERSONAL_INFORMATION,personal_id',
        'brochure'   => 'nullable|file|mimes:pdf,jpg,png,zip|max:5120',
    ], [
        'store_name.required' => 'اسم المتجر مطلوب.',
        'city.required' => 'يجب اختيار المدينة.',
    ]);

    try {
        // 2. معالجة الملف
        $fileName = null;
        if ($request->hasFile('brochure')) {
            $fileName = $request->file('brochure')->store('stores/brochures', 'public');
        }

        // 3. الحفظ الفعلي
        \App\Models\Store::create([
            'store_name'  => $request->store_name,
            'city'        => $request->city,
            'address'     => $request->address,
            'phone'       => $request->phone,
            'upload_file' => $fileName, // التأكد من اسم العمود في قاعدة البيانات
        ]);

        return redirect()->route('block3.stores.index')->with('success', 'تمت إضافة المتجر بنجاح!');

    } catch (\Exception $e) {
        // إذا حدث خطأ في قاعدة البيانات، سيعود برسالة واضحة
        return back()->withInput()->withErrors(['db_error' => 'خطأ في قاعدة البيانات: ' . $e->getMessage()]);
    }
    // ربط الموظفين بالمتجر (تحديث عمود stores_id في جدول الموظفين)
    if ($request->has('employees')) {
        \App\Models\PersonalInformation::whereIn('personal_id', $request->employees)
            ->update(['stores_id' => $store->store_id]);
    }

    return redirect()->route('block3.stores.index')->with('success', 'تم إضافة المتجر والمسؤولين بنجاح!');
}

    // =========================================================
    // EDIT — تعديل المتجر والمدير
    // =========================================================
 public function edit($id)
{
    $store = Store::findOrFail($id);
    $all_products = \App\Models\Product::all();
    $all_employees = \App\Models\PersonalInformation::all(); // تأكد من هذا السطر

    return view('block3.stores.edit', compact('store', 'all_products', 'all_employees'));
}

    // =========================================================
    // UPDATE — تحديث البيانات بما فيها المدير
    // =========================================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'store_name' => 'required',
            'city'       => 'required',
            'address'    => 'required',
            'phone'      => 'required',
'manager_id' => 'nullable|exists:PERSONAL_INFORMATION,personal_id',         ]);

        $store = Store::findOrFail($id);

        $filePath = $store->upload_file;
    if ($request->hasFile('brochure')) {
        // 1. توليد اسم قصير جداً يعتمد على الوقت الحالي + امتداد الملف (مثال: 1713982000.pdf)
        $shortFileName = time() . '.' . $request->file('brochure')->getClientOriginalExtension();

        // 2. حفظ الملف بالاسم القصير باستخدام دالة storeAs بدلاً من store
        $filePath = $request->file('brochure')->storeAs('stores', $shortFileName, 'public');
    }

        // تحديث عبر الـ Stored Procedure كما طلبت سابقاً
        // ملاحظة: تأكد أن الإجراء UpdateStore في SSMS يستقبل بارامتر manager_id إذا كنت تريد تحديثه من هناك
        \DB::statement("EXEC dbo.UpdateStore ?, ?, ?, ?, ?, ?", [
        $id, $request->store_name, $request->city, $request->address, $request->phone, $filePath ?? null
    ]);

    // 2. تحديث المدير يدوياً
    $store = \App\Models\Store::findOrFail($id);
    $store->update(['manager_id' => $request->manager_id]);

    // 3. تحديث الموظفين
    // أولاً: تفريغ المتجر من جميع الموظفين الحاليين (إرجاع القيمة لـ null)
    \App\Models\PersonalInformation::where('stores_id', $id)->update(['stores_id' => null]);

    // ثانياً: تعيين الموظفين الجدد الذين تم تحديدهم
    if ($request->has('employees')) {
        \App\Models\PersonalInformation::whereIn('personal_id', $request->employees)
            ->update(['stores_id' => $id]);
    }

$store = Store::findOrFail($id);

    // ربط المنتجات المختارة من الواجهة
    if ($request->has('products')) {
        // sync تقوم بحذف الارتباطات القديمة وإضافة الجديدة المختارة فقط
        $store->products()->sync($request->products);
    } else {
        // إذا لم يتم اختيار أي منتج، يتم مسح كافة المنتجات المرتبطة بهذا المتجر
        $store->products()->detach();
    }

    return redirect()->route('block3.stores.index')->with('success', 'تم تحديث المتجر والمنتجات بنجاح');
}

    // =========================================================
    // SHOW — عرض التفاصيل مع بيانات المدير الكاملة
    // =========================================================
    public function show($id)
{
    // جلب المتجر مع المدير المرتبط به
    $store = \App\Models\Store::with('manager')->where('store_id', $id)->firstOrFail();

    // جلب قائمة الموظفين (اختياري للعرض)
    $employees = \App\Models\PersonalInformation::all();

    return view('block3.stores.show', compact('store', 'employees'));
}

    // ... (بقية الدوال: destroy, download, transfer تظل كما هي مع ضمان عمل الصلاحيات) ...

 public function destroy($id)
{
    if (session('user.role') !== 'manager') {
        return redirect()->back()->with('error', 'عذراً، لا تمتلك الصلاحية الكافية.');
    }

    try {
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare("DECLARE @can_del BIT, @msg NVARCHAR(250);
                               EXEC DeleteStoreWithCheck ?, @can_del OUTPUT, @msg OUTPUT;
                               SELECT @can_del AS can_delete, @msg AS message;");
        $stmt->execute([$id]);
        $stmt->nextRowset();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result && $result['can_delete'] == 1) {
            return redirect()->route('block3.stores.index')->with('success', $result['message']);
        } else {
            return redirect()->route('block3.stores.index')->with('error', $result['message'] ?? 'لا يمكن الحذف');
        }
    } catch (\Exception $e) {
        return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
    }
}
}
