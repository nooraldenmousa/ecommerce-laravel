<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseProductController extends Controller
{
    private function checkSession()
    {
        if (!session()->has('user')) return false;
        return true;
    }

    // عرض المنتجات المرتبطة بالمستودع
    public function index($id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $warehouse = DB::selectOne("SELECT * FROM WAREHOUSE WHERE warehouse_id = ?", [$id]);
        if (!$warehouse) abort(404);

        $linkedProducts = DB::select("
            SELECT P.*, WP.warehouse_product_id
            FROM PRODUCT P
            INNER JOIN WAREHOUSE_PRODUCT WP ON WP.product_id = P.product_id
            WHERE WP.warehouse_id = ?
        ", [$id]);

        $availableProducts = DB::select("
            SELECT * FROM PRODUCT
            WHERE product_id NOT IN (
                SELECT product_id FROM WAREHOUSE_PRODUCT WHERE warehouse_id = ?
            )
        ", [$id]);

        return view('warehouse.products', compact('warehouse', 'linkedProducts', 'availableProducts'));
    }

    // ربط منتج بالمستودع
    public function attach(Request $request, $id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $request->validate([
            'product_id' => 'required|integer'
        ], [
            'product_id.required' => 'يجب اختيار منتج'
        ]);

        $exists = DB::selectOne("
            SELECT COUNT(*) as count FROM WAREHOUSE_PRODUCT
            WHERE warehouse_id = ? AND product_id = ?
        ", [$id, $request->product_id])->count;

        if ($exists > 0) {
            return back()->with('error', 'هذا المنتج مرتبط بالمستودع مسبقاً ❌');
        }

        DB::statement("
            INSERT INTO WAREHOUSE_PRODUCT (warehouse_id, product_id)
            VALUES (?, ?)
        ", [$id, $request->product_id]);

        return back()->with('success', 'تم ربط المنتج بالمستودع بنجاح ✅');
    }

    // إلغاء ربط منتج
    public function detach($id, $product_id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        if (session('user.role') !== 'manager') {
            return back()->with('error', 'غير مصرح لك بهذه العملية ❌');
        }

        DB::statement("
            DELETE FROM WAREHOUSE_PRODUCT
            WHERE warehouse_id = ? AND product_id = ?
        ", [$id, $product_id]);

        return back()->with('success', 'تم إلغاء ربط المنتج بنجاح ✅');
    }
}