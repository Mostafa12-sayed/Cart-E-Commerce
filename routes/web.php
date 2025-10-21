<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('app');
});

//Route::post('/login',[AuthController::class,'login']);
//Route::post('/logout', function (Request $request) {
//    Auth::guard('web')->logout();
//    $request->session()->invalidate();
//    $request->session()->regenerateToken();
//
//    return response()->json(['message' => 'Logged out']);
//});
Route::any('/{any}', function () {
    return view('app');
})->where('any' , '.*');
