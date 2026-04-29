<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HRController;
use App\Http\Controllers\Block1\EmployeeController;
use App\Http\Controllers\Block1\DepartmentController;
use App\Http\Controllers\Block2\CustomerController;
use App\Http\Controllers\Block2\OfferController;
use App\Http\Controllers\Block2\MarketingController;
use App\Http\Controllers\Block3\StoreController;
use App\Http\Controllers\Block3\PersonalController;
use App\Http\Controllers\Block3\StoreDashboardController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WarehouseStoreController;
use App\Http\Controllers\WarehouseProductController;
use App\Http\Controllers\Block5\ProductController;
use App\Http\Controllers\Block5\ProductStoreController;
use App\Http\Controllers\Block5\ProductWarehouseController;
use App\Http\Controllers\Block5\ProductDashboardController;

// ===========================================================
//  🔐 AUTH - صفحة الدخول الموحدة
// ===========================================================
Route::get('/', [LoginController::class, 'showLogin'])->name('login');
Route::get('/login', [LoginController::class, 'showLogin'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout.get');

// ===========================================================
//  🏢 BLOCK 1 — الموارد البشرية
// ===========================================================
Route::prefix('hr')->name('hr.')->group(function () {
    Route::get('/dashboard', [HRController::class, 'dashboard'])->name('dashboard');
    Route::get('/employees/search', [EmployeeController::class, 'search'])->name('employees.search');
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::post('/employees/{id}/status', [EmployeeController::class, 'changeStatus'])->name('employees.changeStatus');
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/departments/{id}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
    Route::get('/departments/{id}/employees', [DepartmentController::class, 'showEmployees'])->name('departments.employees');
    Route::post('/departments/{id}/assign', [DepartmentController::class, 'assignEmployee'])->name('departments.assign');
    Route::post('/departments/{id}/remove', [DepartmentController::class, 'removeEmployee'])->name('departments.remove');
    Route::post('/departments/{id}/change-role', [DepartmentController::class, 'changeRole'])->name('departments.changeRole');
});

// للتوافق مع الروابط القديمة HR
Route::prefix('block1')->name('block1.')->group(function () {
    Route::get('/employees/search', [EmployeeController::class, 'search'])->name('employees.search');
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::post('/employees/{id}/status', [EmployeeController::class, 'changeStatus'])->name('employees.changeStatus');
    Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/departments/{id}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
    Route::get('/departments/{id}/employees', [DepartmentController::class, 'showEmployees'])->name('departments.employees');
    Route::post('/departments/{id}/assign', [DepartmentController::class, 'assignEmployee'])->name('departments.assign');
    Route::post('/departments/{id}/remove', [DepartmentController::class, 'removeEmployee'])->name('departments.remove');
    Route::post('/departments/{id}/change-role', [DepartmentController::class, 'changeRole'])->name('departments.changeRole');
});

// ===========================================================
//  🛒 BLOCK 2 — التسويق والزبائن
// ===========================================================
Route::prefix('marketing')->name('marketing.')->group(function () {
    Route::get('/dashboard', [MarketingController::class, 'dashboard'])->name('dashboard');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/customers/{id}/change-status/{statusId}', [CustomerController::class, 'changeStatus'])->name('customers.changeStatus');
    Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');
    Route::get('/offers/create', [OfferController::class, 'create'])->name('offers.create');
    Route::post('/offers', [OfferController::class, 'store'])->name('offers.store');
    Route::get('/offers/{id}', [OfferController::class, 'show'])->name('offers.show');
    Route::get('/offers/{id}/edit', [OfferController::class, 'edit'])->name('offers.edit');
    Route::put('/offers/{id}', [OfferController::class, 'update'])->name('offers.update');
    Route::delete('/offers/{id}', [OfferController::class, 'destroy'])->name('offers.destroy');
    Route::get('/offers/{id}/assign', [OfferController::class, 'assignForm'])->name('offers.assign');
    Route::post('/offers/{id}/assign', [OfferController::class, 'assignStore'])->name('offers.assign.store');
});

// للتوافق مع روابط القديمة
Route::resource('customers', CustomerController::class);
Route::get('/customers/{id}/change-status/{statusId}', [CustomerController::class, 'changeStatus'])->name('customers.changeStatus');
Route::resource('offers', OfferController::class);
Route::get('/offers/{id}/assign', [OfferController::class, 'assignForm'])->name('offers.assign');
Route::post('/offers/{id}/assign', [OfferController::class, 'assignStore'])->name('offers.assign.store');
Route::get('/dashboard', [MarketingController::class, 'dashboard'])->name('dashboard');

// ===========================================================
//  🏪 BLOCK 3 — إدارة فروع المتجر
// ===========================================================
Route::prefix('block3')->name('block3.')->group(function () {
    Route::get('/dashboard', [StoreDashboardController::class, 'dashboard'])->name('dashboard');

    Route::prefix('stores')->name('stores.')->group(function () {
        Route::get('/', [StoreController::class, 'index'])->name('index');
        Route::get('/create', [StoreController::class, 'create'])->name('create');
        Route::post('/', [StoreController::class, 'store'])->name('store');
        Route::get('/download/{id}', [StoreController::class, 'download'])->name('download');
        Route::get('/{id}', [StoreController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [StoreController::class, 'edit'])->name('edit');
        Route::put('/{id}', [StoreController::class, 'update'])->name('update');
        Route::delete('/{id}', [StoreController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('personal')->name('personal.')->group(function () {
        Route::get('/create', [PersonalController::class, 'create'])->name('create');
        Route::post('/', [PersonalController::class, 'store'])->name('store');
    });

    Route::prefix('transfer')->name('transfer.')->group(function () {
        Route::get('/', [StoreController::class, 'transferForm'])->name('form');
        Route::post('/', [StoreController::class, 'transferProduct'])->name('product');
    });
});

// ===========================================================
//  🏭 BLOCK 4 — المستودعات
// ===========================================================
Route::prefix('warehouse')->name('warehouse.')->group(function () {
    Route::get('/dashboard', [WarehouseController::class, 'dashboard'])->name('dashboard');
    Route::get('/', [WarehouseController::class, 'index'])->name('index');
    Route::get('/create', [WarehouseController::class, 'create'])->name('create');
    Route::post('/', [WarehouseController::class, 'store'])->name('store');
    Route::get('/search', [WarehouseController::class, 'search'])->name('search');
    Route::get('/{id}', [WarehouseController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [WarehouseController::class, 'edit'])->name('edit');
    Route::put('/{id}', [WarehouseController::class, 'update'])->name('update');
    Route::delete('/{id}', [WarehouseController::class, 'destroy'])->name('destroy');
    Route::get('/{id}/stores', [WarehouseStoreController::class, 'index'])->name('stores');
    Route::post('/{id}/stores', [WarehouseStoreController::class, 'attach'])->name('stores.attach');
    Route::delete('/{id}/stores/{store_id}', [WarehouseStoreController::class, 'detach'])->name('stores.detach');
    Route::get('/{id}/products', [WarehouseProductController::class, 'index'])->name('products');
    Route::post('/{id}/products', [WarehouseProductController::class, 'attach'])->name('products.attach');
    Route::delete('/{id}/products/{product_id}', [WarehouseProductController::class, 'detach'])->name('products.detach');
});

// ===========================================================
//  📦 BLOCK 5 — المنتجات
// ===========================================================
Route::prefix('product')->name('product.')->group(function () {
    Route::get('/dashboard', [ProductDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('/{id}', [ProductController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    Route::get('/{id}/warehouses', [ProductWarehouseController::class, 'index'])->name('warehouses');
    Route::post('/{id}/warehouses', [ProductWarehouseController::class, 'attach'])->name('warehouses.attach');
    Route::delete('/{id}/warehouses/{warehouse_id}', [ProductWarehouseController::class, 'detach'])->name('warehouses.detach');
    Route::get('/{id}/stores', [ProductStoreController::class, 'index'])->name('stores');
    Route::post('/{id}/stores', [ProductStoreController::class, 'attach'])->name('stores.attach');
    Route::delete('/{id}/stores/{store_id}', [ProductStoreController::class, 'detach'])->name('stores.detach');
});

// ===========================================================
//  🌐 API
// ===========================================================
Route::prefix('api/warehouse')->group(function () {
    Route::get('/search', [App\Http\Controllers\Api\WarehouseApiController::class, 'search']);
    Route::get('/', [App\Http\Controllers\Api\WarehouseApiController::class, 'index']);
    Route::post('/', [App\Http\Controllers\Api\WarehouseApiController::class, 'store']);
    Route::put('/{id}', [App\Http\Controllers\Api\WarehouseApiController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Api\WarehouseApiController::class, 'destroy']);
});

Route::prefix('api/product')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\ProductApiController::class, 'index']);
    Route::post('/', [App\Http\Controllers\Api\ProductApiController::class, 'store']);
    Route::put('/{id}', [App\Http\Controllers\Api\ProductApiController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\Api\ProductApiController::class, 'destroy']);
    Route::get('/search', [App\Http\Controllers\Block5\ProductController::class, 'search']);
});

Route::prefix('api/block3')->name('api.block3.')->group(function () {
    Route::get('/stores', [StoreController::class, 'apiIndex'])->name('stores.index');
    Route::post('/stores', [StoreController::class, 'apiStore'])->name('stores.store');
    Route::put('/stores/{id}', [StoreController::class, 'apiUpdate'])->name('stores.update');
    Route::delete('/stores/{id}', [StoreController::class, 'apiDestroy'])->name('stores.destroy');
    Route::get('/stores/search', [StoreController::class, 'apiSearch'])->name('stores.search');
});