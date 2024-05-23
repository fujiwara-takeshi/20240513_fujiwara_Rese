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

Route::get('/', function () {
    return view('index');
});
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/thanks', function () {
    return view('auth.thanks');
});
Route::get('/login', function () {
    return view('auth.login');
});
Route::get('/mypage', function () {
    return view('mypage');
});
Route::get('/detail/{shop_id}', function () {
    return view('detail');
});
Route::get('/done', function () {
    return view('done');
});
Route::get('/email', function () {
    return view('auth.verify-email');
});
