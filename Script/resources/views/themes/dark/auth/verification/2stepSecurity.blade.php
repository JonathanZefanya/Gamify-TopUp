@extends(template().'layouts.app')
@section('title',$page_title)
@section('content')
    <section class="login-register-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-9">
                    <div class="login-register-form">
                        <form action="{{ route('user.twoFA-Verify') }}" method="post">
                            @csrf

                            <div class="section-header">
                                <h3>@lang('2FA Verification here!')</h3>
                                <div class="description">@lang('Please enter the verification code to authenticate your identity and proceed with the verification process.')</div>
                            </div>
                            <div class="row g-4">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <input type="text" name="code" value="{{ old('code') }}"
                                               class="form-control"
                                               id="exampleInputEmail1"
                                               placeholder="@lang('2 FA Code')">
                                        @error('code')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
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

