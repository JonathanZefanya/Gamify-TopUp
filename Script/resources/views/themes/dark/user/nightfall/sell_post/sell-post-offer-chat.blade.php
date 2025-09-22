@extends(template() . 'layouts.user')
@section('title', trans('Conversation'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="pagetitle mt-20">
                <h4 class="mb-1">@lang('Conversation')</h4>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Conversation')</li>
                    </ol>
                </nav>
            </div>

            <div class="section dashboard">
                <!-- Chat section start -->
                <form action="">
                    <div class="message-container">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <div class="message-sidebar">
                                    <ul class="conversations-wrapper p-0">

                                        <li class=" active">
                                            <div class="game-box d-md-flex">
                                                <div class="img-box d-none">
                                                    <img src="{{getFile('dummy','dummy')}}" class="img-fluid" alt="...">
                                                </div>

                                                <div>
                                                    <h5 class="name">{{$sellPost->title}} <a target="_blank"
                                                            href="{{route('sellPost.details',[@slug($sellPost->title),$sellPost->id])}}"><i
                                                                class="far fa-external-link"></i></a></h5>
                                                    <div class="d-flex justify-content-between">
                                                        <span
                                                            class="game-level pe-1">@lang('Price'): <span>{{basicControl()->currency_symbol}}{{$sellPost->price}}</span></span>

                                                        @if($sellPost->payment_lock == 1)
                                                            @if($sellPost->payment_status==1)
                                                                <span
                                                                    class="badge text-bg-success">@lang('Payment Completed')</span>
                                                            @elseif($sellPost->payment_status ==0 && \Carbon\Carbon::now() < Carbon\Carbon::parse($sellPost->lock_at)->addMinutes(basicControl()->payment_expired))
                                                                @if(Auth::check() && Auth::id()==$sellPost->lock_for)
                                                                    <span
                                                                        class="badge text-bg-secondary">@lang('Waiting Payment')</span>
                                                                @elseif(Auth::check() &&  Auth::id()==$sellPost->user_id)
                                                                    <span
                                                                        class="badge text-bg-warning">@lang('Payment Processing')</span>
                                                                @else
                                                                    <span
                                                                        class="badge text-bg-secondary">@lang('Going to Sell')</span>
                                                                @endif
                                                            @else
                                                                <span
                                                                    class="badge text-bg-success">@lang('Accepted')</span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div class="row g-2 mt-3 more-info">
                                                        @forelse($sellPost->post_specification_form as $k => $v)
                                                            <div class="col-6">
                                                                <span>{{$v->field_name}}: {{$v->field_value}}</span>
                                                            </div>
                                                        @empty
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="chat-box">
                                    <div class="header-section">
                                        <div class="profile-info">
                                            <p class="pt-2 ps-2"><i class="fas fa-users "></i> {{trans('Conversation')}}
                                            </p>
                                        </div>
                                        <div class="single-btn-box d-none d-sm-flex d-flex justify-content-sm-end ">
                                            <div class="d-flex">
                                                @if(!empty($persons))
                                                    @forelse($persons as $person)
                                                        <div title="admin"
                                                             class="d-flex flex-row justify-content-start me-1">
                                                            <a href="javascript:void(0)"
                                                               title="{{'@'.$person->username}}"
                                                               class="mr-1 position-relative">
                                                                <i class="batti position-absolute fa fa-circle text-{{($person->LastSeenActivity == true) ?trans('success'):trans('warning') }} font-12"
                                                                   title="{{($person->LastSeenActivity == true) ?trans('Online'):trans('Away') }}"></i>
                                                                <img class="person-image"
                                                                     src="{{ getFile($person->image_driver, $person->image) }}"
                                                                     width="30" height="30"></a>
                                                        </div>
                                                    @empty
                                                    @endforelse
                                                @endif
                                            </div>
                                            @if($isAuthor == true)
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <div class="btn-group" role="group">
                                                        <button id="offerActionBtn" type="button"
                                                                class="cmn-btn2 dropdown-toggle"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="offerActionBtn">
                                                            <li><a class="dropdown-item paymentLock"
                                                                   href="javascript:void(0)"
                                                                   data-offer="{{$offerRequest->user->fullname}}"
                                                                   data-resource="{{$offerRequest->id}}" data-
                                                                   data-bs-toggle="modal"
                                                                   data-bs-target="#offerPaymentLock"><i
                                                                        class="text-success fa fa-check-circle"></i> @lang('Payment Lock')
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div id="pushChatArea">
                                        <div class="chat-box-inner" ref="chatArea">
                                            <div v-for="(item, index) in items" :key="index">
                                                <div
                                                    v-if="item.chatable_id == auth_id && item.chatable_type == auth_model"
                                                    class="d-flex flex-row justify-content-end p-3"
                                                    :title="item.chatable.username">
                                                    <div
                                                        class="me-2 pt-1 ps-2 pe-2 position-relative mw-130 userMessageOption">
                                                        <span class="text-wa">@{{ item.description }}</span>
                                                        <span class="timmer">@{{ item.formatted_date }}</span>
                                                    </div>
                                                    <img :src="item.chatable.imgPath" width="30" height="30"
                                                         alt="User Image" class="userImageChat">
                                                </div>

                                                <div
                                                    v-else
                                                    class="d-flex flex-row justify-content-start p-3"
                                                    :title="item.chatable.username">
                                                    <img :src="item.chatable.imgPath" width="30" height="30"
                                                         alt="User Image" class="userImageChat">
                                                    <div
                                                        class="chat ms-2 pt-1 ps-2 pe-5 position-relative mw-130 userMessageOption">
                                                        <span>@{{ item.description }}</span>
                                                        <span class="timmer">@{{ item.formatted_date }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat-box-bottom w-100">
                                            <form @submit.prevent="send" enctype="multipart/form-data" method="post"
                                                  class="p-0 w-100">
                                                <div
                                                    class="writing-box d-flex justify-content-between align-items-center w-100">
                                                    <div class="input-group px-3 mt-2">
                                                        <input
                                                            class="form-control type_msg"
                                                            v-model.trim="message"
                                                            placeholder="Type your message"
                                                        />
                                                    </div>
                                                    <div class="send text-center">
                                                        <button type="button" class="btn btn-success" @click="send">
                                                            <i class="fas fa-paper-plane"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($isAuthor == true)
        <!-- Offer Payment Lock -->
        <div class="modal fade" id="offerPaymentLock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content ">
                    <div class="modal-header modal-colored-header bg-custom">
                        <h4 class="modal-title" id="myModalLabel">@lang('Confirmation')</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true">
                        </button>
                    </div>
                    <form action="{{route('user.sellPostOfferPaymentLock')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" class="sellPostPaymentLock" name="offer_id" value="">
                            <div class="mb-3">
                                <p>@lang('Are you sure to payment lock for') <span
                                        class="offerBy font-weight-bold"></span>?</p>
                            </div>

                            <div class="form-group">
                                <label>@lang('Amount')</label>
                                <div class="input-group">
                                    <input type="text" name="amount" class="form-control earn" required="">
                                    <button class="cmn-btn2 copy-btn">{{basicControl()->base_currency}}</button>
                                </div>
                                @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="cmn-btn">@lang('Submit')
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('style')
    <style>
        .sell-post-details .game-box {
            position: relative;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 10px;
        }

        .sell-post-details .game-box .img-box {
            margin-right: 15px;
        }

        .sell-post-details .game-box .img-box img {
            width: 200px;
            border-radius: 10px;
        }

        .sell-post-details .game-box .more-info {
            text-transform: capitalize;
        }

        .sell-post-details .game-box .name {
            margin-bottom: 5px;
        }

        .sell-post-details .game-box .game-level {
            color: var(--body-font);
            text-transform: capitalize;
        }

        .sell-post-details .game-box .game-btn-sm {
            font-size: 13px;
            height: 45px;
            padding-top: 3px;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .sell-post-details .game-box .game-btn-sm img {
            width: 14px;
            right: -5px;
        }


        .sell-post-details .game-box {
            position: relative;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 10px;
        }

        .sell-post-details .game-box .img-box {
            margin-right: 15px;
            width: 200px;
            height: 200px;
        }

        .sell-post-details .game-box .img-box img {
            min-width: 200px;
            width: 200px;
            height: 200px;
            border-radius: 10px;
        }

        .sell-post-details .game-box .img-box.owl-carousel .owl-dots {
            text-align: center;
            position: relative;
            top: -33px;
        }

        .sell-post-details .game-box .img-box.owl-carousel .owl-dots button.owl-dot {
            margin: 0 3px;
            width: 15px;
            height: 15px;
            border-radius: 20px;
            background: var(--bg-color2);
        }

        .sell-post-details .game-box .img-box.owl-carousel .owl-dots button.owl-dot.active {
            background: var(--bg-color2);
        }

        .sell-post-details .game-box .more-info {
            text-transform: capitalize;
        }

        .sell-post-details .game-box .name {
            margin-bottom: 5px;
        }

        .sell-post-details .game-box .game-level {
            color: var(--body-color);
            text-transform: capitalize;
        }

        .sell-post-details .game-box .game-btn-sm {
            font-size: 13px;
            height: 45px;
            padding-top: 3px;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .sell-post-details .game-box .game-btn-sm img {
            width: 14px;
            right: -5px;
        }

        .game-box {
            padding: 20px 30px;
        }

        .user .batti {
            font-size: 10px;
            right: 3% !important;
            bottom: 12% !important;
        }

        .fa-circle:before {
            content: "\f111";
            position: absolute;
            bottom: -35px;
            right: -32px;
            font-size: 11px;
        }

        .person-image {
            border-radius: 50%;
        }

        .dropdown-toggle::after {
            display: none;
        }

        .userImageChat {
            height: 30px;
            width: 30px;
            border-radius: 50%;
        }

        .userMessageOption {
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: var(--bg-color3);
            padding-bottom: 7px;
            background: var(--bg-color3);
            border-radius: 6px;
        }

        .userMessageOption .timmer {
            font-size: 12px;
        }
    </style>
@endpush

@push('script')

    <script>
        'use strict';
        let pushChatArea = new Vue({
            el: "#pushChatArea",
            data: {
                items: [],
                auth_id: "{{ auth()->id() }}",
                auth_model: "App\\Models\\User",
                message: "",
            },
            beforeMount() {
                this.getNotifications();
                this.pushNewItem();
            },
            methods: {
                getNotifications() {
                    axios
                        .get("{{ route('user.push.chat.show', $offerRequest->uuid) }}")
                        .then((res) => {
                            this.items = res.data;
                            this.$nextTick(() => {
                                const chatArea = this.$refs.chatArea;
                                if (chatArea) chatArea.scrollTop = chatArea.scrollHeight;
                            });
                        })
                        .catch((error) => {
                            console.error("Error fetching notifications:", error);
                        });
                },
                pushNewItem() {
                    const pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
                        encrypted: true,
                        cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
                    });

                    const channel = pusher.subscribe(
                        "offer-chat-notification." + "{{ $offerRequest->uuid }}"
                    );

                    channel.bind("App\\Events\\OfferChatNotification", (data) => {
                        this.items.push(data.message);
                        const audio = document.getElementById("myAudio");
                        if (audio) audio.play();

                        this.$nextTick(() => {
                            const chatArea = this.$refs.chatArea;
                            if (chatArea) chatArea.scrollTop = chatArea.scrollHeight;
                        });
                    });

                    channel.bind("App\\Events\\UpdateOfferChatNotification", () => {
                        this.getNotifications();
                        console.log("Chat updated");
                    });
                },
                send() {
                    if (this.message.trim() === "") {
                        Notiflix.Notify.failure("{{ trans('Type your message') }}");
                        return;
                    }

                    axios
                        .post("{{ route('user.push.chat.newMessage') }}", {
                            offer_id: "{{ $offerRequest->id }}",
                            sell_post_id: "{{ $offerRequest->sell_post_id }}",
                            message: this.message.trim(),
                        })
                        .then((res) => {
                            if (res.data.errors) {
                                Object.values(res.data.errors).forEach((error) =>
                                    Notiflix.Notify.failure(error)
                                );
                                return;
                            }

                            if (res.data.success) {
                                this.message = "";
                                this.$nextTick(() => {
                                    const chatArea = this.$refs.chatArea;
                                    if (chatArea) chatArea.scrollTop = chatArea.scrollHeight;
                                });
                            }
                        })
                        .catch((error) => {
                            console.error("Error sending message:", error);
                        });
                },
            },
        });
    </script>


    <script>

        $(document).ready(function () {
            $('.paymentLock').on('click', function () {
                $('.sellPostPaymentLock').val($(this).data('resource'));
                $('.offerBy').text($(this).data('offer'));
            })
        })

    </script>

    @if($errors->any())
        <script>
            'use strict';
            @foreach ($errors->all() as $error)
            Notiflix.Notify.failure(`{{trans($error)}}`);
            @endforeach
        </script>
    @endif
@endpush
