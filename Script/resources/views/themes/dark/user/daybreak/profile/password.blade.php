@extends(template().'layouts.user')
@section('title',trans('Password'))
@section('content')
    <div class="container">
        <div class="pagetitle mt-20">
            <h4 class="mb-1">@lang('Password Reset')</h4>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Password Reset')</li>
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
                                        <div class="input-group">
                                            <input type="password" name="currentPassword" value="{{ old('currentPassword') }}"
                                                   class="form-control" id="exampleInputPassword1"
                                                   placeholder="@lang('Enter your current password')">
                                            <span class="input-group-text">
                                                <i class="password-icon fa-regular fa-eye"></i>
                                            </span>
                                        </div>
                                        @error('currentPassword')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputPassword2" class="form-label">@lang('New Password')</label>
                                        <div class="input-group">
                                            <input type="password" name="password" value="{{ old('password') }}"
                                                   class="form-control" id="exampleInputPassword2"
                                                   placeholder="@lang('New Password')">
                                            <span class="input-group-text">
                                                <i class="password-icon fa-regular fa-eye"></i>
                                            </span>
                                        </div>
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="exampleInputPassword3" class="form-label">@lang('Repeat Password')</label>
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}"
                                                   class="form-control" id="exampleInputPassword3"
                                                   placeholder="@lang('Repeat Password')">
                                            <span class="input-group-text">
                                                <i class="password-icon fa-regular fa-eye"></i>
                                            </span>
                                        </div>
                                        @error('password_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
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
    </div>
@endsection

@push('script')
    <script>
        document.querySelectorAll('.password-icon').forEach((icon) => {
            icon.addEventListener('click', () => {
                const input = icon.closest('.input-group').querySelector('input');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.add('fa-eye-slash');
                    icon.classList.remove('fa-eye');
                } else {
                    input.type = 'password';
                    icon.classList.add('fa-eye');
                    icon.classList.remove('fa-eye-slash');
                }
            });
        });

    </script>
@endpush
