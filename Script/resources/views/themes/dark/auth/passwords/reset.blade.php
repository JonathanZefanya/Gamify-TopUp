@extends(template().'layouts.app')
@section('title',trans('Reset Password'))
@section('content')

    <section class="login-register-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-9">
                    <div class="login-register-form">
                        <form action="{{ route('password.reset.update') }}" method="post">
                            @csrf

                            <div class="section-header">
                                <h3>@lang('Reset Password!')</h3>
                                <div class="description">@lang('Initiate the password reset process effortlessly and securely to regain control of your account with just a few simple steps.')</div>
                            </div>
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="password-box">
                                        <input type="password" name="password" value="{{ old('password') }}"
                                               class="form-control password"
                                               id="exampleInputPassword1" placeholder="@lang('Password')">
                                        <i class="password-icon fa-regular fa-eye"></i>
                                    </div>
                                    @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <div class="password-box">
                                        <input type="password" name="password_confirmation"
                                               class="form-control password"
                                               id="exampleInputPassword2" placeholder="@lang('Confirm New Password')">
                                        <i class="password-icon fa-regular fa-eye"></i>
                                    </div>
                                    @error('password_confirmation')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="cmn-btn mt-30 w-100">
                                <span>@lang('Reset Password')</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        @if($errors->any())
        @foreach($errors->all() as $error)
        Notiflix.Notify.failure("{{ $error }}");
        @endforeach
        @endif
    </script>
@endsection
