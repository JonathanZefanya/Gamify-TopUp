@extends('admin.layouts.app')
@section('page_title', __('Update Coupon'))
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
                                aria-current="page">@lang('Update Coupon')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Update Coupon')</h1>
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
                        <form action="{{route('admin.couponEdit',$coupon->id)}}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label for="productNameLabel" class="form-label">@lang('Title')</label>

                                        <input type="text" class="form-control" value="{{$coupon->title}}" name="title"
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
                                            <input type="text" class="form-control" value="{{$coupon->used_limit}}"
                                                   name="used_limit"
                                                   id="UsedLimit"
                                                   placeholder="1000">

                                            <span class="input-group-text" id="basic-addon1">
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" name="is_unlimited"
                                                               id="formInlineCheck10"
                                                               class="form-check-input" value="yes" {{$coupon->is_unlimited ?'checked':''}}>
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
                                                   placeholder="FS202580" value="{{$coupon->code}}">
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
                                            <input type="text" class="form-control" value="{{$coupon->discount}}"
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
                                                            value="percent" {{$coupon->discount_type == 'percent' ? 'selected':''}}>@lang('Percent')</option>
                                                        <option
                                                            value="flat" {{$coupon->discount_type == 'flat' ? 'selected':''}}>@lang('Flat')</option>
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
                                                <input type="text" name="start_date"
                                                       value="{{\Carbon\Carbon::parse($coupon->start_date)->format('d M Y H:i')}}"
                                                       class="js-flatpickr form-control"
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
                                            <input type="text" name="end_date"
                                                   value="{{$coupon->end_date ? \Carbon\Carbon::parse($coupon->end_date)->format('d M Y H:i') : null}}"
                                                   class="js-flatpickr form-control"
                                                   placeholder="Select dates"
                                                   data-hs-flatpickr-options='{
                                                 "dateFormat": "d M Y H:i",
                                                 "enableTime": true
                                               }'>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <div class="form-check form-check-inline">
                                                        <input type="checkbox" name="is_expired" id="formInlineCheck5"
                                                               class="form-check-input" value="no" {{$coupon->end_date ?'':'checked'}}>
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

                            <button type="submit" class="btn btn-primary">@lang('Save Changes')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-3 mb-lg-5">
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center flex-grow-1">
                            <div class="col-12 col-md">
                                <h3 class="page-header-title">@lang('Top Up List')</h3>
                            </div>
                            <div class="col-auto">
                                <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
                                    <div id="datatableCounterInfo">
                                        <div class="d-flex align-items-center">
                            <span class="fs-5 me-3">
                              <span id="datatableCounter">0</span>
                              @lang('Selected')
                            </span>
                                            <a class="btn btn-outline-success btn-sm me-2 change-multiple"
                                               href="javascript:void(0)"
                                               data-route="{{route('admin.couponTopUpTypeChange','permitted')}}">
                                                <i class="fas fa-undo-alt"></i> @lang('Permitted')
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm me-2 change-multiple"
                                               href="javascript:void(0)"
                                               data-route="{{route('admin.couponTopUpTypeChange','not_permitted')}}">
                                                <i class="fas fa-undo-alt"></i> @lang('Not Permitted')
                                            </a>

                                        </div>
                                    </div>
                                    <!-- Filter -->
                                    <form>
                                        <!-- Search -->
                                        <div class="input-group input-group-merge input-group-flush">
                                            <div class="input-group-prepend input-group-text">
                                                <i class="bi-search"></i>
                                            </div>
                                            <input id="datatableWithSearchInput" type="search" class="form-control"
                                                   placeholder="@lang('Search Top Up')" aria-label="Search Top Up">
                                        </div>
                                        <!-- End Search -->
                                    </form>
                                    <!-- End Filter -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="custom-body">
                        <div class="table-responsive datatable-custom">
                            <table
                                class="js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                data-hs-datatables-options='{
                    "columnDefs": [{
                      "targets": [0],
                      "orderable": false
                   }],
                   "order": [],
                   "search": "#datatableWithSearchInput",
                   "isResponsive": false,
                   "isShowPaging": false,
                   "pagination": "datatableWithSearchPagination"
                 }'>
                                <thead class="thead-light">
                                <tr>
                                    <th class="table-column-pe-0">
                                        <div class="form-check">
                                            <input class="form-check-input check-all tic-check" type="checkbox"
                                                   name="check-all"
                                                   id="datatableCheckAll">
                                            <label class="form-check-label" for="datatableCheckAll"></label>
                                        </div>
                                    </th>
                                    <th scope="col">@lang('SL No.')</th>
                                    <th scope="col">@lang('Name')</th>
                                    <th scope="col">@lang('Type')</th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse($topups as $item)
                                    <tr>
                                        <td class="table-column-pe-0">
                                            <div class="form-check">
                                                <input type="checkbox" id="chk-{{$item->id}}"
                                                       class="form-check-input row-tic tic-check" name="check"
                                                       value="{{$item->id}}"
                                                       data-id="{{$item->id}}">
                                                <label class="form-check-label" for="chk-{{ $item->id }}"></label>
                                            </div>
                                        </td>
                                        <td data-label="@lang('SL No.')">{{ $loop->index + 1 }}</td>
                                        <td data-label="@lang('Name')">
                                            <a class="d-flex align-items-center me-2" href="javascript:void(0)">
                                                <div class="flex-shrink-0 trending-notification">
                                                    <div class="avatar avatar-sm avatar-circle">
                                                        <img class="avatar-img"
                                                             src="{{ $item->preview_image }}"
                                                             alt="{{$item->name}}">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="text-hover-primary mb-0">{{$item->name}}</h5>
                                                </div>
                                            </a>
                                        </td>
                                        <td data-label="@lang('Type')">
                                            @if(in_array($item->id,$coupon->top_up_list??[]))
                                                <span class="badge bg-success">@lang('Permitted')</span>
                                            @else
                                                <span class="badge bg-danger">@lang('Not Permitted')</span>
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%">
                                            <div class="text-center p-4">
                                                <img class="dataTables-image mb-3"
                                                     src="{{ asset('assets/admin/img/oc-error.svg') }}"
                                                     alt="Image Description"
                                                     data-hs-theme-appearance="default">
                                                <img class="dataTables-image mb-3"
                                                     src="{{ asset('assets/admin/img/oc-error-light.svg') }}"
                                                     alt="Image Description" data-hs-theme-appearance="dark">
                                                <p class="mb-0">@lang('No data to show')</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table -->

                        <!-- Footer -->
                        <div class="card-footer">
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center justify-content-sm-end">
                                <nav id="datatableWithSearchPagination" aria-label="Activity pagination"></nav>
                            </div>
                            <!-- End Pagination -->
                        </div>
                        <!-- End Footer -->
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-3 mb-lg-5">
                <div class="card">
                    <!-- Header -->
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center flex-grow-1">
                            <div class="col-12 col-md">
                                <h3 class="page-header-title">@lang('Card List')</h3>
                            </div>
                            <div class="col-auto">
                                <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
                                    <div id="datatableCounterInfoCard">
                                        <div class="d-flex align-items-center">
                            <span class="fs-5 me-3">
                              <span id="datatableCounterCard">0</span>
                              @lang('Selected')
                            </span>
                                            <a class="btn btn-outline-success btn-sm me-2 change-multiple-card"
                                               href="javascript:void(0)" data-route="{{route('admin.couponCardTypeChange','permitted')}}">
                                                <i class="fas fa-undo-alt"></i> @lang('Permitted')
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm me-2 change-multiple-card"
                                               href="javascript:void(0)" data-route="{{route('admin.couponCardTypeChange','not_permitted')}}">
                                                <i class="fas fa-undo-alt"></i> @lang('Not Permitted')
                                            </a>
                                        </div>
                                    </div>
                                    <!-- Filter -->
                                    <form>
                                        <!-- Search -->
                                        <div class="input-group input-group-merge input-group-flush">
                                            <div class="input-group-prepend input-group-text">
                                                <i class="bi-search"></i>
                                            </div>
                                            <input id="datatableWithSearchInputCard" type="search" class="form-control"
                                                   placeholder="@lang('Search Card')" aria-label="Search Card">
                                        </div>
                                        <!-- End Search -->
                                    </form>
                                    <!-- End Filter -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="custom-body">

                        <div class="table-responsive datatable-custom">
                            <table
                                class="js-datatable-card table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                data-hs-datatables-options='{
                    "columnDefs": [{
                      "targets": [0],
                      "orderable": false
                   }],
                   "order": [],
                   "search": "#datatableWithSearchInputCard",
                   "isResponsive": false,
                   "isShowPaging": false,
                   "pagination": "datatableWithSearchPagination"
                 }'>
                                <thead class="thead-light">
                                <tr>
                                    <th class="table-column-pe-0">
                                        <div class="form-check">
                                            <input class="form-check-input check-all-card tic-check-card"
                                                   type="checkbox"
                                                   name="check-all-card"
                                                   id="datatableCheckAllCard">
                                            <label class="form-check-label" for="datatableCheckAllCard"></label>
                                        </div>
                                    </th>
                                    <th scope="col">@lang('SL No.')</th>
                                    <th scope="col">@lang('Name')</th>
                                    <th scope="col">@lang('Type')</th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse($cards as $item)
                                    <tr>
                                        <td class="table-column-pe-0">
                                            <div class="form-check">
                                                <input type="checkbox" id="chk-{{$item->id}}-card"
                                                       class="form-check-input row-tic-card tic-check-card" name="check"
                                                       value="{{$item->id}}"
                                                       data-id="{{$item->id}}">
                                                <label class="form-check-label" for="chk-{{ $item->id }}-card"></label>
                                            </div>
                                        </td>
                                        <td data-label="@lang('SL No.')">{{ $loop->index + 1 }}</td>
                                        <td data-label="@lang('Name')">
                                            <a class="d-flex align-items-center me-2" href="javascript:void(0)">
                                                <div class="flex-shrink-0 trending-notification">
                                                    <div class="avatar avatar-sm avatar-circle">
                                                        <img class="avatar-img"
                                                             src="{{ $item->preview_image }}"
                                                             alt="{{$item->name}}">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="text-hover-primary mb-0">{{$item->name}}</h5>
                                                </div>
                                            </a>
                                        </td>
                                        <td data-label="@lang('Type')">
                                            @if(in_array($item->id,$coupon->card_list??[]))
                                                <span class="badge bg-success">@lang('Permitted')</span>
                                            @else
                                                <span class="badge bg-danger">@lang('Not Permitted')</span>
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%">
                                            <div class="text-center p-4">
                                                <img class="dataTables-image mb-3"
                                                     src="{{ asset('assets/admin/img/oc-error.svg') }}"
                                                     alt="Image Description"
                                                     data-hs-theme-appearance="default">
                                                <img class="dataTables-image mb-3"
                                                     src="{{ asset('assets/admin/img/oc-error-light.svg') }}"
                                                     alt="Image Description" data-hs-theme-appearance="dark">
                                                <p class="mb-0">@lang('No data to show')</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table -->

                        <!-- Footer -->
                        <div class="card-footer">
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center justify-content-sm-end">
                                <nav id="datatableWithSearchPagination" aria-label="Activity pagination"></nav>
                            </div>
                            <!-- End Pagination -->
                        </div>
                        <!-- End Footer -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/flatpickr.min.css') }}"/>
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/select.min.js') }}"></script>
@endpush

