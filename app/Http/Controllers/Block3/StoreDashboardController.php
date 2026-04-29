<?php

namespace App\Http\Controllers\Block3;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Warehouse;
use App\Models\Product;

class StoreDashboardController extends Controller
{
    public function dashboard()
    {
        if (!session()->has('user')) {
            return redirect()->route('login');
        }

        $storesCount     = Store::count();
        $warehousesCount = Warehouse::count();
        $productsCount   = Product::count();

        return view('block3.dashboard', compact(
            'storesCount', 'warehousesCount', 'productsCount'
        ));
    }
}
