@extends('layouts.app')

@section('title', 'إضافة مستودع')
@section('page-title', 'إضافة مستودع جديد')

@section('content')

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('warehouse.dashboard') }}">لوحة التحكم</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('warehouse.index') }}">المستودعات</a>
        </li>
        <li class="breadcrumb-item active">إضافة جديد</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus-circle me-2 text-primary"></i>
                إضافة مستودع جديد
            </div>
            <div class="card-body p-4">

                <form action="{{ route('warehouse.store') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">

                        <!-- اسم المستودع -->
                        <div class="col-md-6">
                            <label class="form-label">
                                اسم المستودع <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-warehouse text-primary"></i>
                                </span>
                                <input type="text" name="warehouse_name"
                                       class="form-control @error('warehouse_name') is-invalid @enderror"
                                       placeholder="أدخل اسم المستودع"
                                       value="{{ old('warehouse_name') }}">
                            </div>
                            @error('warehouse_name')
                                <div class="text-danger mt-1" style="font-size:0.82rem;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- المدينة -->
                        <div class="col-md-6">
                            <label class="form-label">
                                المدينة <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-map-marker-alt text-danger"></i>
                                </span>
                                <input type="text" name="city"
                                       class="form-control @error('city') is-invalid @enderror"
                                       placeholder="أدخل المدينة"
                                       value="{{ old('city') }}">
                            </div>
                            @error('city')
                                <div class="text-danger mt-1" style="font-size:0.82rem;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- العنوان -->
                        <div class="col-md-6">
                            <label class="form-label">
                                العنوان <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-map-pin text-warning"></i>
                                </span>
                                <input type="text" name="address"
                                       class="form-control @error('address') is-invalid @enderror"
                                       placeholder="أدخل العنوان التفصيلي"
                                       value="{{ old('address') }}">
                            </div>
                            @error('address')
                                <div class="text-danger mt-1" style="font-size:0.82rem;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- الهاتف -->
                        <div class="col-md-6">
                            <label class="form-label">
                                رقم الهاتف <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-phone text-success"></i>
                                </span>
                                <input type="text" name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="أدخل رقم الهاتف"
                                       value="{{ old('phone') }}">
                            </div>
                            @error('phone')
                                <div class="text-danger mt-1" style="font-size:0.82rem;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- المدير -->
                        <div class="col-md-6">
                            <label class="form-label">المدير المسؤول</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user-tie text-info"></i>
                                </span>
                                <select name="manager_id"
                                        class="form-select @error('manager_id') is-invalid @enderror">
                                    <option value="">— اختر المدير —</option>
                                    @foreach($managers as $manager)
                                        <option value="{{ $manager->personal_id }}"
                                            {{ old('manager_id') == $manager->personal_id ? 'selected' : '' }}>
                                            {{ $manager->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- ملف البروشور -->
                        <div class="col-md-6">
                            <label class="form-label">ملف البروشور</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-file-upload text-secondary"></i>
                                </span>
                                <input type="file" name="upload_file"
                                       class="form-control @error('upload_file') is-invalid @enderror"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       onchange="previewFile(this)">
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                الصيغ المقبولة: PDF, JPG, PNG (حجم أقصى 5MB)
                            </small>
                            @error('upload_file')
                                <div class="text-danger mt-1" style="font-size:0.82rem;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                            <!-- Preview -->
                            <div id="filePreview" class="mt-2 d-none">
                                <span class="badge bg-success">
                                    <i class="fas fa-check me-1"></i>
                                    <span id="fileName"></span>
                                </span>
                            </div>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <hr class="my-4">
                    <div class="d-flex gap-3 justify-content-end">
                        <a href="{{ route('warehouse.index') }}"
                           class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>إلغاء
                        </a>
                        <button type="reset" class="btn btn-outline-warning">
                            <i class="fas fa-redo me-2"></i>مسح
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>حفظ المستودع
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
    function previewFile(input) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            $('#fileName').text(fileName);
            $('#filePreview').removeClass('d-none');
        }
    }
</script>
@endsection