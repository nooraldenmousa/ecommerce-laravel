<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin()
    {
        if (session()->has('user')) {
            return $this->redirectByRole(session('user.block'));
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'اسم المستخدم مطلوب',
            'password.required' => 'كلمة المرور مطلوبة',
        ]);

        $user = DB::selectOne("
            SELECT
                U.user_id, U.username, U.password, U.account_status,
                P.personal_id, P.firstNmae, P.lastName,
                P.role_id, P.department_id, P.warehouse_id, P.stores_id,
                R.type as role_type
            FROM [USER] U
            LEFT JOIN PERSONAL_INFORMATION P ON P.user_id = U.user_id
            LEFT JOIN ROLE R ON R.role_id = P.role_id
            WHERE U.username = ?
        ", [$request->username]);

        if (!$user) {
            return back()->withErrors(['username' => 'اسم المستخدم غير صحيح'])->withInput();
        }

        if ($user->account_status === 'inactive') {
            return back()->withErrors(['username' => 'حسابك غير فعال، تواصل مع الإدارة'])->withInput();
        }

        // التحقق من كلمة المرور (مشفرة أو نص عادي)
        $passwordMatch = false;
        try {
            if (Hash::check($request->password, $user->password)) {
                $passwordMatch = true;
            }
        } catch (\Exception $e) {
            // باسورد غير مشفر
        }
        if (!$passwordMatch && $request->password === $user->password) {
            $passwordMatch = true;
        }

        if (!$passwordMatch) {
            return back()->withErrors(['password' => 'كلمة المرور غير صحيحة'])->withInput();
        }

        $block    = $this->getBlockByRole($user->role_id, $user->role_type);
        $roleType = strtolower($user->role_type ?? '');
        $isManager = str_contains($roleType, 'manager') ||
                     str_contains($roleType, 'مدير') ||
                     str_contains($roleType, 'admin') ||
                     $user->role_id % 2 === 1;

        session([
            'user' => [
                'id'           => $user->user_id,
                'username'     => $user->username,
                'name'         => trim(($user->firstNmae ?? '') . ' ' . ($user->lastName ?? '')),
                'role'         => $isManager ? 'manager' : 'employee',
                'role_id'      => $user->role_id,
                'role_type'    => $user->role_type,
                'person_id'    => $user->personal_id,
                'block'        => $block,
                'department_id'=> $user->department_id,
                'warehouse_id' => $user->warehouse_id,
                'stores_id'    => $user->stores_id,
            ]
        ]);

        // للتوافق مع HR
        if ($block === 'hr') {
            session([
                'user_id'   => $user->user_id,
                'username'  => $user->username,
                'role_id'   => $user->role_id,
                'person_id' => $user->personal_id,
            ]);
        }

        return $this->redirectByRole($block);
    }

 private function getBlockByRole($roleId, $roleType)
{
    $roleType = strtolower($roleType ?? '');

    if (str_contains($roleType, 'product') || str_contains($roleType, 'منتج'))
        return 'product';

    if (str_contains($roleType, 'hr') || str_contains($roleType, 'موارد'))
        return 'hr';

    if (str_contains($roleType, 'market') || str_contains($roleType, 'تسويق'))
        return 'marketing';

    if (str_contains($roleType, 'store') || str_contains($roleType, 'متجر'))
        return 'store';

    if (str_contains($roleType, 'warehouse') || str_contains($roleType, 'مستودع'))
        return 'warehouse';

    return 'warehouse';
}

    private function redirectByRole($block)
    {
        return match($block) {
            'hr'        => redirect()->route('hr.dashboard'),
            'marketing' => redirect()->route('marketing.dashboard'),
            'store'     => redirect()->route('block3.dashboard'),
            'warehouse' => redirect()->route('warehouse.dashboard'),
            'product'   => redirect()->route('product.dashboard'),
            default     => redirect()->route('warehouse.dashboard'),
        };
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
