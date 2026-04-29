<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HRController extends Controller
{
    public function dashboard()
    {
        if (!session('user')) {
            return redirect()->route('login');
        }

        $totalEmployees  = DB::selectOne("SELECT COUNT(*) as count FROM PERSONAL_INFORMATION WHERE department_id IS NOT NULL")->count;
        $totalDepartments = DB::selectOne("SELECT COUNT(*) as count FROM DEPARTMENT")->count;

        return view('hr.dashboard', compact('totalEmployees', 'totalDepartments'));
    }
}
