<div class="card-body pt-0">
    <div class="profile-form-section">
        <form action="{{route('user.profile.update')}}" method="POST">
            @csrf

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
                <a href="javascript:history.back()" class="cmn-btn2">@lang('cancel')</a>
            </div>
        </form>
    </div>
</div>
