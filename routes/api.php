<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
//
Route::get('/products', [ProductsController::class, 'index']);
//Route::get('/user', [AuthController::class, 'user']);
//Route::get('/check-auth', [AuthController::class, 'check']);
//
//Route::middleware(['web'])->group(function () {
//    Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart']);
//    Route::get('/cart', [CartController::class, 'index']);
//    Route::delete('/remove-from-cart/{id}', [CartController::class, 'removeFromCart']);
//
//    Route::post('/purchase', [UsersController::class, 'purchase']);
//    Route::post('/cart/increment', [CartController::class, 'incrementQuantity']);
//    Route::post('/cart/decrement', [CartController::class, 'decrementQuantity']);
//
//    Route::post('/login',[AuthController::class,'login']);
//    Route::post('/logout', function (Request $request) {
//        Auth::guard('web')->logout();
//        $request->session()->invalidate();
//        $request->session()->regenerateToken();
//
//        return response()->json(['message' => 'Logged out']);
//    });
//});
Route::middleware(['web', 'api'])->group(function () {
    Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::delete('/remove-from-cart/{id}', [CartController::class, 'removeFromCart']);
    Route::post('/purchase', [UsersController::class, 'purchase']);
    Route::post('/cart/increment', [CartController::class, 'incrementQuantity']);
    Route::post('/cart/decrement', [CartController::class, 'decrementQuantity']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/recover-password', [AuthController::class, 'recoverPassword']);

    Route::post('/logout', function (Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'Logged out']);
    });
    Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');

});
