@extends(template().'layouts.app')
@section('title',trans('Recover Password'))
@section('content')
    <section class="login-register-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-xl-6 col-lg-7 col-md-9">
                    <div class="login-register-form">
                        <form action="{{ route('user.password.email') }}" method="post">
                            @csrf

                            <div class="section-header">
                                <h3>@lang('Recover Password!')</h3>
                                <div class="description">@lang('Regain access with your seamless and secure account retrieval process in just a few clicks!')</div>
                            </div>
                            <div class="row g-4">
                                <div class="col-12">
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="exampleInputEmail1"
                                           placeholder="@lang("Email address")">
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="cmn-btn mt-30 w-100">
                                <span>@lang('Send Link')</span>
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
