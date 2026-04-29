<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseStoreController extends Controller
{
    private function checkSession()
    {
        if (!session()->has('user')) return false;
        return true;
    }

    // عرض المتاجر المرتبطة بالمستودع
    public function index($id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $warehouse = DB::selectOne("SELECT * FROM WAREHOUSE WHERE warehouse_id = ?", [$id]);
        if (!$warehouse) abort(404);

        $linkedStores = DB::select("
            SELECT S.*, WS.warehouse_store_id
            FROM STORE S
            INNER JOIN WAREHOUSE_STORE WS ON WS.store_id = S.store_id
            WHERE WS.warehouse_id = ?
        ", [$id]);

        $availableStores = DB::select("
            SELECT * FROM STORE
            WHERE store_id NOT IN (
                SELECT store_id FROM WAREHOUSE_STORE WHERE warehouse_id = ?
            )
        ", [$id]);

        return view('warehouse.stores', compact('warehouse', 'linkedStores', 'availableStores'));
    }

    // ربط متجر بالمستودع
    public function attach(Request $request, $id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $request->validate([
            'store_id' => 'required|integer'
        ], [
            'store_id.required' => 'يجب اختيار متجر'
        ]);

        // التحقق من عدم وجود الربط مسبقاً
        $exists = DB::selectOne("
            SELECT COUNT(*) as count FROM WAREHOUSE_STORE
            WHERE warehouse_id = ? AND store_id = ?
        ", [$id, $request->store_id])->count;

        if ($exists > 0) {
            return back()->with('error', 'هذا المتجر مرتبط بالمستودع مسبقاً ❌');
        }

        DB::statement("
            INSERT INTO WAREHOUSE_STORE (warehouse_id, store_id)
            VALUES (?, ?)
        ", [$id, $request->store_id]);

        return back()->with('success', 'تم ربط المتجر بالمستودع بنجاح ✅');
    }

    // إلغاء ربط متجر من المستودع
    public function detach($id, $store_id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        if (session('user.role') !== 'manager') {
            return back()->with('error', 'غير مصرح لك بهذه العملية ❌');
        }

        DB::statement("
            DELETE FROM WAREHOUSE_STORE
            WHERE warehouse_id = ? AND store_id = ?
        ", [$id, $store_id]);

        return back()->with('success', 'تم إلغاء ربط المتجر بنجاح ✅');
    }
}