@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        {{-- رأس الصفحة --}}
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-store me-2"></i>تفاصيل المتجر: {{ $store->store_name }}</h5>
            <a href="{{ route('block3.stores.index') }}" class="btn btn-sm btn-light">
                <i class="fas fa-arrow-right me-1"></i> عودة للقائمة
            </a>
        </div>

        <div class="card-body p-4">
            <div class="row">
                {{-- القسم الأول: معلومات المتجر الأساسية --}}
                <div class="col-md-6">
                    <h6 class="text-primary border-bottom pb-2 mb-3"><i class="fas fa-info-circle me-1"></i> البيانات الأساسية</h6>
                    <table class="table table-bordered align-middle">
                        <tr>
                            <th class="bg-light w-25">رقم المتجر</th>
                            <td class="fw-bold">#{{ $store->store_id }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">اسم المتجر</th>
                            <td>{{ $store->store_name }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">المدينة</th>
                            <td>
                                <span class="badge bg-info text-dark">{{ $store->city }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">العنوان</th>
                            <td>{{ $store->address ?? 'غير محدد' }}</td>
                        </tr>
                    </table>
                </div>

                {{-- القسم الثاني: التواصل والمسؤولين --}}
                <div class="col-md-6">
                    <h6 class="text-primary border-bottom pb-2 mb-3"><i class="fas fa-user-tie me-1"></i> الإدارة والتواصل</h6>
                    <table class="table table-bordered align-middle">
                        <tr>
                            <th class="bg-light w-25">الهاتف</th>
                            <td>{{ $store->phone ?? 'لا يوجد هاتف' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">المدير المسؤول</th>
                            <td class="fw-bold text-success">
                                <i class="fas fa-user-shield me-1"></i>
                                {{ $store->manager ? $store->manager->firstName . ' ' . $store->manager->lastName : 'غير محدد' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">البروشور</th>
                            <td>
                                @if($store->upload_file)
                                    <a href="{{ asset('storage/' . $store->upload_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-file-download"></i> عرض ملف المتجر
                                    </a>
                                @else
                                    <span class="text-muted small">لا يوجد ملف مرفق</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- القسم الثالث: جدول الموظفين (الإضافة الجديدة والاحترافية) --}}
            <div class="row mt-4">
                <div class="col-12">
                    <h6 class="text-primary border-bottom pb-2 mb-3"><i class="fas fa-users me-1"></i> كادر موظفي المتجر</h6>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm border text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم الكامل</th>
                                    <th>رقم الهاتف</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($store->employees as $employee)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold">{{ $employee->firstName }} {{ $employee->lastName }}</td>
                                        <td>{{ $employee->phone ?? '---' }}</td>
                                        <td><span class="badge bg-success opacity-75">موظف نشط</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 text-muted italic">
                                            <i class="fas fa-user-slash d-block mb-2 fa-2x opacity-25"></i>
                                            لا يوجد موظفون مربوطون بهذا المتجر حالياً.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
    <div class="col-12">
        <h6 class="text-success border-bottom pb-2 mb-3"><i class="fas fa-boxes me-1"></i> المنتجات المعروضة في هذا الفرع</h6>
        <div class="row">
            @forelse($store->products as $product)
                <div class="col-md-4 mb-3">
                    <div class="card border-info h-100 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title fw-bold text-dark">{{ $product->product_name }}</h6>
                            <p class="card-text text-muted small">{{ Str::limit($product->description, 50) }}</p>
                            <span class="badge bg-primary">السعر: {{ $product->price }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-3 text-muted">
                    لا توجد منتجات معروضة في هذا المتجر حالياً.
                </div>
            @endforelse
        </div>
    </div>
</div>
            {{-- أزرار التحكم السفلى --}}
            <div class="mt-4 pt-3 border-top d-flex gap-2">
                <a href="{{ route('block3.stores.edit', $store->store_id) }}" class="btn btn-primary px-4 shadow-sm">
                    <i class="fas fa-edit me-1"></i> تعديل بيانات المتجر
                </a>
                <a href="{{ route('block3.stores.index') }}" class="btn btn-outline-secondary px-4">
                    إلغاء
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .table th { font-size: 0.9rem; }
    .card { border-radius: 12px; overflow: hidden; }
    .badge { font-weight: 500; }
</style>
@endsection
