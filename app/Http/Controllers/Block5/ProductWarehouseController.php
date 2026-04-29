<?php

namespace App\Http\Controllers\Block5;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductWarehouseController extends Controller
{
    private function checkSession()
    {
        if (!session()->has('user')) return false;
        return true;
    }

    public function index($id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $product = DB::selectOne("SELECT * FROM PRODUCT WHERE product_id = ?", [$id]);
        if (!$product) abort(404);

        $linkedWarehouses = DB::select("
            SELECT W.*, WP.warehouse_product_id
            FROM WAREHOUSE W
            INNER JOIN WAREHOUSE_PRODUCT WP ON WP.warehouse_id = W.warehouse_id
            WHERE WP.product_id = ?
        ", [$id]);

        $availableWarehouses = DB::select("
            SELECT * FROM WAREHOUSE
            WHERE warehouse_id NOT IN (
                SELECT warehouse_id FROM WAREHOUSE_PRODUCT WHERE product_id = ?
            )
        ", [$id]);

        return view('product.warehouses', compact('product', 'linkedWarehouses', 'availableWarehouses'));
    }

    public function attach(Request $request, $id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $request->validate(['warehouse_id' => 'required|integer'], [
            'warehouse_id.required' => 'يجب اختيار مستودع'
        ]);

        $exists = DB::selectOne("
            SELECT COUNT(*) as count FROM WAREHOUSE_PRODUCT
            WHERE product_id = ? AND warehouse_id = ?
        ", [$id, $request->warehouse_id])->count;

        if ($exists > 0) {
            return back()->with('error', 'المنتج مخزن في هذا المستودع مسبقاً ❌');
        }

        DB::statement("
            INSERT INTO WAREHOUSE_PRODUCT (warehouse_id, product_id) VALUES (?, ?)
        ", [$request->warehouse_id, $id]);

        return back()->with('success', 'تم تخزين المنتج في المستودع بنجاح ✅');
    }

    public function detach($id, $warehouse_id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        if (session('user.role') !== 'manager') {
            return back()->with('error', 'غير مصرح لك بهذه العملية ❌');
        }

        DB::statement("
            DELETE FROM WAREHOUSE_PRODUCT WHERE product_id = ? AND warehouse_id = ?
        ", [$id, $warehouse_id]);

        return back()->with('success', 'تم إلغاء تخزين المنتج بنجاح ✅');
    }
}
