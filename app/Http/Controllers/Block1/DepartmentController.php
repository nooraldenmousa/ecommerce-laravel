<?php
namespace App\Http\Controllers\Block1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = DB::table('DEPARTMENT')->paginate(10);
        return view('block1.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('block1.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:100|unique:DEPARTMENT,department_name',
        ]);

        DB::table('DEPARTMENT')->insert([
            'department_name' => $request->department_name,
        ]);

        return redirect()->route('hr.departments.index')
                         ->with('success', 'تم إضافة القسم بنجاح');
    }

    public function edit($id)
    {
        $department = DB::table('DEPARTMENT')
                        ->where('department_id', $id)->first();
        return view('block1.departments.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'department_name' => 'required|string|max:100',
        ]);

        DB::table('DEPARTMENT')
            ->where('department_id', $id)
            ->update(['department_name' => $request->department_name]);

        return redirect()->route('hr.departments.index')
                         ->with('success', 'تم تعديل القسم');
    }

public function showEmployees($id)
{
    $department = DB::table('DEPARTMENT')->where('department_id', $id)->first();

    $employees = DB::table('PERSONAL_INFORMATION')
        ->join('ROLE', 'PERSONAL_INFORMATION.role_id', '=', 'ROLE.role_id')
        ->where('PERSONAL_INFORMATION.department_id', $id)
        ->select('PERSONAL_INFORMATION.*', 'ROLE.type as role_name')
        ->get();


    $availableEmployees = DB::table('PERSONAL_INFORMATION')
        ->whereNull('department_id')
        ->get();
$roles = DB::table('ROLE')->get();

return view('block1.departments.employees', compact(
    'department',
    'employees',
    'availableEmployees',
    'roles'
));
}


public function assignEmployee(Request $request, $id)
{

    $roleMap = [
        1 => 2,  // HR → موظف HR
        2 => 4,  // تسويق → موظف تسويق
        3 => 8,  // مستودع → موظف مستودع
        4 => 6,  // متجر → موظف متجر
    ];

    $role_id = $roleMap[$id] ?? null;

    DB::table('PERSONAL_INFORMATION')
        ->where('personal_id', $request->personal_id)
        ->update([
            'department_id' => $id,
            'role_id'       => $role_id,
        ]);

    return back()->with('success', 'تم تعيين الموظف للقسم');
}


public function removeEmployee(Request $request, $id)
{
    DB::table('PERSONAL_INFORMATION')
        ->where('personal_id', $request->personal_id)
        ->update(['department_id' => null]);

    return back()->with('success', 'تم إزالة الموظف من القسم');
}
public function changeRole(Request $request, $id)
{
    $request->validate([
        'personal_id' => 'required|exists:PERSONAL_INFORMATION,personal_id',
        'role_id'     => 'required|exists:ROLE,role_id',
    ]);

    DB::table('PERSONAL_INFORMATION')
        ->where('personal_id', $request->personal_id)
        ->update([
            'role_id' => $request->role_id
        ]);

    return back()->with('success', 'تم تغيير المنصب');
}
    public function destroy($id)
    {
        $hasEmployees = DB::table('PERSONAL_INFORMATION')
            ->where('department_id', $id)->exists();

        if ($hasEmployees) {
            return back()->with('error', 'لا يمكن حذف قسم يحتوي على موظفين');
        }

        DB::table('DEPARTMENT')->where('department_id', $id)->delete();
        return back()->with('success', 'تم حذف القسم');
    }
}
