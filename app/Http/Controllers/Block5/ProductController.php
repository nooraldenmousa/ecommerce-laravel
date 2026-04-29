<?php

namespace App\Http\Controllers\Block5;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private function checkSession()
    {
        if (!session()->has('user')) return false;
        return true;
    }

    // Dashboard
    public function dashboard()
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $totalProducts   = DB::selectOne("SELECT COUNT(*) as count FROM PRODUCT")->count;
        $totalWarehouses = DB::selectOne("SELECT COUNT(*) as count FROM WAREHOUSE_PRODUCT")->count;
        $totalStores     = DB::selectOne("SELECT COUNT(*) as count FROM PRODUCT_STORE")->count;
        $recentProducts  = DB::select("SELECT TOP 5 * FROM PRODUCT ORDER BY product_id DESC");

        return view('product.dashboard', compact(
            'totalProducts', 'totalWarehouses', 'totalStores', 'recentProducts'
        ));
    }

    // عرض كل المنتجات
    public function index(Request $request)
    {
        if (!$this->checkSession()) return redirect()->route('login');

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

        return view('product.index', compact('products', 'search', 'minPrice', 'maxPrice'));
    }

    // صفحة إضافة منتج
    public function create()
    {
        if (!$this->checkSession()) return redirect()->route('login');
        return view('product.create');
    }

    // حفظ منتج جديد - Stored Procedure
    public function store(Request $request)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $request->validate([
            'product_name' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'upload_file'  => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ], [
            'product_name.required' => 'اسم المنتج مطلوب',
            'price.required'        => 'السعر مطلوب',
            'price.min'             => 'السعر يجب أن يكون موجباً أو صفر',
        ]);

        $fileName = null;
        if ($request->hasFile('upload_file')) {
            $file     = $request->file('upload_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $fileName);
        }

        // Stored Procedure
        DB::statement("EXEC sp_AddProduct ?, ?, ?, ?", [
            $request->product_name,
            $request->description,
            $request->price,
            $fileName
        ]);

        return redirect()->route('product.index')
            ->with('success', 'تم إضافة المنتج بنجاح ✅');
    }

    // عرض تفاصيل منتج
    public function show($id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $product = DB::selectOne("SELECT * FROM PRODUCT WHERE product_id = ?", [$id]);
        if (!$product) abort(404);

        $warehouses = DB::select("
            SELECT W.* FROM WAREHOUSE W
            INNER JOIN WAREHOUSE_PRODUCT WP ON WP.warehouse_id = W.warehouse_id
            WHERE WP.product_id = ?
        ", [$id]);

        $stores = DB::select("
            SELECT S.* FROM STORE S
            INNER JOIN PRODUCT_STORE PS ON PS.store_id = S.store_id
            WHERE PS.product_id = ?
        ", [$id]);

        return view('product.show', compact('product', 'warehouses', 'stores'));
    }

    // صفحة تعديل منتج
    public function edit($id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $product = DB::selectOne("SELECT * FROM PRODUCT WHERE product_id = ?", [$id]);
        if (!$product) abort(404);

        return view('product.edit', compact('product'));
    }

    // تحديث منتج
    public function update(Request $request, $id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        $request->validate([
            'product_name' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'upload_file'  => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $product = DB::selectOne("SELECT * FROM PRODUCT WHERE product_id = ?", [$id]);
        if (!$product) abort(404);

        $fileName = $product->upload_file;
        if ($request->hasFile('upload_file')) {
            $file     = $request->file('upload_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $fileName);
        }

        DB::statement("
            UPDATE PRODUCT SET
                product_name = ?,
                description  = ?,
                price        = ?,
                upload_file  = ?
            WHERE product_id = ?
        ", [
            $request->product_name,
            $request->description,
            $request->price,
            $fileName,
            $id
        ]);

        return redirect()->route('product.index')
            ->with('success', 'تم تحديث المنتج بنجاح ✅');
    }

    // حذف منتج - للمانجر فقط + شرط
    public function destroy($id)
    {
        if (!$this->checkSession()) return redirect()->route('login');

        if (session('user.role') !== 'manager') {
            return back()->with('error', 'غير مصرح لك بالحذف ❌');
        }

        $linkedWarehouses = DB::selectOne("
            SELECT COUNT(*) as count FROM WAREHOUSE_PRODUCT WHERE product_id = ?
        ", [$id])->count;

        $linkedStores = DB::selectOne("
            SELECT COUNT(*) as count FROM PRODUCT_STORE WHERE product_id = ?
        ", [$id])->count;

        if ($linkedWarehouses > 0 || $linkedStores > 0) {
            return back()->with('error', 'لا يمكن حذف المنتج لأنه مرتبط بمستودع أو متجر ❌');
        }

        DB::statement("DELETE FROM PRODUCT WHERE product_id = ?", [$id]);

        return redirect()->route('product.index')
            ->with('success', 'تم حذف المنتج بنجاح ✅');
    }

    // بحث ديناميكي AJAX
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

        return response()->json($products);
    }
}
