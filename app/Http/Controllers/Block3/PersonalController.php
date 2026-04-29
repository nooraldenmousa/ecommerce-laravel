<?php

namespace App\Http\Controllers\Block3;

use App\Http\Controllers\Controller;
use App\Models\PersonalInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PersonalController extends Controller
{
    // عرض صفحة إضافة شخص جديد
    public function create()
    {
        return view('block3.personal.create');
    }

    // حفظ البيانات في قاعدة البيانات
    public function store(Request $request)
    {
        // التحقق من البيانات (Validation)
        $validatedData = $request->validate([
            'firstNmae' => 'required|string|max:50',
            'lastName'  => 'required|string|max:50',
            'father'  => 'required|string|max:50',
            'mother'  => 'nullable|string|max:50',
            'phone'     => 'nullable|string|max:50',
            'email'     => 'nullable|email|max:50',
            'role_id'   => 'nullable|integer',
            'salary'    => 'nullable|numeric',
            'upload_file' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $data = $request->all();

        // معالجة رفع الملف إذا وجد
        if ($request->hasFile('upload_file')) {
            $data['upload_file'] = $request->file('upload_file')->store('personal_files', 'public');
        }

        // إنشاء السجل في جدول PERSONAL_INFORMATION
        PersonalInformation::create($data);

        // التوجيه لصفحة إضافة المتجر لكي تختار المدير الذي أضفته للتو
        return redirect()->route('block3.stores.create')
                         ->with('success', 'تم إضافة المعلومات الشخصية بنجاح! يمكنك الآن اختيار هذا الشخص كمدير.');
    }
}
