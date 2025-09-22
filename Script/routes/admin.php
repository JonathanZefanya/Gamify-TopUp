<?php

use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\BasicControlController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CookiePolicyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailConfigController;
use App\Http\Controllers\Admin\FirebaseConfigController;
use App\Http\Controllers\Admin\KycController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\ManageMenuController;
use App\Http\Controllers\Admin\ManualGatewayController;
use App\Http\Controllers\Admin\PaymentLogController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\PayoutLogController;
use App\Http\Controllers\Admin\PayoutMethodController;
use App\Http\Controllers\Admin\PluginController;
use App\Http\Controllers\Admin\PusherConfigController;
use App\Http\Controllers\Admin\SmsConfigController;
use App\Http\Controllers\Admin\SocialiteController;
use App\Http\Controllers\Admin\StorageController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\TempleteController;
use App\Http\Controllers\Admin\TransactionLogController;
use App\Http\Controllers\Admin\TranslateAPISettingController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\InAppNotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminProfileSettingController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\MaintenanceModeController;
use App\Http\Controllers\Admin\NotificationTemplateController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\SubscribeController;
use App\Http\Controllers\Admin\RolePermissionController;

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

Route::get('clear', function () {
    Illuminate\Support\Facades\Artisan::call('optimize:clear');
    $previousUrl = url()->previous();
    $keywords = ['push-notification', 'ajax', 'cart-count'];
    if (array_filter($keywords, fn($keyword) => str_contains($previousUrl, $keyword))) {
        return redirect('/')->with('success', 'Cache Cleared Successfully');
    }
    return redirect()->back(fallback: '/')->with('success', 'Cache Cleared Successfully');
})->name('clear');

