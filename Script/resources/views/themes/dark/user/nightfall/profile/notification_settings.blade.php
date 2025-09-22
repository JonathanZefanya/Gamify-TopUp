@extends(template().'layouts.user')
@section('title',trans('Identity Verification'))
@section('content')
    <div class="pagetitle">
        <h3 class="mb-1">@lang('Notification Permissions')</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('Notification Permissions')</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="account-settings-profile-section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">@lang('Notification Permissions')
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.notification.permission') }}" method="post">
                        @csrf

                        <div class="account-settings-profile-section">
                            <div class="card">
                                <div class="card-body pt-0">
                                    <p>@lang('We need permission from your browser to show notifications.') <strong>@lang('Request Permission')</strong>
                                    </p>
                                    <!-- Cmn table start -->
                                    <div class="cmn-table mt-20">
                                        <div class="table-responsive">
                                            <table class="table align-middle">
                                                <thead>
                                                <tr>
                                                    <th class="w1" scope="col">@lang('type')</th>
                                                    <th class="w2" scope="col">✉️@lang('email')</th>
                                                    <th class="w2" scope="col">🖥 @lang('browser')</th>
                                                    <th class="w2" scope="col">🖥 @lang('sms')</th>
                                                    <th class="w3" scope="col">👩🏻‍💻 @lang('app')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($notificationTemplates as $key => $item)                                <tr>
                                                    <td data-label="Type">
                                                        <div class="d-flex align-items-center">
                                                            <span>{{ $item->name }}</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="✉️ Email">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                   role="switch" name="email_key[]"
                                                                   value="{{$item->template_key ?? ""}}"
                                                                   {{ !$item->email ? 'disabled':'' }}
                                                                   id="emailSwitch"
                                                                {{ in_array($item->template_key, optional($user->notifypermission)->template_email_key ?? []) ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td data-label="🖥 Browser">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                   role="switch" name="sms_key[]"
                                                                   value="{{ $item->template_key ?? "" }}"
                                                                   {{ !$item->sms ? 'disabled' : '' }}
                                                                   id="pushSwitch"
                                                                {{ in_array($item->template_key, optional($user->notifypermission)->template_sms_key ?? []) ? 'checked' : '' }}>
                                                        </div>
                                                    </td>

                                                    <td data-label="🖥 Sms">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                   role="switch" name="push_key[]"
                                                                   value="{{ $item->template_key ?? "" }}"
                                                                   {{ !$item->push ? 'disabled' : '' }}
                                                                   id="pushSwitch"
                                                                {{ in_array($item->template_key, optional($user->notifypermission)->template_push_key ?? []) ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td data-label="👩🏻‍💻 App">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                   role="switch" name="in_app_key[]"
                                                                   value="{{$item->template_key ?? ""}}"
                                                                   id="appSwitch"
                                                                {{!$item->in_app ? 'disabled':''}}
                                                                {{ in_array($item->template_key, optional($user->notifypermission)->template_in_app_key ?? []) ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                    <div class="text-center">
                                                        @include('empty')
                                                    </div>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <button type="submit" class="cmn-btn mt-4 w-100">@lang('Save Changes')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
