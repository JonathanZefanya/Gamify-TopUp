<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\TopUpController;
use App\Http\Controllers\Frontend\CardController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\FrontendController;

$basicControl = basicControl();

Route::group(['middleware' => ['maintenanceMode']], function () use ($basicControl) {

    Route::controller(FrontendController::class)->group(function () {
        Route::get('review/list', 'reviewList')->name('reviewList');
    });

    Route::controller(TopUpController::class)->group(function () {
        Route::group(['prefix' => 'direct-topup', 'as' => 'topUp.'], function () {
            Route::get('list/{catId?}', 'getDirectTopUp')->name('fetch');
            Route::get('details/{slug?}', 'directTopUpDetails')->name('details');

            Route::group(['middleware' => ['auth'], 'prefix' => 'user', 'as' => 'user.'], function () {
                Route::post('buy', 'buy')->name('buy');
                Route::any('order', 'order')->name('order');

                Route::post('add-review', 'addReview')->name('addReview');

                Route::post('coupon/apply', 'couponApply')->name('couponApply');
            });
        });
    });

    Route::controller(CardController::class)->group(function () {
        Route::group(['prefix' => 'card', 'as' => 'card.'], function () {
            Route::get('list/{catId?}', 'getCard')->name('fetch');
            Route::get('details/{slug?}', 'cardDetails')->name('details');

            Route::group(['middleware' => ['auth'], 'prefix' => 'user', 'as' => 'user.'], function () {
                Route::post('single-order', 'singleOrder')->name('singleOrder');
                Route::post('buy', 'buy')->name('buy');
                Route::any('order', 'order')->name('order');

                Route::post('add-review', 'addReview')->name('addReview');
            });
        });
    });


    Route::controller(CartController::class)->group(function () {
        Route::group(['prefix' => 'cart', 'as' => 'cart.'], function () {
            Route::group(['middleware' => ['auth'], 'prefix' => 'user', 'as' => 'user.'], function () {
                Route::get('list', 'getCartList')->name('fetch');
                Route::post('added', 'addCart')->name('addCart');
                Route::get('get-items', 'getCartItems')->name('getCartItems');
                Route::post('quantity-update', 'quantityUpdate')->name('quantityUpdate');
                Route::post('remove', 'remove')->name('remove');
                Route::get('cart-count', 'cartCount')->name('cartCount');
            });
        });
    });
});
