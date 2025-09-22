@extends('admin.layouts.app')
@section('page_title', __('Dashboard'))
@section('content')
    <div class="content container-fluid dashboard-height">
        <div id="firebase-app">
            <div class="shadow p-3 mb-5 alert-soft-blue mb-4 mb-lg-7" role="alert"
                 v-if="notificationPermission == 'default' && !is_notification_skipped" v-cloak>
                <div class="alert-box d-flex flex-wrap align-items-center">
                    <div class="flex-shrink-0">
                        <img class="avatar avatar-xl"
                             src="{{ asset('assets/admin/img/oc-megaphone.svg') }}"
                             alt="Image Description" data-hs-theme-appearance="default">
                        <img class="avatar avatar-xl"
                             src="{{ asset('assets/admin/img/oc-megaphone-light.svg') }}"
                             alt="Image Description" data-hs-theme-appearance="dark">
                    </div>

                    <div class="flex-grow-1 ms-3">
                        <h3 class=" mb-1">@lang("Attention!")</h3>
                        <div class="d-flex align-items-center">
                            <p class="mb-0 text-muted"> @lang('Please allow your browser to get instant push notification. Allow it from
                                notification setting.')</p>
                            <button id="allow-notification" class="btn btn-sm btn-primary mx-2"><i
                                    class="fa fa-check-circle"></i> @lang('Allow me')</button>
                        </div>
                    </div>
                    <button type="button" class="btn-close"
                            @click.prevent="skipNotification" data-bs-dismiss="alert"
                            aria-label="Close">
                    </button>
                </div>
            </div>
            <div class="alert alert-soft-blue mb-4 mb-lg-7" role="alert"
                 v-if="notificationPermission == 'denied' && !is_notification_skipped" v-cloak>
                <div class="d-flex align-items-center mt-4">
                    <div class="flex-shrink-0">
                        <img class="avatar avatar-xl"
                             src="{{ asset('assets/admin/img/oc-megaphone.svg') }}"
                             alt="Image Description" data-hs-theme-appearance="default">
                        <img class="avatar avatar-xl"
                             src="{{ asset('assets/admin/img/oc-megaphone-light.svg') }}"
                             alt="Image Description" data-hs-theme-appearance="dark">
                    </div>

                    <div class="flex-grow-1 ms-3">
                        <h3 class=" mb-1">@lang("Attention!")</h3>
                        <div class="d-flex align-items-center">
                            <p class="mb-0 text-muted"> @lang("Please allow your browser to get instant push notification. Allow it from
                                notification setting.")</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" @click.prevent="skipNotification" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>
            </div>
        </div>

        @if(!adminAccessRoute('Dashboard') && !adminAccessRoute('User Management'))
            <div class="row justify-content-sm-center text-center py-10">
                <div class="col-sm-7 col-md-5">
                    <img class="img-fluid mb-5" src="{{asset('assets/admin/dark-oc-collaboration.svg')}}" alt="Image Description" data-hs-theme-appearance="default">
                    <img class="img-fluid mb-5" src="{{asset('assets/admin/oc-collaboration.svg')}}" alt="Image Description" data-hs-theme-appearance="dark">

                    <h1>@lang("Hello,") {{auth()->user()->name}} @lang("nice to see you!")</h1>
                </div>
            </div>
        @endif


        @if(adminAccessRoute('Dashboard'))
            <div class="row">
                @include('admin.partials.dashboard.recentTran')
                @include('admin.partials.dashboard.record')
            </div>

            @include('admin.partials.dashboard.module-performance')
            @include('admin.partials.dashboard.order-figure')
        @endif

        @if(adminAccessRoute('User Management'))
            <div class="card mb-3 mb-lg-5">
                <div class="card-header card-header-content-between">
                    <h4 class="card-header-title">@lang("Latest Users")</h4>

                    <a class="btn btn-ghost-secondary btn-sm" href="{{ route("admin.users") }}">@lang("View All")</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless table-thead-bordered table-align-middle card-table">
                        <thead class="thead-light">
                        <tr>
                            <th>@lang('Full Name')</th>
                            <th>@lang('Email-Phone')</th>
                            <th>@lang('Balance')</th>
                            <th>@lang('Country')</th>
                            <th>@lang('Email Verification')</th>
                            <th>@lang('Sms Verification')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($latestUser as $user)
                            <tr>
                                <td>
                                    <a class="d-flex align-items-center me-2"
                                       href="{{ route("admin.user.view.profile", $user->id) }}">
                                        <div class="flex-shrink-0">
                                            {!! $user->profilePicture() !!}
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="text-hover-primary mb-0">{{ $user->firstname . ' ' . $user->lastname }}</h5>
                                            <span class="fs-6 text-body">{{'@'. $user->username }}</span>
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <span class="d-block h5 mb-0"> {{ $user->email }}</span>
                                    <span class="d-block fs-5">{{ $user->phone }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{ currencyPosition($user->balance) }}
                                    </div>
                                </td>
                                <td>
                                    {{ $user->country ?? 'N/A' }}
                                </td>
                                <td>
                                    @if($user->email_verification == 1)
                                        <span class="badge bg-soft-info text-info">
                                        <span class="legend-indicator bg-info"></span>@lang("Verified")
                                    </span>
                                    @else
                                        <span class="badge bg-warning text-warning">
                                        <span class="legend-indicator bg-warning"></span>@lang("Unverified")
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->sms_verification == 1)
                                        <span class="badge bg-soft-primary text-primary">
                                        <span class="legend-indicator bg-primary"></span>@lang("Verified")
                                    </span>
                                    @else
                                        <span class="badge bg-soft-secondary text-secondary">
                                        <span class="legend-indicator bg-secondary"></span>@lang("Unverified")
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->status == 1)
                                        <span class="badge bg-soft-success text-success">
                                        <span class="legend-indicator bg-success"></span>@lang("Active")
                                    </span>
                                    @else
                                        <span class="badge bg-soft-danger text-danger">
                                        <span class="legend-indicator bg-danger"></span>@lang("Inactive")
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-white btn-sm"
                                           href="{{ route('admin.user.edit', $user->id) }}">
                                            <i class="bi-pencil-fill me-1"></i> @lang("Edit")
                                        </a>
                                        <div class="btn-group">
                                            <button type="button"
                                                    class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty"
                                                    id="userEditDropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false"></button>
                                            <div class="dropdown-menu dropdown-menu-end mt-1"
                                                 aria-labelledby="userEditDropdown">
                                                <a class="dropdown-item"
                                                   href="{{ route('admin.user.view.profile', $user->id) }}">
                                                    <i class="bi-eye-fill dropdown-item-icon"></i> @lang("View Profile")
                                                </a>
                                                <a class="dropdown-item"
                                                   href="{{ route('admin.send.email', $user->id) }}">
                                                    <i
                                                        class="bi-envelope dropdown-item-icon"></i> @lang("Send Mail")
                                                </a>
                                                <a class="dropdown-item loginAccount" href="javascript:void(0)"
                                                   data-route="{{ route('admin.login.as.user', $user->id) }}"
                                                   data-bs-toggle="modal" data-bs-target="#loginAsUserModal">
                                                    <i class="bi bi-box-arrow-in-right dropdown-item-icon"></i>
                                                    @lang("Login As User")
                                                </a>
                                                <a class="dropdown-item addBalance" href="javascript:void(0)"
                                                   data-route="{{ route('admin.user.update.balance', $user->id) }}"
                                                   data-balance="{{ currencyPosition($user->balance) }}"
                                                   data-bs-toggle="modal" data-bs-target="#addBalanceModal">
                                                    <i class="bi bi-cash-coin dropdown-item-icon"></i>
                                                    @lang("Manage Balance")
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <div class="text-center p-4">
                                    <img class="dataTables-image mb-3"
                                         src="{{ asset('assets/admin/img/oc-error.svg') }}"
                                         alt="Image Description" data-hs-theme-appearance="default">
                                    <img class="dataTables-image mb-3"
                                         src="{{ asset('assets/admin/img/oc-error-light.svg') }}"
                                         alt="Image Description"
                                         data-hs-theme-appearance="dark">
                                    <p class="mb-0">@lang("No data to show")</p>
                                </div>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @include('admin.partials.dashboard.browserHistory')
        @endif

    </div>

    @if($basicControl->is_active_cron_notification && adminAccessRoute('Dashboard'))
        <!-- Modal -->
        <div class="modal fade" id="cron-info" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fal fa-info-circle"></i>
                            @lang('Cron Job Set Up Instruction')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="bg-orange text-white p-2">
                                    <i>@lang('**To sending emails and manage records automatically you need to setup cron job in your server. Make sure your job is running properly. We insist to set the cron job time as minimum as possible.**')</i>
                                </p>
                            </div>
                            <div class="col-md-12 form-group">
                                <label><strong>@lang('Command for Email')</strong></label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control copyText"
                                           value="curl -s {{ route('queue.work') }}" disabled>
                                    <button class="input-group-text bg-primary btn btn-primary text-white copy-btn"
                                            id="button-addon2">
                                        <i class="fas fa-copy"></i></button>

                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label><strong>@lang('Command for Cron Job')</strong></label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control copyText"
                                           value="curl -s {{ route('schedule:run') }}"
                                           disabled>
                                    <button class="input-group-text bg-primary btn btn-primary text-white copy-btn"
                                            id="button-addon2">
                                        <i class="fas fa-copy"></i></button>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <p class="bg-dark text-white p-2">
                                    @lang('*To turn off this pop up go to ')
                                    <a href="{{route('admin.basic.control')}}"
                                       class="text-danger">@lang('Basic control')</a>
                                    @lang(' and disable `Cron Set Up Pop Up`.*')
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(adminAccessRoute('User Management'))
        @include('admin.user_management.components.login_as_user')
        @include('admin.user_management.components.update_balance_modal')
    @endif

