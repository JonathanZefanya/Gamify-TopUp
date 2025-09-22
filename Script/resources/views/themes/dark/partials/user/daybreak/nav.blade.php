<ul class="nav main-nav" id="main-nav">
    <li class="nav-item">
        <a class="nav-link" aria-current="page" href="{{ route('page', '/') }}" data-bs-toggle="tooltip" title="Gamers Haven">
            <i class="fa-regular fa-house"></i>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ menuActive(['user.dashboard']) }}" aria-current="page" href="{{ route('user.dashboard') }}" data-bs-toggle="tooltip" title="Dashboard">
            <i class="fa-regular fa-grid-2"></i>
        </a>
    </li>
    @if(basicControl()->top_up)
        <li class="nav-item">
            <a class="nav-link {{ menuActive(['user.topUpOrder']) }}" href="{{ route('user.topUpOrder'). '?type=all' }}" data-bs-toggle="tooltip" title="Top Up Order">
                <i class="fa-regular fa-bag-shopping"></i>
            </a>
        </li>
    @endif
    @if(basicControl()->card)
        <li class="nav-item">
            <a class="nav-link {{ menuActive(['user.cardOrder']) }}" href="{{ route('user.cardOrder'). '?type=all' }}" data-bs-toggle="tooltip" title="Card Order">
                <i class="fa-regular fa-credit-card"></i>
            </a>
        </li>
    @endif

    <li class="nav-item">
        <div class="dropdown">
            <button class="nav-link {{ menuActive(['user.fund.index', 'user.ticket.list','user.ticket.create','user.ticket.view','user.apiKey']) }}" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" title="More">
                <i class="fa-regular fa-ellipsis-stroke-vertical"></i>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item {{ menuActive(['user.add.fund']) }}" href="{{ route('user.add.fund') }}" data-bs-toggle="tooltip" title="Add Fund">@lang('Add Fund')</a>
                </li>
                <li class="sub-dropdown">
                    <a href="#0" class="dropdown-item  {{ menuActive(['user.payout', 'user.payout.index']) }}" title="Manage Payout">
                        @lang('Manage Payout')<i class="fa-regular fa-chevron-right"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ menuActive('user.payout') }}" href="{{ route('user.payout') }}" data-bs-toggle="tooltip" title="Payout">@lang('Payout')</a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ menuActive(['user.payout.index']) }}" href="{{ route('user.payout.index') }}" data-bs-toggle="tooltip" title="Payout Log">@lang('Payout Logs')</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="dropdown-item {{ menuActive('user.fund.index') }}" href="{{ route('user.fund.index') }}" data-bs-toggle="tooltip" title="Payment Log">@lang('Payment Logs')</a>
                </li>
                <li>
                    <a class="dropdown-item {{ menuActive(['user.transaction']) }}" href="{{ route('user.transaction') }}" data-bs-toggle="tooltip" title="Transactions">@lang('Transactions')</a>
                </li>

                @if (basicControl()->sell_post)
                    <li class="sub-dropdown">
                        <a href="#0" class="dropdown-item {{ menuActive(['user.sellCreate', 'user.sellList', 'user.sellPostOfferMore']) }}" title="Manage Post">
                            @lang('Manage Post') <i class="fa-regular fa-chevron-right"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item {{ menuActive('user.sellCreate') }}" href="{{ route('user.sellCreate') }}" data-bs-toggle="tooltip" title="Create Post">@lang('Create Sell')</a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ menuActive(['user.sellList']) }}" href="{{ route('user.sellList') }}" data-bs-toggle="tooltip" title="Sales List">@lang('Sales List')</a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ menuActive(['user.sellPostOfferMore']) }}" href="{{ route('user.sellPostOfferMore') }}" data-bs-toggle="tooltip" title="Offer List">@lang('Offer List')</a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ menuActive(['user.sellPostOrder']) }}" href="{{ route('user.sellPostOrder') }}" data-bs-toggle="tooltip" title="Order List">@lang('Order List')</a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li>
                    <a class="dropdown-item {{ menuActive(['user.ticket.list','user.ticket.create','user.ticket.view']) }}" href="{{ route('user.ticket.list') }}" data-bs-toggle="tooltip" title="Support Ticket">@lang('Support Ticket')</a>
                </li>
                <li>
                    <a class="dropdown-item {{ menuActive(['user.apiKey']) }}" href="{{ route('user.apiKey') }}" data-bs-toggle="tooltip" title="API Key">@lang('Api Key')</a>
                </li>
            </ul>
        </div>
    </li>
</ul>
<style>
    .search-bar .search-icon {
        padding: 10px;
        margin-left: -46px;
    }
</style>

