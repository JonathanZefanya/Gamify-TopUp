<!-- Sidebar section start -->
<aside id="sidebar" class="sidebar">
    <div class="logo-container">
        <a href="{{url('/')}}" class="logo d-flex align-items-center">
            <img src="{{getFile(basicControl()->logo_driver,basicControl()->logo)}}" alt="{{basicControl()->site_name}}">
        </a>
    </div>

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{menuActive('user.dashboard')}}" href="{{route('user.dashboard')}}">
                <i class="fa-regular fa-grid"></i>
                <span>@lang('Dashboard')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{menuActive('user.add.fund')}}" href="{{route('user.add.fund')}}">
                <i class="fa-regular fa-wallet"></i>
                <span>@lang('Add Fund')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ menuActive('user.payout') }}" href="{{ route('user.payout') }}">
                <i class="fa-regular fa-money-bill"></i>
                <span>@lang('Payout')</span>
            </a>
        </li>
        @if(basicControl()->top_up)
            <li class="nav-item">
                <a class="nav-link collapsed {{menuActive('user.topUpOrder')}}" data-bs-target="#account-settings"
                   data-bs-toggle="collapse" href="#">
                    <i class="fa-sharp fa-regular fa-shield-alt"></i><span>@lang('Top Up Order')</span>
                    <i class="fa-regular fa-angle-down ms-auto bi-chevron-down"></i>
                </a>
                <ul id="account-settings" class="nav-content collapse {{menuActive('user.topUpOrder',2)}}" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{route('user.topUpOrder').'?type=all'}}"
                           class="{{(request()->route()->getName() == 'user.topUpOrder' && request()->type == 'all') ? 'active':''}}">
                            <i class="fa-regular fa-circle"></i><span>@lang('All Order')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.topUpOrder').'?type=wait-sending'}}"
                           class="{{(request()->route()->getName() == 'user.topUpOrder' && request()->type == 'wait-sending') ? 'active':''}}">
                            <i class="fa-regular fa-circle"></i><span>@lang('Wait Sending')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.topUpOrder').'?type=complete'}}"
                           class="{{(request()->route()->getName() == 'user.topUpOrder' && request()->type == 'complete') ? 'active':''}}">
                            <i class="fa-regular fa-circle"></i><span>@lang('Complete')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.topUpOrder').'?type=refund'}}"
                           class="{{(request()->route()->getName() == 'user.topUpOrder' && request()->type == 'refund') ? 'active':''}}">
                            <i class="fa-regular fa-circle"></i><span>@lang('Refund')</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        @if(basicControl()->card)
            <li class="nav-item">
                <a class="nav-link collapsed {{menuActive('user.cardOrder')}}" data-bs-target="#crm"
                   data-bs-toggle="collapse" href="#">
                    <i class="fa-sharp fa-regular fa-gift-card"></i><span>@lang('Card Order')</span>
                    <i class="fa-regular fa-angle-down ms-auto bi-chevron-down"></i>
                </a>
                <ul id="crm" class="nav-content collapse {{menuActive('user.cardOrder',2)}}"
                    data-bs-parent="#sidebar-nav">

                    <li>
                        <a href="{{route('user.cardOrder').'?type=all'}}"
                           class="{{(request()->route()->getName() == 'user.cardOrder' && request()->type == 'all') ? 'active':''}}">
                            <i class="fa-regular fa-circle"></i><span>@lang('All Order')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.cardOrder').'?type=wait-sending'}}"
                           class="{{(request()->route()->getName() == 'user.cardOrder' && request()->type == 'wait-sending') ? 'active':''}}">
                            <i class="fa-regular fa-circle"></i><span>@lang('Wait Sending')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.cardOrder').'?type=complete'}}"
                           class="{{(request()->route()->getName() == 'user.cardOrder' && request()->type == 'complete') ? 'active':''}}">
                            <i class="fa-regular fa-circle"></i><span>@lang('Complete')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('user.cardOrder').'?type=refund'}}"
                           class="{{(request()->route()->getName() == 'user.cardOrder' && request()->type == 'refund') ? 'active':''}}">
                            <i class="fa-regular fa-circle"></i><span>@lang('Refund')</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        @if (basicControl()->sell_post)
            <li class="nav-item">
                <a class="nav-link collapsed {{menuActive(['user.sellCreate', 'user.sellList', 'user.sellPostOfferMore','user.sellPostOrder'])}}" data-bs-target="#post"
                   data-bs-toggle="collapse" href="#">
                    <i class="fa-brands fa-sellsy"></i><span>@lang('Sell Post')</span>
                    <i class="fa-regular fa-angle-down ms-auto bi-chevron-down"></i>
                </a>
                <ul id="post" class="nav-content collapse {{ menuActive(['user.sellCreate', 'user.sellList', 'user.sellPostOfferMore','user.sellPostOrder'],2) }}"
                    data-bs-parent="#sidebar-nav">

                    <li>
                        <a href="{{ route('user.sellCreate') }}"
                           class="{{ request()->route()->getName() == 'user.sellCreate' ? 'active':'' }}">
                            <i class="fa-regular fa-circle"></i><span>@lang('Create Sell')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.sellList') }}"
                           class="{{ request()->route()->getName() == 'user.sellList' ? 'active':'' }}">
                            <i class="fa-regular fa-circle"></i><span>@lang('Sales List')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.sellPostOfferMore') }}"
                           class="{{ request()->route()->getName() == 'user.sellPostOfferMore' ? 'active':'' }}">
                            <i class="fa-regular fa-circle"></i><span>@lang('Offer List')</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.sellPostOrder') }}"
                           class="{{ request()->route()->getName() == 'user.sellPostOrder' ? 'active':'' }}">
                            <i class="fa-regular fa-circle"></i><span>@lang('Order List')</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link {{menuActive('user.fund.index')}}" href="{{route('user.fund.index')}}">
                <i class="fa-regular fa-paper-plane"></i>
                <span>@lang('Payment Logs')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ menuActive(['user.payout.index']) }}" href="{{ route('user.payout.index') }}">
                <i class="fa-regular fa-money-bills-simple"></i>
                <span>@lang('Payout Logs')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{menuActive('user.transaction')}}" href="{{route('user.transaction')}}">
                <i class="fa-regular fa-arrow-right-arrow-left"></i>
                <span>@lang('Transaction')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{menuActive(['user.ticket.list','user.ticket.create','user.ticket.view'])}}" href="{{route('user.ticket.list')}}">
                <i class="fa-regular fa-user-headset"></i>
                <span>@lang('Support Ticket')</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{menuActive('user.apiKey')}}" href="{{route('user.apiKey')}}">
                <i class="fa-regular fa-key-skeleton"></i>
                <span>@lang('Api Key')</span>
            </a>
        </li>
    </ul>
</aside>
<!-- Sidebar section end -->