@endsection

@push('js-lib')
    <script src="{{ asset('assets/admin/js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/apexcharts.min.js') }}"></script>
@endpush

@push("script")
    <script>

        $(document).on('click', '.loginAccount', function () {
            let route = $(this).data('route');
            $('.loginAccountAction').attr('action', route)
        });
        $(document).on('click', '.addBalance', function () {
            $('.setBalanceRoute').attr('action', $(this).data('route'));
            $('.user-balance').text($(this).data('balance'));
        });
        document.querySelectorAll('.js-chart').forEach(item => {
            HSCore.components.HSChartJS.init(item)
        });
        $(document).ready(function () {
            let isActiveCronNotification = '{{ $basicControl->is_active_cron_notification }}';
            if (isActiveCronNotification == 1)
                $('#cron-info').modal('show');
            $(document).on('click', '.copy-btn', function () {
                var _this = $(this)[0];
                var copyText = $(this).siblings('input');
                $(copyText).prop('disabled', false);
                copyText.select();
                document.execCommand("copy");
                $(copyText).prop('disabled', true);
                $(this).text('Coppied');
                setTimeout(function () {
                    $(_this).text('');
                    $(_this).html('<i class="fas fa-copy"></i>');
                }, 500)
            });
        });
    </script>
@endpush

