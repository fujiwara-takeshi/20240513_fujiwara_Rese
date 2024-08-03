<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PaymentController;

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

Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['auth'])->name('verification.verify');

Route::middleware('auth', 'verified')->group(function() {
    Route::get('/', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/detail/{shop_id}', [ShopController::class, 'show'])->name('shop.show');
    Route::post('/shop', [ShopController::class, 'store'])->name('shop.store');
    Route::patch('/shop/{shop_id}', [ShopController::class, 'update'])->name('shop.update');

    Route::post('/area', [AreaController::class, 'store'])->name('area.store');

    Route::post('/genre', [GenreController::class, 'store'])->name('genre.store');

    Route::post('/favorite', [FavoriteController::class, 'store'])->name('favorite.store');
    Route::delete('/favorite', [FavoriteController::class, 'destroy'])->name('favorite.destroy');

    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('/reservation/{reservation_id}', [ReservationController::class, 'show'])->name('reservation.show');
    Route::delete('/reservation/{reservation_id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');
    Route::get('/reservation/{reservation_id}/edit', [ReservationController::class, 'edit'])->name('reservation.edit');
    Route::patch('/reservation/{reservation_id}', [ReservationController::class, 'update'])->name('reservation.update');

    Route::get('/review/{shop_id}/create', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');

    Route::get('/mypage/{user_id}', [UserController::class, 'index'])->name('user.index');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/users', [UserController::class, 'users'])->name('users');

    Route::post('/mail/confirm', [MailController::class, 'confirm'])->name('mail.confirm');
    Route::post('/mail', [MailController::class, 'send'])->name('mail.send');

    Route::get('/payment/{reservation_id}', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
});