Route::get('queue-work', function () {
    return Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work');

Route::get('schedule-run', function () {
    return Illuminate\Support\Facades\Artisan::call('schedule:run');
})->name('schedule:run');

$adminPrefix = basicControl()->admin_prefix ?? 'admin';
Route::group(['prefix' => $adminPrefix, 'as' => 'admin.'], function () {
    Route::get('/themeMode/{themeType?}', function ($themeType = 'true') {
        session()->put('themeMode', $themeType);
        return $themeType;
    })->name('themeMode');

    Route::get('/403', function () {
        abort(403);
    })->name('403');

    /*== Authentication Routes ==*/
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest:admin');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request')
        ->middleware('guest:admin');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::any('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset')->middleware('guest:admin');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])
        ->name('password.reset.update');


    Route::middleware(['auth:admin','demo'])->group(function () {
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        Route::controller(AdminProfileSettingController::class)->group(function () {
            Route::get('profile', 'profile')->name('profile');
            Route::put('profile', 'profileUpdate')->name('profile.update');
            Route::put('password', 'passwordUpdate')->name('password.update');
            Route::post('notification-permission', 'notificationPermission')->name('notification.permission');
        });

        Route::controller(DashboardController::class)->group(function () {
            Route::get('dashboard', 'index')->name('dashboard');
            Route::post('save-token', 'saveToken')->name('save.token');
            Route::get('dashboard/monthly-deposit-withdraw', 'monthlyDepositWithdraw')->name('monthly.deposit.withdraw');
            Route::get('dashboard/chartUserRecords', 'chartUserRecords')->name('chartUserRecords');
            Route::get('dashboard/chartTicketRecords', 'chartTicketRecords')->name('chartTicketRecords');
            Route::get('dashboard/chartOrderRecords', 'chartOrderRecords')->name('chartOrderRecords');
            Route::get('dashboard/chartTransactionRecords', 'chartTransactionRecords')->name('chartTransactionRecords');
            Route::get('dashboard/chartLoginHistory', 'chartLoginHistory')->name('chartLoginHistory');

            Route::get('dashboard/chartTopUpOrderRecords', 'chartTopUpOrderRecords')->name('chartTopUpOrderRecords');
            Route::get('dashboard/chartCardOrderRecords', 'chartCardOrderRecords')->name('chartCardOrderRecords');
            Route::get('dashboard/chartAddFundRecords', 'chartAddFundRecords')->name('chartAddFundRecords');
            Route::get('dashboard/chartOrderMovement', 'chartOrderMovement')->name('chartOrderMovement');
        });

        Route::middleware(['permission:Manage Staff'])->group(function () {
            /* ===== ROLES AND PERMISSIONS ===== */
            Route::controller(RolePermissionController::class)->group(function () {
                Route::get('role/list', 'index')->name('role');
                Route::get('get/role/list', 'getRoleList')->name('get.role.list');
                Route::get('get/role/{id}', 'getRole')->name('get.role');
                Route::post('role/create', 'roleCreate')->name('role.create');
                Route::post('role/update', 'roleUpdate')->name('role.update');
                Route::delete('role/delete/{id}', 'roleDelete')->name('role.delete');

                Route::get('manage/staffs', 'staffList')->name('role.staff');
                Route::get('get/staffs/list', 'getStaffList')->name('get.staff.list');
                Route::get('manage/staffs/create', 'staffCreate')->name('staff.create');
                Route::post('manage/staffs/store', 'staffStore')->name('role.usersCreate');
                Route::get('edit/staff/{id}', 'editStaff')->name('edit.staff');
                Route::post('manage/staff/update', 'staffUpdate')->name('staff.role.update');
                Route::post('manage/staffs/status/change/{id}', 'statusChange')->name('role.statusChange');
                Route::post('manage/staffs/login/{id}', 'userLogin')->name('role.usersLogin');
            });
        });

        Route::middleware(['permission:Control Panel'])->group(function () {
            Route::controller(BasicControlController::class)->group(function () {
                Route::get('settings/{settings?}', 'index')->name('settings');
                Route::get('basic-control', 'basicControl')->name('basic.control');
                Route::post('basic-control-update', 'basicControlUpdate')->name('basic.control.update');
                Route::post('basic-control-activity-update', 'basicControlActivityUpdate')->name('basic.control.activity.update');
                Route::get('currency-exchange-api-config', 'currencyExchangeApiConfig')->name('currency.exchange.api.config');
                Route::post('currency-exchange-api-config/update', 'currencyExchangeApiConfigUpdate')->name('currency.exchange.api.config.update');
            });

            Route::controller(StorageController::class)->group(function () {
                Route::get('storage', 'index')->name('storage.index');
                Route::any('storage/edit/{id}', 'edit')->name('storage.edit');
                Route::any('storage/update/{id}', 'update')->name('storage.update');
                Route::post('storage/set-default/{id}', 'setDefault')->name('storage.setDefault');
            });

            Route::controller(MaintenanceModeController::class)->group(function () {
                Route::get('maintenance-mode', 'index')->name('maintenance.index');
                Route::post('maintenance-mode/update', 'maintenanceModeUpdate')->name('maintenance.mode.update');
            });

            Route::controller(LogoController::class)->group(function () {
                Route::get('logo-setting', 'logoSetting')->name('logo.settings');
                Route::post('logo-update', 'logoUpdate')->name('logo.update');
            });

            Route::controller(FirebaseConfigController::class)->group(function () {
                Route::get('firebase-config', 'firebaseConfig')->name('firebase.config');
                Route::post('firebase-config-update', 'firebaseConfigUpdate')->name('firebase.config.update');
                Route::get('firebase/config/file/download', 'firebaseConfigFileDownload')->name('firebase.config.file.download');
                Route::post('firebase/config/file/upload', 'firebaseConfigFileUpload')->name('firebase.config.file.upload');
            });

            Route::controller(PusherConfigController::class)->group(function () {
                Route::get('pusher-config', 'pusherConfig')->name('pusher.config');
                Route::post('pusher-config-update', 'pusherConfigUpdate')->name('pusher.config.update');
            });

            Route::controller(EmailConfigController::class)->group(function () {
                Route::get('email-controls', 'emailControls')->name('email.control');
                Route::get('email-config/edit/{method}', 'emailConfigEdit')->name('email.config.edit');
                Route::post('email-config/update/{method}', 'emailConfigUpdate')->name('email.config.update');
                Route::post('email-config/set-as-default/{method}', 'emailSetAsDefault')->name('email.set.default');
                Route::post('test.email', 'testEmail')->name('test.email');
            });

            Route::controller(NotificationTemplateController::class)->group(function () {
                Route::match(['get', 'post'], 'default-template', 'defaultTemplate')->name('email.template.default');
                Route::get('email-templates', 'emailTemplates')->name('email.templates');
                Route::get('email-template/edit/{id}', 'editEmailTemplate')->name('email.template.edit');
                Route::put('email-template/{id?}/{language_id}', 'updateEmailTemplate')->name('email.template.update');

                Route::get('sms-templates', 'smsTemplates')->name('sms.templates');
                Route::get('sms-template/edit/{id}', 'editSmsTemplate')->name('sms.template.edit');
                Route::put('sms-template/{id?}/{language_id}', 'updateSmsTemplate')->name('sms.template.update');

                Route::get('in-app-notification-templates', 'inAppNotificationTemplates')
                    ->name('in.app.notification.templates');
                Route::get('in-app-notification-template/edit/{id}', 'editInAppNotificationTemplate')
                    ->name('in.app.notification.template.edit');
                Route::put('in-app-notification-template/{id?}/{language_id}', 'updateInAppNotificationTemplate')
                    ->name('in.app.notification.template.update');
                Route::get('push-notification-templates', 'pushNotificationTemplates')->name('push.notification.templates');
                Route::get('push-notification-template/edit/{id}', 'editPushNotificationTemplate')->name('push.notification.template.edit');
                Route::put('push-notification-template/{id?}/{language_id}', 'updatePushNotificationTemplate')->name('push.notification.template.update');
            });

            Route::controller(SmsConfigController::class)->group(function () {
                Route::get('sms-configuration', 'index')->name('sms.controls');
                Route::get('sms-config-edit/{method}', 'smsConfigEdit')->name('sms.config.edit');
                Route::post('sms-config-update/{method}', 'smsConfigUpdate')->name('sms.config.update');
                Route::post('sms-method-update/{method}', 'manualSmsMethodUpdate')->name('manual.sms.method.update');
                Route::post('sms-config/set-as-default/{method}', 'smsSetAsDefault')->name('sms.set.default');
            });

            Route::controller(PluginController::class)->group(function () {
                Route::get('plugin', 'pluginConfig')->name('plugin.config');
                Route::get('plugin/tawk', 'tawkConfiguration')->name('tawk.configuration');
                Route::post('plugin/tawk/Configuration/update', 'tawkConfigurationUpdate')->name('tawk.configuration.update');
                Route::get('plugin/fb-messenger-configuration', 'fbMessengerConfiguration')->name('fb.messenger.configuration');
                Route::post('plugin/fb-messenger-configuration/update', 'fbMessengerConfigurationUpdate')->name('fb.messenger.configuration.update');
                Route::get('plugin/google-recaptcha', 'googleRecaptchaConfiguration')->name('google.recaptcha.configuration');
                Route::post('plugin/google-recaptcha/update', 'googleRecaptchaConfigurationUpdate')->name('google.recaptcha.Configuration.update');
                Route::get('plugin/google-analytics', 'googleAnalyticsConfiguration')->name('google.analytics.configuration');
                Route::post('plugin/google-analytics', 'googleAnalyticsConfigurationUpdate')->name('google.analytics.configuration.update');
                Route::get('plugin/manual-recaptcha', 'manualRecaptcha')->name('manual.recaptcha');
                Route::post('plugin/manual-recaptcha/update', 'manualRecaptchaUpdate')->name('manual.recaptcha.update');
                Route::post('plugin/active-recaptcha', 'activeRecaptcha')->name('active.recaptcha');
            });

            Route::controller(TranslateAPISettingController::class)->group(function () {
                Route::get('translate-api-setting', 'translateAPISetting')->name('translate.api.setting');
                Route::get('translate-api-config/edit/{method}', 'translateAPISettingEdit')->name('translate.api.config.edit');
                Route::post('translate-api-setting/update/{method}', 'translateAPISettingUpdate')->name('translate.api.setting.update');
                Route::post('translate-api-setting/set-as-default/{method}', 'translateSetAsDefault')->name('translate.set.default');
            });

            Route::controller(LanguageController::class)->group(function () {
                Route::get('languages', 'index')->name('language.index');
                Route::get('language/create', 'create')->name('language.create');
                Route::post('language/store', 'store')->name('language.store');
                Route::get('language/edit/{id}', 'edit')->name('language.edit');
                Route::put('language/update/{id}', 'update')->name('language.update');
                Route::delete('language-delete/{id}', 'destroy')->name('language.delete');
                Route::put('change-language-status/{id}', 'changeStatus')->name('change.language.status');


                Route::get('{short_name}/keywords', 'keywords')->name('language.keywords');
                Route::post('language-keyword/{short_name}', 'addKeyword')->name('add.language.keyword');
                Route::put('language-keyword/{short_name}/{key}', 'updateKeyword')->name('update.language.keyword');
                Route::delete('language-keyword/{short_name}/{key}', 'deleteKeyword')->name('delete.language.keyword');
                Route::post('language-import-json', 'importJson')->name('language.import.json');
                Route::put('update-key/{language}', 'updateKey')->name('language.update.key');
                Route::post('language/keyword/translate', 'singleKeywordTranslate')->name('single.keyword.translate');
                Route::post('language/all-keyword/translate/{shortName}', 'allKeywordTranslate')->name('all.keyword.translate');
            });
        });

        Route::middleware(['permission:Support Ticket'])->group(function () {
            Route::controller(SupportTicketController::class)->group(function () {
                Route::get('tickets/{status?}', 'tickets')->name('ticket');
                Route::get('tickets-search/{status}', 'ticketSearch')->name('ticket.search');
                Route::get('tickets-view/{id}', 'ticketView')->name('ticket.view');
                Route::put('ticket-reply/{id}', 'ticketReplySend')->name('ticket.reply');
                Route::get('ticket-download/{ticket}', 'ticketDownload')->name('ticket.download');
                Route::post('ticket-closed/{id}', 'ticketClosed')->name('ticket.closed');
                Route::post('ticket-delete', 'ticketDelete')->name('ticket.delete');
            });
        });

        Route::controller(InAppNotificationController::class)->group(function () {
            Route::get('push-notification-show', 'showByAdmin')->name('push.notification.show');
            Route::get('push.notification.readAll', 'readAllByAdmin')->name('push.notification.readAll');
            Route::get('push-notification-readAt/{id}', 'readAt')->name('push.notification.readAt');
        });

        Route::middleware(['permission:Payment Methods'])->group(function () {
            Route::controller(PaymentMethodController::class)->group(function () {
                Route::get('payment-methods', 'index')->name('payment.methods');
                Route::get('edit-payment-methods/{id}', 'edit')->name('edit.payment.methods');
                Route::put('update-payment-methods/{id}', 'update')->name('update.payment.methods');
                Route::post('sort-payment-methods', 'sortPaymentMethods')->name('sort.payment.methods');
                Route::post('payment-methods/deactivate', 'deactivate')->name('payment.methods.deactivate');
            });

            Route::controller(ManualGatewayController::class)->group(function () {
                Route::get('payment-methods/manual', 'index')->name('deposit.manual.index');
                Route::get('payment-methods/manual/create', 'create')->name('deposit.manual.create');
                Route::post('payment-methods/manual/store', 'store')->name('deposit.manual.store');
                Route::get('payment-methods/manual/edit/{id}', 'edit')->name('deposit.manual.edit');
                Route::put('payment-methods/manual/update/{id}', 'update')->name('deposit.manual.update');
            });
        });

        Route::match(['get', 'post'], 'currency-exchange-api-config', [BasicControlController::class, 'currencyExchangeApiConfig'])->name('currency.exchange.api.config');


        Route::middleware(['permission:Website Management'])->group(function () {
            Route::controller(PageController::class)->group(function () {
                Route::get('frontend/pages/{theme}', 'index')->name('page.index');
                Route::get('frontend/create-page/{theme}', 'create')->name('create.page');
                Route::post('frontend/create-page/store/{theme}', 'store')->name('create.page.store');
                Route::get('frontend/edit-page/{id}/{theme}/{language?}', 'edit')->name('edit.page');
                Route::post('frontend/update-page/{id}/{theme}', 'update')->name('update.page');
                Route::post('frontend/page/update-slug', 'updateSlug')->name('update.slug');
                Route::delete('frontend/page/delete/{id}', 'delete')->name('page.delete');

                Route::get('frontend/edit-static-page/{id}/{theme}/{language?}', 'editStaticPage')->name('edit.static.page');
                Route::post('frontend/update-static-page/{id}/{theme}', 'updateStaticPage')->name('update.static.page');

                Route::get('frontend/page/seo/{id}', 'pageSEO')->name('page.seo');
                Route::post('frontend/page/seo/update/{id}', 'pageSeoUpdate')->name('page.seo.update');
            });

            Route::controller(ManageMenuController::class)->group(function () {
                Route::get('frontend/manage-menu', 'manageMenu')->name('manage.menu');
                Route::post('frontend/header-menu-item/store', 'headerMenuItemStore')->name('header.menu.item.store');
                Route::post('frontend/footer-menu-item/store', 'footerMenuItemStore')->name('footer.menu.item.store');
                Route::post('frontend/manage-menu/add-custom-link', 'addCustomLink')->name('add.custom.link');
                Route::get('frontend/manage-menu/edit-custom-link/{pageId}', 'editCustomLink')->name('edit.custom.link');
                Route::post('frontend/manage-menu/update-custom-link/{pageId}', 'updateCustomLink')->name('update.custom.link');
                Route::delete('frontend/manage-menu/delete-custom-link/{pageId}', 'deleteCustomLink')->name('delete.custom.link');
                Route::get('frontend/manage-menu/get-custom-link-data', 'getCustomLinkData')->name('get.custom.link');
            });

            Route::controller(ContentController::class)->group(function () {
                Route::get('frontend/contents/{name}', 'index')->name('manage.content');
                Route::post('frontend/contents/store/{name}/{language}', 'store')->name('content.store');
                Route::get('frontend/contents/item/{name}', 'manageContentMultiple')->name('manage.content.multiple');
                Route::post('frontend/contents/item/store/{name}/{language}', 'manageContentMultipleStore')->name('content.multiple.store');
                Route::get('frontend/contents/item/edit/{name}/{id}', 'multipleContentItemEdit')->name('content.item.edit');
                Route::post('frontend/contents/item/update/{name}/{id}/{language}', 'multipleContentItemUpdate')->name('multiple.content.item.update');
                Route::delete('frontend/contents/delete/{id}', 'ContentDelete')->name('content.item.delete');
            });
        });

        Route::middleware(['permission:User Management'])->group(function () {
            Route::controller(UsersController::class)->group(function () {
                Route::get('login/as/user/{id}', 'loginAsUser')->name('login.as.user');
                Route::post('block-profile/{id}', 'blockProfile')->name('block.profile');
                Route::get('users', 'index')->name('users');
                Route::get('user/edit/{id}', 'userEdit')->name('user.edit');
                Route::get('users/search', 'search')->name('users.search');

                Route::post('users-delete-multiple', 'deleteMultiple')->name('user.delete.multiple');
                Route::post('user/update/{id}', 'userUpdate')->name('user.update');
                Route::post('user/email/{id}', 'EmailUpdate')->name('user.email.update');
                Route::post('user/username/{id}', 'usernameUpdate')->name('user.username.update');
                Route::post('user/update-balance/{id}', 'updateBalanceUpdate')->name('user.update.balance');
                Route::post('user/password/{id}', 'passwordUpdate')->name('user.password.update');
                Route::post('user/preferences/{id}', 'preferencesUpdate')->name('user.preferences.update');
                Route::post('user/two-fa-security/{id}', 'userTwoFaUpdate')->name('user.twoFa.update');
                Route::post('user/balance-update/{id}', 'userBalanceUpdate')->name('user-balance-update');

                Route::get('user/send-email/{id}', 'sendEmail')->name('send.email');
                Route::post('user/send-email/{id?}', 'sendMailUser')->name('user.email.send');
                Route::get('mail-all-user', 'mailAllUser')->name('mail.all.user');

                Route::get('user/order/top-up/{id}', 'topUpOrder')->name('user.topUpOrder.list');
                Route::get('user/order/top-up/search/{id}', 'topUpOrderSearch')->name('user.topUpOrder.search');

                Route::get('user/order/card/{id}', 'cardOrder')->name('user.cardOrder.list');
                Route::get('user/order/card/search/{id}', 'cardOrderSearch')->name('user.cardOrder.search');

                Route::get('user/activity/{id}', 'specificActivity')->name('user.specific.activity');
                Route::get('user/activity/search/{id}', 'specificActivitySearch')->name('user.specific.activity.search');

                Route::get('user/transaction/{id}', 'transaction')->name('user.transaction');
                Route::get('user/transaction/search/{id}', 'userTransactionSearch')->name('user.transaction.search');

                Route::get('user/payment/{id}', 'payment')->name('user.payment');
                Route::get('user/payment/search/{id}', 'userPaymentSearch')->name('user.payment.search');

                Route::get('user/withdraw/{id}', 'payout')->name('user.payout');
                Route::get('user/withdraw/search/{id}', 'userPayoutSearch')->name('user.payout.search');

                Route::get('/email-send', 'emailToUsers')->name('email-send');
                Route::post('/email-send', 'sendEmailToUsers')->name('email-send.store');
                Route::delete('user/delete/{id}', 'userDelete')->name('user.delete');

                Route::get('users/add', 'userAdd')->name('users.add');
                Route::post('users/store', 'userStore')->name('user.store');
                Route::get('users/added-successfully/{id}', 'userCreateSuccessMessage')
                    ->name('user.create.success.message');
                Route::get('user/view-profile/{id}', 'userViewProfile')->name('user.view.profile');
                Route::get('user/kyc/{id}', 'userKyc')->name('user.kyc.list');
                Route::get('user/kyc/search/{id}', 'KycSearch')->name('user.kyc.search');

                Route::get('users/count-data', 'countData')->name('users.search.countData');
            });
        });

        Route::middleware(['permission:All Transactions'])->group(function () {
            Route::controller(TransactionLogController::class)->group(function () {
                Route::get('transaction', 'transaction')->name('transaction');
                Route::get('transaction/search', 'transactionSearch')->name('transaction.search');
            });

            Route::controller(PaymentLogController::class)->group(function () {
                Route::get('payment/log', 'index')->name('payment.log');
                Route::get('payment/search', 'search')->name('payment.search');
                Route::get('payment/pending', 'pending')->name('payment.pending');
                Route::get('payment/pending/request', 'paymentRequest')->name('payment.request');
                Route::put('payment/action/{id}', 'action')->name('payment.action');
            });
        });

        Route::middleware(['permission:All Marketing'])->group(function () {
            //SUBSCRIBERS
            Route::controller(SubscribeController::class)->group(function () {
                Route::get('subscribe', 'index')->name('subscribe');
                Route::get('subscribe-search', 'subscribeSearch')->name('subscribe.search');
            });
        });

        Route::middleware(['permission:Website Management'])->group(function () {
            /* ====== Blog Category Controller =====*/
            Route::resource('blog-category', BlogCategoryController::class);
            Route::resource('blogs', BlogController::class);
            Route::get('blogs/edit/{id}/{language}', [BlogController::class, 'blogEdit'])->name('blog.edit');
            Route::post('blogs/update/{id}/{language}', [BlogController::class, 'blogUpdate'])->name('blog.update');
            Route::post('blogs/slug/update', [BlogController::class, 'slugUpdate'])->name('slug.update');
            Route::get('blogs/seo-page/{id}', [BlogController::class, 'blogSeo'])->name('blog.seo');
            Route::post('blogs/seo-update/{id}', [BlogController::class, 'blogSeoUpdate'])->name('blog.seo.update');
            Route::any('blog/{id}/status', [BlogController::class, 'status'])->name('blog.status');
            Route::any('blog-category/{id}/status', [BlogCategoryController::class, 'status'])->name('blog-category.status');
        });

        /* ===== ADMIN TEMPLATE SETTINGS ===== */
        Route::get('template', [TempleteController::class, 'index'])->name('template.all');
        Route::any('template/select', [TempleteController::class, 'selectTemplete'])->name('select.template');

        /* ===== SOCIALITE ===== */
        Route::get('socialite', [SocialiteController::class, 'index'])->name('socialite.index');
        Route::match(['get', 'post'], 'google-config', [SocialiteController::class, 'googleConfig'])->name('google.control');
        Route::match(['get', 'post'], 'facebook-config', [SocialiteController::class, 'facebookConfig'])->name('facebook.control');
        Route::match(['get', 'post'], 'github-config', [SocialiteController::class, 'githubConfig'])->name('github.control');

        /* ===== ADMIN COOKIE POLICY SETTING ===== */
        Route::get('cookie-policy-setting', [CookiePolicyController::class, 'cookiePolicySetting'])->name('cookiePolicy.setting');
        Route::post('cookie-policy-update', [CookiePolicyController::class, 'cookiePolicyUpdate'])->name('cookiePolicy.update');

        /*= MANAGE KYC =*/
        Route::controller(KycController::class)->group(function () {
            Route::get('kyc-setting/list', 'index')->name('kyc.form.list');
            Route::get('kyc-setting/create', 'create')->name('kyc.create');
            Route::post('manage-kyc/store', 'store')->name('kyc.store');
            Route::get('manage-kyc/edit/{id}', 'edit')->name('kyc.edit');
            Route::post('manage-kyc/update/{id}', 'update')->name('kyc.update');
            Route::get('kyc/{status?}', 'userKycList')->name('kyc.list');
            Route::get('kyc/search/{status?}', 'userKycSearch')->name('kyc.search');
            Route::get('kyc/view/{id}', 'view')->name('kyc.view');
            Route::post('user/kyc/action/{id}', 'action')->name('kyc.action');
            Route::get('user/kyc-search', 'searchKyc')->name('userKyc.search');
            Route::post('kyc/isMandatory', 'kycIsMandatory')->name('kycIsMandatory');
        });


        Route::controller(PayoutMethodController::class)->group(function () {
            Route::get('withdraw-methods/list', 'index')->name('payout.method.list');
            Route::get('withdraw-methods/create', 'create')->name('payout.method.create');
            Route::post('withdraw-methods/store', 'store')->name('payout.method.store');
            Route::get('withdraw-methods/manual/edit/{id}', 'manualEdit')->name('payout.manual.method.edit');
            Route::get('withdraw-methods/edit/{id}', 'edit')->name('payout.method.edit');
            Route::put('withdraw-methods/update/{id}', 'update')->name('payout.method.update');
            Route::post('withdraw-methods/auto-update/{id}', 'autoUpdate')->name('payout.method.auto.update');
            Route::post('withdraw-methods/active-deactivate', 'activeDeactivate')->name('payout.active.deactivate');
            Route::get('withdraw-methods/days/setting', 'withdrawDays')->name('payout.withdraw.days');
            Route::post('withdraw-methods/days/setting', 'withdrawDaysUpdate')->name('withdrawal.days.update');
        });


        Route::controller(PayoutLogController::class)->group(function () {
            Route::get('withdraw/log', 'index')->name('payout.log');
            Route::get('withdraw/search', 'search')->name('payout.search');
            Route::get('withdraw/pending', 'pending')->name('payout.pending');
            Route::put('withdraw/action', 'action')->name('payout.action');
        });

        Route::any('app-control', [BasicControlController::class, 'appControl'])->name('app.control');

        Route::post('basic-control-table-view-update', [BasicControlController::class, 'basicControlTableViewUpdate'])->name('basic.control.table.update');
    });
});


