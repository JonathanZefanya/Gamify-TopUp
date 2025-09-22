<!-- Navbar Vertical -->
<aside
    class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-vertical-aside-initialized
    {{in_array(session()->get('themeMode'), [null, 'auto'] )?  'navbar-dark bg-dark ' : 'navbar-light bg-white'}}">
    <div class="navbar-vertical-container">
        <div class="navbar-vertical-footer-offset">
            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}" aria-label="{{ $basicControl->site_title }}">
                <img class="navbar-brand-logo navbar-brand-logo-auto"
                     src="{{ getFile(session()->get('themeMode') == 'auto'?$basicControl->admin_dark_mode_logo_driver : $basicControl->admin_logo_driver, session()->get('themeMode') == 'auto'?$basicControl->admin_dark_mode_logo:$basicControl->admin_logo, true) }}"
                     alt="{{ $basicControl->site_title }} Logo"
                     data-hs-theme-appearance="default">

                <img class="navbar-brand-logo"
                     src="{{ getFile($basicControl->admin_dark_mode_logo_driver, $basicControl->admin_dark_mode_logo, true) }}"
                     alt="{{ $basicControl->site_title }} Logo"
                     data-hs-theme-appearance="dark">

                <img class="navbar-brand-logo-mini"
                     src="{{ getFile($basicControl->favicon_driver, $basicControl->favicon, true) }}"
                     alt="{{ $basicControl->site_title }} Logo"
                     data-hs-theme-appearance="default">
                <img class="navbar-brand-logo-mini"
                     src="{{ getFile($basicControl->favicon_driver, $basicControl->favicon, true) }}"
                     alt="Logo"
                     data-hs-theme-appearance="dark">
            </a>
            <!-- End Logo -->

            <!-- Navbar Vertical Toggle -->
            <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
                <i class="bi-arrow-bar-left navbar-toggler-short-align"
                   data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                   data-bs-toggle="tooltip"
                   data-bs-placement="right"
                   title="Collapse">
                </i>
                <i
                    class="bi-arrow-bar-right navbar-toggler-full-align"
                    data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                    data-bs-toggle="tooltip"
                    data-bs-placement="right"
                    title="Expand"
                ></i>
            </button>
            <!-- End Navbar Vertical Toggle -->

            <!-- Content -->
            <div class="navbar-vertical-content">
                <div id="navbarVerticalMenu" class="nav nav-pills nav-vertical card-navbar-nav">

                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.dashboard']) }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="bi-house-door nav-icon"></i>
                            <span class="nav-link-title">@lang("Dashboard")</span>
                        </a>
                    </div>

                    @if(adminAccessRoute('Manage Staff'))
                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.role.staff']) }}"
                               href="{{ route('admin.role.staff') }}">
                                <i class="fa-light fa-user nav-icon"></i>
                                <span class="nav-link-title">@lang("Manage Staff")</span>
                            </a>
                        </div>

                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.role']) }}"
                               href="{{ route('admin.role') }}" data-placement="left">
                                <i class="fa-light fa-users-gear nav-icon"></i>
                                <span class="nav-link-title">@lang('Role & Permission')</span>
                            </a>
                        </div>
                    @endif


                    @if(adminAccessRoute('Card'))
                        <span class="dropdown-header mt-2">@lang('Cards')</span>
                        <small class="bi-three-dots nav-subtitle-replacer"></small>
                        <div class="nav-item">
                            <a class="nav-link {{ request()->query('type') == 'card'? 'active' : '' }}"
                               href="{{ route('admin.categoryList').'?type=card' }}" data-placement="left">
                                <i class="fas fa-tags nav-icon"></i>
                                <span class="nav-link-title">@lang("Category")</span>
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.card.list','admin.card.store','admin.card.edit',
                           'admin.cardService.list','admin.cardServiceCode.list']) }}"
                               href="{{ route('admin.card.list') }}" data-placement="left">
                                <i class="fas fa-vr-cardboard nav-icon"></i>
                                <span class="nav-link-title">@lang("Card")</span>
                            </a>
                        </div>
                    @endif

                    @if(adminAccessRoute('Direct Top Up'))
                        <span class="dropdown-header mt-2">@lang('Direct Top Up')</span>
                        <small class="bi-three-dots nav-subtitle-replacer"></small>
                        <div class="nav-item">
                            <a class="nav-link {{ request()->query('type') == 'top_up'? 'active' : '' }}"
                               href="{{ route('admin.categoryList').'?type=top_up' }}" data-placement="left">
                                <i class="fas fa-tags nav-icon"></i>
                                <span class="nav-link-title">@lang("Category")</span>
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.topUpList','admin.topUpStore','admin.topUpEdit','admin.topUpService.list']) }}"
                               href="{{ route('admin.topUpList') }}" data-placement="left">
                                <i class="fas fa-shield-alt nav-icon"></i>
                                <span class="nav-link-title">@lang("Top Up")</span>
                            </a>
                        </div>
                    @endif

                    @if(adminAccessRoute('All Orders'))
                        <span class="dropdown-header mt-2"> @lang("Orders")</span>
                        <small class="bi-three-dots nav-subtitle-replacer"></small>
                        <div class="nav-item">
                            <a class="nav-link dropdown-toggle {{ menuActive(['admin.orderTopUp.list','admin.orderTopUp.view'], 3) }}"
                               href="#navbarVerticalOrderMenu"
                               role="button"
                               data-bs-toggle="collapse"
                               data-bs-target="#navbarVerticalOrderMenu"
                               aria-expanded="false"
                               aria-controls="navbarVerticalOrderMenu">
                                <i class="fa-light fas fa-shield-alt nav-icon"></i>
                                <span class="nav-link-title">@lang("Top Up Order")</span>
                            </a>
                            <div id="navbarVerticalOrderMenu"
                                 class="nav-collapse collapse {{ menuActive(['admin.orderTopUp.list','admin.orderTopUp.view'], 2) }}"
                                 data-bs-parent="#navbarVerticalOrderMenu">
                                <a class="nav-link {{(request()->routeIs('admin.orderTopUp.list') && @request()->type == 'all') ? 'active':''}}"
                                   href="{{ route('admin.orderTopUp.list').'?type=all' }}">@lang("All Orders")
                                </a>
                                <a class="nav-link {{(request()->routeIs('admin.orderTopUp.list') && @request()->type == 'pending') ? 'active':''}}"
                                   href="{{ route('admin.orderTopUp.list').'?type=pending' }}">@lang("Pending Orders")</a>
                                <a class="nav-link {{(request()->routeIs('admin.orderTopUp.list') && @request()->type == 'complete') ? 'active':''}}"
                                   href="{{ route('admin.orderTopUp.list').'?type=complete' }}">@lang("Complete Orders")</a>
                                <a class="nav-link {{(request()->routeIs('admin.orderTopUp.list') && @request()->type == 'refund') ? 'active':''}}"
                                   href="{{ route('admin.orderTopUp.list').'?type=refund' }}">@lang("Refund Orders")</a>
                            </div>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link dropdown-toggle {{ menuActive(['admin.orderCard.list','admin.orderCard.view'], 3) }}"
                               href="#navbarVerticalCardOrderMenu"
                               role="button"
                               data-bs-toggle="collapse"
                               data-bs-target="#navbarVerticalCardOrderMenu"
                               aria-expanded="false"
                               aria-controls="navbarVerticalCardOrderMenu">
                                <i class="fa-light fas fa-vr-cardboard nav-icon nav-icon"></i>
                                <span class="nav-link-title">@lang("Card Order")</span>
                            </a>
                            <div id="navbarVerticalCardOrderMenu"
                                 class="nav-collapse collapse {{ menuActive(['admin.orderCard.list','admin.orderCard.view'], 2) }}"
                                 data-bs-parent="#navbarVerticalCardOrderMenu">
                                <a class="nav-link {{(request()->routeIs('admin.orderCard.list') && @request()->type == 'all') ? 'active':''}}"
                                   href="{{ route('admin.orderCard.list').'?type=all' }}">@lang("All Orders")
                                </a>
                                <a class="nav-link {{(request()->routeIs('admin.orderCard.list') && @request()->type == 'pending') ? 'active':''}}"
                                   href="{{ route('admin.orderCard.list').'?type=pending' }}">@lang("Pending Orders")</a>
                                <a class="nav-link {{(request()->routeIs('admin.orderCard.list') && @request()->type == 'complete') ? 'active':''}}"
                                   href="{{ route('admin.orderCard.list').'?type=complete' }}">@lang("Complete Orders")</a>
                                <a class="nav-link {{(request()->routeIs('admin.orderCard.list') && @request()->type == 'refund') ? 'active':''}}"
                                   href="{{ route('admin.orderCard.list').'?type=refund' }}">@lang("Refund Orders")</a>
                            </div>
                        </div>
                    @endif

                    @if($basicControl->sell_post == 1)
                        <span class="dropdown-header mt-2"> @lang("Sell Post")</span>
                        <small class="bi-three-dots nav-subtitle-replacer"></small>
                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.sellPostCategory*']) }}"
                               href="{{ route('admin.sellPostCategory') }}" data-placement="left">
                                <i class="fa-light fa-bullhorn nav-icon"></i>
                                <span class="nav-link-title">@lang("Sell Category")</span>
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link dropdown-toggle {{ menuActive(['admin.gameSellList','admin.sell.details','admin.sellPost.conversation'], 3) }}"
                               href="#navbarVerticalSellPostMenu"
                               role="button"
                               data-bs-toggle="collapse"
                               data-bs-target="#navbarVerticalSellPostMenu"
                               aria-expanded="false"
                               aria-controls="navbarVerticalSellPostMenu">
                                <i class="bi bi-graph-up-arrow nav-icon"></i>
                                <span class="nav-link-title">@lang("Selling Post")</span>
                            </a>
                            <div id="navbarVerticalSellPostMenu"
                                 class="nav-collapse collapse {{ menuActive(['admin.gameSellList','admin.sell.details','admin.sellPost.conversation'], 2) }}"
                                 data-bs-parent="#navbarVerticalSellPostMenu">
                                <a class="nav-link {{last(request()->segments()) == 'approval' ? 'active':''}}"
                                   href="{{ route('admin.gameSellList','approval')}}">@lang("Approval")</a>

                                <a class="nav-link {{last(request()->segments()) == 'pending' ? 'active':''}}"
                                   href="{{ route('admin.gameSellList','pending')}}">@lang("Pending")</a>

                                <a class="nav-link {{last(request()->segments()) == 'resubmission' ? 'active':''}}"
                                   href="{{ route('admin.gameSellList','resubmission')}}">@lang("Resubmission")</a>

                                <a class="nav-link {{last(request()->segments()) == 'hold' ? 'active':''}}"
                                   href="{{ route('admin.gameSellList','hold')}}">@lang("Hold")</a>

                                <a class="nav-link {{last(request()->segments()) == 'soft-reject' ? 'active':''}}"
                                   href="{{ route('admin.gameSellList','soft-reject')}}">@lang("Soft Rejected")</a>

                                <a class="nav-link {{last(request()->segments()) == 'hard-reject' ? 'active':''}}"
                                   href="{{ route('admin.gameSellList','hard-reject')}}">@lang("Hard Rejected")</a>

                            </div>
                        </div>

                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.postSell*']) }}"
                               href="{{ route('admin.postSell') }}" data-placement="left">
                                <i class="fa-light fa-newspaper nav-icon"></i>
                                <span class="nav-link-title">@lang("Sold Post")</span>
                            </a>
                        </div>
                    @endif


                    @if(adminAccessRoute('All Transactions'))
                        <span class="dropdown-header mt-2">@lang('Transactions')</span>
                        <small class="bi-three-dots nav-subtitle-replacer"></small>
                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.transaction']) }}"
                               href="{{ route('admin.transaction') }}" data-placement="left">
                                <i class="bi bi-send nav-icon"></i>
                                <span class="nav-link-title">@lang("Transaction")</span>
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.payout.log']) }}"
                               href="{{ route('admin.payout.log') }}" data-placement="left">
                                <i class="bi bi-wallet2 nav-icon "></i>
                                <span class="nav-link-title">@lang("Withdraw Log")</span>
                            </a>
                        </div>

                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.payment.log']) }}"
                               href="{{ route('admin.payment.log') }}" data-placement="left">
                                <i class="bi bi-credit-card-2-front nav-icon"></i>
                                <span class="nav-link-title">@lang("Payment Log")</span>
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.payment.pending']) }}"
                               href="{{ route('admin.payment.pending') }}" data-placement="left">
                                <i class="bi bi-cash nav-icon"></i>
                                <span class="nav-link-title">@lang("Payment Request")</span>
                            </a>
                        </div>
                    @endif

                    @if(adminAccessRoute('All Marketing'))
                        <span class="dropdown-header mt-2">@lang('Marketing')</span>
                        <small class="bi-three-dots nav-subtitle-replacer"></small>
                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.campaign.view']) }}"
                               href="{{ route('admin.campaign.view') }}" data-placement="left">
                                <i class="fa-light fa-bullhorn nav-icon"></i>
                                <span class="nav-link-title">@lang("Campaign")</span>
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.couponList','admin.couponStore','admin.couponEdit']) }}"
                               href="{{ route('admin.couponList') }}" data-placement="left">
                                <i class="fa-light fa-percent nav-icon"></i>
                                <span class="nav-link-title">@lang("Coupon")</span>
                            </a>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.review.list']) }}"
                               href="{{ route('admin.review.list') }}" data-placement="left">
                                <i class="bi bi-emoji-smile nav-icon"></i>
                                <span class="nav-link-title">@lang("Review")</span>
                            </a>
                        </div>
                    @endif


                    @if(adminAccessRoute('Support Ticket'))
                        <span class="dropdown-header mt-2"> @lang("Ticket Panel")</span>
                        <small class="bi-three-dots nav-subtitle-replacer"></small>
                        <div class="nav-item">
                            <a class="nav-link dropdown-toggle {{ menuActive(['admin.ticket', 'admin.ticket.search', 'admin.ticket.view'], 3) }}"
                               href="#navbarVerticalTicketMenu"
                               role="button"
                               data-bs-toggle="collapse"
                               data-bs-target="#navbarVerticalTicketMenu"
                               aria-expanded="false"
                               aria-controls="navbarVerticalTicketMenu">
                                <i class="fa-light fa-headset nav-icon"></i>
                                <span class="nav-link-title">@lang("Support Ticket")</span>
                            </a>
                            <div id="navbarVerticalTicketMenu"
                                 class="nav-collapse collapse {{ menuActive(['admin.ticket','admin.ticket.search', 'admin.ticket.view'], 2) }}"
                                 data-bs-parent="#navbarVerticalTicketMenu">
                                <a class="nav-link {{ request()->is('admin/tickets/all') ? 'active' : '' }}"
                                   href="{{ route('admin.ticket', 'all') }}">@lang("All Tickets")
                                </a>
                                <a class="nav-link {{ request()->is('admin/tickets/answered') ? 'active' : '' }}"
                                   href="{{ route('admin.ticket', 'answered') }}">@lang("Answered Ticket")</a>
                                <a class="nav-link {{ request()->is('admin/tickets/replied') ? 'active' : '' }}"
                                   href="{{ route('admin.ticket', 'replied') }}">@lang("Replied Ticket")</a>
                                <a class="nav-link {{ request()->is('admin/tickets/closed') ? 'active' : '' }}"
                                   href="{{ route('admin.ticket', 'closed') }}">@lang("Closed Ticket")</a>
                            </div>
                        </div>
                    @endif

                    <span class="dropdown-header mt-2"> @lang('Kyc Management')</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['admin.kyc.form.list','admin.kyc.edit','admin.kyc.create']) }}"
                           href="{{ route('admin.kyc.form.list') }}" data-placement="left">
                            <i class="bi-stickies nav-icon"></i>
                            <span class="nav-link-title">@lang('KYC Setting')</span>
                        </a>
                    </div>

                    <div class="nav-item" {{ menuActive(['admin.kyc.list*','admin.kyc.view'], 3) }}>
                        <a class="nav-link dropdown-toggle collapsed" href="#navbarVerticalKycRequestMenu"
                           role="button"
                           data-bs-toggle="collapse" data-bs-target="#navbarVerticalKycRequestMenu"
                           aria-expanded="false"
                           aria-controls="navbarVerticalKycRequestMenu">
                            <i class="bi bi-person-lines-fill nav-icon"></i>
                            <span class="nav-link-title">@lang("KYC Request")</span>
                        </a>
                        <div id="navbarVerticalKycRequestMenu"
                             class="nav-collapse collapse {{ menuActive(['admin.kyc.list*','admin.kyc.view'], 2) }}"
                             data-bs-parent="#navbarVerticalKycRequestMenu">

                            <a class="nav-link {{ Request::is('admin/kyc/pending') ? 'active' : '' }}"
                               href="{{ route('admin.kyc.list', 'pending') }}">
                                @lang('Pending KYC')
                            </a>
                            <a class="nav-link {{ Request::is('admin/kyc/approve') ? 'active' : '' }}"
                               href="{{ route('admin.kyc.list', 'approve') }}">
                                @lang('Approved KYC')
                            </a>
                            <a class="nav-link {{ Request::is('admin/kyc/rejected') ? 'active' : '' }}"
                               href="{{ route('admin.kyc.list', 'rejected') }}">
                                @lang('Rejected KYC')
                            </a>
                        </div>
                    </div>

                    @if(adminAccessRoute('User Management'))
                        <span class="dropdown-header mt-2"> @lang("User Panel")</span>
                        <small class="bi-three-dots nav-subtitle-replacer"></small>

                        <div class="nav-item">
                            <a class="nav-link dropdown-toggle {{ menuActive(['admin.users'], 3) }}"
                               href="#navbarVerticalUserPanelMenu"
                               role="button"
                               data-bs-toggle="collapse"
                               data-bs-target="#navbarVerticalUserPanelMenu"
                               aria-expanded="false"
                               aria-controls="navbarVerticalUserPanelMenu">
                                <i class="bi-people nav-icon"></i>
                                <span class="nav-link-title">@lang('User Management')</span>
                            </a>
                            <div id="navbarVerticalUserPanelMenu"
                                 class="nav-collapse collapse {{ menuActive(['admin.mail.all.user','admin.users','admin.users.add','admin.user.edit',
                                                                        'admin.user.view.profile','admin.user.transaction','admin.user.payment',
                                                                        'admin.user.payout','admin.user.kyc.list','admin.send.email'], 2) }}"
                                 data-bs-parent="#navbarVerticalUserPanelMenu">

                                <a class="nav-link d-flex justify-content-between
                             {{ request('status') === 'activeUser' ? 'active' : '' }}"
                                   href="{{ route('admin.users', ['status' => 'activeUser']) }}">
                                    <span class="nav-link-title">@lang('Active User')</span>
                                </a>
                                <a class="nav-link d-flex justify-content-between {{ request('status') === 'blocked' ? 'active' : '' }}"
                                   href="{{ route('admin.users', ['status' => 'blocked']) }}">
                                    <span class="nav-link-title">@lang('Banned User')</span> <span
                                        class="badge bg-primary rounded-pill ms-1 bannedUser"></span>
                                </a>
                                <a class="nav-link d-flex justify-content-between {{ request('status') === 'emailUnVerify' ? 'active' : '' }}"
                                   href="{{ route('admin.users',['status' => 'emailUnVerify']) }}">
                                    <span class="nav-link-title">@lang('Email Unverified')</span> <span
                                        class="badge bg-primary rounded-pill ms-1 emailUnverified"></span>
                                </a>
                                <a class="nav-link d-flex justify-content-between {{ request('status') === 'smsUnVerify' ? 'active' : '' }}"
                                   href="{{ route('admin.users' ,['status' => 'smsUnVerify']) }}">
                                    <span class="nav-link-title">@lang('Sms Unverified')</span> <span
                                        class="badge bg-primary rounded-pill ms-1 smsUnverified"></span>
                                </a>
                                <a class="nav-link d-flex justify-content-between {{ request('status') === 'withBlalnce' ? 'active' : '' }}"
                                   href="{{ route('admin.users', ['status' => 'withBlalnce']) }}">
                                    <span class="nav-link-title">@lang('With Balance')</span>
                                </a>

                                <a class="nav-link d-flex justify-content-between {{ request('status') === 'all' ? 'active' : '' }}"
                                   href="{{ route('admin.users', ['status' => 'all']) }}">
                                    <span class="nav-link-title">@lang('All User')</span>
                                </a>

                                <a class="nav-link {{ menuActive(['admin.mail.all.user']) }}"
                                   href="{{ route("admin.mail.all.user") }}">@lang('Mail To Users')</a>
                            </div>
                        </div>

                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.userActivity']) }}"
                               href="{{ route('admin.userActivity') }}" data-placement="left">
                                <i class="fal fa-waveform nav-icon"></i>
                                <span class="nav-link-title">@lang('User Activity')</span>
                            </a>
                        </div>

                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.subscribe']) }}"
                               href="{{ route('admin.subscribe') }}" data-placement="left">
                                <i class="fas fa-users nav-icon"></i>
                                <span class="nav-link-title">@lang('Subscribers')</span>
                            </a>
                        </div>
                    @endif

                    @if(adminAccessRoute('Control Panel') || adminAccessRoute('Payment Methods'))
                        <span class="dropdown-header mt-2"> @lang('SETTINGS PANEL')</span>
                        <small class="bi-three-dots nav-subtitle-replacer"></small>

                        @if(adminAccessRoute('Control Panel'))
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(controlPanelRoutes()) }}"
                                   href="{{ route('admin.settings') }}" data-placement="left">
                                    <i class="bi bi-gear nav-icon"></i>
                                    <span class="nav-link-title">@lang('Control Panel')</span>
                                </a>
                            </div>
                        @endif

                        @if(adminAccessRoute('Payment Methods'))
                            <div
                                class="nav-item {{ menuActive(['admin.payment.methods', 'admin.edit.payment.methods', 'admin.deposit.manual.index', 'admin.deposit.manual.create', 'admin.deposit.manual.edit'], 3) }}">
                                <a class="nav-link dropdown-toggle"
                                   href="#navbarVerticalGatewayMenu"
                                   role="button"
                                   data-bs-toggle="collapse"
                                   data-bs-target="#navbarVerticalGatewayMenu"
                                   aria-expanded="false"
                                   aria-controls="navbarVerticalGatewayMenu">
                                    <i class="bi-briefcase nav-icon"></i>
                                    <span class="nav-link-title">@lang('Payment Setting')</span>
                                </a>
                                <div id="navbarVerticalGatewayMenu"
                                     class="nav-collapse collapse {{ menuActive(['admin.payment.methods', 'admin.edit.payment.methods', 'admin.deposit.manual.index', 'admin.deposit.manual.create', 'admin.deposit.manual.edit'], 2) }}"
                                     data-bs-parent="#navbarVerticalGatewayMenu">

                                    <a class="nav-link {{ menuActive(['admin.payment.methods', 'admin.edit.payment.methods',]) }}"
                                       href="{{ route('admin.payment.methods') }}">@lang('Payment Gateway')</a>

                                    <a class="nav-link {{ menuActive([ 'admin.deposit.manual.index', 'admin.deposit.manual.create', 'admin.deposit.manual.edit']) }}"
                                       href="{{ route('admin.deposit.manual.index') }}">@lang('Manual Gateway')</a>
                                </div>
                            </div>
                        @endif
                    @endif

                    <div class="nav-item">
                        <a class="nav-link dropdown-toggle {{ menuActive(['admin.payout.method.list','admin.payout.method.create','admin.manual.method.edit','admin.payout.method.edit','admin.payout.withdraw.days'], 3) }}"
                           href="#navbarVerticalWithdrawMenu"
                           role="button"
                           data-bs-toggle="collapse"
                           data-bs-target="#navbarVerticalWithdrawMenu"
                           aria-expanded="false"
                           aria-controls="navbarVerticalWithdrawMenu">
                            <i class="bi bi-wallet2 nav-icon"></i>
                            <span class="nav-link-title">@lang('Withdraw Setting')</span>
                        </a>
                        <div id="navbarVerticalWithdrawMenu"
                             class="nav-collapse collapse {{ menuActive(['admin.payout.method.list','admin.payout.method.create','admin.manual.method.edit','admin.payout.method.edit','admin.payout.withdraw.days'], 2) }}"
                             data-bs-parent="#navbarVerticalWithdrawMenu">
                            <a class="nav-link {{ menuActive(['admin.payout.method.list','admin.payout.method.create','admin.manual.method.edit','admin.payout.method.edit']) }}"
                               href="{{ route('admin.payout.method.list') }}">@lang('Withdraw Method')</a>

                            <a class="nav-link  {{ menuActive(['admin.payout.withdraw.days']) }}"
                               href="{{ route("admin.payout.withdraw.days") }}">@lang('Withdrawal Days Setup')</a>
                        </div>
                    </div>


                    @if(adminAccessRoute('Website Management'))
                        <span class="dropdown-header mt-2">@lang("Themes Settings")</span>
                        <small class="bi-three-dots nav-subtitle-replacer"></small>
                        <div class="nav-item">
                            <a class="nav-link {{ menuActive(['admin.template.all']) }}"
                               href="{{ route('admin.template.all') }}"
                               data-placement="left">
                                <i class="fa-light fa-check-square nav-icon"></i>
                                <span class="nav-link-title">@lang('Choose Theme')</span>
                            </a>
                        </div>
                        <div id="navbarVerticalThemeMenu">
                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.page.index','admin.create.page','admin.edit.page']) }}"
                                   href="{{ route('admin.page.index', basicControl()->theme) }}"
                                   data-placement="left">
                                    <i class="fa-light fa-list nav-icon"></i>
                                    <span class="nav-link-title">@lang('Pages')</span>
                                </a>
                            </div>

                            <div class="nav-item">
                                <a class="nav-link {{ menuActive(['admin.manage.menu']) }}"
                                   href="{{ route('admin.manage.menu') }}" data-placement="left">
                                    <i class="bi-folder2-open nav-icon"></i>
                                    <span class="nav-link-title">@lang('Manage Menu')</span>
                                </a>
                            </div>
                        </div>

                        @php
                            $segments = request()->segments();
                            $last  = end($segments);

                            $contents = config('contents');
                            $filteredContents = [];

                            foreach ($contents as $key => $value) {
                                if (isset($value['theme']) && ($value['theme'] === $basicControl->theme || $value['theme'] === 'all')) {
                                    $filteredContents[$key] = $value;
                                }
                            }
                        @endphp
                        <div class="nav-item">
                            <a class="nav-link dropdown-toggle {{ menuActive(['admin.manage.content', 'admin.manage.content.multiple', 'admin.content.item.edit*'], 3) }}"
                               href="#navbarVerticalContentsMenu"
                               role="button" data-bs-toggle="collapse"
                               data-bs-target="#navbarVerticalContentsMenu" aria-expanded="false"
                               aria-controls="navbarVerticalContentsMenu">
                                <i class="fa-light fa-pen nav-icon"></i>
                                <span class="nav-link-title">@lang('Manage Content')</span>
                            </a>
                            <div id="navbarVerticalContentsMenu"
                                 class="content-manage nav-collapse collapse {{ menuActive(['admin.manage.content', 'admin.manage.content.multiple', 'admin.content.item.edit*'], 2) }} "
                                 data-bs-parent="#navbarVerticalContentsMenu">
                                @foreach(array_diff(array_keys($filteredContents), ['message','content_media']) as $name)
                                    @php
                                        $contentImage = config('contents.' . $name . '.preview');
                                    @endphp
                                    <div class="contentAll d-flex justify-content-between">
                                        <a class="nav-link contentTitle {{($last == $name) ? 'active' : '' }}"
                                           href="{{ route('admin.manage.content', $name) }}">@lang(stringToTitle(str_replace($basicControl->theme,'', $name)))</a>
                                        <button class="btn btn-white btn-sm sidebarContentImage contentImage"
                                                data-image="{{ json_encode($contentImage) }}"
                                                data-bs-toggle="tooltip" title="Section Style">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        <div class="nav-item">
                            <a class="nav-link dropdown-toggle {{ menuActive(['admin.blog-category.index', 'admin.blog-category.create','admin.blog-category.edit', 'admin.blogs.index', 'admin.blogs.create','admin.blogs.edit*'], 3) }}"
                               href="#navbarVerticalBlogMenu"
                               role="button" data-bs-toggle="collapse"
                               data-bs-target="#navbarVerticalBlogMenu" aria-expanded="false"
                               aria-controls="navbarVerticalBlogMenu">
                                <i class="fa-light fa-newspaper nav-icon"></i>
                                <span class="nav-link-title">@lang('Manage Blog')</span>
                            </a>
                            <div id="navbarVerticalBlogMenu"
                                 class="nav-collapse collapse {{ menuActive(['admin.blog-category.index', 'admin.blog-category.create','admin.blog-category.edit', 'admin.blogs.index', 'admin.blogs.create','admin.blogs.edit*'], 2) }}"
                                 data-bs-parent="#navbarVerticalBlogMenu">
                                <a class="nav-link {{ menuActive(['admin.blog-category.index', 'admin.blog-category.create','admin.blog-category.edit']) }}"
                                   href="{{ route('admin.blog-category.index') }}">@lang('Blog Category')</a>

                                <a class="nav-link {{ menuActive(['admin.blogs.index', 'admin.blogs.create','admin.blogs.edit*']) }}"
                                   href="{{ route('admin.blogs.index') }}">@lang('Blog')</a>
                            </div>
                        </div>
                    @endif


                    @foreach(collect(config('generalsettings.settings')) as $key => $setting)
                        <div class="nav-item d-none">
                            <a class="nav-link  {{ isMenuActive($setting['route']) }}"
                               href="{{ getRoute($setting['route'], $setting['route_segment'] ?? null) }}">
                                <i class="{{$setting['icon']}} nav-icon"></i>
                                <span class="nav-link-title">{{ __(getTitle($key.' '.'Settings')) }}</span>
                            </a>
                        </div>
                    @endforeach

                    <span class="dropdown-header mt-2"> @lang('Application Panel')</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>
                    <div class="nav-item">
                        <a class="nav-link {{ menuActive(['clear']) }}"
                           href="{{ route('clear') }}" data-placement="left">
                            <i class="fas fa-sync nav-icon"></i>
                            <span class="nav-link-title">@lang('Cache Clear')</span>
                        </a>
                    </div>

                </div>

                <div class="navbar-vertical-footer">
                    <ul class="navbar-vertical-footer-list">
                        <li class="navbar-vertical-footer-list-item">
                            <span class="dropdown-header">@lang('Version 4.0')</span>
                        </li>
                        <li class="navbar-vertical-footer-list-item">
                            <div class="dropdown dropup">
                                <button type="button" class="btn btn-ghost-secondary btn-icon rounded-circle"
                                        id="selectThemeDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                                        data-bs-dropdown-animation></button>
                                <div class="dropdown-menu navbar-dropdown-menu navbar-dropdown-menu-borderless"
                                     aria-labelledby="selectThemeDropdown">
                                    <a class="dropdown-item" href="javascript:void(0)" data-icon="bi-moon-stars"
                                       data-value="auto">
                                        <i class="bi-moon-stars me-2"></i>
                                        <span class="text-truncate"
                                              title="Auto (system default)">@lang("Default")</span>
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0)" data-icon="bi-brightness-high"
                                       data-value="default">
                                        <i class="bi-brightness-high me-2"></i>
                                        <span class="text-truncate"
                                              title="Default (light mode)">@lang("Light Mode")</span>
                                    </a>
                                    <a class="dropdown-item active" href="javascript:void(0)" data-icon="bi-moon"
                                       data-value="dark">
                                        <i class="bi-moon me-2"></i>
                                        <span class="text-truncate" title="Dark">@lang("Dark Mode")</span>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>
