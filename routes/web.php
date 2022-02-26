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
