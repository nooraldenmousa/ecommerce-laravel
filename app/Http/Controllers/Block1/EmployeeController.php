<?php

namespace App\Http\Controllers\Block1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PersonalInformation;
use App\Models\Department;
use App\Models\Role;
use App\Models\EmployeeStatus;

class EmployeeController extends Controller
{

    public function index(Request $request)
    {
        $query = PersonalInformation::with(['department', 'role', 'employeeStatus']);

        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('firstNmae', 'like', '%' . $request->name . '%')
                  ->orWhere('lastName', 'like', '%' . $request->name . '%')
                  ->orWhereRaw("CONCAT(firstNmae, ' ', lastName) LIKE ?", ['%' . $request->name . '%']);
            });
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('status_id')) {
            $query->where('employee_status_id', $request->status_id);
        }

        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        $employees = $query->paginate(10);

        $departments = Department::all();
        $statuses    = EmployeeStatus::all();
        $roles       = Role::all();

        return view('block1.employees.index', compact(
            'employees',
            'departments',
            'statuses',
            'roles'
        ));
    }

    public function search(Request $request)
    {
        $query = PersonalInformation::with(['department', 'role', 'employeeStatus']);

        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('firstNmae', 'like', '%' . $request->name . '%')
                  ->orWhere('lastName', 'like', '%' . $request->name . '%')
                  ->orWhereRaw("CONCAT(firstNmae, ' ', lastName) LIKE ?", ['%' . $request->name . '%']);
            });
        }

        return response()->json($query->limit(20)->get());
    }

    public function create()
    {
        $departments = Department::all();
        $roles       = Role::all();
        $statuses    = EmployeeStatus::all();

        return view('block1.employees.create', compact(
            'departments',
            'roles',
            'statuses'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstNmae'       => 'required|string|max:100',
            'mother'          => 'required|string|max:100',
            'lastName'        => 'required|string|max:100',
            'national_number' => 'required|unique:PERSONAL_INFORMATION,national_number',
            'email'           => 'required|email|unique:PERSONAL_INFORMATION,email',
            'phone'           => 'required|digits:10',
            'birthday'        => 'required|date|before:' . now()->subYears(18)->toDateString(),
            'salary'          => 'required|numeric|min:0',
        ]);

        $imagePath = null;

        if ($request->hasFile('upload_file')) {
            $imagePath = $request->file('upload_file')->store('employees', 'public');
        }

        PersonalInformation::create([
            'firstNmae'          => $request->firstNmae,
            'lastName'           => $request->lastName,
            'national_number'    => $request->national_number,
            'father'             => $request->father,
            'mother'             => $request->mother,
            'email'              => $request->email,
            'phone'              => $request->phone,
            'birthday'           => $request->birthday,
            'address'            => $request->address,
            'salary'             => $request->salary,
            'role_id'            => $request->role_id,
            'department_id'      => $request->department_id,
            'employee_status_id' => 1,
            'upload_file'        => $imagePath,
        ]);

        return redirect()->route('hr.employees.index')
            ->with('success', 'تم إضافة الموظف');
    }

    public function show($id)
    {
        $employee = PersonalInformation::with(['department', 'role', 'employeeStatus'])
            ->findOrFail($id);

        return view('block1.employees.show', compact('employee'));
    }

    public function edit($id)
    {
        $employee    = PersonalInformation::findOrFail($id);
        $departments = Department::all();
        $roles       = Role::all();
        $statuses    = EmployeeStatus::all();

        return view('block1.employees.edit', compact(
            'employee',
            'departments',
            'roles',
            'statuses'
        ));
    }

    public function update(Request $request, $id)
    {
        $employee = PersonalInformation::findOrFail($id);

        if (session('role_id') == 1) {
            $employee->update([
                'employee_status_id' => $request->employee_status_id
            ]);
            return redirect()->route('hr.employees.index')
                ->with('success', 'تم تغيير حالة الموظف');
        }

        $request->validate([
            'firstNmae' => 'required|string|max:100',
            'lastName'  => 'required|string|max:100',
            'mother'    => 'required|string|max:100',
            'father'    => 'required|string|max:100',
            'address'   => 'required|string|max:255',
            'phone'     => 'required|digits:10',
            'salary'    => 'required|numeric|min:0',
        ]);

        $employee->update([
            'firstNmae'     => $request->firstNmae,
            'lastName'      => $request->lastName,
            'father'        => $request->father,
            'mother'        => $request->mother,
            'address'       => $request->address,
            'phone'         => $request->phone,
            'salary'        => $request->salary,
            'department_id' => $request->department_id,
            'role_id'       => $request->role_id,
        ]);

        return redirect()->route('hr.employees.index')
            ->with('success', 'تم تعديل الموظف');
    }

    public function changeStatus(Request $request, $id)
    {
        $employee = PersonalInformation::findOrFail($id);

        $employee->update([
            'employee_status_id' => $request->employee_status_id
        ]);

        return redirect()->route('hr.employees.index')
            ->with('success', 'تم تغيير حالة الموظف بنجاح');
    }

    public function destroy($id)
    {
        $employee = PersonalInformation::findOrFail($id);

        if ($employee->department_id != null) {
            return back()->with('error', 'لا يمكن حذف موظف مرتبط بقسم');
        }

        $employee->delete();

        return back()->with('success', 'تم حذف الموظف');
    }
}