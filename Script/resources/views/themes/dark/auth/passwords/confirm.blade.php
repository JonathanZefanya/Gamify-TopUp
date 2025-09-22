@extends(template().'layouts.app')
@section('title',trans('Confirm Password'))
@section('content')

    <section class="login-register-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-9">
                    <div class="login-register-form">
                        <form action="{{ route('password.email') }}" method="post">
                            @csrf

                            <div class="section-header">
                                <h3>@lang('Confirm Password!')</h3>
                                <div class="description">@lang('Please enter your new password again to confirm and ensure accuracy.')</div>
                            </div>
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
                            </div>
                            <button type="submit" class="cmn-btn mt-30 w-100">
                                <span>@lang('Confirm Password')</span>
                            </button>
                            @if (Route::has('password.request'))
                                <div class="pt-20 text-center">
                                    <p class="mb-0 highlight mt-1"><a
                                            href="{{ route('password.request') }}">@lang('Forgot Your Password')</a>
                                    </p>
                                </div>
                            @endif
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
