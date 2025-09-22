@extends('admin.layouts.app')
@section('page_title', __('Campaign'))
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
                                                           href="javascript:void(0)">@lang('Campaign')</a></li>
                            <li class="breadcrumb-item active"
                                aria-current="page">@lang('Campaign')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Campaign')</h1>
                </div>
            </div>
        </div>
        <form action="{{route('admin.campaign.store')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-3 mb-lg-5">
                        <div class="card-header">
                            <h4 class="card-header-title">@lang('Campaign Information')</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="productNameLabel" class="form-label">@lang('Name')</label>

                                    <input type="text" class="form-control" name="name" value="{{$campaign->name}}"
                                           id="productNameLabel"
                                           placeholder="@lang('Flash Deal')" aria-label="@lang('Flash Deal').">
                                    @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="Date" class="form-label">@lang('Date')</label>
                                    <div class="input-group mb-3 custom">
                                        <input type="text" id="filter_date_range" name="date"
                                               class="js-flatpickr form-control"
                                               placeholder="Select dates"
                                               aria-describedby="flatpickr_filter_date_range">
                                        <span class="input-group-text"
                                              id="flatpickr_filter_date_range">
                                                        <i class="bi bi-arrow-counterclockwise"></i>
                                </span>
                                    </div>
                                    @error('date')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="TopUp" class="form-label">@lang('Top Up')</label>

                                    <div class="tom-select-custom">
                                        <select class="js-select form-select" name="topups[]" id="topUpSelect"
                                                autocomplete="off"
                                                multiple
                                                data-hs-tom-select-options='{
                                        "singleMultiple": true,
                                        "hideSelected": false,
                                        "placeholder": "Select Top Up"
                                      }'>
                                            @if(!empty($topUpServices))
                                                @foreach($topUpServices as $service)
                                                    <option value="{{$service->id}}"
                                                            {{$service->is_offered ? 'selected':''}}
                                                            data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle me-2" src="{{$service->image_path}}" alt="{{$service->name}}" /><span class="text-truncate">{{$service->name}}</span></span>'>
                                                        {{$service->name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-4">
                                    <label for="Card" class="form-label">@lang('Card')</label>

                                    <div class="tom-select-custom">
                                        <select class="js-select form-select" name="cards[]" id="cardSelect"
                                                autocomplete="off"
                                                multiple
                                                data-hs-tom-select-options='{
                                        "singleMultiple": true,
                                        "hideSelected": false,
                                        "placeholder": "Select Card"
                                      }'>
                                            @if(!empty($cardServices))
                                                @foreach($cardServices as $service)
                                                    <option value="{{$service->id}}"
                                                            {{$service->is_offered ? 'selected':''}}
                                                            data-option-template='<span class="d-flex align-items-center"><img class="avatar avatar-xss avatar-circle me-2" src="{{$service->image_path}}" alt="{{$service->name}}" /><span class="text-truncate">{{$service->name}}</span></span>'>
                                                        {{$service->name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <label class="row form-check form-switch my-4" for="status">
                                            <span class="col-8 col-sm-9 ms-0">
                                              <span class="d-block text-dark">@lang('Status')</span>
                                              <span
                                                  class="d-block fs-5">@lang('Display the Campaign on the front page (If you disable a campaign with a "running" status, you will need to reassign prices for all associated product)').</span>
                                            </span>
                                <span class="col-4 col-sm-3 text-end">
                                                    <input type="hidden" value="0" name="status">
                                                    <input class="form-check-input " type="checkbox" name="status"
                                                           id="status" value="1" {{$campaign->status ? 'checked':''}}>
                                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="d-grid gap-3 gap-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title h4">@lang('Action')</h2>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-start gap-2">
                                    <button type="submit" class="btn btn-primary">@lang('Save Changes')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="js-add-field card mb-3 mb-lg-5">
                        <div class="card-header card-header-content-sm-between">
                            <h4 class="card-header-title mb-2 mb-sm-0">@lang('Top Ups')</h4>
                        </div>
                        <div class="table-responsive datatable-custom">
                            <table id="datatable"
                                   class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th class="table-column-ps-0">@lang('Name')</th>
                                    <th class="table-column-ps-0">@lang('Price')</th>
                                    <th class="table-column-ps-0">@lang('Discount')</th>
                                    <th class="table-column-ps-0">@lang('Discount Type')</th>
                                    <th class="table-column-ps-0">@lang('Max Sell')</th>
                                    <th class="table-column-ps-0"></th>
                                </tr>
                                </thead>

                                <tbody id="offeredTopUpTable">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="js-add-field card mb-3 mb-lg-5">
                        <div class="card-header card-header-content-sm-between">
                            <h4 class="card-header-title mb-2 mb-sm-0">@lang('Card')</h4>
                        </div>
                        <div class="table-responsive datatable-custom">
                            <table id="datatable"
                                   class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                                <thead class="thead-light">
                                <tr>
                                    <th></th>
                                    <th class="table-column-ps-0">@lang('Name')</th>
                                    <th class="table-column-ps-0">@lang('Price')</th>
                                    <th class="table-column-ps-0">@lang('Discount')</th>
                                    <th class="table-column-ps-0">@lang('Discount Type')</th>
                                    <th class="table-column-ps-0">@lang('Max Sell')</th>
                                    <th class="table-column-ps-0"></th>
                                </tr>
                                </thead>

                                <tbody id="offeredCardTable">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
                        <h4 class="h1">@lang('Welcome to Campaign Panel')</h4>
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
                            <h4>@lang('Read before to start a campaign')</h4>
                            <p>@lang('Please select campaign products and set their prices and discounts. If a campaign ends or a product is removed from the campaign, its price will automatically revert to the original price.')</p>
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
    <link rel="stylesheet" href="{{ asset('assets/admin/css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict';
        document.addEventListener('DOMContentLoaded', function () {
            let startDate = '{{ $campaign->start_date }}';
            let endDate = '{{ $campaign->end_date }}';

            flatpickr('.js-flatpickr', {
                mode: 'range',
                dateFormat: 'Y-m-d',
                minDate: 'today',
                defaultDate: [startDate, endDate],
                onChange: function (selectedDates) {
                    if (selectedDates.length === 2) {
                        console.log('Date range selected:', selectedDates[0].toLocaleDateString(), 'to', selectedDates[1].toLocaleDateString());
                    }
                }
            });
        });

        new bootstrap.Modal(document.getElementById('exportCustomersGuideModal')).show()
        HSCore.components.HSTomSelect.init('.js-select');
        var currency = "{{basicControl()->base_currency}}";

        var offerTopUps = [];
        var offerCards = [];

        let selectedTopUpIds = $('#topUpSelect').val();
        getCampaignTopUp(selectedTopUpIds);

        let selectedCardIds = $('#cardSelect').val();
        getCampaignCard(selectedCardIds);

        $(document).on("change", "#topUpSelect", function () {
            let selectedIds = $(this).val();
            getCampaignTopUp(selectedIds)
        });

        $(document).on("change", "#cardSelect", function () {
            let selectedIds = $(this).val();
            getCampaignCard(selectedIds)
        });

        function getCampaignTopUp(selectedIds) {
            axios.post("{{ route('admin.campaign.getTopUpService') }}", {
                selectedIds: selectedIds,
            })
                .then(function (response) {
                    if (response.data.status) {
                        let res = response.data.offerServices;
                        res.forEach(item => {
                            pushIfNotExists(offerTopUps, item, 'id');
                        });

                        offerTopUps = offerTopUps.filter(item =>
                            res.some(resItem => resItem.id === item.id)
                        );

                        showTopUpCampaignTable();
                    }
                })
                .catch(function (error) {

                });
        }

        function getCampaignCard(selectedIds) {
            axios.post("{{ route('admin.campaign.getCardService') }}", {
                selectedIds: selectedIds,
            })
                .then(function (response) {
                    if (response.data.status) {
                        let res = response.data.offerServices;
                        res.forEach(item => {
                            pushIfNotExists(offerCards, item, 'id');
                        });

                        offerCards = offerCards.filter(item =>
                            res.some(resItem => resItem.id === item.id)
                        );

                        showCardCampaignTable();
                    }
                })
                .catch(function (error) {

                });
        }

        function pushIfNotExists(array, newItem, key) {
            const exists = array.some(item => item[key] === newItem[key]);
            if (!exists) {
                array.push(newItem);
            }
        }

        function showTopUpCampaignTable() {
            let offeredTopUpTable = $('#offeredTopUpTable');
            offeredTopUpTable.html('');
            let show = "";

            offerTopUps.forEach((obj) => {
                show += `<tr>
                                <th>
                                    <img class="avatar" src="${obj.image_path}" alt="Image Description">
                                </th>
                                <th class="table-column-ps-0">
                                    <input type="text" value="${obj.name}" class="form-control" readonly style="min-width: 12rem;">
                                </th>
                                <th class="table-column-ps-0">
                                    <div class="input-group input-group-merge" style="min-width: 7rem;">
                                        <div class="input-group-prepend input-group-text">${currency}</div>
                                        <input type="text" name="topup_price[${obj.id}]" class="form-control" value="${obj.price}">
                                    </div>
                                </th>
                                <th class="table-column-ps-0">
                                    <input type="number" step="any" name="topup_discount[${obj.id}]" value="${obj.discount}" class="form-control" style="min-width: 3rem;">
                                </th>
                                <th class="table-column-ps-0">
                                    <select class="form-select" name="topup_discount_type[${obj.id}]" style="min-width: 6rem;">
                                         <option value="flat" ${obj.discount_type === 'flat' ? 'selected' : ''}>Flat</option>
                                         <option value="percentage" ${obj.discount_type === 'percentage' ? 'selected' : ''}>Percentage</option>
                                    </select>
                                </th>
                                <th class="table-column-ps-0">
                                    <input type="number" name="topup_max_sell[${obj.id}]" value="${obj.max_sell}" class="form-control" style="min-width: 3rem;">
                                </th>
                            </tr>`;
            });

            offeredTopUpTable.append(show);
        }

        function showCardCampaignTable() {
            let offeredCardTable = $('#offeredCardTable');
            offeredCardTable.html('');
            let show = "";

            offerCards.forEach((obj) => {
                show += `<tr>
                                <th>
                                    <img class="avatar" src="${obj.image_path}" alt="Image Description">
                                </th>
                                <th class="table-column-ps-0">
                                    <input type="text" value="${obj.name}" class="form-control" readonly style="min-width: 12rem;">
                                </th>
                                <th class="table-column-ps-0">
                                    <div class="input-group input-group-merge" style="min-width: 7rem;">
                                        <div class="input-group-prepend input-group-text">${currency}</div>
                                        <input type="text" name="card_price[${obj.id}]" class="form-control" value="${obj.price}">
                                    </div>
                                </th>
                                <th class="table-column-ps-0">
                                    <input type="number" step="any" name="card_discount[${obj.id}]" value="${obj.discount}" class="form-control" style="min-width: 3rem;">
                                </th>
                                <th class="table-column-ps-0">
                                    <select class="form-select" name="card_discount_type[${obj.id}]" style="min-width: 6rem;">
                                         <option value="flat" ${obj.discount_type === 'flat' ? 'selected' : ''}>Flat</option>
                                         <option value="percentage" ${obj.discount_type === 'percentage' ? 'selected' : ''}>Percentage</option>
                                    </select>
                                </th>
                                <th class="table-column-ps-0">
                                    <input type="number" name="card_max_sell[${obj.id}]" value="${obj.max_sell}" class="form-control" style="min-width: 3rem;">
                                </th>
                            </tr>`;
            });

            offeredCardTable.append(show);
        }

    </script>
@endpush
