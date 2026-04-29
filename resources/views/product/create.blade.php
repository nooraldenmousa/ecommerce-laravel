@extends('layouts.app')
@section('title', 'إضافة منتج')
@section('page-title', 'إضافة منتج جديد')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('product.dashboard') }}">لوحة التحكم</a></li>
        <li class="breadcrumb-item"><a href="{{ route('product.index') }}">المنتجات</a></li>
        <li class="breadcrumb-item active">إضافة جديد</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus-circle me-2 text-success"></i>إضافة منتج جديد
            </div>
            <div class="card-body p-4">
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">اسم المنتج <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-box text-success"></i></span>
                                <input type="text" name="product_name"
                                       class="form-control @error('product_name') is-invalid @enderror"
                                       placeholder="أدخل اسم المنتج"
                                       value="{{ old('product_name') }}">
                            </div>
                            @error('product_name')<div class="text-danger mt-1" style="font-size:0.82rem;">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">السعر <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-dollar-sign text-success"></i></span>
                                <input type="number" name="price" step="0.01" min="0"
                                       class="form-control @error('price') is-invalid @enderror"
                                       placeholder="0.00"
                                       value="{{ old('price') }}">
                            </div>
                            @error('price')<div class="text-danger mt-1" style="font-size:0.82rem;">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">الوصف</label>
                            <textarea name="description" rows="3"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="أدخل وصف المنتج...">{{ old('description') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">صورة المنتج</label>
                            <input type="file" name="upload_file"
                                   class="form-control @error('upload_file') is-invalid @enderror"
                                   accept=".jpg,.jpeg,.png"
                                   onchange="previewImage(this)">
                            <small class="text-muted"><i class="fas fa-info-circle me-1"></i>الصيغ المقبولة: JPG, PNG (حجم أقصى 5MB)</small>
                            @error('upload_file')<div class="text-danger mt-1" style="font-size:0.82rem;">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 d-flex align-items-center">
                            <div id="imagePreview" class="d-none">
                                <img id="previewImg" src="" alt="preview"
                                     style="width:100px;height:100px;object-fit:cover;border-radius:10px;border:2px solid #40916c;">
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex gap-3 justify-content-end">
                        <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>إلغاء
                        </a>
                        <button type="reset" class="btn btn-outline-warning" onclick="$('#imagePreview').addClass('d-none')">
                            <i class="fas fa-redo me-2"></i>مسح
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>حفظ المنتج
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#previewImg').attr('src', e.target.result);
            $('#imagePreview').removeClass('d-none');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
