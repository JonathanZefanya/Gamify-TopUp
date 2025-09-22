@extends(template().'layouts.app')
@section('title',trans('Login'))
@section('content')
    <section class="login-register-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-9">
                    <div class="login-register-form">
                        <form action="{{ route('login') }}" method="post">
                            @csrf

                            @if(isset($template['authentication']) && $loginRegister = $template['authentication'][0])
                                <div class="section-header">
                                    <h3>{{@$loginRegister->description->login_page_heading}}</h3>
                                    <div
                                        class="description">{{@$loginRegister->description->login_page_sub_heading}}
                                    </div>
                                </div>
                            @endif

                            @if(config('socialite.google_status') || config('socialite.facebook_status') || config('socialite.github_status'))
                                <div class="row g-2">
                                    @if(config('socialite.google_status'))
                                        <div class="col-sm-4">
                                            <a href="{{route('socialiteLogin','google')}}" class="social-btn w-100"><img
                                                    src="{{ asset(template(true).'img/login-signup/google.png') }}"
                                                    alt="Google Icon">@lang('Google')</a>
                                        </div>
                                    @endif
                                    @if(config('socialite.facebook_status'))
                                        <div class="col-sm-4">
                                            <a href="{{route('socialiteLogin','facebook')}}"
                                               class="social-btn w-100"><img
                                                    src="{{ asset(template(true).'img/login-signup/facebook.png') }}"
                                                    alt="Facebook Icon">@lang('Facebook')</a>
                                        </div>
                                    @endif
                                    @if(config('socialite.github_status'))
                                        <div class="col-sm-4">
                                            <a href="{{route('socialiteLogin','github')}}" class="social-btn w-100"><img
                                                    src="{{ asset(template(true).'img/login-signup/github.png') }}"
                                                    alt="Github Icon">@lang('Github')</a>
                                        </div>
                                    @endif
                                </div>
                                <hr class="divider">
                            @endif
                            <div class="row g-4">
                                <div class="col-12">
                                    <input type="text" name="username" value="{{request()->username,old('username')}}"
                                           class="form-control"
                                           id="exampleInputEmail1"
                                           placeholder="@lang("Enter Email or Username")">
                                    @error('username')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="password-box">
                                        <input type="password" name="password" value="{{request()->password}}"
                                               class="form-control password"
                                               id="exampleInputPassword1" placeholder="@lang('Password')">
                                        <i class="password-icon fa-regular fa-eye"></i>
                                    </div>
                                    @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                @if((basicControl()->google_recaptcha == 1) && (basicControl()->google_reCaptcha_status_login))
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
                                @if(basicControl()->manual_recaptcha &&  basicControl()->reCaptcha_status_login)
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
                                <div class="col-12">
                                    <div class="form-check d-flex justify-content-between flex-wrap gap-2">
                                        <div class="check">
                                            <input type="checkbox" name="remember" class="form-check-input"
                                                   id="exampleCheck1" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                   for="exampleCheck1">@lang('Remember me')</label>
                                        </div>
                                        <div class="forgot highlight">
                                            <a href="{{ route('password.request') }}">@lang('Forgot password?')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="cmn-btn mt-30 w-100"><span>@lang('Log In')</span></button>

                            <div class="pt-20 text-center">
                                @lang("Don't have an account?")
                                <p class="mb-0 highlight mt-1"><a
                                        href="{{ route('register') }}">@lang('Create an account')</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('js-lib')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush

@push('extra_scripts')
    <script>
        'use strict';

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
