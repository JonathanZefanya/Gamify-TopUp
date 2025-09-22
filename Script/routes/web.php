<?php

use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\User\KycVerificationController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\PayoutController;
use App\Http\Controllers\User\SocialiteController;
use App\Http\Controllers\Auth\LoginController as UserLoginController;
use App\Http\Controllers\Frontend\CardController;
use App\Http\Controllers\Frontend\TopUpController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\DepositController;
use App\Http\Controllers\ManualRecaptchaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InAppNotificationController;
use App\Http\Controllers\FaSecurityController;
use App\Http\Controllers\User\SupportTicketController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\User\VerificationController;
use App\Http\Controllers\Frontend\BlogController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


$basicControl = basicControl();
Route::get('language/{locale}', function ($locale) {
    $language = \App\Models\Language::where('short_name', $locale)->first();
    if (!$language) $locale = 'en';
    session()->put('lang', $locale);
    session()->put('rtl', $language ? $language->rtl : 0);
    return back();
})->name('language');


Route::get('maintenance-mode', function () {

    $data['maintenanceMode'] = \App\Models\MaintenanceMode::first();
    return view(template() . 'maintenance', $data);
})->name('maintenance');


Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPassword'])->name('user.password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset')->middleware('guest');
Route::post('current/password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset.update');

Route::get('payment/view/{deposit_id}', [ShopController::class, 'paymentView'])->name('paymentView');

Route::get('instruction/page', function () {
    return view('instruction-page');
})->name('instructionPage');

