@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- عرض الأخطاء إن وجدت --}}
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm border-0 mb-4">
            <h6 class="fw-bold"><i class="fas fa-exclamation-circle me-2"></i> خطأ في إدخال البيانات:</h6>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white py-3">
            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> إضافة متجر جديد</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('block3.stores.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">اسم المتجر <span class="text-danger">*</span></label>
                        <input type="text" name="store_name" class="form-control" value="{{ old('store_name') }}" placeholder="أدخل اسم المتجر" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">المحافظة <span class="text-danger">*</span></label>
                        <select name="city" class="form-select" required>
                            <option value="" disabled selected>اختر المحافظة...</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province }}" {{ old('city') == $province ? 'selected' : '' }}>{{ $province }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">العنوان التفصيلي</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="مثال: جانب حديقة الجاحظ">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="أدخل رقم التواصل">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">إرفاق بروشور أو ملف المتجر</label>
                        <input type="file" name="brochure" class="form-control" accept=".pdf,.jpg,.png">
                        <small class="text-muted">الأنواع المسموحة: PDF, JPG, PNG (بحد أقصى 5MB)</small>
                    </div>
                </div>

                <div class="mt-5 text-end">
                    <a href="{{ route('block3.stores.index') }}" class="btn btn-light border px-4 me-2">إلغاء</a>
                    <button type="submit" class="btn btn-success px-4 shadow-sm">
                        <i class="fas fa-save me-1"></i> حفظ بيانات المتجر
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
