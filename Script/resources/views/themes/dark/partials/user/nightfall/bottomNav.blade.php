<!-- Bottom Mobile Tab nav section start -->
<ul class="nav bottom-nav fixed-bottom d-xl-none">
    <li class="nav-item">
        <a class="nav-link  toggle-sidebar-btn" aria-current="page">
            <i class="fa-regular fa-list"></i>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{menuActive('user.add.fund')}}" href="{{route('user.add.fund')}}"><i
                class="fa-regular fa-wallet"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{menuActive('user.dashboard')}}" href="{{route('user.dashboard')}}"><i
                class="fa-regular fa-house"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{menuActive('user.transaction')}}" href="{{route('user.transaction')}}"><i
                class="fa-regular fa-exchange-alt"></i></a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{menuActive('user.profile')}}" href="{{route('user.profile')}}"><i
                class="fa-regular fa-user"></i></a>
    </li>
</ul>
<!-- Bottom Mobile Tab nav section end -->
