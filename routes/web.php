<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminPanelController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\GetAddressController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\LocalizationController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// DON'T Put it inside the '/admin' Prefix , Otherwise you'll never get the page due to assign.guard that will redirect you too many times
Route::get('admin/login', [AdminLoginController::class, 'showLoginForm']);
Route::post('admin/login', [AdminLoginController::class, 'login'])->name('admin.login');
Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::get('lang/{lang}', [LocalizationController::class, 'index'])->name('language');

Route::group(['prefix' => '/admin', 'middleware' => 'assign.guard:admin,admin/login'], function () {

    Route::get('dashboard', [AdminPanelController::class, 'index']);

    Route::resource('roles', RoleController::class);
    Route::resource('admins', AdminController::class);

    Route::resource('invoices', InvoiceController::class);
    Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'downloadPdf'])->name('invoices.download');

    // Users
    Route::resource('users', UserController::class);
    Route::get('users/{user}/invoices', [UserController::class, 'invoices'])->name('users.invoices');

    Route::resource('products', ProductController::class)->only(['index']);


    Route::get('activity_logs', [ActivityLogController::class, 'index'])->name('activity_logs');

    Route::get('get_product_data', [ProductController::class, 'getData']);

    Route::get('get_address/{id}', [GetAddressController::class, 'index'])->name('get_address');

    Route::get('get_discount_amounts/{discount_sort}' , [DiscountController::class, 'discountAmount']);
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/storage_link', function () {
    Artisan::call('storage:link');
});

Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');
    return 'Optimization cache cleared!';
});
