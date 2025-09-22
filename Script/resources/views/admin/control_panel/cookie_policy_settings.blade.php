@extends('admin.layouts.app')
@section('page_title', __('Cookie Policy'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">@lang('Cookie Policy Settings')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ route('admin.dashboard') }}">
                                    @lang('Dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Settings')</li>
                            <li class="breadcrumb-item active"
                                aria-current="page">@lang('Cookie Policy Settings')</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('admin.control_panel.components.sidebar', ['settings' => config('generalsettings.settings'), 'suffix' => 'settings'])
            </div>
            <div class="col-lg-9">
                <div class="d-grid gap-3 gap-lg-5">
                    <div class="card">
                        <div class="card-header">
                            @lang('Cookie Settings')
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.cookiePolicy.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-4">
                                    <label for="cookie_heading" class="col-sm-3 col-form-label form-label">@lang("Cookie Heading")</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               class="form-control @error('cookie_heading') is-invalid @enderror"
                                               name="cookie_heading" id="cookie_heading"
                                               placeholder="@lang("Cookie Heading")"
                                               value="{{ old('cookie_heading', basicControl()->cookie_heading) }}"
                                               autocomplete="off">
                                        @error('cookie_heading')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="cookie_description" class="col-sm-3 col-form-label form-label">@lang("Cookie Description")</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               class="form-control @error('cookie_description') is-invalid @enderror"
                                               name="cookie_description" id="cookie_description"
                                               placeholder="@lang("Cookie Description")"
                                               value="{{ old('cookie_description', basicControl()->cookie_description) }}"
                                               autocomplete="off">
                                        @error('cookie_description')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="cookie_button" class="col-sm-3 col-form-label form-label">@lang("Cookie Button Name")</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               class="form-control @error('cookie_button') is-invalid @enderror"
                                               name="cookie_button" id="cookie_button"
                                               placeholder="@lang("Cookie Button Name")"
                                               value="{{ old('cookie_button', basicControl()->cookie_button) }}"
                                               autocomplete="off">
                                        @error('cookie_button')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label for="cookie_button_link" class="col-sm-3 col-form-label form-label">@lang("Cookie Button Link")</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               class="form-control @error('cookie_button_link') is-invalid @enderror"
                                               name="cookie_button_link" id="cookie_button_link"
                                               placeholder="@lang("Cookie Button Name")"
                                               value="{{ old('cookie_button_link', basicControl()->cookie_button_link) }}"
                                               autocomplete="off">
                                        @error('cookie_button_link')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label" for="cImage">@lang(stringToTitle('Cookie Image'))</label>
                                        <label class="form-check form-check-dashed" for="logoUploader" id="content_img">
                                            <img id="contentImg"
                                                 class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                 src="{{ getFile(basicControl()->cookie_image_driver, basicControl()->cookie_image) }}"
                                                 alt="Image Description" data-hs-theme-appearance="default">
                                            <img id="contentImg"
                                                 class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                 src="{{ getFile(basicControl()->cookie_image_driver, basicControl()->cookie_image) }}"
                                                 alt="Image Description" data-hs-theme-appearance="dark">
                                            <span class="d-block">@lang("Browse your file here")</span>
                                            <input type="file" name="cookie_image" class="js-file-attach form-check-input @error('cookie_image') is-invalid @enderror"
                                                   id="logoUploader" data-hs-file-attach-options='{
                                                                      "textTarget": "#contentImg",
                                                                      "mode": "image",
                                                                      "targetAttr": "src",
                                                                      "allowTypes": [".png", ".jpeg", ".jpg", ".svg"]
                                                                   }'
                                            />
                                            @error('cookie_image')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="row form-check form-switch mb-4" for="fb_messenger_status">
                                            <span class="col-8 col-sm-9 ms-0">
                                              <span class="d-block text-dark">@lang("Status")</span>
                                              <span class="d-block fs-5">@lang("Enable status to allow user login using Cookie.")</span>
                                            </span>
                                            <span class="col-4 col-sm-3 text-end">
                                                <input type='hidden' value='0' name='cookie_status'>
                                                <input type="checkbox" name="cookie_status" id="cookie_status" value="1" {{(basicControl()->cookie_status == 1) ? 'checked' : ''}} class="form-check-input">
                                            </span>
                                            @error('cookie_status')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </label>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">@lang('Save changes')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <style>
        .row.form-check{
            margin-top: 20px;
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset("assets/admin/js/hs-file-attach.min.js") }}"></script>

    <script>
        'use strict';
        $(document).ready(() => new HSFileAttach('.js-file-attach'));
    </script>
@endpush
