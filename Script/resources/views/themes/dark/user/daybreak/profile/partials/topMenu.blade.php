<div class="account-settings-navbar">
    <ul class="nav">
        <li class="nav-item"><a class="nav-link {{ menuActive(['user.profile']) }}" aria-current="page" href="{{ route('user.profile') }}"><i class="fa-regular fa-user"></i>@lang('profile ')</a></li>
        <li class="nav-item"><a class="nav-link {{ menuActive(['user.notification.permission.list']) }}" href="{{ route('user.notification.permission.list') }}"><i class="fa-regular fa-link"></i>@lang('Notification')</a></li>
        <li class="nav-item"><a class="nav-link {{ menuActive('user.kyc.settings') }}" href="{{ route('user.kyc.settings') }}"><i class="fa-regular fa-link"></i> @lang('Identity Verification')</a></li>
    </ul>
</div>
