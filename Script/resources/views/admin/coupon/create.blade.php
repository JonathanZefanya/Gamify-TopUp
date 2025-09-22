@extends('admin.layouts.app')
@section('page_title', __('Create Coupon'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang('Coupon')</a></li>
                            <li class="breadcrumb-item active"
                                aria-current="page">@lang('Create Coupon')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Create Coupon')</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="card mb-3 mb-lg-5">
                    <div class="card-header">
                        <h4 class="card-header-title">@lang('Coupon information')</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{route('admin.couponStore')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label for="productNameLabel" class="form-label">@lang('Title')</label>

                                        <input type="text" class="form-control" value="{{old('title')}}" name="title"
                                               id="productNameLabel"
                                               placeholder="Flash Sale">
                                        @error('title')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label for="UsedLimit" class="form-label">@lang('Used Limit')</label>
                                        <div class="input-group-append">
                                            <input type="text" class="form-control" value=""
                                                   name="used_limit"
                                                   id="UsedLimit"
                                                   placeholder="1000">

                                            <span class="input-group-text" id="basic-addon1">
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" name="is_unlimited"
                                                               id="formInlineCheck10"
                                                               class="form-check-input" value="yes" checked>
                                                        <label class="form-check-label"
                                                               for="formInlineCheck10">@lang('Unlimited')</label>
                                                    </div>
                                                </span>
                                        </div>
                                        @error('used_limit')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label for="code" class="form-label">@lang('Code') <i
                                                class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="@lang('Code should be unique min 6 length')"></i></label>

                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="code" id="code"
                                                   placeholder="FS202580" value="{{old('code')}}">
                                            <button class="btn btn-outline-secondary" onclick="generateCode()"
                                                    type="button"
                                                    id="button-addon2">@lang('Generate Code')</button>
                                        </div>
                                        @error('code')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label for="weightLabel" class="form-label">@lang('Discount')</label>

                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"
                                                      id="basic-addon1">{{basicControl()->currency_symbol}}</span>
                                            </div>
                                            <input type="text" class="form-control" value="{{old('discount')}}"
                                                   name="discount" id="weightLabel"
                                                   placeholder="0.0" aria-label="0.0">

                                            <div class="input-group-append">
                                                <div class="tom-select-custom tom-select-custom-end">
                                                    <select class="js-select form-select" name="discount_type"
                                                            autocomplete="off"
                                                            data-hs-tom-select-options='{
                                    "searchInDropdown": false,
                                    "hideSearch": true,
                                    "dropdownWidth": "6rem"
                                  }'>
                                                        <option
                                                            value="percent" {{old('discount_type') == 'percent' ? 'selected':''}}>@lang('Percent')</option>
                                                        <option
                                                            value="flat" {{old('discount_type') == 'flat' ? 'selected':''}}>@lang('Flat')</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        @error('discount')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <!-- Form Group -->
                                        <div class="form-group">
                                            <label for="projectDeadlineFlatpickrNewProjectLabel"
                                                   class="input-label mb-2">@lang('Start Date')</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="bi-calendar-week"></i></span>
                                                </div>
                                                <input type="text" name="start_date" class="js-flatpickr form-control"
                                                       placeholder="Select dates"
                                                       data-hs-flatpickr-options='{
                                                 "dateFormat": "d M Y H:i",
                                                 "enableTime": true
                                               }'>

                                            </div>
                                            @error('start_date')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <!-- Form Group -->
                                        <label for="projectDeadlineFlatpickrNewProjectLabel"
                                               class="input-label mb-2">@lang('End Date')</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="bi-calendar-week"></i></span>
                                            </div>
                                            <input type="text" name="end_date" class="js-flatpickr form-control"
                                                   placeholder="Select dates"
                                                   data-hs-flatpickr-options='{
                                                 "dateFormat": "d M Y H:i",
                                                 "enableTime": true
                                               }'>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" name="is_expired" id="formInlineCheck5"
                                                               class="form-check-input" value="no">
                                                        <label class="form-check-label"
                                                               for="formInlineCheck5">@lang('Never Expired')</label>
                                                    </div>
                                                </span>
                                            </div>

                                            @error('end_date')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                        <small
                                            class="form-text">@lang('Check this box if the coupon should run indefinitely.')</small>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">@lang('Create')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exportCustomersGuideModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-close">
                    <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm" data-bs-dismiss="modal"
                            aria-label="Close">
                        <i class="bi-x-lg"></i>
                    </button>
                </div>
                <!-- End Header -->

                <!-- Body -->
                <div class="modal-body p-sm-5">
                    <div class="text-center mb-5">
                        <h4 class="h1">@lang('Welcome to Coupon Panel')</h4>
                    </div>

                    <!-- Media -->
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <img class="avatar avatar-xl avatar-4x3"
                                 src="{{asset('assets/admin/dark-oc-looking-for-answers.svg')}}" alt="Image Description"
                                 data-hs-theme-appearance="default">
                            <img class="avatar avatar-xl avatar-4x3"
                                 src="{{asset('assets/admin/light-oc-looking-for-answers.svg')}}"
                                 alt="Image Description" data-hs-theme-appearance="dark">
                        </div>

                        <div class="flex-grow-1 ms-4">
                            <h4>@lang('Read before to create a new coupon')</h4>
                            <p>@lang('After creating a new coupon, you’ll be redirected to the assignment page to specify the applicable Top-Up and Card options for the coupon.')</p>
                        </div>
                    </div>
                    <!-- End Media -->
                </div>
                <!-- End Body -->

                <!-- Footer -->
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" aria-label="Close">Continue
                    </button>
                </div>
                <!-- End Footer -->
            </div>
        </div>
    </div>
@endsection

@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/flatpickr.min.css') }}"/>
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/flatpickr.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function () {
            new bootstrap.Modal(document.getElementById('exportCustomersGuideModal')).show()
            // INITIALIZATION OF FLATPICKR
            // =======================================================
            HSCore.components.HSFlatpickr.init('.js-flatpickr', {
                minDate: "today",
            })
        })();

        function generateCode(length = 8) {
            const characters = 'ABDG0123456789';
            let result = '';
            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * characters.length));
            }

            $('#code').val(result);
        }
    </script>
@endpush
