<?php

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
use App\Http\Controllers\Customer\Auth\AuthController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\SettingController;
use App\Http\Controllers\Customer\BillingController;
use App\Http\Controllers\Customer\InvoiceController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sign-in',[AuthController::class,'login'])->name('auth.login');
Route::post('/sign-in',[AuthController::class,'signIn']);

Route::get('/logout',[AuthController::class,'logout'])->name('auth.logout');
Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');
Route::get('/settings',[SettingController::class, 'index'])->name('setting');
Route::get('/billing',[BillingController::class, 'index'])->name('billing');
Route::get('/billing/{user_id}',[InvoiceController::class, 'get_invoice'])->name('billing');
Route::get('/invoice/create',[InvoiceController::class, 'index'])->name('invoice.create');
Route::post('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
//Route::post('/invoice/create', [OrderController::class,'sendInvoice'])->name('invoice.create');

/*
Route::group(['middleware' => 'auth'], function () {
    
});*/

