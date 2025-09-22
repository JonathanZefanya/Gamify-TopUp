<!-- Footer Section start -->
@php
    $footer = footerData();
@endphp
@if(isset($footer))
    <section class="footer-section">
        <div class="container">
            <div class="row gy-4 g-sm-5">
                <div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="500">
                    <div class="footer-widget footer-widget-1">
                        <div class="widget-logo">
                            <a href="{{ route('page', '/') }}"><img class="footer-logo" src="{{ getFile(basicControl()->logo_driver, basicControl()->logo) }}" alt="{{ basicControl()->site_title }}"></a>
                        </div>
                        <p>{{ $footer['single']['message'] }}</p>
                        <ul class="social-box mt-30">
                            @foreach($footer['multiple'] as $item)
                                <li><a href="{{ @$item['media']->my_link }}" aria-label="{{ @$item['name'] }}"><i
                                            class="{{ @$item['media']->icon }}"></i></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6" data-aos="fade-up" data-aos-duration="700">
                    <div class="footer-widget">
                        <h5 class="widget-title">@lang('Useful Link')</h5>
                        <ul>
                            @if(getFooterMenuData('useful_link') != null)
                                @foreach(getFooterMenuData('useful_link') as $list)
                                    {!! $list !!}
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 pt-sm-0 pt-3 ps-lg-5" data-aos="fade-up" data-aos-duration="900">
                    <div class="footer-widget">
                        <h5 class="widget-title">@lang('Company Policy')</h5>
                        <ul>
                            @if(getFooterMenuData('support_link') != null)
                                @foreach(getFooterMenuData('support_link') as $list)
                                    {!! $list !!}
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 pt-sm-0 pt-3" data-aos="fade-up" data-aos-duration="1100">
                    <div class="footer-widget">
                        <h5 class="widget-title">{{ $footer['single']['newsletter_text'] }}</h5>
                        <p>@lang('Subscribe To Our Mailing List And Stay Up To Date')</p>
                        <form class="newsletter-form" action="{{route('subscribe')}}" method="post">
                            @csrf

                            <input type="text" class="form-control" placeholder="Your email" name="email">
                            <button type="submit" class="subscribe-btn"><i
                                    class="fa-regular fa-paper-plane"></i></button>
                        </form>
                        @error('email')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer Section end -->

    <!-- Copyright section start -->
    <div class="copyright-section">
        <div class="container">
            <div class="copyright-inner">
                <div class="row gy-4 align-items-center">
                    <div class="col-sm-6">
                        <p class="mb-0 text-center text-sm-start">{{ $footer['single']['copyright_text_one'] ?? ' ' }} <a class="highlight" href="{{ route('page', '/') }}">{{ basicControl()->site_title }}</a> {{ $footer['single']['copyright_text_two'] ?? ' ' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright section end -->
@endif

