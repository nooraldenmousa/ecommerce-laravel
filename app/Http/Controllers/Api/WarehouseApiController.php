<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseApiController extends Controller
{
    // GET - جلب كل المستودعات
    public function index()
    {
        $warehouses = DB::select("
            SELECT W.*,
                   P.firstNmae + ' ' + P.lastName as manager_name
            FROM WAREHOUSE W
            LEFT JOIN PERSONAL_INFORMATION P ON P.personal_id = W.manager_id
            ORDER BY W.warehouse_id DESC
        ");

        return response()->json([
            'status'  => 'success',
            'data'    => $warehouses
        ]);
    }

    // GET - بحث
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

        return response()->json([
            'status' => 'success',
            'data'   => $warehouses
        ]);
    }

    // POST - إضافة مستودع
    public function store(Request $request)
    {
        $request->validate([
            'warehouse_name' => 'required|string|max:255',
            'city'           => 'required|string|max:100',
            'address'        => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
        ]);

        DB::statement("
            INSERT INTO WAREHOUSE (warehouse_name, city, address, phone, manager_id)
            VALUES (?, ?, ?, ?, ?)
        ", [
            $request->warehouse_name,
            $request->city,
            $request->address,
            $request->phone,
            $request->manager_id
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'تم إضافة المستودع بنجاح'
        ], 201);
    }

    // PUT - تعديل مستودع
    public function update(Request $request, $id)
    {
        $request->validate([
            'warehouse_name' => 'required|string|max:255',
            'city'           => 'required|string|max:100',
            'address'        => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
        ]);

        DB::statement("
            UPDATE WAREHOUSE SET
                warehouse_name = ?,
                city = ?,
                address = ?,
                phone = ?,
                manager_id = ?
            WHERE warehouse_id = ?
        ", [
            $request->warehouse_name,
            $request->city,
            $request->address,
            $request->phone,
            $request->manager_id,
            $id
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'تم تحديث المستودع بنجاح'
        ]);
    }

    // DELETE - حذف مستودع
    public function destroy($id)
    {
        $linkedStores = DB::selectOne("
            SELECT COUNT(*) as count FROM WAREHOUSE_STORE WHERE warehouse_id = ?
        ", [$id])->count;

        $linkedProducts = DB::selectOne("
            SELECT COUNT(*) as count FROM WAREHOUSE_PRODUCT WHERE warehouse_id = ?
        ", [$id])->count;

        if ($linkedStores > 0 || $linkedProducts > 0) {
            return response()->json([
                'status'  => 'error',
                'message' => 'لا يمكن حذف المستودع لأنه مرتبط بمتاجر أو منتجات'
            ], 400);
        }

        DB::statement("DELETE FROM WAREHOUSE WHERE warehouse_id = ?", [$id]);

        return response()->json([
            'status'  => 'success',
            'message' => 'تم حذف المستودع بنجاح'
        ]);
    }
}