Route::group(['middleware' => ['maintenanceMode']], function () use ($basicControl) {
    Route::group(['middleware' => ['guest']], function () {
        Route::get('/login', [UserLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [UserLoginController::class, 'login'])->name('login.submit');
    });

    Route::group(['middleware' => ['auth'], 'prefix' => 'user', 'as' => 'user.'], function () {

        Route::controller(VerificationController::class)->group(function () {
            Route::get('check', 'check')->name('check');
            Route::get('resend-code', 'resendCode')->name('resendCode');
            Route::post('mail-verify', 'mailVerify')->name('mailVerify');
            Route::post('sms-verify', 'smsVerify')->name('smsVerify');
            Route::post('twoFA-Verify', 'twoFAverify')->name('twoFA-Verify');
        });

        Route::middleware('userCheck')->group(function () {

            Route::post('verification/kyc-form/submit', [KycVerificationController::class, 'verificationSubmit'])->name('kyc.verification.submit');
            Route::get('profile/kyc-settings', [HomeController::class, 'kycSettings'])->name('kyc.settings');
            Route::get('profile/kyc-details', [KycVerificationController::class, 'kycFormDetails'])->name('kycFrom.details');
            Route::get('verification/history', [KycVerificationController::class, 'verificationHistory'])->name('kyc.history');
            Route::get('profile', [HomeController::class, 'profile'])->name('profile');

            Route::middleware('kyc')->group(function () {
                Route::controller(HomeController::class)->group(function () {
                    Route::get('dashboard', 'index')->name('dashboard');
                    Route::post('save-token', 'saveToken')->name('save.token');
                    Route::get('add-fund', 'addFund')->name('add.fund');
                    Route::get('payment-logs', 'paymentLog')->name('fund.index');

                    Route::get('transaction-list', 'transaction')->name('transaction');

                    Route::any('api-key', 'apiKey')->name('apiKey');
                    Route::any('change-dashboard', 'changeDashboard')->name('change.dashboard');
                });

                Route::controller(InAppNotificationController::class)->group(function () {
                    Route::get('push-notification-show', 'show')->name('push.notification.show');
                    Route::get('push.notification.readAll', 'readAll')->name('push.notification.readAll');
                    Route::get('push-notification-readAt/{id}', 'readAt')->name('push.notification.readAt');
                });

                Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
                    Route::controller(SupportTicketController::class)->group(function () {
                        Route::get('/', 'index')->name('list');
                        Route::get('/create', 'create')->name('create');
                        Route::post('/create', 'store')->name('store');
                        Route::get('/view/{ticket}', 'ticketView')->name('view');
                        Route::put('/reply/{ticket}', 'reply')->name('reply');
                    });
                });

                Route::controller(HomeController::class)->group(function () {
                    Route::post('profile-update', 'profileUpdate')->name('profile.update');
                    Route::post('profile-update/image', 'profileUpdateImage')->name('profile.update.image');
                    Route::any('update/password', 'updatePassword')->name('updatePassword');
                });

                Route::get('notification-permission/list', [NotificationController::class, 'index'])->name('notification.permission.list');
                Route::post('notification-perission/update', [NotificationController::class, 'notificationSettingsChanges'])->name('notification.permission');

                Route::controller(FaSecurityController::class)->group(function () {
                    Route::get('/twostep-security', 'twoStepSecurity')->name('twostep.security');
                    Route::post('twoStep-enable', 'twoStepEnable')->name('twoStepEnable');
                    Route::post('twoStep-disable', 'twoStepDisable')->name('twoStepDisable');
                    Route::post('twoStep/re-generate', 'twoStepRegenerate')->name('twoStepRegenerate');
                });

                Route::controller(PayoutController::class)->group(function () {
                    Route::get('payout-list', 'index')->name('payout.index');
                    Route::get('payout-search', 'search')->name('payout.search');
                    Route::get('payout', 'payout')->name('payout');
                    Route::get('payout-supported-currency', 'payoutSupportedCurrency')->name('payout.supported.currency');
                    Route::get('payout-check-amount', 'checkAmount')->name('payout.checkAmount');
                    Route::post('request-payout', 'payoutRequest')->name('payout.request');
                    Route::match(['get', 'post'], 'confirm-payout/{trx_id}', 'confirmPayout')->name('payout.confirm');
                    Route::post('confirm-payout/flutterwave/{trx_id}', 'flutterwavePayout')->name('payout.flutterwave');
                    Route::post('confirm-payout/paystack/{trx_id}', 'paystackPayout')->name('payout.paystack');
                    Route::get('payout-check-limit', 'checkLimit')->name('payout.checkLimit');
                    Route::post('payout-bank-form', 'getBankForm')->name('payout.getBankForm');
                    Route::post('payout-bank-list', 'getBankList')->name('payout.getBankList');
                });
            });
        });
    });

    Route::post('/channel/subscribe', [FrontendController::class, 'subscribe'])->name('subscribe');
    Route::get('captcha', [ManualRecaptchaController::class, 'reCaptCha'])->name('captcha');
    Route::post('/contact/send', [FrontendController::class, 'contactSend'])->name('contact.send');

    Route::controller(DepositController::class)->group(function () {
        Route::get('supported-currency', 'supportedCurrency')->name('supported.currency');
        Route::post('payment-request', 'paymentRequest')->name('payment.request');
        Route::get('deposit-check-amount', 'checkAmount')->name('deposit.checkAmount');
    });

    Route::controller(PaymentController::class)->group(function () {
        Route::get('payment-process/{trx_id}', 'depositConfirm')->name('payment.process');
        Route::post('addFundConfirm/{trx_id}', 'fromSubmit')->name('addFund.fromSubmit');
        Route::match(['get', 'post'], 'success', 'success')->name('success');
        Route::match(['get', 'post'], 'failed', 'failed')->name('failed');
        Route::match(['get', 'post'], 'payment/{code}/{trx?}/{type?}', 'gatewayIpn')->name('ipn');
        Route::match(['get', 'post'], 'payout/{code}', 'payoutIpn')->name('payoutIpn');
    });

    Route::get('cards', [CardController::class, 'cardList'])->name('cards');
    Route::get('top-ups', [TopUpController::class, 'topupList'])->name('top-up');

    Route::get('blog/{slug?}', [BlogController::class, 'blog'])->name('blog');
    Route::get('blog-details/{slug?}', [BlogController::class, 'blogDetails'])->name('blog.details');

    Route::get('/buy', [FrontendController::class, 'sellPost'])->name('buy');
    Route::get('/sell/post/details/{slug?}/{id}', [FrontendController::class, 'sellPostDetails'])->name('sellPost.details');
    Route::post('/ajaxCheckSellPostCalc', [FrontendController::class, 'ajaxCheckSellPostCalc'])->name('ajaxCheckSellPostCalc');

    Route::get('axios/nav-search', [FrontendController::class, 'navSearch'])->name('navSearch');

    Route::get('auth/{socialite}', [SocialiteController::class, 'socialiteLogin'])->name('socialiteLogin');
    Route::get('auth/callback/{socialite}', [SocialiteController::class, 'socialiteCallback'])->name('socialiteCallback');

    Route::post('setting-change', [FrontendController::class, 'settingChange'])->name('settingChange');


    Auth::routes();
    /*= Frontend Manage Controller =*/
    Route::get("/{slug?}", [FrontendController::class, 'page'])->name('page');
});


