@extends('admin.layouts.app')
@section('page_title',__('Edit Staff'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang("Dashboard")</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang("Edit Staff")</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang("Edit Staff")</h1>
                </div>
            </div>
        </div>


        <div class="row d-flex justify-content-center">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">@lang('Staff information')</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <form action="{{route('admin.staff.role.update')}}" method="post">
                            @csrf
                            <input type="hidden" value="{{$staff->id}}" name="id">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="staffName">@lang('Name')</label>
                                        <input type="text" id="staffName" value="{{old('name',$staff->name)}}"
                                               name="name" class="form-control"  placeholder="Enter staff name">
                                    </div>
                                    @error("name")
                                    <span class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                            </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <label class="form-label" for="selectRole">@lang('Role')</label>
                                    <!-- Select -->
                                    <div class="tom-select-custom">
                                        <select class="js-select form-select" name="role" id="selectRole" autocomplete="off"
                                                data-hs-tom-select-options='{
                                                          "placeholder": "Select a role...",
                                                          "hideSearch": true
                                                        }'>
                                            <option value="">Select a role...</option>
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}" @selected(old('role',$staff->role_id) == $role->id)>{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- End Select -->
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="staffEmail">@lang('Email')</label>
                                        <input type="email" id="staffEmail" value="{{old('email',$staff->email)}}"
                                               name="email" class="form-control"  placeholder="Enter staff email">
                                    </div>
                                    @error("email")
                                    <span class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                            </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="staffUsername">@lang('Username')</label>
                                        <input type="text" id="staffUsername" value="{{old('username',$staff->username)}}"
                                               name="username" class="form-control"  placeholder="Enter staff email">
                                    </div>
                                    @error("username")
                                    <span class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                            </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="staffPassword">@lang('Password')</label>
                                        <input type="password" id="staffPassword"
                                               name="password" class="form-control"  placeholder="Enter staff password" autocomplete="off">
                                    </div>
                                    @error("password")
                                    <span class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                            </span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <label class="row form-check form-switch" for="staffStatus">
                                <span class="col-8 col-sm-9 ms-0">
                                  <span class="text-dark">@lang('Status') <i
                                          class="bi-question-circle text-body ms-1"
                                          data-bs-toggle="tooltip" data-bs-placement="top"
                                          title="Enable Staff Status"></i></span>
                                </span>
                                        <span class="col-4 col-sm-3 text-end">
                                  <input type="checkbox" class="form-check-input" name="status" id="staffStatus" @checked(old('status') == 'on'|| $staff->status == 1)>
                                </span>
                                    </label>
                                    @error("status")
                                    <span class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                            </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary mt-4">@lang('Save')</button>
                            </div>
                        </form>
                    </div>
                    <!-- Body -->
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
@endpush
@push('script')
    <script>
        (function() {
            // INITIALIZATION OF SELECT
            // =======================================================
            HSCore.components.HSTomSelect.init('.js-select')
        })();
    </script>
@endpush

