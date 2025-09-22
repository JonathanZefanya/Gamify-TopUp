@extends(template().'layouts.error')
@section('title','419')
@section('content')
    <section class="error-section">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-sm-6">
                    <div class="error-thum">
                        <img src="{{asset('assets/global/img/oc-error-light.svg')}}" alt="...">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="error-content">
                        <div class="error-title">@lang('419')</div>
                        <div class="error-info">{{trans('Sorry, your session has expired')}}</div>
                        <div class="btn-area">
                            <a href="{{url('/')}}" class="cmn-btn">@lang('Back To Home')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

