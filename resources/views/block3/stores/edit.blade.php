@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>تعديل بيانات المتجر: {{ $store->store_name }}
                    </h5>
                    <a href="{{ route('block3.stores.index') }}" class="btn btn-sm btn-light">عودة للقائمة</a>
                </div>

                <div class="card-body p-4">
                    {{-- عرض أخطاء التحقق من البيانات --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- استخدام store_id كما في قاعدة البيانات --}}
                    <form action="{{ route('block3.stores.update', $store->store_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">اسم المتجر</label>
                            <input type="text" name="store_name" class="form-control" value="{{ old('store_name', $store->store_name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">المدينة</label>
                            <input type="text" name="city" class="form-control" value="{{ old('city', $store->city) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">العنوان التفصيلي</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $store->address) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">رقم الهاتف</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $store->phone) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">ملف البروشور (اختياري)</label>
                            <input type="file" name="brochure" class="form-control">
                            @if($store->upload_file)
                                <small class="text-muted">الملف الحالي: {{ $store->upload_file }}</small>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">المنتجات المتوفرة في هذا الفرع</label>
                            <select name="products[]" class="form-select" multiple size="5">
                                @foreach($all_products as $product)
                                    <option value="{{ $product->product_id }}"
                                        {{ $store->products->contains('product_id', $product->product_id) ? 'selected' : '' }}>
                                        {{ $product->product_name }} - ({{ $product->price }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>حفظ التغييرات
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
