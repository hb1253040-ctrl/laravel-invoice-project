<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\InvoiceController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sign-in',[AuthController::class, 'signIn']);

Route::get('/logout',[AuthController::class, 'logout']);

Route::get('billing/{user_id}',[InvoiceController::class, 'get_invoice']);

Route::post('/invoice/create',[InvoiceController::class, 'create']);