@push('script')
    <script src="{{ asset('assets/global/js/jquery.magnific-popup.min.js') }}" defer></script>

    <script>
        'use strict';
        const baseUrl = "{{ asset('') }}";

        function initializeMagnificPopup(imageSelector1, imageSelector2) {
            document.addEventListener('DOMContentLoaded', function () {
                const selectors = [imageSelector1, imageSelector2];
                selectors.forEach(selector => {
                    $(selector).on('click', function () {
                        let imageData = $(this).data('image');

                        let items = Object.keys(imageData).map(function (key) {
                            return {
                                src: baseUrl + imageData[key],
                                type: 'image',
                                title: key
                            };
                        });

                        $.magnificPopup.open({
                            items: items,
                            gallery: {
                                enabled: true
                            },
                            type: 'image',
                            image: {
                                titleSrc: function (item) {
                                    return `<div class="mfp-title-overlay"><h5>${item.title}</h5></div>`;
                                }
                            }
                        });
                    });
                });
            });
        }

        initializeMagnificPopup('.contentImageInside', '.sidebarContentImage');
        $(document).ready(function () {
            $.ajax({
                url: '{{ route('admin.users.search.countData') }}',
                type: 'GET',
                success: function (response) {
                    $('.bannedUser').text(response.banned_users);
                    $('.emailUnverified').text(response.email_unverified);
                    $('.smsUnverified').text(response.sms_unverified);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endpush




