@extends(template().'layouts.user')
@section('title',trans('Dashboard'))
@section('content')
    <div class="pagetitle">
        <h3 class="mb-1">@lang('Dashboard')</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('Dashboard')</li>
            </ol>
        </nav>
    </div>


    <div class="dashboard-top">
        <div class="row g-4 align-items-center">
            <div class="col-lg-4">
                <div class="text-box text-center text-lg-start">
                    <div
                        class="d-flex align-items-center gap-3 justify-content-center justify-content-lg-start">
                        <h2 class="title mb-1">@lang('Hi'), @lang(auth()->user()->fullname)!</h2>
                    </div>
                    <h2 class="title mb-1">@lang('What do you want to') <span class="highlight">@lang('buy')</span>
                        @lang('today')?
                    </h2>
                    <h5 class="sub-title ">@lang('Digital Game Marketplace offers a seamless shopping experience for gamers ')
                    </h5>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="desktop-view-card-section">
                    <div class="grid-container">
                        <div class="item">
                            <div class="deposit-invest-box">
                                <div class="img-box">
                                    <img src="{{asset(template(true).'img/box-card/market-analysis-31.png')}}" alt="...">
                                </div>
                                <div class="text-box">
                                    <a href="{{url('/')}}" class="cmn-btn"><i class="fa-regular fa-usd-circle"></i>
                                        @lang('Buy')</a>
                                    <a href="{{route('user.add.fund')}}" class="cmn-btn"><i
                                            class="fa-regular fa-wallet"></i>
                                        @lang('Deposit')</a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="box-card2">
                                <div class="img-box">
                                    <img src="{{asset(template(true).'img/box-card/bitcoin-46.png')}}" alt="...">
                                </div>
                                <div class="text-box">
                                    <h4 class="title mb-0">{{currencyPosition(auth()->user()->balance)}}</h4>
                                    <p class="mb-0">@lang('Main Balance')</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="box-card2">
                                <div class="img-box">
                                    <img src="{{asset(template(true).'img/box-card/money-50.png')}}" alt="...">
                                </div>
                                <div class="text-box">
                                    <h5 class="mb-0">{{$stat['totalTopUpOrder']}}</h5>
                                    <p class="mtitle b-0">@lang('Top Up Order')</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="box-card2">
                                <div class="img-box">
                                    <img src="{{asset(template(true).'img/box-card/money-jar-54.png')}}" alt="...">
                                </div>
                                <div class="text-box">
                                    <h5 class="title mb-0">{{$stat['totalCardOrder']}} </h5>
                                    <p class="mb-0">@lang('Card Order')</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="box-card2">
                                <div class="img-box">
                                    <img src="{{asset(template(true).'img/box-card/money-motivation-90.png')}}" alt="...">
                                </div>
                                <div class="text-box">
                                    <h5 class="title mb-0">{{$totalTickets}} </h5>
                                    <p class="mb-0">@lang('Support Ticket')</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-mobile-view-carousel-section">
                    <div class="row">
                        <div class="col-12">
                            <div class="owl-carousel owl-theme carousel-1">
                                <div class="item">
                                    <div class="deposit-invest-box">
                                        <div class="img-box">
                                            <img src="{{asset(template(true).'img/box-card/market-analysis-31.png')}}"
                                                 alt="...">
                                        </div>
                                        <div class="text-box">
                                            <a href="{{url('/')}}" class="cmn-btn"><i
                                                    class="fa-regular fa-usd-circle"></i>
                                                @lang('Buy')</a>
                                            <a href="{{route('user.add.fund')}}" class="cmn-btn"><i
                                                    class="fa-regular fa-wallet"></i>
                                                @lang('Deposit')</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="box-card2">
                                        <div class="img-box">
                                            <img src="{{asset(template(true).'img/box-card/bitcoin-46.png')}}" alt="...">
                                        </div>
                                        <div class="text-box">
                                            <h4 class="title mb-0">{{currencyPosition(auth()->user()->balance)}}</h4>
                                            <p class="mb-0">@lang('Main Balance')</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="box-card2">
                                        <div class="img-box">
                                            <img src="{{asset(template(true).'img/box-card/money-50.png')}}" alt="...">
                                        </div>
                                        <div class="text-box">
                                            <h5 class="title mb-0">{{$stat['totalTopUpOrder']}}</h5>
                                            <p class="mb-0">@lang('Top Up Order')</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="box-card2">
                                        <div class="img-box">
                                            <img src="{{asset(template(true).'img/box-card/money-jar-54.png')}}" alt="...">
                                        </div>
                                        <div class="text-box">
                                            <h5 class="title mb-0">{{$stat['totalCardOrder']}} </h5>
                                            <p class="mb-0">@lang('Card Order')</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="box-card2">
                                        <div class="img-box">
                                            <img src="{{asset(template(true).'img/box-card/money-motivation-90.png')}}"
                                                 alt="...">
                                        </div>
                                        <div class="text-box">
                                            <h5 class="title mb-0">{{$totalTickets}} </h5>
                                            <p class="mb-0">@lang('Support Ticket')</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-30">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card mt-25">
                    <div class="card-body" id="orderMovement">
                        <div class="card h-100">
                            <div class="card-body p-1">
                                <div id="columnChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row g-4">
                    <div class="col-lg-12 col-md-6">
                        <div id="datepicker" class=" h-100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="{{asset('assets/global/js/apexcharts.min.js')}}"></script>
    <script>
        Notiflix.Block.standard('#orderMovement');
        document.addEventListener("DOMContentLoaded", function () {
            var options = {
                series: [{
                    name: 'Top Up',
                    color: '#567eae',
                    data: []
                }, {
                    name: 'Card',
                    color: '#32c36c',
                    data: []
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    foreColor: '#ffffff'
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                    labels: {
                        style: {
                            colors: '#ffffff'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Order Count',
                        style: {
                            color: '#ffffff'
                        }
                    },
                    labels: {
                        style: {
                            colors: '#ffffff'
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val ;
                        }
                    },
                    theme: 'dark'
                }
            };



            var chart = new ApexCharts(document.querySelector("#columnChart"), options);
            chart.render();

            updateOrderMovementGraph();

            async function updateOrderMovementGraph() {
                let $url = "{{ route('user.getOrderMovement') }}";
                await axios.get($url)
                    .then(function (res) {
                        let data = res.data.orderFigures.horizontalBarChatInbox;
                        options.series[0].data = data.topUp;
                        options.series[1].data = data.card;
                        chart.updateSeries(options.series);
                        Notiflix.Block.remove('#orderMovement');
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            }
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
                                            url: "{{ route('user.save.token') }}",
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
                    user_foreground: '',
                    user_background: '',
                    notificationPermission: Notification.permission,
                    is_notification_skipped: sessionStorage.getItem('is_notification_skipped') == '1'
                },
                mounted() {
                    sessionStorage.clear();
                    this.user_foreground = "{{$firebaseNotify['user_foreground']}}";
                    this.user_background = "{{$firebaseNotify['user_background']}}";
                },
                methods: {
                    skipNotification() {
                        sessionStorage.setItem('is_notification_skipped', '1')
                        this.is_notification_skipped = true;
                    }
                }
            });
        </script>
    @endpush
@endif

