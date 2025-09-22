@extends(template().'layouts.user')
@section('title',trans('Profile'))
@section('content')

    <div class="container">
        <div class="row">
            <div class="pagetitle mt-20">
                <h4 class="mb-1">@lang('Profile')</h4>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Profile')</li>
                    </ol>
                </nav>
            </div>
            <!-- End Page Title -->
            <!-- Left side columns -->

            <div class="row">
                <!-- Account-settings -->
                <!-- Account settings navbar start -->
                @include(template().'user.'.getDash().'.profile.partials.topMenu')
                <div class="account-settings-profile-section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">@lang('Profile Details')</h5>
                            <form action="{{route('user.profile.update.image')}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="profile-details-section">
                                    <div class="d-flex gap-3 align-items-center">
                                        <div class="image-area">
                                            <img id="profile-img" src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}" alt="{{auth()->user()->fullname}}">
                                        </div>
                                        <div class="btn-area">
                                            <div class="btn-area-inner d-flex">
                                                <div class="cmn-file-input">
                                                    <label for="formFile" class="form-label">@lang('Change photo')</label>
                                                    <input class="form-control" name="image" type="file" id="formFile" onchange="previewImage('profile-img')">
                                                </div>
                                                <button type="submit" class="cmn-btn3">@lang('Upload')
                                                </button>
                                            </div>
                                            <small>@lang('Allowed JPG, GIF or PNG. Max size of 800K')</small>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @include(template().'user.'.getDash().'.profile.partials.profile')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css-lib')
    <link rel="stylesheet" href="{{ asset(template(true).'css/intlTelInput.min.css') }}">
    <style>
        .cmn-btn3{
            color: var(--body-color);
        }
    </style>
@endpush
@push('js-lib')
    <script src="{{ asset(template(true).'js/intlTelInput.min.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict';
        const originalImageSrc = document.getElementById('profile-img').src;
        const previewImage = (id) => {
            document.getElementById(id).src = URL.createObjectURL(event.target.files[0]);
        };

        $(document).ready(function () {
            $('.cmn-select2').select2();
            // International Telephone Input start
            const input = document.querySelector("#telephone");
            const iti = window.intlTelInput(input, {
                initialCountry: "bd",
                separateDialCode: true,
            });
            input.addEventListener("countrychange", updateCountryInfo);
            updateCountryInfo();

            function updateCountryInfo() {
                const selectedCountryData = iti.getSelectedCountryData();
                const phoneCode = '+' + selectedCountryData.dialCode;
                const countryCode = selectedCountryData.iso2;
                const countryName = selectedCountryData.name;
                $('#phoneCode').val(phoneCode);
                $('#countryCode').val(countryCode);
                $('#countryName').val(countryName);
            }

            const initialPhone = "{{ old('phone', $userProfile->phone) }}";
            const initialPhoneCode = "{{ old('phone_code', $userProfile->phone_code) }}";
            const initialCountryCode = "{{ old('country_code', $userProfile->country_code) }}";
            const initialCountry = "{{ old('country', $userProfile->country) }}";
            if (initialPhoneCode) {
                iti.setNumber(initialPhoneCode);
            }
            if (initialCountryCode) {
                iti.setNumber(initialCountryCode);
            }
            if (initialCountry) {
                iti.setNumber(initialCountry);
            }
            if (initialPhone) {
                iti.setNumber(initialPhone);
            }
        })
    </script>
@endpush
