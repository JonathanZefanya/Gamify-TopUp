@extends(template().'layouts.user')
@section('title',trans('Password'))
@section('content')
    <div class="pagetitle">
        <h3 class="mb-1">@lang('Reset Password')</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('Reset Password')</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="account-settings-profile-section">
            <div class="card">
                <div class="card-body pt-0">
                    <form action="{{route('user.updatePassword')}}" method="POST">
                        @csrf
                        <div class="profile-form-section">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="CurrentPassword" class="form-label">@lang('Current password')</label>
                                    <div class="password-box">
                                        <input type="password" name="currentPassword" value="{{old('currentPassword')}}"
                                               class="form-control password"
                                               id="exampleInputPassword1" placeholder="@lang('Enter your current password')">
                                        <i class="password-icon fa-regular fa-eye"></i>
                                    </div>
                                    @error('currentPassword')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="Address" class="form-label">@lang('New Password')</label>
                                    <div class="password-box">
                                        <input type="password" name="password" value="{{ old('password') }}"
                                               class="form-control password"
                                               id="exampleInputPassword2"
                                               placeholder="@lang('New Password')">
                                        <i class="password-icon fa-regular fa-eye"></i>
                                    </div>
                                    @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="Address" class="form-label">@lang('Repeat Password')</label>
                                    <div class="password-box">
                                        <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}"
                                               class="form-control password"
                                               id="exampleInputPassword3"
                                               placeholder="@lang('Repeat Password')">
                                        <i class="password-icon fa-regular fa-eye"></i>
                                    </div>
                                    @error('password_confirmation')
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

@push('script')
    <script>
        if (document.querySelector('.profile-form-section')) {
            const passwordBoxes = document.querySelectorAll('.password-box');
            passwordBoxes.forEach((passwordBox) => {
                const passwordInput = passwordBox.querySelector('.password');
                const passwordIcon = passwordBox.querySelector('.password-icon');

                passwordIcon.addEventListener("click", function () {
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        passwordIcon.classList.add('fa-eye-slash');
                        passwordIcon.classList.remove('fa-eye');
                    } else {
                        passwordInput.type = 'password';
                        passwordIcon.classList.add('fa-eye');
                        passwordIcon.classList.remove('fa-eye-slash');
                    }
                });
            });
        }
    </script>
@endpush
