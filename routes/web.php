<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'indexLogin']);
Route::get('/register', [App\Http\Controllers\Auth\LoginController::class, 'register']);
Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'indexLogin']);
Route::post('/login/user', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.user');

Auth::routes();
Route::get('/employee/home', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employee.dashboard');
Route::get('/employee/transactions', [App\Http\Controllers\EmployeeController::class, 'indexTransaction'])->name('employee.transaction');
Route::get('/employee/profile', [App\Http\Controllers\EmployeeController::class, 'indexProfile'])->name('employee.profile');
Route::post('/employee/profile/update', [App\Http\Controllers\EmployeeController::class, 'updateProfile'])->name('employee.profile.update');
Route::put('/employee/profile/update-password', [App\Http\Controllers\EmployeeController::class, 'updatePassword'])->name('employee.profile.update.password');
Route::get('/employee/transaction/create', [App\Http\Controllers\EmployeeController::class, 'createTransaction'])->name('employee.transaction.create');
Route::post('/employee/transaction/store', [App\Http\Controllers\EmployeeController::class, 'storeTransaction'])->name('employee.transaction.store');
Route::get('/employee/transaction/edit/{id}', [App\Http\Controllers\EmployeeController::class, 'editTransaction'])->name('employee.transaction.edit');
Route::put('/employee/transaction/update/{id}', [App\Http\Controllers\EmployeeController::class, 'updateTransaction'])->name('employee.transaction.update');
Route::delete('/employee/transaction/delete/{id}', [App\Http\Controllers\EmployeeController::class, 'deleteTransaction'])->name('employee.transaction.delete');

Route::get('/employee/report', [App\Http\Controllers\EmployeeController::class, 'indexReport'])->name('employee.report');
Route::get('/employee/report/print', [App\Http\Controllers\EmployeeController::class, 'printReport'])->name('employee.report.print');

Route::get('/admin/home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'getUsers'])->name('admin.users');
Route::get('/admin/users/income', [App\Http\Controllers\AdminController::class, 'usersIncome'])->name('admin.income');
Route::post('/admin/users/store', [App\Http\Controllers\AdminController::class, 'createUserManagement'])->name('admin.users.store');
Route::post('/admin/users/frontOffice/store', [App\Http\Controllers\AdminController::class, 'storeFrontOffice'])->name('admin.users.frontOffice.store');
Route::get('/admin/users/detail/{id}', [App\Http\Controllers\AdminController::class, 'detailUsers'])->name('admin.users.detail');
Route::delete('/admin/users/delete/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.users.delete');
Route::get('/admin/code-angkringan', [App\Http\Controllers\AdminController::class, 'codeAngkringan'])->name('admin.users.codeAngkringan');
Route::post('/admin/code-angkringan/store', [App\Http\Controllers\AdminController::class, 'codeStoreAngkringan'])->name('admin.users.codeStoreAngkringan');
Route::put('/admin/code-angkringan/update/{id}', [App\Http\Controllers\AdminController::class, 'codeUpdateAngkringan'])->name('admin.users.codeUpdateAngkringan');
Route::get('/admin/code-angkringan/detail/{code_angkringan}', [App\Http\Controllers\AdminController::class, 'detailAngkringan'])->name('admin.users.codeDetailAngkringan');
Route::get('/admin/search-code', [App\Http\Controllers\AdminController::class, 'selectSearch'])->name('admin.code.search');

Route::get('/admin/user/print-transaction/{user_id}', [App\Http\Controllers\AdminController::class, 'printReportTransactionUser'])->name('admin.user.printTransaction');


Route::get('/admin/menu', [App\Http\Controllers\AdminController::class, 'getMenu'])->name('admin.menu.index');
Route::post('/admin/menu/store', [App\Http\Controllers\AdminController::class, 'storeMenu'])->name('admin.menu.store');
Route::put('/admin/menu/update/{id}', [App\Http\Controllers\AdminController::class, 'updateMenu'])->name('admin.menu.update');
Route::delete('/admin/menu/delete/{id}', [App\Http\Controllers\AdminController::class, 'deleteMenu'])->name('admin.menu.delete');


Route::get('/employee/menu/{id}', [App\Http\Controllers\EmployeeController::class, 'getMenuId'])->name('employee.menu.detail');
Route::post('/employee/cart/store', [App\Http\Controllers\EmployeeController::class, 'storeCart'])->name('employee.cart.store');
Route::delete('/employee/cart/delete/{id}', [App\Http\Controllers\EmployeeController::class, 'deleteCart'])->name('employee.cart.delete');

Route::get('/management/home', [App\Http\Controllers\ManagementController::class, 'index'])->name('management.dashboard');
Route::get('/management/employees', [App\Http\Controllers\ManagementController::class, 'indexEmployee'])->name('management.employees');
Route::get('/management/users', [App\Http\Controllers\ManagementController::class, 'getUsers'])->name('management.users');
Route::get('/management/users/detail/{id}', [App\Http\Controllers\ManagementController::class, 'detailUsers'])->name('management.users.detail');
Route::get('/management/user/print-transaction/{user_id}', [App\Http\Controllers\ManagementController::class, 'printReportTransactionUser'])->name('management.user.printTransaction');

Route::get('/management/profile', [App\Http\Controllers\ManagementController::class, 'indexProfile'])->name('management.profile');
Route::post('/management/profile/update', [App\Http\Controllers\ManagementController::class, 'updateProfile'])->name('management.profile.update');
Route::put('/management/profile/update-password', [App\Http\Controllers\ManagementController::class, 'updatePassword'])->name('management.profile.update.password');