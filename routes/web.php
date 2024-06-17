<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();




//Admin Routes

Route::group(['middleware' => ['auth']], function () {
    //Miscelleneous Routes
    Route::get('/unauthorised', '\App\Http\Controllers\HomeController@unauthorised')->name('page.unauthorised');

    //Login and Logout Routes

    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //SuperAdmin  Routes
    // Route::group(['middleware' => ['admin']], function () {

        //Roles
        //Create Roles
        Route::get('admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('admin.roles');
        Route::post('admin/store/role', [App\Http\Controllers\RoleController::class, 'store'])->name('admin.store.role');
        //User
        //Create User
        Route::get('admin/users', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.users');
        Route::post('admin/store/user', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.store.user');
        //Update User
        Route::post('admin/update/user/{id}', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.update.user');
        //Delete User
        Route::get('admin/user/delete/{id}', [App\Http\Controllers\AdminController::class, 'delete'])->name('admin.users.delete');

        //Permission
        //Create Permission
        Route::get('admin/permissions', [App\Http\Controllers\PermissionController::class, 'index'])->name('admin.permissions');
        Route::post('admin/store/permission', [App\Http\Controllers\PermissionController::class, 'store'])->name('admin.store.permission');

        //Grant Permission
        Route::get('admin/rolePermission', [App\Http\Controllers\AdminController::class, 'rolePermissionIndex'])->name('admin.role.permission');
        Route::post('admin/update/rolePermission', [App\Http\Controllers\AdminController::class, 'assignPermissionRole'])->name('admin.update.role.permissions');
        //Category
        Route::get('admin/category', [App\Http\Controllers\ProductController::class, 'categoryIndex'])->name('admin.categories');
        Route::post('admin/store/category', [App\Http\Controllers\ProductController::class, 'categoryStore'])->name('admin.categories.store');

        //Product
        Route::get('admin/product', [App\Http\Controllers\ProductController::class, 'productIndex'])->name('admin.products');
        Route::post('admin/store/product', [App\Http\Controllers\ProductController::class, 'productStore'])->name('admin.product.store');
        Route::post('admin/update/product/{id}', [App\Http\Controllers\ProductController::class, 'productUpdate'])->name('admin.product.update');
        Route::get('admin/delete/product/{id}', [App\Http\Controllers\ProductController::class, 'delete'])->name('admin.product.delete');

        //Ledger
        Route::get('admin/baseLedger', [App\Http\Controllers\LedgerController::class, 'index'])->name('admin.ledgers');
        Route::post('admin/update/ledger/{id}', [App\Http\Controllers\LedgerController::class, 'update'])->name('admin.ledgers.update');

        //Expense
        Route::get('admin/expense', [App\Http\Controllers\ExpenseController::class, 'index'])->name('admin.expense');
        Route::get('admin/expense/create', [App\Http\Controllers\ExpenseController::class, 'create'])->name('admin.expense.create');
        Route::post('admin/expense/store', [App\Http\Controllers\ExpenseController::class, 'store'])->name('admin.expense.store');

        //Customers
        Route::get('admin/customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('admin.customer');
        Route::get('admin/customers/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('admin.customer.create');
        Route::post('admin/customers/store', [App\Http\Controllers\CustomerController::class, 'store'])->name('admin.customer.store');
        Route::post('admin/customers/modalStore', [App\Http\Controllers\CustomerController::class, 'modalStore'])->name('admin.customer.store.modal');
        Route::post('admin/customers/update/{id}', [App\Http\Controllers\CustomerController::class, 'update'])->name('admin.customer.update');

        //sales
        Route::get('admin/sales/create', [App\Http\Controllers\SalesController::class, 'create'])->name('admin.sales.create');
        Route::get('admin/sales/getProductDetail', [App\Http\Controllers\SalesController::class, 'getProductDetails'])->name('admin.sales.getdetail');
        Route::get('admin/sales/getcustomerDetail', [App\Http\Controllers\SalesController::class, 'searchCustomer'])->name('admin.sales.getcustomer');

        //Sales Entry

        Route::post('admin/sales/salesEntry', [App\Http\Controllers\SalesController::class, 'store'])->name('admin.sales.store');

        //Report Contorller
        Route::get('admin/sales/salesReport', [App\Http\Controllers\ReportController::class, 'salesReport'])->name('admin.sales.report');
        Route::get('admin/sales/salesReport/markComplete/{receipt_id}', [App\Http\Controllers\ReportController::class, 'markComplete'])->name('admin.sales.report.markcomplete');
        Route::get('admin/sales/salesReport/markSales/{receipt_id}', [App\Http\Controllers\ReportController::class, 'markSales'])->name('admin.sales.report.markSales');

        Route::post('admin/sales/salesReport/payment/{receipt_id}', [App\Http\Controllers\ReportController::class, 'payment'])->name('admin.sales.report.payment');
        Route::get('admin/sales/debtorsList', [App\Http\Controllers\ReportController::class, 'debtorsList'])->name('admin.debtors.report');
        Route::get('admin/sales/creditorsList', [App\Http\Controllers\ReportController::class, 'creditorsList'])->name('admin.creditors.report');
        //Change Delivery Date
        Route::post('admin/sales/changeDeliveryDate{receipt_id}', [App\Http\Controllers\SalesController::class, 'changeDeliverDate'])->name('admin.sales.change.deliveryDate');

        //Expense Ledger Routes
        Route::get('admin/expenseLedger', [App\Http\Controllers\LedgerController::class, 'createExpenseLedger'])->name('admin.expenseLedger.create');
        Route::post('admin/expenseLedger/store', [App\Http\Controllers\LedgerController::class, 'storeExpenseLedger'])->name('admin.expenseLedger.store');

        Route::post('admin/expense/expenseLedger/store', [App\Http\Controllers\ExpenseController::class, 'storeExpenseLedger'])->name('admin.expense.expenseLedger.store');

        //Mark as Delivered
        Route::get('admin/sales/markDelivered/{receipt_id}', [App\Http\Controllers\ReportController::class, 'markDelivered'])->name('admin.sales.delivered');

        //Purchase Routes
        Route::get('admin/purchase/create/', [App\Http\Controllers\PurchaseController::class, 'create'])->name('admin.purchase.create');
        Route::post('admin/purchase/add', [App\Http\Controllers\PurchaseController::class, 'store'])->name('admin.purchase.add');

        //Contra Routes
        Route::get('admin/contra', [App\Http\Controllers\LedgerController::class, 'contra'])->name('admin.contra');
        Route::post('admin/contra/make', [App\Http\Controllers\LedgerController::class, 'makeContra'])->name('admin.contra.make');

        //Add Balance Routes
        Route::get('admin/balance', [App\Http\Controllers\LedgerController::class, 'balance'])->name('admin.balance');
        Route::post('admin/balance/add', [App\Http\Controllers\LedgerController::class, 'addBalance'])->name('admin.balance.add');

        //Profit and Loss
        Route::get('admin/profitLoss', [App\Http\Controllers\ProfitLossController::class, 'profitLoss'])->name('admin.profitloss');
        Route::get('admin/profitLoss/daily', [App\Http\Controllers\ProfitLossController::class, 'profitLossDaily'])->name('admin.profitloss.daily');
        //Print 
        Route::get('admin/print/', [App\Http\Controllers\SalesController::class, 'printView'])->name('admin.printView');

        //Settings

        Route::get('admin/settings/', [App\Http\Controllers\HomeController::class, 'settings'])->name('admin.settings');
        Route::post('admin/settings/update', [App\Http\Controllers\HomeController::class, 'settingsUpdate'])->name('admin.settings.update');
        
    // });
});
