<?php

namespace App\Http\Controllers\Block5;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductDashboardController extends Controller
{
    public function dashboard()
    {
        if (!session()->has('user')) {
            return redirect()->route('login');
        }

        $totalProducts   = DB::selectOne("SELECT COUNT(*) as count FROM PRODUCT")->count;
        $totalWarehouses = DB::selectOne("SELECT COUNT(*) as count FROM WAREHOUSE_PRODUCT")->count;
        $totalStores     = DB::selectOne("SELECT COUNT(*) as count FROM PRODUCT_STORE")->count;
        $recentProducts  = DB::select("SELECT TOP 5 * FROM PRODUCT ORDER BY product_id DESC");

        return view('product.dashboard', compact(
            'totalProducts', 'totalWarehouses', 'totalStores', 'recentProducts'
        ));
    }
}
