@extends('admin.layouts.app')
@section('page_title', __('Plugin Controls'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang('Dashboard')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Settings')</li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Plugin Controls')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Plugin Controls')</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3">
                @include('admin.control_panel.components.sidebar', ['settings' => config('generalsettings.plugin'), 'suffix' => ''])
            </div>
            <div class="col-lg-7">
                <div class="d-grid gap-3 gap-lg-5">
                    <div id="connectedAccountsSection" class="card">
                        <div class="card-header">
                            <h4 class="card-title">@lang("Manual Recaptcha")</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.manual.recaptcha.update') }}" method="post">
                                @csrf
                                <div class="list-group list-group-lg list-group-flush list-group-no-gutters">

                                    <!-- List Item -->
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <img class="avatar avatar-xs" src="{{ asset('assets/admin/img/user-login.svg') }}" alt="Image Description">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-0">@lang("Admin Login")</h4>
                                                        <p class="fs-5 text-body mb-0">@lang("Manual reCAPTCHA enhances admin login security by verifying human interaction.")</p>                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="form-check form-switch">
                                                            <input type="hidden" name="admin_login_recaptcha" value="0">
                                                            <input class="form-check-input" name="admin_login_recaptcha" type="checkbox" id="adminLoginRecaptcha" value="1"
                                                                {{ $basicControl->recaptcha_admin_login == 1 ? 'checked' : ''}}>
                                                            <label class="form-check-label" for="adminLoginRecaptcha"></label>
                                                            @error('admin_login_recaptcha')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End List Item -->

                                    <!-- List Item -->
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <img class="avatar avatar-xs" src="{{ asset('assets/admin/img/user-login.svg') }}" alt="Image Description">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-0">@lang("User Login")</h4>
                                                        <p class="fs-5 text-body mb-0">@lang("Manual reCAPTCHA enhances login security by verifying human interaction.")</p>                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="form-check form-switch">
                                                            <input type="hidden" name="user_login_recaptcha" value="0">
                                                            <input class="form-check-input" name="user_login_recaptcha" type="checkbox" id="userLoginRecaptcha" value="1"
                                                                {{ $basicControl->reCaptcha_status_login == 1 ? 'checked' : ''}}>
                                                            <label class="form-check-label" for="userLoginRecaptcha"></label>
                                                            @error('user_login_recaptcha')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End List Item -->
                                    <!-- List Item -->
                                    <div class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <img class="avatar avatar-xs" src="{{ asset('assets/admin/img/user-login.svg') }}" alt="Image Description">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="mb-0">@lang('User Registration')</h4>
                                                        <p class="fs-5 text-body mb-0">@lang("Manual reCAPTCHA enhances registration security by verifying human interaction.")</p>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="form-check form-switch">
                                                            <input type="hidden" name="user_registration_recaptcha" value="0">
                                                            <input class="form-check-input" type="checkbox" name="user_registration_recaptcha" id="userRegistrationRecaptcha" value="1"
                                                                {{ $basicControl->reCaptcha_status_registration == 1 ? 'checked' : ''}}>
                                                            <label class="form-check-label" for="userRegistrationRecaptcha"></label>
                                                            @error('user_registration_recaptcha')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End List Item -->


                                </div>
                                <div class="d-flex justify-content-start">
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

