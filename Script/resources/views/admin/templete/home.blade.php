@extends('admin.layouts.app')
@section('page_title', __('Theme Settings'))
@section('content')
    <div class="content container-fluid" id="homeStyles">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active"
                                aria-current="page">@lang("Theme")</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang("Active Theme")</h1>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            @foreach(config('themes') as $key => $theme)
                <div class="col-xl-5 {{ ($key == 0) ? 'offset-xl-1' : '' }}  col-md-6 col-lg-6 mb-3 mb-md-5">
                    <div class="select-theme">
                        <label class="form-control" for="formControlRadio{{$key}}">
                            <span class="form-check">
                                <input type="radio" class="form-check-input" name="theme" data-theme_name="{{$theme['name']}}" value="{{$key}}"
                                       id="formControlRadio{{$key}}" @checked(basicControl()->theme == $key)>
                                <img class="img-fluid w-100 themeImage"
                                     src="{{ asset($theme['preview']) }}"
                                     alt="Image Description">
                            </span>
                        </label>
                    </div>
                    <div class="text-center">
                        <h5 class="mb-0 bg-warning p-3">@lang($theme['name'])</h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@push('style')
    <style>
        .form-control{
            max-width: 600px;
            width: 100%;
        }
    </style>
@endpush
@push('script')
    <script>
        $(document).ready(function () {
            $('.form-check-input').on('change', function () {
                if ($(this).prop('checked')) {
                    let theme = $(this).val();
                    let theme_name = $(this).data('theme_name');
                    $.ajax({
                        url: '{{ route('admin.select.template') }}',
                        type: 'GET',
                        data: {
                            theme,
                            theme_name
                        },
                        success: function (response) {

                            Notiflix.Notify.success(response.message);
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>
@endpush
