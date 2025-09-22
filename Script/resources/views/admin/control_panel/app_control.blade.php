@extends('admin.layouts.app')
@section('page_title', __('App Control'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item">
                                <a class="breadcrumb-link" href="javascript:void(0)">@lang("Dashboard")</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang("Settings")</li>
                            <li class="breadcrumb-item active" aria-current="page">@lang("App Control")</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang("App Control")</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3">
                @include('admin.control_panel.components.sidebar', ['settings' => config('generalsettings.settings'), 'suffix' => 'Settings'])
            </div>

            <div class="col-lg-9 seo-setting">
                <div class="d-grid gap-3 gap-lg-5">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title h4">@lang('App Control')</h2>
                        </div>
                        <div class="card-body">
                            <!-- Form -->
                            <form action="{{ route('admin.app.control') }}" method="post">
                                @csrf
                                <div class="row mb-4">
                                    <label for="AppColor"
                                           class="col-sm-3 col-form-label form-label">@lang("App Color")</label>
                                    <div class="col-sm-9">
                                        <input type="color"
                                               class="form-control color-form-input @error('app_color') is-invalid @enderror"
                                               name="app_color"
                                               id="AppColor"
                                               placeholder="App Color" aria-label="App Color"
                                               value="{{ old('app_color',$basicControl->app_color) }}">
                                        @error('app_color')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label for="AppVersion"
                                           class="col-sm-3 col-form-label form-label">@lang("App Version")</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               class="form-control color-form-input @error('app_version') is-invalid @enderror"
                                               name="app_version"
                                               id="AppVersion"
                                               placeholder="App Version" aria-label="App Version"
                                               value="{{ old('app_version',$basicControl->app_version) }}">
                                        @error('app_version')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label for="AppBuild"
                                           class="col-sm-3 col-form-label form-label">@lang("App Build")</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               class="form-control color-form-input @error('app_build') is-invalid @enderror"
                                               name="app_build"
                                               id="AppBuild"
                                               placeholder="App Build" aria-label="App Build"
                                               value="{{ old('app_build',$basicControl->app_build) }}">
                                        @error('app_build')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-sm-12">
                                        <div class="list-group list-group-lg list-group-flush list-group-no-gutters">
                                            <div class="list-group-item">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <div class="row align-items-center">
                                                            <div class="col">
                                                                <span
                                                                    class="d-block text-dark">@lang("Major Version")</span>
                                                                <p class="fs-5 text-body mb-0">@lang("Enable this feature only if the app version is a major release.")</p>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="form-check form-switch">
                                                                    <input type='hidden' value='0' name='is_major'>
                                                                    <input
                                                                        class="form-check-input @error('is_major') is-invalid @enderror"
                                                                        type="checkbox"
                                                                        name="is_major"
                                                                        id="MajorLabel"
                                                                        value="1" {{ old('is_major', $basicControl->is_major) == 1 ? 'checked' : ''}}>
                                                                    <label class="form-check-label"
                                                                           for="MajorLabel"></label>
                                                                    @error('is_major')
                                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
    <script src="{{ asset("assets/admin/js/hs-file-attach.min.js") }}"></script>
@endpush

@push('script')
    <script>
        'use strict';
        $(document).ready(function () {
            HSCore.components.HSTomSelect.init('.js-select', {
                maxOptions: 250,
            })
            new HSFileAttach('.js-file-attach')
        })
    </script>
@endpush

