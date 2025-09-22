<?php

use App\Http\Controllers\ChatNotificationController;
use App\Http\Controllers\User\SellPostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\DashboardController;

$basicControl = basicControl();

Route::group(['middleware' => ['maintenanceMode']], function () use ($basicControl) {
    Route::group(['middleware' => ['auth','userCheck','kyc'], 'prefix' => 'user', 'as' => 'user.'], function () {
        Route::controller(OrderController::class)->group(function () {
            Route::get('topUp/orders', 'topUpOrder')->name('topUpOrder')->middleware('module:top_up');
            Route::get('card/orders', 'cardOrder')->name('cardOrder')->middleware('module:card');
        });

        Route::controller(DashboardController::class)->group(function () {
            Route::get('get-order/movement', 'getOrderMovement')->name('getOrderMovement');
        });

        Route::controller(SellPostController::class)->middleware('module:sell_post')->group(function () {
            Route::post('payment/sellPost', 'sellPostMakePayment')->name('sellPost.makePayment');
            Route::get('/post/order', 'sellPostOrder')->name('sellPostOrder');
            Route::get('/post/search', 'sellPostOrderSearch')->name('sellPostOrder.search');
            Route::get('/post/offer', 'sellPostOfferList')->name('sellPostOffer.List');
            Route::get('/post/my-offer', 'sellPostMyOffer')->name('sellPostMyOffer');

            Route::get('/sell-post/create', 'sellCreate')->name('sellCreate');
            Route::post('/sell-post/store', 'sellStore')->name('sellStore');
            Route::get('/sell-post/list', 'sellList')->name('sellList');
            Route::get('/sell-post/search', 'sellPostSearch')->name('sellPost.search');
            Route::get('/sell-post/edit/{id}', 'sellPostEdit')->name('sellPostEdit');
            Route::post('/sell-post/update/{id}', 'sellPostUpdate')->name('sellPostUpdate');
            Route::delete('/sell-post/delete/{id}', 'sellPostDelete')->name('sellPostDelete');
            Route::delete('/sell/image-delete/{id}/{imgDelete}', 'SellDelete')->name('sell.image.delete');
            Route::get('/post/my-offer-search', 'myOfferSearch')->name('myOffer.search');

            Route::post('/sell-post/offer', 'sellPostOffer')->name('sellPostOffer');
            Route::get('/sell-post/offerList', 'sellPostOfferMore')->name('sellPostOfferMore');
            Route::post('/sell-post/offer/remove', 'sellPostOfferRemove')->name('sellPostOfferRemove');
            Route::post('/sell-post/offer/reject', 'sellPostOfferReject')->name('sellPostOfferReject');
            Route::post('/sell-post/offer/accept', 'sellPostOfferAccept')->name('sellPostOfferAccept');
            Route::get('/sell-post/offer/chat/{uuId}', 'sellPostOfferChat')->name('offerChat');

            Route::post('/sell-post/offer/lock', 'sellPostOfferPaymentLock')->name('sellPostOfferPaymentLock');
            Route::post('/sell-post/payment/{sellPost}', 'sellPostPayment')->name('sellPost.payment');
            Route::get('/sell-post/payment/{sellPost:payment_uuid}', 'sellPostPaymentUrl')->name('sellPost.payment.url');
        });

        Route::get('push-chat-show/{uuId}', [ChatNotificationController::class, 'show'])->name('push.chat.show');
        Route::post('push-chat-newMessage', [ChatNotificationController::class, 'newMessage'])->name('push.chat.newMessage');
    });


});
