@extends(template().'layouts.user')
@section('title',trans('Identity Verification'))
@section('content')
    <div class="container">
        <div class="pagetitle mt-20">
            <h4 class="mb-1">@lang('Notification Permissions')</h4>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Notification Permissions')</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            @include(template().'user.'.getDash().'.profile.partials.topMenu')
            @include(template().'user.'.getDash().'.profile.partials.notification_settings')
        </div>
    </div>
@endsection
