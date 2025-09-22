@php
    $footer = footerData();
@endphp

@if(isset($footer))
    <section class="footer-section">
        <div class="newsletter-section " data-aos="fade-up" data-aos-duration="500">
            <div class="container">
                <div class="newsletter-section-inner">
                    <div class="row align-items-center g-4 g-sm-5">
                        <div class="col-lg-6 col-md-5" >
                            <div class="content-area">
                                <h2 class="subscribe-normal-text">{{ @$footer['single']['newsletter_text'] }}</h2>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-7">
                            <form class="newsletter-form" action="{{route('subscribe')}}" method="post">
                                @csrf

                                <input type="text" class="form-control" placeholder="Enter your mail" name="email">
                                <button type="submit" class="subscribe-btn">{{ @$footer['single']['newsletter_button'] }}</button>
                            </form>
                            @error('email')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Newsletter section end -->
        <div class="container">
            <div class="row gy-4 gy-sm-5">
                <div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-duration="500">
                    <div class="footer-widget footer-widget-1">
                        <div class="widget-logo">
                            <a href="{{ route('page', '/') }}"><img class="footer-logo" src="{{ getFile(basicControl()->logo_driver, basicControl()->logo) }}" alt="GEMOT"></a>
                        </div>
                        <p>
                            {{ @$footer['single']['message'] }}
                        </p>

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
                        <h5 class="widget-title">@lang('Support Link')</h5>
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
                        <h5 class="widget-title">@lang('Contact Us')</h5>
                        <p class="contact-item"><i class="fa-regular fa-location-dot"></i>{{ @$footer['single']['footer_location'] }}</p>
                        <p class="contact-item"><i class="fa-regular fa-envelope"></i>{{ @$footer['single']['footer_email'] }}</p>
                        <p class="contact-item"><i class="fa-regular fa-phone"></i>{{ @$footer['single']['footer_phone'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