@if($firebaseNotify)
    @push('script')
        <script type="module">

            import {initializeApp} from "https://www.gstatic.com/firebasejs/9.17.1/firebase-app.js";
            import {
                getMessaging,
                getToken,
                onMessage
            } from "https://www.gstatic.com/firebasejs/9.17.1/firebase-messaging.js";

            const firebaseConfig = {
                apiKey: "{{$firebaseNotify['apiKey']}}",
                authDomain: "{{$firebaseNotify['authDomain']}}",
                projectId: "{{$firebaseNotify['projectId']}}",
                storageBucket: "{{$firebaseNotify['storageBucket']}}",
                messagingSenderId: "{{$firebaseNotify['messagingSenderId']}}",
                appId: "{{$firebaseNotify['appId']}}",
                measurementId: "{{$firebaseNotify['measurementId']}}"
            };

            const app = initializeApp(firebaseConfig);
            const messaging = getMessaging(app);
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('{{ getProjectDirectory() }}' + `/firebase-messaging-sw.js`, {scope: './'}).then(function (registration) {
                        requestPermissionAndGenerateToken(registration);
                    }
                ).catch(function (error) {
                });
            } else {
            }

            onMessage(messaging, (payload) => {
                if (payload.data.foreground || parseInt(payload.data.foreground) == 1) {
                    const title = payload.notification.title;
                    const options = {
                        body: payload.notification.body,
                        icon: payload.notification.icon,
                    };
                    new Notification(title, options);
                }
            });

            function requestPermissionAndGenerateToken(registration) {
                document.addEventListener("click", function (event) {
                    if (event.target.id == 'allow-notification') {
                        Notification.requestPermission().then((permission) => {
                            if (permission === 'granted') {
                                getToken(messaging, {
                                    serviceWorkerRegistration: registration,
                                    vapidKey: "{{$firebaseNotify['vapidKey']}}"
                                })
                                    .then((token) => {
                                        $.ajax({
                                            url: "{{ route('admin.save.token') }}",
                                            method: "post",
                                            data: {
                                                token: token,
                                            },
                                            success: function (res) {
                                            }
                                        });
                                        window.newApp.notificationPermission = 'granted';
                                    });
                            } else {
                                window.newApp.notificationPermission = 'denied';
                            }
                        });
                    }
                });
            }
        </script>
        <script>
            window.newApp = new Vue({
                el: "#firebase-app",
                data: {
                    admin_foreground: '',
                    admin_background: '',
                    notificationPermission: Notification.permission,
                    is_notification_skipped: sessionStorage.getItem('is_notification_skipped') == '1'
                },
                mounted() {
                    sessionStorage.clear();
                    this.admin_foreground = "{{$firebaseNotify['admin_foreground']}}";
                    this.admin_background = "{{$firebaseNotify['admin_background']}}";
                },
                methods: {
                    skipNotification() {
                        sessionStorage.setItem('is_notification_skipped', '1');
                        this.is_notification_skipped = true;
                    }
                }
            });
        </script>
    @endpush
@endif













