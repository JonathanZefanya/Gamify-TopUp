@extends(template().'layouts.app')
@section('title','Instruction Page')
@section('content')
    <section class="error pt_120 pb_120 {{ getTheme() == 'dark' ? 'bg-dark' : 'bg-light' }}" >
        <div class="container">
            <div class="error-container w-100 d-flex justify-content-center text-center">
                <div class="error-container-inner">
                    @if(!auth()->guard('admin')->check())
                        <div class="error-image">
                            <img class="errorImageMain" src="{{getTheme() == 'dark' ? asset('assets/global/img/oc-error-light.svg') :asset('assets/global/img/oc-error.svg')}}" alt="error">
                        </div>
                    @elseif(auth()->guard('admin')->check())
                        <div class="">
                            <img src="{{ asset('assets/admin/img/content-add-instruction.png')}}" alt="error">
                        </div>
                    @endif
                    <div class="error-content mt_40">
                        <h3>@lang('Coming Soon Content in') ` {{config('languages.langCode')[app()->currentLocale()] }}
                            `</h3>
                        <p class="mt-2">@lang('If there is no content available in') <span class="text-gradient">`{{config('languages.langCode')[app()->currentLocale()] }}`</span>, @lang('our administrators are working diligently to set up relevant content for our')
                            ` {{config('languages.langCode')[app()->currentLocale()] }}
                            `</span> @lang('audience. We appreciate your patience as we strive to provide valuable information in your preferred language.')
                        </p>
                    </div>
                    @if(auth()->guard('admin')->check())
                        <div class="error-button mt-5">
                            <a href="{{ route('admin.page.index', basicControl()->theme) }}" class="btn-1"><i
                                    class="fa-light fa-tools mr_5 fs_18"></i> @lang('Go To Settings')<span></span></a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
