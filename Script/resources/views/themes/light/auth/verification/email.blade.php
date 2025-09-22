@extends(template().'layouts.app')
@section('title',$page_title)
@section('content')
    <section class="login-register-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-9">
                    <div class="login-register-form">
                        <form action="{{ route('user.mailVerify') }}" method="post">
                            @csrf

                            <div class="section-header">
                                <h3>@lang('Email Verification Here!')</h3>
                                <div class="description">@lang('Ensure account security with a quick and simple email verification process. Stay protected, stay connected.')</div>
                            </div>
                            <div class="row g-4">
                                <div class="col-12">
                                    <input type="text" name="code" value="{{ old('code') }}"
                                           class="form-control"
                                           id="exampleInputEmail1"
                                           placeholder="@lang('Code')">
                                    @error('code')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                @if (Route::has('user.resendCode'))
                                    <div class="col-12">
                                        <div
                                            class="form-check d-flex justify-content-between flex-wrap gap-2">
                                            <div class="forgot highlight">
                                                <a href="{{route('user.resendCode')}}?type=email">@lang('Resend code')</a>
                                                @error('resend')
                                                <p class="text-danger mt-1">@lang($message)</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="cmn-btn mt-30 w-100">
                                <span>@lang('Submit')</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

