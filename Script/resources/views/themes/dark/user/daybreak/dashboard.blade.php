@extends(template().'layouts.user')
@section('title',trans('Dashboard'))
@section('content')
    <div class="container">
        <div class="row">
            <div class="mt-50">
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="offer-section">
                            <div class="swiper offer-swiper" data-aos="fade-up" data-aos-duration="500">
                                <div class="swiper-wrapper">
                                    @foreach($topSlider as $slider)
                                        <div class="swiper-slide">
                                            <div class="slider-box dash-slider">
                                                <div class="text-box">
                                                    <div class="section-subtitle">
                                                        {{ optional($slider->campaign_data)->discount. ((optional($slider->campaign_data)->discount_type == 'percentage') ? '%' : basicControl()->currency_symbol)}}@lang(' offer')
                                                    </div>
                                                    <h1 class="title">{{ $slider->name }}</h1>
                                                    <div class="price">
                                                        <div class="promo-price">{{ currencyPosition(showActualPrice($slider)) }}</div>
                                                        <div class="original-price line-through">{{ currencyPosition($slider->price) }}</div>
                                                    </div>
                                                    <div class="cmn-btn-group mt-20">
                                                        <a href="{{ route('page', '/') }}" class="purchases-btn">@lang('buy')</a>
                                                        <a href="{{ route('user.add.fund') }}" class="cart-btn">@lang('Add Fund')</a>
                                                    </div>
                                                </div>
                                                <div class="img-box">
                                                    <img src="{{ getFile($slider->image_driver, $slider->image) }}" alt="@lang('Slider Image')">
                                                    <img src="{{ asset(template(true).'user/'.getDash().'/img/dashShape.png') }}" alt="@lang('Slider Image')">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                        <!-- offer section end -->
                        <div class="card mt-25">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="box-card3">
                                            <div class="icon-box">
                                                <img src="{{asset(template(true).'img/box-card/bitcoin-46.png')}}" alt="...">
                                            </div>

                                            <div class="text-box">
                                                <h5 class="title">{{ currencyPosition(auth()->user()->balance) }}</h5>
                                                <h6>@lang('Main Balance')</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="box-card3">
                                            <div class="icon-box">
                                                <img src="{{asset(template(true).'img/box-card/money-50.png')}}" alt="...">
                                            </div>

                                            <div class="text-box">
                                                <h5 class="title">{{ $stat['totalTopUpOrder'] }}</h5>
                                                <h6>@lang('Top Up Order')</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="box-card3">
                                            <div class="icon-box">
                                                <img src="{{asset(template(true).'img/box-card/money-jar-54.png')}}" alt="...">
                                            </div>

                                            <div class="text-box">
                                                <h5 class="title">{{ $stat['totalCardOrder'] }}</h5>
                                                <h6>@lang('Card Order')</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="box-card3">
                                            <div class="icon-box">
                                                <img src="{{asset(template(true).'img/box-card/money-motivation-90.png')}}" alt="...">
                                            </div>

                                            <div class="text-box">
                                                <h5 class="title">{{ $totalTickets }}</h5>
                                                <h6>@lang('Total Ticket')</h6>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

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
                            @if(isset($sellPostOffer) && $sellPostOffer->count() > 0)
                                <div class="col-lg-12 col-md-6">
                                    <div class="card">
                                        <div
                                            class="card-header pb-0 border-0 d-flex align-items-center justify-content-between gap-2 ">
                                            <h4 class="mb-0">@lang('Latest offer list')</h4>
                                            <a href="{{ route('user.sellPostOfferMore') }}" class="view-all-btn">@lang('view all') <span><i
                                                        class="fa-regular fa-angle-right"></i></span></a>
                                        </div>
                                        <div class="card-body">
                                            @foreach($sellPostOffer as $offer)
                                                <div class="d-flex justify-content-between gap-2 flex-wrap">
                                                    <div class="offer-list-box">
                                                        <div class="img-box">
                                                            <img src="{{ getFile(optional($offer->user)->image_driver, optional($offer->user)->image) }}" alt="{{ optional($offer->user)->firstname .' '.optional($offer->user)->lastname }}">
                                                        </div>
                                                        <div class="text-box">
                                                            <h6>{{ optional($offer->user)->firstname .' '.optional($offer->user)->lastname }}</h6>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <h6 class="mb-0">{{ currencyPosition($offer->amount) }}</h6>
                                                                @if($offer->status == 0)
                                                                    <span class="badge text-bg-warning">@lang('Pending')</span>
                                                                @elseif($offer->status == 1)
                                                                    <span class="badge text-bg-success">@lang('Accepted')</span>
                                                                @elseif($offer->status == 2)
                                                                    <span class="badge text-bg-danger">@lang('Rejected')</span>
                                                                @elseif($offer->status == 3)
                                                                    <span class="badge text-bg-secondary">@lang('Resubmission')</span>
                                                                @else
                                                                    <span class="badge text-bg-info">@lang('Unknown')</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="action-btn-secondary" type="button"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-regular fa-ellipsis-stroke-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="offerActionBtn">

                                                            @if($offer->status != 1)
                                                                <li><a class="dropdown-item offerAccept"
                                                                       href="javascript:void(0)"
                                                                       data-resource="{{$offer->id}}"
                                                                       data-bs-toggle="modal"
                                                                       data-bs-target="#offerAccept">
                                                                        <i class="text-success fa fa-check-circle"></i> @lang('Accept')
                                                                    </a>
                                                                </li>
                                                            @else
                                                                <li><a class="dropdown-item"
                                                                       href="{{route('user.offerChat',$offer->uuid)}}"><i
                                                                            class="text-success fa fa-comment"></i> @lang('Conversation')
                                                                    </a>
                                                                </li>
                                                            @endif

                                                            @if($offer->status == 0 || $offer->status == 3)
                                                                <li><a class="dropdown-item offerReject"
                                                                       href="javascript:void(0)"
                                                                       data-resource="{{$offer->id}}"
                                                                       data-bs-toggle="modal"
                                                                       data-bs-target="#offerReject"><i
                                                                            class="text-danger fa fa-times"></i> @lang('Reject')
                                                                    </a>
                                                                </li>
                                                            @endif

                                                            @if($offer->status == 2 || $offer->status == 0 || $offer->status == 3)
                                                                <li><a class="dropdown-item offerRemove"
                                                                       href="javascript:void(0)"
                                                                       data-resource="{{$offer->id}}"
                                                                       data-bs-toggle="modal"
                                                                       data-bs-target="#offerRemove"><i
                                                                            class="text-danger fa fa-trash-alt"></i> @lang('Remove')
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                                <hr class="cmn-hr2">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(isset($sellPost) && $sellPost->count() > 0)
                                <div class="col-lg-12 col-md-6">
                                    <div class="card">
                                        <div
                                            class="card-header pb-0 border-0 d-flex align-items-center justify-content-between gap-2 ">
                                            <h4 class="mb-0">@lang('Latest sell post')</h4>
                                            <a href="{{ route('user.sellList') }}" class="view-all-btn">@lang('view all') <span><i
                                                        class="fa-regular fa-angle-right"></i></span></a>
                                        </div>
                                        <div class="card-body">
                                            @foreach($sellPost as $post)
                                                <div class="d-flex justify-content-between gap-2 flex-wrap">
                                                    <div class="offer-list-box">
                                                        <div class="img-box d-block">
                                                        @if($firstImage = collect($post->image)->first())
                                                            <img src="{{ getFile($post->image_driver, $firstImage) }}" alt="{{ $post->title . ' image 1' }}" style="display: inline-block; margin-right: 10px; max-width: 100px;">
                                                        @endif
                                                    </div>
                                                        <div class="text-box">
                                                            <h6>{{ $post->title }}</h6>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <h6 class="mb-0">{{ currencyPosition($post->price) }}</h6>
                                                                @if($post->status == 0)
                                                                    <span class="badge text-bg-warning">@lang('Pending')</span>
                                                                @elseif($post->status == 1)
                                                                    <span class="badge text-bg-success">@lang('Approved')</span>
                                                                @elseif($post->status == 2)
                                                                    <span class="badge text-bg-primary">@lang('Resubmission')</span>
                                                                @elseif($post->status == 3)
                                                                    <span class="badge text-bg-danger">@lang('Hold')</span>
                                                                @elseif($post->status == 4)
                                                                    <span class="badge text-bg-secondary">@lang('Soft Rejected')</span>
                                                                @elseif($post->status == 5)
                                                                    <span class="badge text-bg-dark">@lang('Hard Rejected')</span>
                                                                @else
                                                                    <span class="badge text-bg-info">@lang('Unknown')</span>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="action-btn-secondary" type="button"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa-regular fa-ellipsis-stroke-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item offerAccept"
                                                                   href="{{Route('sellPost.details',[slug($post->title), $post->id])}}">
                                                                    <i class="fa-regular fa fa-eye"></i> @lang('Details')
                                                                </a>
                                                            </li>

                                                            @if($post->payment_status != 1)
                                                                <li><a class="dropdown-item offerAccept"
                                                                       href="{{Route('user.sellPostEdit',$post->id)}}">
                                                                        <i class="fa-regular fa fa-edit"></i> @lang('Edit')
                                                                    </a>
                                                                </li>

                                                                <li><a class="dropdown-item notiflix-confirm"
                                                                       href="javascript:void(0)"
                                                                       data-bs-toggle="modal"
                                                                       data-bs-target="#delete-modal"
                                                                       data-route="{{route('user.sellPostDelete',$post->id)}}">
                                                                        <i class="fa-regular fa fa-trash"></i> @lang('Delete')
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                                <hr class="cmn-hr2">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-modal" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">@lang('Delete Confirm')</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to delete this?')</p>
                </div>

                <div class="modal-footer mt-10">
                    <form action="" method="post" class="deleteRoute">
                        @csrf
                        @method('delete')
                        <button type="submit" class="cmn-btn2">@lang('Yes')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="offerAccept" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="offerAcceptLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="offerAcceptLabel">@lang('Accept Offer')</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <form action="{{route('user.sellPostOfferAccept')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" class="acceptOfferId" name="offer_id" value="">
                        <label>@lang('Say Something')</label>
                        <textarea name="description" rows="4" class="form-control custom earn mt-3"
                                  required></textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="cmn-btn">@lang('Submit')
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Offer Remove Model -->
    <div class="modal fade" id="offerRemove" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="offerRemoveLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="offerRemoveLabel">@lang('Remove Offer')</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <form action="{{route('user.sellPostOfferRemove')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" class="removeOfferId" name="offer_id" value="">
                        <label>@lang('Are you want to remove this offer?')</label>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="cmn-btn2">@lang('Yes')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Offer Reject Model -->
    <div class="modal fade" id="offerReject" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="offerRejectLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="offerRejectLabel">@lang('Reject Offer')</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <form action="{{route('user.sellPostOfferReject')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" class="rejectOfferId" name="offer_id" value="">
                        <label>@lang('Are you want to reject this offer?')</label>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-success-custom">@lang('Yes')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        #columnChart {
            width: 100%;
            height: 400px;
        }
    </style>
@endpush
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
                    foreColor: '#555151',
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
                            colors: '#555151',
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Order Count',
                        style: {
                            color: '#555151'
                        }
                    },
                    labels: {
                        style: {
                            colors: '#555151'
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
                },
                responsive: [{
                    breakpoint: 600,
                    options: {
                        xaxis: {
                            labels: {
                                style: {
                                    fontSize: '10px'
                                }
                            }
                        }
                    }
                }]
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
        $(document).ready(function () {
            const progressCircle = document.querySelector(".autoplay-progress svg");
            const progressContent = document.querySelector(".autoplay-progress span");
            var swiper = new Swiper(".offer-swiper", {
                centeredSlides: true,
                effect: "fade",
                autoplay: {
                    false: true,
                    delay: 4000,
                    disableOnInteraction: false
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev"
                },
            });

            $('.notiflix-confirm').on('click', function () {
                let route = $(this).data('route');
                $('.deleteRoute').attr('action', route)
            })
        });

        $(document).ready(function () {
            $('.offerRemove').on('click', function () {
                $('.removeOfferId').val($(this).data('resource'));
            })

            $('.offerReject').on('click', function () {
                $('.rejectOfferId').val($(this).data('resource'));
            })

            $('.offerAccept').on('click', function () {
                $('.acceptOfferId').val($(this).data('resource'));
            })
        })
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

