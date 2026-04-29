<?php

namespace App\Http\Controllers\Block2;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\PersonalInformation;
use App\Models\User;

class CustomerController extends Controller
{

    public function login(): View
    {
        return view('auth.login');
    }

    public function dashboard(): View
    {
        $customers = PersonalInformation::all();
        return view('marketing.dashboard', compact('customers'));
    }

    public function create(): View
    {
        return view('customers.create');
    }

    public function index(Request $request)
    {
        $query = PersonalInformation::query();

        if ($request->search_name) {
            $query->where('firstNmae', 'like', '%' . $request->search_name . '%')
                  ->orWhere('lastName', 'like', '%' . $request->search_name . '%');
        }
        if ($request->search_email) {
            $query->where('email', 'like', '%' . $request->search_email . '%');
        }
        if ($request->search_type) {
            $typeId = $request->search_type == 'vip' ? 2 : 1;
            $query->where('customer_type_id', $typeId);
        }
        if ($request->search_status) {
            $statusId = $request->search_status == 'active' ? 1 : 2;
            $query->where('customer_status_id', $statusId);
        }

        $customers = $query->get();
        return view('customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        try {
            $uploadPath = null;
            if ($request->hasFile('upload_file')) {
                $uploadPath = $request->file('upload_file')->store('customers', 'public');
            }

            $customer = PersonalInformation::create([
                'firstNmae'          => $request->firstNmae,
                'lastName'           => $request->lastName,
                'father'             => $request->father ?? null,
                'email'              => $request->email,
                'phone'              => $request->phone,
                'national_number'    => $request->national_number,
                'birthday'           => $request->birthday ?? null,
                'upload_file'        => $uploadPath,
                'customer_type_id'   => $request->customer_type_id,
                'customer_status_id' => $request->customer_status_id,
                'address'            => $request->address ?? null,
            ]);

            return redirect()->route('marketing.customers.index')->with('success', 'تم إضافة الزبون بنجاح');

        } catch (\Exception $e) {
            return back()->with('error', 'خطأ: ' . $e->getMessage());
        }
    }

  public function show($id)
{
    $customer = PersonalInformation::findOrFail($id);
    $offers = \App\Models\Offer::all(); // جلب كل العروض
    return view('customers.show', compact('customer', 'offers'));
}
    public function status(): string
    {
        return "Change Customer Status Page";
    }

   public function edit($id)
{
    $customer = PersonalInformation::findOrFail($id);

    $marketingEmployees = \App\Models\PersonalInformation::whereNotNull('role_id')
        ->whereHas('role', fn($q) => $q->where('type', 'like', '%market%'))
        ->whereNotNull('firstNmae')
        ->get();

    return view('customers.edit', compact('customer', 'marketingEmployees'));
}

    public function update(Request $request, $id)
    {
        $customer = PersonalInformation::findOrFail($id);

        $request->validate([
            'firstNmae'          => 'required|string|max:255',
            'lastName'           => 'required|string|max:255',
            'phone'              => 'required|string|max:20',
            'customer_type_id'   => 'required|exists:CUSTOMER_TYPE,customer_type_id',
            'customer_status_id' => 'required|exists:CUSTOMER_STATUS,customer_status_id',
            'email' => [
                'required',
                'email',
                Rule::unique('PERSONAL_INFORMATION', 'email')->ignore($id, 'personal_id'),
            ],
            'national_number' => [
                'required',
                'numeric',
                Rule::unique('PERSONAL_INFORMATION', 'national_number')->ignore($id, 'personal_id'),
            ],
        ]);

        $uploadPath = $customer->upload_file; // احتفظ بالصورة القديمة
        if ($request->hasFile('upload_file')) {
            $uploadPath = $request->file('upload_file')->store('customers', 'public');
        }

        $customer->update([
            'firstNmae'          => $request->firstNmae,
            'lastName'           => $request->lastName,
            'father'             => $request->father ?? null,
            'email'              => $request->email,
            'phone'              => $request->phone,
            'national_number'    => $request->national_number,
            'birthday'           => $request->birthday ?? null,
            'upload_file'        => $uploadPath,
            'customer_type_id'   => $request->customer_type_id,
            'customer_status_id' => $request->customer_status_id,
            'address'            => $request->address ?? null,
            'assigned_to'        => $request->assigned_to ?? null,
        ]);

        return redirect()->route('marketing.customers.index')->with('success', 'تم تعديل الزبون بنجاح');
    }

    public function search(Request $request)
    {
        $query = PersonalInformation::query();

        if ($request->filled('search_name')) {
            $query->where('firstNmae', 'like', '%' . $request->search_name . '%')
                  ->orWhere('lastName', 'like', '%' . $request->search_name . '%');
        }
        if ($request->filled('search_email')) {
            $query->where('email', 'like', '%' . $request->search_email . '%');
        }
        if ($request->filled('search_type')) {
            $typeId = $request->search_type == 'vip' ? 2 : 1;
            $query->where('customer_type_id', $typeId);
        }
        if ($request->filled('search_status')) {
            $statusId = $request->search_status == 'active' ? 1 : 2;
            $query->where('customer_status_id', $statusId);
        }

        $customers = $query->get();
        return view('marketing.search', compact('customers'));
    }

    public function destroy($id)
    {
        $customer = PersonalInformation::findOrFail($id);

        if ($customer->assigned_to != null) {
            return redirect()->route('marketing.customers.index')
                ->with('error', 'لا يمكن حذف الزبون لأنه مرتبط بموظف تسويق.');
        }

        $customer->delete();
        return redirect()->route('marketing.customers.index')->with('success', 'تم حذف الزبون بنجاح');
    }

    public function managerDashboard()
    {
        $customers = PersonalInformation::all();
        return view('dashboard.manager', compact('customers'));
    }

    public function employeeDashboard()
    {
        $customers = PersonalInformation::all();
        return view('marke', compact('customers'));
    }

    public function changeStatus($id, $statusId)
    {
        $customer = PersonalInformation::findOrFail($id);
        $customer->customer_status_id = $statusId;
        $customer->save();

        return redirect()->route('marketing.customers.index')->with('success', 'تم تغيير حالة الزبون بنجاح');
    }
}