@extends(template().'layouts.user')
@section('title',trans('Profile'))
@section('content')
    <div class="pagetitle">
        <h3 class="mb-1">@lang('Profile')</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('My Profile')</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="account-settings-profile-section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">@lang('Profile Setting')
                    </h5>
                    <div class="profile-details-section">
                        <form action="{{route('user.profile.update.image')}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="d-flex gap-3 align-items-center">
                                <div class="image-area">
                                    <img id="profile-img"
                                         src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}"
                                         alt="{{auth()->user()->fullname}}">
                                </div>
                                <div class="btn-area">
                                    <div class="btn-area-inner d-flex">
                                        <div class="cmn-file-input">
                                            <label for="formFile" class="form-label">@lang('Change photo')</label>
                                            <input class="form-control" name="image" type="file" id="formFile"
                                                   onchange="previewImage('profile-img')">
                                        </div>
                                        <button type="submit" class="cmn-btn3">@lang('Upload')
                                        </button>
                                    </div>
                                    <small>@lang('Allowed JPG, JPEG or PNG. Max size of 1MB')</small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form action="{{route('user.profile.update')}}" method="POST">
                        @csrf
                        <div class="profile-form-section">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="firstname" class="form-label">@lang('First Name')</label>
                                    <input type="text" name="firstname" placeholder="@lang('Your Firstname')"
                                           value="{{ old('firstname', $userProfile->firstname) }}" class=" form-control"
                                           id="firstname">
                                    @error('firstname')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="lastname" class="form-label">@lang('Last Name')</label>
                                    <input type="text" name="lastname" placeholder="@lang('Your Lastname')"
                                           value="{{ old('lastname', $userProfile->lastname) }}" class="form-control"
                                           id="lastname">
                                    @error('lastname')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="Username" class="form-label">@lang('Username')</label>
                                    <input type="text" name="username" placeholder="@lang('Username')"
                                           value="{{ old('username', $userProfile->username) }}" class="form-control"
                                           id="e-mail">
                                    @error('username')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="organization" class="form-label">@lang('Email Address')</label>
                                    <input type="email" name="email" placeholder="@lang('Email Address')"
                                           value="{{ old('email', $userProfile->email) }}" class="form-control"
                                           id="organization">
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phonenumber" class="form-label">@lang('Phone Number')</label>
                                    <div>
                                        <input id="telephone" class="form-control" name="phone" type="tel"
                                               onkeyup="this.value = this.value.replace (/^\.|[^\d\.]/g, '')">
                                        <input type="hidden" name="phone_code" id="phoneCode"/>
                                        <input type="hidden" name="country_code" id="countryCode"/>
                                        <input type="hidden" name="country" id="countryName"/>
                                    </div>
                                    @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">@lang('Language')</label>
                                    <select class="cmn-select2" name="language">
                                        @foreach($languages as $language)
                                            <option
                                                value="{{ $language->id }}" {{ old('language', $userProfile->language_id) == $language->id ? 'selected' : '' }}>
                                                {{ __($language->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">@lang('Time Zone')</label>
                                    <select class="cmn-select2" name="timezone">
                                        @foreach(timezone_identifiers_list() as $key => $value)
                                            <option
                                                value="{{$value}}" {{  (old('timezone',$userProfile->timezone) == $value ? ' selected' : '') }}>{{ __($value) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="Address" class="form-label">@lang('Address')</label>
                                    <textarea name="address"
                                              class="form-control">{{ old('address', $userProfile->address_one) }}</textarea>
                                    @error('address')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="btn-area d-flex g-3">
                                <button type="submit" class="cmn-btn">@lang('save changes')</button>
                            </div>
                        </div>
                    </form>
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
