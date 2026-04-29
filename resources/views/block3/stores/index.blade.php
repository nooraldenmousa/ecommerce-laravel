@extends('layouts.app')

@section('content')

<div class="container mt-4">

    {{-- رأس الصفحة --}}
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h2 class="fw-bold text-dark mb-0">إدارة المتاجر | <span class="text-primary">MyStore</span></h2>
            <p class="text-muted small">عرض وإدارة كافة المتاجر المسجلة في النظام</p>
        </div>
        <a href="{{ route('block3.stores.create') }}" class="btn btn-primary px-4 shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> إضافة متجر جديد
        </a>
    </div>

    {{-- التنبيهات --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- فلتر البحث --}}
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('block3.stores.index') }}">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-bold">بحث باسم المتجر</label>
                        <input type="text" name="search" class="form-control"
                               placeholder="اكتب اسم المتجر..."
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">تصفية بالمدينة</label>
                        <select name="city" class="form-select">
                            <option value="">كل المدن</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province }}"
                                    {{ request('city') == $province ? 'selected' : '' }}>
                                    {{ $province }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-dark w-100">
                            <i class="fas fa-search me-1"></i> بحث
                        </button>
                        <a href="{{ route('block3.stores.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-redo me-1"></i> إعادة
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- عدد النتائج --}}
    <div class="mb-2">
        <span class="badge bg-secondary">عدد النتائج: {{ $stores->count() }}</span>
    </div>

    {{-- الجدول --}}
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="py-3">المعرف</th>
                        <th class="py-3">اسم المتجر</th>
                        <th class="py-3">المدينة</th>
                        <th class="py-3">الهاتف</th>
                        <th class="py-3">البروشور</th>
                        <th class="py-3">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stores as $store)
                        <tr>
                            <td class="fw-bold text-secondary">#{{ $store->store_id }}</td>
                            <td class="fw-bold">{{ $store->store_name }}</td>
                            <td>
                                <span class="badge bg-light text-primary border">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $store->city }}
                                </span>
                            </td>
                            <td class="text-muted">{{ $store->phone ?? '—' }}</td>
                            <td>
                                @if($store->upload_file)
                                    <a href="{{ route('block3.stores.download', $store->store_id) }}"
                                       class="btn btn-sm btn-outline-success">
                                        <i class="fas fa-download me-1"></i> تحميل
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('block3.stores.show', $store->store_id) }}"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i> عرض
                                    </a>
                                    <a href="{{ route('block3.stores.edit', $store->store_id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>
                                    @if(session('user.role') == 'manager')
                                        <form action="{{ route('block3.stores.destroy', $store->store_id) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-5 text-muted">
                                <i class="fas fa-box-open d-block mb-2 fa-2x"></i>
                                لا توجد متاجر حالياً
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('input[name="search"]').on('input', function () {
        const search = $(this).val();
        const city = $('select[name="city"]').val();
        $.get('{{ route("block3.stores.index") }}', { search: search, city: city }, function (html) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTbody = doc.querySelector('tbody');
            const newCount = doc.querySelector('.badge.bg-secondary');
            if (newTbody) $('tbody').html(newTbody.innerHTML);
            if (newCount) $('.badge.bg-secondary').html(newCount.innerHTML);
        });
    });

    $('select[name="city"]').on('change', function () {
        const search = $('input[name="search"]').val();
        const city = $(this).val();
        $.get('{{ route("block3.stores.index") }}', { search: search, city: city }, function (html) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTbody = doc.querySelector('tbody');
            const newCount = doc.querySelector('.badge.bg-secondary');
            if (newTbody) $('tbody').html(newTbody.innerHTML);
            if (newCount) $('.badge.bg-secondary').html(newCount.innerHTML);
        });
    });
});
</script>
@endpush