<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::get('/products', [ProductsController::class, 'index']);

Route::middleware(['web'])->group(function () {
    Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::delete('/remove-from-cart/{id}', [CartController::class, 'removeFromCart']);
    Route::get('/session', function () {
        return session()->all();
    });
    Route::post('/purchase', [UsersController::class, 'purchase']);
    Route::post('/cart/increment', [CartController::class, 'incrementQuantity']);
    Route::post('/cart/decrement', [CartController::class, 'decrementQuantity']);
});
Route::get('/session/all', function () {

    return session()->all();
});
