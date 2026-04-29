<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    // التحقق من الجلسة
    private function checkSession()
    {
        if (!session()->has('user')) {
            return false;
        }
        return true;
    }

    // Dashboard
    public function dashboard()
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $totalWarehouses = DB::selectOne("SELECT COUNT(*) as count FROM WAREHOUSE")->count;
        $totalProducts   = DB::selectOne("SELECT COUNT(*) as count FROM WAREHOUSE_PRODUCT")->count;
        $totalStores     = DB::selectOne("SELECT COUNT(*) as count FROM WAREHOUSE_STORE")->count;
        $recentWarehouses = DB::select("SELECT TOP 5 * FROM WAREHOUSE ORDER BY warehouse_id DESC");

        return view('warehouse.dashboard', compact(
            'totalWarehouses', 'totalProducts', 'totalStores', 'recentWarehouses'
        ));
    }

    // عرض كل المستودعات
    public function index(Request $request)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $search = $request->get('search', '');
        $city   = $request->get('city', '');

        $warehouses = DB::select("
            SELECT W.*, 
                   P.firstNmae + ' ' + P.lastName as manager_name
            FROM WAREHOUSE W
            LEFT JOIN PERSONAL_INFORMATION P ON P.personal_id = W.manager_id
            WHERE (W.warehouse_name LIKE ? OR ? = '')
            AND   (W.city LIKE ? OR ? = '')
            ORDER BY W.warehouse_id DESC
        ", ["%$search%", $search, "%$city%", $city]);

        $cities = DB::select("SELECT DISTINCT city FROM WAREHOUSE WHERE city IS NOT NULL");

        return view('warehouse.index', compact('warehouses', 'search', 'city', 'cities'));
    }

    // صفحة إضافة مستودع
    public function create()
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $managers = DB::select("
            SELECT P.personal_id, P.firstNmae + ' ' + P.lastName as full_name
            FROM PERSONAL_INFORMATION P
            INNER JOIN ROLE R ON R.role_id = P.role_id
            WHERE R.type = 'manager'
        ");

        return view('warehouse.create', compact('managers'));
    }

    // حفظ مستودع جديد
    public function store(Request $request)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $request->validate([
            'warehouse_name' => 'required|string|max:255',
            'city'           => 'required|string|max:100',
            'address'        => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'upload_file'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'manager_id'     => 'nullable|integer',
        ], [
            'warehouse_name.required' => 'اسم المستودع مطلوب',
            'city.required'           => 'المدينة مطلوبة',
            'address.required'        => 'العنوان مطلوب',
            'phone.required'          => 'رقم الهاتف مطلوب',
        ]);

        $fileName = null;
        if ($request->hasFile('upload_file')) {
            $file     = $request->file('upload_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/warehouses'), $fileName);
        }

        // Stored Procedure
        DB::statement("
            EXEC sp_AddWarehouse ?, ?, ?, ?, ?, ?
        ", [
            $request->warehouse_name,
            $request->city,
            $request->address,
            $request->phone,
            $fileName,
            $request->manager_id
        ]);

        return redirect()->route('warehouse.index')
            ->with('success', 'تم إضافة المستودع بنجاح ✅');
    }

    // عرض تفاصيل مستودع
    public function show($id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $warehouse = DB::selectOne("
            SELECT W.*,
                   P.firstNmae + ' ' + P.lastName as manager_name
            FROM WAREHOUSE W
            LEFT JOIN PERSONAL_INFORMATION P ON P.personal_id = W.manager_id
            WHERE W.warehouse_id = ?
        ", [$id]);

        if (!$warehouse) abort(404);

        $stores = DB::select("
            SELECT S.* FROM STORE S
            INNER JOIN WAREHOUSE_STORE WS ON WS.store_id = S.store_id
            WHERE WS.warehouse_id = ?
        ", [$id]);

        $products = DB::select("
            SELECT P.* FROM PRODUCT P
            INNER JOIN WAREHOUSE_PRODUCT WP ON WP.product_id = P.product_id
            WHERE WP.warehouse_id = ?
        ", [$id]);

        $employees = DB::select("
            SELECT P.personal_id, P.firstNmae + ' ' + P.lastName as full_name,
                   R.type as role
            FROM PERSONAL_INFORMATION P
            INNER JOIN ROLE R ON R.role_id = P.role_id
            WHERE P.warehouse_id = ?
        ", [$id]);

        return view('warehouse.show', compact('warehouse', 'stores', 'products', 'employees'));
    }

    // صفحة تعديل مستودع
    public function edit($id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $warehouse = DB::selectOne("SELECT * FROM WAREHOUSE WHERE warehouse_id = ?", [$id]);
        if (!$warehouse) abort(404);

        $managers = DB::select("
            SELECT P.personal_id, P.firstNmae + ' ' + P.lastName as full_name
            FROM PERSONAL_INFORMATION P
            INNER JOIN ROLE R ON R.role_id = P.role_id
            WHERE R.type = 'manager'
        ");

        return view('warehouse.edit', compact('warehouse', 'managers'));
    }

    // تحديث مستودع
    public function update(Request $request, $id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $request->validate([
            'warehouse_name' => 'required|string|max:255',
            'city'           => 'required|string|max:100',
            'address'        => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'upload_file'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'manager_id'     => 'nullable|integer',
        ]);

        $warehouse = DB::selectOne("SELECT * FROM WAREHOUSE WHERE warehouse_id = ?", [$id]);
        if (!$warehouse) abort(404);

        $fileName = $warehouse->upload_file;
        if ($request->hasFile('upload_file')) {
            $file     = $request->file('upload_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/warehouses'), $fileName);
        }

        DB::statement("
            UPDATE WAREHOUSE SET
                warehouse_name = ?,
                city = ?,
                address = ?,
                phone = ?,
                upload_file = ?,
                manager_id = ?
            WHERE warehouse_id = ?
        ", [
            $request->warehouse_name,
            $request->city,
            $request->address,
            $request->phone,
            $fileName,
            $request->manager_id,
            $id
        ]);

        return redirect()->route('warehouse.index')
            ->with('success', 'تم تحديث المستودع بنجاح ✅');
    }

    // حذف مستودع - للمانجر فقط
    public function destroy($id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        if (session('user.role') !== 'manager') {
            return back()->with('error', 'غير مصرح لك بالحذف ❌');
        }

        // التحقق من عدم ارتباط المستودع بمتجر أو منتج
        $linkedStores = DB::selectOne("
            SELECT COUNT(*) as count FROM WAREHOUSE_STORE WHERE warehouse_id = ?
        ", [$id])->count;

        $linkedProducts = DB::selectOne("
            SELECT COUNT(*) as count FROM WAREHOUSE_PRODUCT WHERE warehouse_id = ?
        ", [$id])->count;

        if ($linkedStores > 0 || $linkedProducts > 0) {
            return back()->with('error', 'لا يمكن حذف المستودع لأنه مرتبط بمتاجر أو منتجات ❌');
        }

        DB::statement("DELETE FROM WAREHOUSE WHERE warehouse_id = ?", [$id]);

        return redirect()->route('warehouse.index')
            ->with('success', 'تم حذف المستودع بنجاح ✅');
    }

    // بحث ديناميكي AJAX
    public function search(Request $request)
    {
        $search = $request->get('search', '');
        $city   = $request->get('city', '');

        $warehouses = DB::select("
            SELECT W.*,
                   P.firstNmae + ' ' + P.lastName as manager_name
            FROM WAREHOUSE W
            LEFT JOIN PERSONAL_INFORMATION P ON P.personal_id = W.manager_id
            WHERE (W.warehouse_name LIKE ? OR ? = '')
            AND   (W.city LIKE ? OR ? = '')
            ORDER BY W.warehouse_id DESC
        ", ["%$search%", $search, "%$city%", $city]);

        return response()->json($warehouses);
    }
}