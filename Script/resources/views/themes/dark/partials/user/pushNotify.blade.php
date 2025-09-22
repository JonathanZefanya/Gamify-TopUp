@if(basicControl()->in_app_notification)

    @php
        $class = getTextColorClass();
    @endphp
    <li class="nav-item dropdown" id="pushNotificationArea">
        <a class="nav-link nav-icon notificationDropIcon" href="javascript:void(0)" data-bs-toggle="dropdown">
            <i class="fa-light fa-bell notify-bell"></i>
            <span class="badge badge-number notificationDropNum" v-cloak>@{{items.length}}</span>
        </a>

        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <div class=" {{ $class }} " :class="{'dropdown-header': true, 'border-bottom': items.length > 0}">
                @lang('You have ') @{{items.length}} @lang(' new notifications')
            </div>
            <div class="dropdown-body">
                <div class="notification-item" v-for="(item, index) in items"
                     @click.prevent="readAt(item.id, item.description.link)">
                    <a :href="item.description.link">
                        <i class="fa-light fa-bell-on text-warning"></i>
                        <div>
                            <p class=" {{ $class }} "
                                v-cloak>
                                @{{ item.description.text }}
                            </p>
                            <p class=" {{ $class }} "
                                v-cloak>
                                @{{ item.formatted_date }}
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="dropdown-footer">
                <a href="javascript:void(0)" v-if="items.length > 0"
                   @click.prevent="readAll">@lang('Clear all notification')</a>
            </div>
        </div>
    </li>

    <style>
        #pushNotificationArea .dropdown-menu{
            min-width: 22rem !important;
            padding: 15px;
        }
        #pushNotificationArea .notification-item{
            border-bottom: 1px solid var(--border-color2);
        }
        #pushNotificationArea .notification-item a{
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 10px 0;
        }
        #pushNotificationArea .border-bottom{
            border-bottom: 1px solid var(--border-color2) !important;
        }
        #pushNotificationArea .notification-item a:hover{
            background: var(--bg-color2);
        }
        #pushNotificationArea .notification-item a i{
            font-size: 24px;
        }
        #pushNotificationArea .dropdown-header{
            color: #fff;
            font-size: 18px;
        }
        .dark-theme .text-dark{
            color: #fff !important;
        }
        #pushNotificationArea .dropdown-footer{
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 0 0 0;
            color: #fff;
        }
        .notify-bell{
            font-size: 19px;
        }
    </style>
    @push('script')
        <script defer>
            'use strict';
            let pushNotificationArea = new Vue({
                el: "#pushNotificationArea",
                data: {
                    items: [],
                },
                mounted() {
                    this.getNotifications();
                    this.pushNewItem();
                },
                methods: {
                    getNotifications() {
                        let app = this;
                        axios.get("{{ route('user.push.notification.show') }}")
                            .then(function (res) {
                                app.items = res.data;
                            })
                    },
                    readAt(id, link) {
                        let app = this;
                        let url = "{{ route('user.push.notification.readAt', 0) }}";
                        url = url.replace(/.$/, id);
                        axios.get(url)
                            .then(function (res) {
                                if (res.status) {
                                    app.getNotifications();
                                    if (link !== '#') {
                                        window.location.href = link
                                    }
                                }
                            })
                    },
                    readAll() {
                        let app = this;
                        let url = "{{ route('user.push.notification.readAll') }}";
                        axios.get(url)
                            .then(function (res) {
                                if (res.status) {
                                    app.items = [];
                                }
                            })
                    },
                    pushNewItem() {
                        this.pusherCall();
                    },
                    pusherCall() {
                        let app = this;
                        Pusher.logToConsole = false;
                        let pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
                            encrypted: true,
                            cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
                        });
                        let channel = pusher.subscribe('user-notification.' + "{{ Auth::id() }}");
                        channel.bind('App\\Events\\UserNotification', function (data) {
                            app.items.unshift(data.message);
                        });
                        channel.bind('App\\Events\\UpdateUserNotification', function (data) {
                            app.getNotifications();
                        });
                    },
                }
            });
        </script>
    @endpush
@endif