@push('script')
    <script>
        var couponId = "{{$coupon->id}}";
        (function () {
            // INITIALIZATION OF FLATPICKR
            // =======================================================
            HSCore.components.HSFlatpickr.init('.js-flatpickr', {
                minDate: "today",
            })

            HSCore.components.HSDatatables.init('.js-datatable', {
                select: {
                    style: 'multi',
                    selector: 'td:first-child input[type="checkbox"]',
                    classMap: {
                        checkAll: '#datatableCheckAll',
                        counter: '#datatableCounter',
                        counterInfo: '#datatableCounterInfo'
                    }
                },
            })

            $.fn.dataTable.ext.errMode = 'throw';
            $(document).on('click', '#datatableCheckAll', function () {
                $('.tic-check').not(this).prop('checked', this.checked);
            });

            $(document).on('change', ".row-tic", function () {
                let length = $(".row-tic").length;
                let checkedLength = $(".row-tic:checked").length;
                if (length == checkedLength) {
                    $('#check-all').prop('checked', true);
                } else {
                    $('#check-all').prop('checked', false);
                }
            });


            $(document).on('click', '.change-multiple', function (e) {
                let route = $(this).data('route');
                e.preventDefault();
                let all_value = [];
                $(".row-tic:checked").each(function () {
                    all_value.push($(this).attr('data-id'));
                });

                let strIds = all_value;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: route,
                    data: {strIds: strIds, couponId: couponId},
                    datatType: 'json',
                    type: "post",
                    success: function (data) {
                        location.reload();
                    },
                });
            });

            //Card

            HSCore.components.HSDatatables.init('.js-datatable-card', {
                select: {
                    style: 'multi',
                    selector: 'td:first-child input[type="checkbox"]',
                    classMap: {
                        checkAll: '#datatableCheckAllCard',
                        counter: '#datatableCounterCard',
                        counterInfo: '#datatableCounterInfoCard'
                    }
                },
            })

            $.fn.dataTable.ext.errMode = 'throw';
            $(document).on('click', '#datatableCheckAllCard', function () {
                $('.tic-check-card').not(this).prop('checked', this.checked);
            });

            $(document).on('change', ".row-tic-card", function () {
                let length = $(".row-tic-card").length;
                let checkedLength = $(".row-tic-card:checked").length;
                if (length == checkedLength) {
                    $('#check-all-card').prop('checked', true);
                } else {
                    $('#check-all-card').prop('checked', false);
                }
            });


            $(document).on('click', '.change-multiple-card', function (e) {
                let route = $(this).data('route');
                e.preventDefault();
                let all_value = [];
                $(".row-tic-card:checked").each(function () {
                    all_value.push($(this).attr('data-id'));
                });

                let strIds = all_value;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: route,
                    data: {strIds: strIds, couponId: couponId},
                    datatType: 'json',
                    type: "post",
                    success: function (data) {
                        location.reload();
                    },
                });
            });
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
