@extends(template().'layouts.app')
@section('title',trans('Sign Up'))
@push('css-lib')
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/intlTelInput.min.css')}}"/>
@endpush
@section('content')
    <section class="login-register-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8 col-md-10">
                    <div class="login-register-form">
                        <form action="{{ route('register') }}" method="post">
                            @csrf

                            @if(isset($template['authentication']) && $loginRegister = $template['authentication'][0])
                                <div class="section-header">
                                    <h3>{{@$loginRegister->description->register_page_heading}}</h3>
                                    <div
                                        class="description">{{@$loginRegister->description->register_page_sub_heading}}
                                    </div>
                                </div>
                            @endif
                            @if(config('socialite.google_status') || config('socialite.facebook_status') || config('socialite.github_status'))
                                <div class="row g-2">
                                    @if(config('socialite.google_status'))
                                        <div class="col-sm-4">
                                            <a href="{{route('socialiteLogin','google')}}" class="social-btn w-100"><img
                                                    src="{{ asset(template(true).'img/login-signup/google.png') }}" alt="Google Icon">@lang('Google')</a>
                                        </div>
                                    @endif
                                    @if(config('socialite.facebook_status'))
                                        <div class="col-sm-4">
                                            <a href="{{route('socialiteLogin','facebook')}}" class="social-btn w-100"><img
                                                    src="{{ asset(template(true).'img/login-signup/facebook.png') }}" alt="Facebook Icon">@lang('Facebook')</a>
                                        </div>
                                    @endif
                                    @if(config('socialite.github_status'))
                                        <div class="col-sm-4">
                                            <a href="{{route('socialiteLogin','github')}}" class="social-btn w-100"><img
                                                    src="{{ asset(template(true).'img/login-signup/github.png') }}" alt="Github Icon">@lang('Github')</a>
                                        </div>
                                    @endif
                                </div>
                                <hr class="divider">
                            @endif
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <input type="text" name="first_name" value="{{old('first_name')}}"
                                           class="form-control" id="exampleInputEmail0"
                                           placeholder="@lang('First Name')">
                                    @error('first_name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="last_name" value="{{old('last_name')}}"
                                           class="form-control" id="exampleInputEmail0"
                                           placeholder="@lang('Last Name')">
                                    @error('last_name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="username" value="{{old('username')}}"
                                           class="form-control" id="exampleInputEmail3"
                                           placeholder="@lang('Username')">
                                    @error('username')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" value="{{old('email')}}"
                                           class="form-control" id="exampleInputEmail4"
                                           placeholder="@lang('Email')">
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <input id="telephone" class="form-control" name="phone" type="tel">
                                    <input type="hidden" name="phone_code" id="phoneCode"/>
                                    <input type="hidden" name="country" id="countryName"/>
                                    <input type="hidden" name="country_code" id="countryCode"/>
                                    @error('phone')
                                    <span class="text-danger">@lang($message)</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="password-box">
                                        <input type="password" name="password" value="{{old('password')}}"
                                               class="form-control password"
                                               id="exampleInputPassword1" placeholder="@lang('Password')">
                                        <i class="password-icon fa-regular fa-eye"></i>
                                    </div>
                                    @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="password-box">
                                        <input type="password" value="{{ old('password_confirmation') }}"
                                               class="form-control password"
                                               id="exampleInputPassword2"
                                               placeholder="@lang('Confirm Password')" name="password_confirmation">
                                        <i class="password-icon fa-regular fa-eye"></i>
                                    </div>
                                </div>

                                @if((basicControl()->google_recaptcha == 1) && (basicControl()->google_reCaptcha_status_registration))
                                    <div class="row mt-4">
                                        <div
                                            class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror"
                                            data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                        @error('g-recaptcha-response')
                                        <span class="invalid-feedback d-block text-danger" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                    </span>
                                        @enderror
                                    </div>
                                @endif
                                @if(basicControl()->manual_recaptcha &&  basicControl()->reCaptcha_status_registration)
                                    <div class="col-12">
                                        <input type="text" tabindex="2"
                                               class="form-control @error('captcha') is-invalid @enderror"
                                               name="captcha" id="captcha" autocomplete="off"
                                               placeholder="@lang('Enter captcha code')">

                                        @error('captcha')
                                        <div class="text-danger">@lang($message)</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <div
                                            class="input-group input-group-merge d-flex justify-content-between"
                                            data-hs-validation-validate-class>
                                            <img src="{{route('captcha').'?rand='. rand()}}"
                                                 id='captcha_image2'>
                                            <a class="input-group-append input-group-text"
                                               href='javascript: refreshCaptcha2();'>
                                                <i class="fal fa-sync"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="cmn-btn mt-30 w-100"><span>@lang('signup')</span></button>
                            <div class="pt-20 text-center">
                                @lang("Don't have an account?")
                                <p class="mb-0 highlight mt-1"><a href="{{ route('login') }}">@lang('Login Here')</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js-lib')
    <script src="{{ asset(template(true) . 'js/intlTelInput.min.js')}}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
@push('extra_scripts')
    <script>
        'use strict';
        const input = document.querySelector("#telephone");
        const iti = window.intlTelInput(input, {
            initialCountry: "bd",
            separateDialCode: true,
        });

        function updateCountryInfo() {
            const selectedCountryData = iti.getSelectedCountryData();
            const phoneCode = selectedCountryData.dialCode;
            const countryName = selectedCountryData.name;
            const countryCode = selectedCountryData.iso2;
            $('#phoneCode').val(phoneCode)
            $('#countryName').val(countryName)
            $('#countryCode').val(countryCode)
        }

        input.addEventListener("countrychange", updateCountryInfo);
        updateCountryInfo();

        function refreshCaptcha() {
            let img = document.images['captcha_image'];
            img.src = img.src.substring(
                0, img.src.lastIndexOf("?")
            ) + "?rand=" + Math.random() * 1000;
        }

        function refreshCaptcha2() {
            let img = document.images['captcha_image2'];
            img.src = img.src.substring(
                0, img.src.lastIndexOf("?")
            ) + "?rand=" + Math.random() * 1000;
        }

    </script>
@endpush
