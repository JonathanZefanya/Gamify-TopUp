<?php

use App\Http\Controllers\Admin\PayoutLogController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BuyController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\MyOrderController;
use App\Http\Controllers\Api\PayoutController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SellPostController;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\SupportTicketController;
use App\Http\Controllers\Api\TwoFASecurityController;
use App\Http\Controllers\Api\VerificationController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TopUpController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\CardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/register/form', 'registerUserForm');
    Route::post('/register', 'registerUser');
    Route::post('/login', 'loginUser');
    Route::post('/recovery-pass/get-email', 'getEmailForRecoverPass');
    Route::post('/recovery-pass/get-code', 'getCodeForRecoverPass');
    Route::post('/update-pass', 'updatePass');

    Route::post('/generate/authorization-token', 'generateBearer');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('language/{id?}', 'language');
    Route::get('app/config', 'appConfig');
    Route::get('get/gateways', 'getGateways');
    Route::get('campaign', 'campaign');
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::controller(VerificationController::class)->group(function () {
        Route::post('/twoFA-Verify', 'twoFAverify');
        Route::post('/mail-verify', 'mailVerify');
        Route::post('/sms-verify', 'smsVerify');
        Route::get('/resend-code', 'resendCode');
    });

    Route::group(['middleware' => ['CheckStatusApi']], function () {

        Route::controller(ProfileController::class)->group(function () {
            Route::post('profile/kyc/submit', 'kycSubmit');
            Route::get('profile', 'profile');
            Route::delete('account/delete', 'accountDelete');
            Route::post('firebase-token/save', 'firebaseTokenSave');
        });

        Route::middleware('apiKYC')->group(function () {

            Route::controller(HomeController::class)->group(function () {
                Route::get('pusher/config', 'pusherConfig');
                Route::get('dashboard', 'dashboard');

                Route::get('transaction', 'transaction');
                Route::get('transaction/search', 'transactionSearch');

                Route::get('payment-log', 'paymentHistory');
                Route::get('payment-log/search', 'paymentHistorySearch');

                Route::get('payout-history', 'payoutHistory');
                Route::get('payout-history/search', 'payoutHistorySearch');

                Route::get('api-key', 'apiKey');
                Route::post('api-key', 'apiKeyUpdate');
            });

            Route::controller(ProfileController::class)->group(function () {
                Route::post('profile/image/upload', 'profileImageUpload');
                Route::post('profile/information/update', 'profileInfoUpdate');
                Route::post('profile/password/update', 'profilePassUpdate');
            });

            Route::controller(TwoFASecurityController::class)->group(function () {
                Route::get('2FA-security', 'twoFASecurity');
                Route::post('2FA-security/enable', 'twoFASecurityEnable');
                Route::post('2FA-security/disable', 'twoFASecurityDisable');
            });

            Route::controller(SupportTicketController::class)->group(function () {
                Route::get('support-ticket/list', 'ticketList');
                Route::post('support-ticket/create', 'ticketCreate');
                Route::get('support-ticket/view/{id}', 'ticketView');
                Route::post('support-ticket/reply', 'ticketReply');
            });

            Route::controller(MyOrderController::class)->group(function () {
                Route::get('topUp/order', 'topUpOrder')->middleware('ModuleApi:top_up');
                Route::get('card/order', 'cardOrder')->middleware('ModuleApi:card');
            });

            Route::group(['middleware' => ['ModuleApi:sell_post']], function () {
                Route::controller(MyOrderController::class)->group(function () {
                    Route::get('id/purchases', 'idPurchase');
                    Route::get('my/order', 'myOrder');
                });

                Route::controller(SellPostController::class)->group(function () {
                    Route::get('sell-post/category', 'sellPostCategory');
                    Route::post('sell-post/create', 'sellPostCreate');
                    Route::get('sell-post/list', 'sellPostList');
                    Route::get('sell-post/edit', 'sellPostEdit');
                    Route::post('sell-post/update', 'sellPostUpdate');
                    Route::delete('sell-post/delete', 'sellPostDelete');

                    Route::get('offer/list', 'offerList');
                    Route::post('offer/accept', 'offerAccept');
                    Route::post('offer/reject', 'offerReject');
                    Route::post('offer/remove', 'offerRemove');
                    Route::get('offer/conversation', 'offerConversation');
                    Route::post('offer/new-message', 'offerNewMessage');

                    Route::post('offer/payment-lock', 'paymentLock');
                });

            });

            Route::controller(PayoutController::class)->group(function () {
                Route::get('payout', 'payout');
                Route::post('payout/get-bank/list', 'payoutGetBankList');
                Route::post('payout/get-bank/from', 'payoutGetBankFrom');
                Route::post('payout/paystack/submit', 'payoutPaystackSubmit');
                Route::post('payout/flutterwave/submit', 'payoutFlutterwaveSubmit');
                Route::post('payout/submit/confirm', 'payoutSubmit');
            });

            Route::controller(ShopController::class)->group(function () {
                Route::get('top-up/list', 'topUpList');
                Route::get('top-up/details', 'topUpDetails');
                Route::get('top-up/categories', 'topUpCategories');

                Route::post('top-up/make-order', 'topUpOrder')->middleware('ModuleApi:top_up');
                Route::post('top-up/make-payment', 'topUpMakePayment')->middleware('ModuleApi:top_up');
                Route::post('card/make-order', 'cardOrder')->middleware('ModuleApi:card');
                Route::post('card/make-payment', 'cardMakePayment')->middleware('ModuleApi:card');
                Route::post('add-fund', 'addFund');

                Route::post('wallet-payment', 'walletPayment');
                Route::post('payment-done', 'paymentDone');
                Route::post('card-payment', 'cardPayment');
                Route::post('show-other-payment', 'showOtherPayment');
                Route::post('manual-payment', 'manualPaymentSubmit');
            });

            Route::controller(CouponController::class)->group(function () {
                Route::get('coupons', 'coupons');
                Route::post('apply-coupon', 'couponApply');

            });

            Route::controller(TopUpController::class)->group(function () {
                Route::get('topup/services', 'topUpServices');
                Route::get('topup/review', 'topUpReview');
                Route::post('topup/review', 'topUpReviewPost');
                Route::get('get-topup/orders', 'getTopUpOrder');
            });

            Route::controller(CardController::class)->group(function () {
                Route::get('get-card', 'getCard');
                Route::get('card/categories', 'cardCategories');
                Route::get('card/details', 'cardDetails');
                Route::get('card/services', 'cardServices');
                Route::get('card/review', 'cardReview');
                Route::post('card/review', 'cardReviewPost');
            });

            Route::controller(BuyController::class)->group(function () {
                Route::get('buy/id', 'buyList');
                Route::get('buy/id/details', 'buyIdDetails')->middleware('ModuleApi:sell_post');
                Route::post('buy/id/make-payment', 'buyIdMakePayment')->middleware('ModuleApi:sell_post');
                Route::post('make/offer', 'makeOffer')->middleware('ModuleApi:sell_post');
            });

            Route::controller(HomeController::class)->group(function () {
                Route::get('get-category', 'getCategory');
                Route::get('get-campaign', 'getCampaign');
                Route::post('make/payment', 'makePayment');
            });

        });
    });
});
