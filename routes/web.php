<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});
Route::get('/session',function(){

    session(['name' => 'John Doe']);
    return session()->all();
});
Route::get('/session/all',function(){

    return session()->all();
});
Route::any('/{any}', function () {
    return view('app');
})->where('any' , '.*');
