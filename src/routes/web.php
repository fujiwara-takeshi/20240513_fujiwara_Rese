<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

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

Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::post('/login', [LoginController::class, 'store'])->name('login');

Route::middleware('auth')->group(function() {
    Route::get('/', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/search', [ShopController::class, 'search'])->name('shop.search');
    Route::get('/detail/{shop_id}', [ShopController::class, 'show'])->name('shop.show');
    Route::get('/shop/create', [ShopController::class, 'create'])->name('shop.create');
    Route::post('/shop', [ShopController::class, 'store'])->name('shop.store');
    Route::get('/shop/{shop_id}/edit', [ShopController::class, 'edit'])->name('shop.edit');
    Route::patch('/shop/{shop_id}', [ShopController::class, 'update'])->name('shop.update');

    Route::post('/favorite', [FavoriteController::class, 'store'])->name('favorite.store');
    Route::delete('/favorite', [FavoriteController::class, 'destroy'])->name('favorite.destroy');

    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('/done', [ReservationController::class, 'done'])->name('reservation.done');
    Route::delete('/reservation/{reservation_id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');
    Route::get('/reservation/{reservation_id}/edit', [ReservationController::class, 'edit'])->name('reservation.edit');
    Route::patch('/reservation/{reservation_id}', [ReservationController::class, 'update'])->name('reservation.update');

    Route::get('/review/{shop_id}/create', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

    Route::get('/mypage/{user_id}', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
});
