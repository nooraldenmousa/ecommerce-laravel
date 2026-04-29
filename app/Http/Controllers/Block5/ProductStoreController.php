<?php

namespace App\Http\Controllers\Block5;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductStoreController extends Controller
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

        $linkedStores = DB::select("
            SELECT S.*, PS.product_store_id
            FROM STORE S
            INNER JOIN PRODUCT_STORE PS ON PS.store_id = S.store_id
            WHERE PS.product_id = ?
        ", [$id]);

        $availableStores = DB::select("
            SELECT * FROM STORE
            WHERE store_id NOT IN (
                SELECT store_id FROM PRODUCT_STORE WHERE product_id = ?
            )
        ", [$id]);

        return view('product.stores', compact('product', 'linkedStores', 'availableStores'));
    }

    public function attach(Request $request, $id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $request->validate(['store_id' => 'required|integer'], [
            'store_id.required' => 'يجب اختيار متجر'
        ]);

        $exists = DB::selectOne("
            SELECT COUNT(*) as count FROM PRODUCT_STORE
            WHERE product_id = ? AND store_id = ?
        ", [$id, $request->store_id])->count;

        if ($exists > 0) {
            return back()->with('error', 'المنتج معروض في هذا المتجر مسبقاً ❌');
        }

        DB::statement("
            INSERT INTO PRODUCT_STORE (product_id, store_id) VALUES (?, ?)
        ", [$id, $request->store_id]);

        return back()->with('success', 'تم عرض المنتج في المتجر بنجاح ✅');
    }

    public function detach($id, $store_id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        if (session('user.role') !== 'manager') {
            return back()->with('error', 'غير مصرح لك بهذه العملية ❌');
        }

        DB::statement("
            DELETE FROM PRODUCT_STORE WHERE product_id = ? AND store_id = ?
        ", [$id, $store_id]);

        return back()->with('success', 'تم إلغاء عرض المنتج في المتجر بنجاح ✅');
    }
}
