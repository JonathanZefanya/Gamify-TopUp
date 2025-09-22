<!-- Contact section start -->
@if(isset($light_contact))
    @php
        $socialData = getSocialData();
    @endphp
    <section class="contact-section">
        <div class="container">
            <div class="contact-inner">
                <div class="row g-4">
                    <div class="col-xl-5 col-lg-6">
                        <div class="contact-area">
                            <div class="section-header mb-0">
                                <h3>{{ $light_contact['single']['title'] ?? ' ' }}</h3>
                            </div>
                            <p class="para_text">{{ $light_contact['single']['sub_title'] ?? ' ' }}</p>
                            <div class="contact-item-list">
                                <div class="item">
                                    <div class="icon-area">
                                        <i class="fa-light fa-phone"></i>
                                    </div>
                                    <div class="content-area">
                                        <h6 class="mb-0">@lang('Phone'):</h6>
                                        <p class="mb-0">{{ $light_contact['single']['phone'] ?? ' ' }}</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="icon-area">
                                        <i class="fa-light fa-envelope"></i>
                                    </div>
                                    <div class="content-area">
                                        <h6 class="mb-0">@lang('Email'):</h6>
                                        <p class="mb-0">{{ $light_contact['single']['email'] ?? ' ' }}</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="icon-area">
                                        <i class="fa-light fa-location-dot"></i>
                                    </div>
                                    <div class="content-area">
                                        <h6 class="mb-0">@lang('Address'):</h6>
                                        <p class="mb-0">{{ $light_contact['single']['location'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-30">
                                <h5>@lang('Socials')</h5>
                                <ul class="social-box mt-10">
                                    @foreach($socialData['multiple'] as $socialItem)
                                        <li>
                                            <a href="{{ $socialItem['media']->my_link ?? '#' }}">
                                                <i class="{{ $socialItem['media']->icon ?? ' ' }}"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6">
                        <div class="contact-message-area">
                            <div class="contact-header">
                                <h3 class="section-title">{{ $light_contact['single']['form_title'] ?? ' ' }}</h3>
                                <p>{{ $light_contact['single']['form_sub_title'] ?? ' ' }}</p>
                            </div>
                            <form action="{{route('contact.send')}}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <input type="text" class="form-control" placeholder="@lang('Your Name')" name="name" value="{{ old('name') }}">

                                        @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <input type="email" class="form-control" placeholder="@lang('E-mail Address')" name="con_email" value="{{ old('email') }}">
                                        @error('con_email')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <input type="text" class="form-control" placeholder="@lang('Your Subject')" name="subject" value="{{ old('subject') }}">
                                        @error('subject')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="mb  -3 col-12">
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"
                                                  placeholder="@lang('Your Massage')" name="message">{{ old('message') }}</textarea>
                                        @error('message')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="btn-area d-flex justify-content-end">
                                    <button type="submit" class="cmn-btn w-100"><span>{{ $light_contact['single']['button'] }}</span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

