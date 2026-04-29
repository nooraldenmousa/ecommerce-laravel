<?php

namespace App\Http\Controllers\Block2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketingController extends Controller
{
    public function dashboard()
    {
        if (!session('user')) {
            return redirect()->route('login');
        }

        $totalCustomers = DB::selectOne("SELECT COUNT(*) as count FROM PERSONAL_INFORMATION WHERE customer_status_id IS NOT NULL")->count;
        $vipCustomers   = DB::selectOne("SELECT COUNT(*) as count FROM PERSONAL_INFORMATION WHERE customer_type_id = 2")->count;

        return view('marketing.dashboard', compact('totalCustomers', 'vipCustomers'));
    }
}
