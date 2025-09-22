@extends(template().'layouts.error')
@section('title','405')
@section('content')
    <section class="error-section">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-sm-6">
                    <div class="error-thum">
                        <img src="{{asset('assets/global/img/oc-error.svg')}}" alt="...">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="error-content">
                        <div class="error-title">@lang('405')</div>
                        <div class="error-info">{{trans('Method Not Allowed')}}</div>
                        <div class="btn-area">
                            <a href="{{url('/')}}" class="cmn-btn">@lang('Back To Home')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
