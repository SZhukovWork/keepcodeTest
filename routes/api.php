<?php

use App\Http\Controllers\Auth\JWTAuthController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->group(function () {
    Route::post('login', [JWTAuthController::class, 'login'])
        ->name('api.login');
});
Route::middleware('auth:api')->group(function () {
    Route::get('/products', [ProductsController::class, 'allApi'])->name('api.products');
    Route::post('/products', [ProductsController::class, 'create'])->name('api.products.create');

    Route::get('/orders', [OrdersController::class, 'allApi'])->name('api.orders');
    Route::post('/orders', [OrdersController::class, 'create'])->name('api.orders.create');
    Route::get('/orders/{orderId}/{productId}/status', [OrdersController::class, 'productStatus'])->name('api.orders.product.status');
});
