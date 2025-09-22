<?php

use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\Module\SellPostCategoryController;
use App\Http\Controllers\Admin\Module\SellSummaryController;
use App\Http\Controllers\ChatNotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Module\CategoryController;
use App\Http\Controllers\Admin\Module\TopUpController;
use App\Http\Controllers\Admin\Module\TopUpServiceController;
use App\Http\Controllers\Admin\Module\TopUpOrderController;
use App\Http\Controllers\Admin\Module\CardController;
use App\Http\Controllers\Admin\Module\CardServiceController;
use App\Http\Controllers\Admin\Module\CardServiceCodeController;
use App\Http\Controllers\Admin\Module\CardOrderController;
use App\Http\Controllers\Admin\Module\ReviewController;
use App\Http\Controllers\Admin\Module\CouponController;
use App\Http\Controllers\Admin\Module\CampaignController;
use App\Http\Controllers\Admin\UsersController;

$adminPrefix = basicControl()->admin_prefix ?? 'admin';
Route::group(['prefix' => $adminPrefix, 'as' => 'admin.'], function () {
    Route::middleware(['auth:admin'])->group(function () {
        Route::controller(CurrencyController::class)->group(function () {
            Route::group(['prefix' => 'currency'], function () {
                Route::get('list', 'currencyList')->name('currencyList');
                Route::get('list/search', 'currencyListSearch')->name('currencyListSearch');
                Route::post('create', 'currencyCreate')->name('currencyCreate');
                Route::post('edit/{id}', 'currencyEdit')->name('currencyEdit');
                Route::post('sort', 'currencySort')->name('currencySort');
                Route::get('status-change', 'currencyStatusChange')->name('currencyStatusChange');
                Route::delete('delete/{id}', 'currencyDelete')->name('currencyDelete');
                Route::post('multiple-delete', 'multipleDelete')->name('currencyMultipleDelete');
                Route::post('multiple/status-change', 'multipleStatusChange')->name('currencyMultipleStatusChange');
                Route::post('multiple/rate-update', 'multipleRateUpdate')->name('currencyMultipleRateUpdate');
            });
        });

        Route::controller(CategoryController::class)->group(function () {
            Route::group(['prefix' => 'category'], function () {
                Route::get('list', 'categoryList')->name('categoryList');
                Route::get('list/search', 'categoryListSearch')->name('categoryListSearch');
                Route::post('create', 'categoryCreate')->name('categoryCreate');
                Route::post('edit/{id}', 'categoryEdit')->name('categoryEdit');
                Route::post('sort', 'categorySort')->name('categorySort');
                Route::get('status-change', 'categoryStatusChange')->name('categoryStatusChange');
                Route::delete('delete/{id}', 'categoryDelete')->name('categoryDelete');
            });
        });

        Route::middleware(['permission:Direct Top Up'])->group(function () {
            Route::controller(TopUpController::class)->group(function () {
                Route::group(['prefix' => 'top-up'], function () {
                    Route::get('list', 'topUpList')->name('topUpList');
                    Route::get('list/search', 'topUpListSearch')->name('topUpListSearch');
                    Route::any('store', 'topUpStore')->name('topUpStore');
                    Route::any('edit/{id}', 'topUpEdit')->name('topUpEdit');
                    Route::post('sort', 'topUpSort')->name('topUpSort');
                    Route::get('status-change', 'topUpStatusChange')->name('topUpStatusChange');
                    Route::delete('delete/{id}', 'topUpDelete')->name('topUpDelete');
                    Route::post('multiple-delete', 'multipleDelete')->name('topUpMultipleDelete');
                    Route::post('multiple/status-change', 'multipleStatusChange')->name('topUpMultipleStatusChange');
                });
            });

            Route::controller(TopUpServiceController::class)->group(function () {
                Route::group(['prefix' => 'top-up/service', 'as' => 'topUpService.'], function () {
                    Route::get('list', 'serviceList')->name('list');
                    Route::get('search', 'serviceSearch')->name('search');
                    Route::any('store', 'serviceStore')->name('store');
                    Route::any('update/{id}', 'serviceUpdate')->name('update');
                    Route::post('sort', 'serviceSort')->name('sort');
                    Route::get('status-change', 'serviceStatusChange')->name('statusChange');
                    Route::delete('delete/{id}', 'serviceDelete')->name('delete');
                    Route::post('multiple-delete', 'multipleDelete')->name('multipleDelete');
                    Route::post('multiple/status-change', 'multipleStatusChange')->name('multipleStatusChange');

                    Route::get('export', 'serviceExport')->name('export');
                    Route::get('sample', 'serviceSample')->name('sample');
                    Route::post('import', 'serviceImport')->name('import');
                });
            });
        });


        Route::middleware(['permission:Card'])->group(function () {
            Route::controller(CardController::class)->group(function () {
                Route::group(['prefix' => 'card', 'as' => 'card.'], function () {
                    Route::get('list', 'list')->name('list');
                    Route::get('list/search', 'search')->name('search');
                    Route::any('store', 'store')->name('store');
                    Route::any('edit/{id}', 'edit')->name('edit');
                    Route::post('sort', 'sort')->name('sort');
                    Route::get('status-change', 'statusChange')->name('statusChange');
                    Route::delete('delete/{id}', 'delete')->name('delete');
                    Route::post('multiple-delete', 'multipleDelete')->name('multipleDelete');
                    Route::get('trending/{id}', 'trending')->name('trending');
                    Route::post('multiple-trending', 'multipleTrending')->name('multipleTrending');
                    Route::post('multiple/status-change', 'multipleStatusChange')->name('multipleStatusChange');
                });
            });

            Route::controller(CardServiceController::class)->group(function () {
                Route::group(['prefix' => 'card/service', 'as' => 'cardService.'], function () {
                    Route::get('list', 'serviceList')->name('list');
                    Route::get('search', 'serviceSearch')->name('search');
                    Route::any('store', 'serviceStore')->name('store');
                    Route::any('update/{id}', 'serviceUpdate')->name('update');
                    Route::post('sort', 'serviceSort')->name('sort');
                    Route::get('status-change', 'serviceStatusChange')->name('statusChange');
                    Route::delete('delete/{id}', 'serviceDelete')->name('delete');
                    Route::post('multiple-delete', 'multipleDelete')->name('multipleDelete');
                    Route::post('multiple/status-change', 'multipleStatusChange')->name('multipleStatusChange');

                    Route::get('export', 'serviceExport')->name('export');
                    Route::get('sample', 'serviceSample')->name('sample');
                    Route::post('import', 'serviceImport')->name('import');
                });
            });

            Route::controller(CardServiceCodeController::class)->group(function () {
                Route::group(['prefix' => 'card/service/code', 'as' => 'cardServiceCode.'], function () {
                    Route::get('list', 'list')->name('list');
                    Route::get('search', 'search')->name('search');
                    Route::any('store', 'store')->name('store');
                    Route::post('multiple/status-change', 'multipleStatusChange')->name('multipleStatusChange');
                    Route::post('multiple-delete', 'multipleDelete')->name('multipleDelete');

                    Route::get('export', 'export')->name('export');
                    Route::get('sample', 'sample')->name('sample');
                    Route::post('import', 'import')->name('import');
                });
            });
        });

        Route::middleware(['permission:All Orders'])->group(function () {
            Route::controller(TopUpOrderController::class)->group(function () {
                Route::group(['prefix' => 'top-up/order', 'as' => 'orderTopUp.'], function () {
                    Route::get('list', 'list')->name('list');
                    Route::get('list/search', 'listSearch')->name('listSearch');
                    Route::get('view', 'view')->name('view');
                    Route::post('complete', 'complete')->name('complete');
                    Route::post('cancel', 'cancel')->name('cancel');
                });
            });

            Route::controller(CardOrderController::class)->group(function () {
                Route::group(['prefix' => 'card/order', 'as' => 'orderCard.'], function () {
                    Route::get('list', 'list')->name('list');
                    Route::get('list/search', 'listSearch')->name('listSearch');
                    Route::get('view', 'view')->name('view');
                    Route::post('code-send', 'codeSend')->name('codeSend');
                    Route::post('complete', 'complete')->name('complete');
                    Route::post('cancel', 'cancel')->name('cancel');
                });
            });
        });

        Route::middleware(['permission:All Marketing'])->group(function () {
            //MANAGE REVIEW
            Route::controller(ReviewController::class)->group(function () {
                Route::group(['prefix' => 'review', 'as' => 'review.'], function () {
                    Route::get('list', 'list')->name('list');
                    Route::get('list/search', 'search')->name('search');
                    Route::post('multiple-delete', 'multipleDelete')->name('multipleDelete');
                    Route::post('multiple/status-change', 'multipleStatusChange')->name('multipleStatusChange');
                });
            });

            //MANAGE COUPON
            Route::controller(CouponController::class)->group(function () {
                Route::group(['prefix' => 'coupon', 'as' => 'coupon'], function () {
                    Route::get('list', 'couponList')->name('List');
                    Route::any('store', 'couponStore')->name('Store');
                    Route::any('edit/{id}', 'couponEdit')->name('Edit');
                    Route::delete('delete/{id}', 'couponDelete')->name('Delete');
                    Route::post('multiple/status/change', 'couponMultipleStatusChange')->name('MultipleStatusChange');
                    Route::post('multiple/delete', 'couponMultipleDelete')->name('MultipleDelete');

                    Route::post('topup/type/change/{type}', 'topUpTypeChange')->name('TopUpTypeChange');
                    Route::post('card/type/change/{type}', 'cardTypeChange')->name('CardTypeChange');
                });
            });

            //MANAGE CAMPAIGN
            Route::controller(CampaignController::class)->group(function () {
                Route::group(['prefix' => 'campaign', 'as' => 'campaign.'], function () {
                    Route::get('view', 'view')->name('view');
                    Route::post('get/top-ups/service', 'getTopUpService')->name('getTopUpService');
                    Route::post('get/card/service', 'getCardService')->name('getCardService');
                    Route::post('store', 'store')->name('store');
                });
            });
        });

        Route::controller(SellPostCategoryController::class)->group(function () {
            /*====== Manage Sell Post Category =======*/
            Route::get('/sell/category-list', 'category')->name('sellPostCategory');
            Route::get('/sell/create', 'categoryCreate')->name('sellPostCategoryCreate');
            Route::post('/sell/store/{language?}', 'categoryStore')->name('sellPostCategoryStore');
            Route::delete('/sell/delete/{id}', 'categoryDelete')->name('sellPostCategoryDelete');
            Route::get('/sell/edit/{id}', 'categoryEdit')->name('sellPostCategoryEdit');
            Route::put('/sell/update/{id}/{language?}', 'categoryUpdate')->name('sellPostCategoryUpdate');
            Route::post('/sell/status/change', 'statusSellMultiple')->name('sell.statusChange');


            /*====== Manage Sell Post List =======*/
            Route::get('/sell/post/list/{status?}', 'sellList')->name('gameSellList');
            Route::get('/sell/post/search/list/{status?}', 'sellListSearch')->name('gameSellListSearch');
            Route::get('/sell/post/details/{id}', 'sellDetails')->name('sell.details');
            Route::put('/sell/post/update/{id}', 'SellUpdate')->name('sell.update');
            Route::delete('/sell/post/image-delete/{id}/{imgDelete}', 'SellDelete')->name('sell.image.delete');
            Route::post('/sell/post/action/', 'SellAction')->name('sellPostAction');
            Route::get('/sell/post/offer/{sellPostId}', 'sellPostOffer')->name('sellPost.offer');
            Route::get('/sell/post/conversation/{uuid}', 'conversation')->name('sellPost.conversation');

        });

        //Sell summary
        Route::controller(SellSummaryController::class)->group(function () {

            Route::get('/post/sell', 'postSellTran')->name('postSell');
            Route::get('/post/sell/search', 'postSellSearch')->name('postSell.search');
            Route::get('/post/sell/paymentRelease', 'paymentRelease')->name('postSell.paymentRelease');
            Route::get('/post/sell/paymentUpcoming', 'paymentUpcoming')->name('postSell.paymentUpcoming');

            Route::post('/post/sell/payment-hold', 'paymentHold')->name('paymentHold');
            Route::post('/post/sell/payment-unhold', 'paymentUnhold')->name('paymentUnhold');
        });

        Route::get('push-chat-show/{uuId}', [ChatNotificationController::class, 'showByAdmin'])->name('push.chat.show');
        Route::post('push-chat-newMessage', [ChatNotificationController::class, 'newMessageByAdmin'])->name('push.chat.newMessage');

        Route::middleware(['permission:User Management'])->group(function () {
            Route::controller(UsersController::class)->group(function () {
                Route::get('users/activity', 'userActivity')->name('userActivity');
                Route::get('users/activity/search', 'userActivitySearch')->name('userActivitySearch');
            });
        });

    });
});
