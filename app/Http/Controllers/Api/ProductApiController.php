<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductApiController extends Controller
{
    // GET - كل المنتجات
    public function index()
    {
        $products = DB::select("SELECT * FROM PRODUCT ORDER BY product_id DESC");
        return response()->json(['status' => 'success', 'data' => $products]);
    }

    // GET - بحث
    public function search(Request $request)
    {
        $search   = $request->get('search', '');
        $minPrice = $request->get('min_price', '');
        $maxPrice = $request->get('max_price', '');

        $products = DB::select("
            SELECT * FROM PRODUCT
            WHERE (product_name LIKE ? OR ? = '')
            AND   (price >= ? OR ? = '')
            AND   (price <= ? OR ? = '')
            ORDER BY product_id DESC
        ", [
            "%$search%", $search,
            $minPrice ?: 0, $minPrice,
            $maxPrice ?: 999999999, $maxPrice
        ]);

        return response()->json(['status' => 'success', 'data' => $products]);
    }

    // POST - إضافة
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
        ]);

        DB::statement("
            INSERT INTO PRODUCT (product_name, description, price)
            VALUES (?, ?, ?)
        ", [$request->product_name, $request->description, $request->price]);

        return response()->json(['status' => 'success', 'message' => 'تم إضافة المنتج بنجاح'], 201);
    }

    // PUT - تعديل
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'price'        => 'required|numeric|min:0',
        ]);

        DB::statement("
            UPDATE PRODUCT SET product_name = ?, description = ?, price = ?
            WHERE product_id = ?
        ", [$request->product_name, $request->description, $request->price, $id]);

        return response()->json(['status' => 'success', 'message' => 'تم تحديث المنتج بنجاح']);
    }

    // DELETE - حذف
    public function destroy($id)
    {
        $linkedW = DB::selectOne("SELECT COUNT(*) as count FROM WAREHOUSE_PRODUCT WHERE product_id = ?", [$id])->count;
        $linkedS = DB::selectOne("SELECT COUNT(*) as count FROM PRODUCT_STORE WHERE product_id = ?", [$id])->count;

        if ($linkedW > 0 || $linkedS > 0) {
            return response()->json([
                'status'  => 'error',
                'message' => 'لا يمكن حذف المنتج لأنه مرتبط بمستودع أو متجر'
            ], 400);
        }

        DB::statement("DELETE FROM PRODUCT WHERE product_id = ?", [$id]);
        return response()->json(['status' => 'success', 'message' => 'تم حذف المنتج بنجاح']);
    }
}
