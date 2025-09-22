@extends('admin.layouts.app')
@section('page_title', __('KYC Setting'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item">
                                <a class="breadcrumb-link" href="javascript:void(0)">
                                    @lang('Dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('KYC Setting')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('KYC Setting')</h1>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0">@lang('KYC Form')</h4>
                <a href="{{ route('admin.kyc.create') }}" class="btn btn-primary">@lang('Add Form')</a>
            </div>

            <div class="table-responsive">
                <table class="table table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                    <tr>
                        <th>@lang('No.')</th>
                        <th>@lang('Form Type')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($kycList as $key => $kyc)
                        <tr>
                            <td>{{ $loop->index + 1  }}</td>
                            <td>
                                @lang($kyc->name)
                            </td>
                            <td>
                                @if($kyc->status ==  0)
                                    <span class="badge bg-soft-danger text-danger"><span class="legend-indicator bg-danger"></span>@lang('Inactive')</span>
                                @elseif($kyc->status ==  1)
                                    <span class="badge bg-soft-success text-success"><span class="legend-indicator bg-success"></span>@lang('Active')</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-white btn-sm" href="{{ route('admin.kyc.edit', $kyc->id) }}">
                                    <i class="bi-pencil-fill me-1"></i> @lang("Edit")
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="odd"><td valign="top" colspan="8" class="dataTables_empty"><div class="text-center p-4">
                                    <img class="mb-3 dataTables-image" src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                                    <img class="mb-3 dataTables-image" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="dark">
                                    <p class="mb-0">@lang("No data to show")</p>
                                </div></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('css-lib')
    @push('style')
        <style>
            .alert-soft-dark{
                background: #f0f0f054 !important;
            }
            .animated-button {
                position: relative;
                display: inline-block;
                overflow: hidden;
                color: #605555;
                background-color: #fff;
                border: 1px solid #fff;
                padding: 8px 16px;
                text-align: center;
                text-decoration: none;
                font-size: 14px;
                font-weight: bold;
                transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
            }

            .animated-button::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.2);
                transform: skewX(-30deg);
                transition: left 0.5s ease-in-out;
                z-index: 1;
            }

            .animated-button:hover {
                background-color: #377dff;
                color: #fff;
                transform: scale(1.05);
            }

            .animated-button:hover::before {
                left: 100%;
            }

            .animated-button:active {
                transform: scale(0.95);
            }
        </style>
    @endpush
@endpush

@push('script')
    <script>
        'use strict';

        $(document).on('click', '#kycMandatoryButton', function() {
            let button = $(this);
            let currentStatus = button.data('status');


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('admin.kycIsMandatory') }}",
                type: "POST",
                data: { kycMandatory: currentStatus },
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        let newStatus = currentStatus === 1 ? 0 : 1;
                        Notiflix.Notify.success('KYC Mandatory setting updated successfully.');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        Notiflix.Notify.failure('Failed to update KYC Mandatory setting.');
                    }
                },
                error: function(xhr, status, error) {
                    Notiflix.Notify.failure('An error occurred: ' + xhr.responseText);
                }
            });
        });
    </script>
@endpush



