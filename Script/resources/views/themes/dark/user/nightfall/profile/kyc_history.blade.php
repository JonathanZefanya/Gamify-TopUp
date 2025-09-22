@extends(template().'layouts.user')
@section('title',trans('KYC Verification History'))
@section('content')
    <div class="main row px-3">
        <div class="col-12">
            <div class="row pageHeadingAll">
                <div class="AddProduct">
                    <h2>@lang('Verification History')</h2>
                </div>
            </div>
            <div class="card">
                <div class="cmn-table mt-20">
                    <div class="table-responsive mt-4">
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('Serial')</th>
                                    <th scope="col">@lang('Type')</th>
                                    <th scope="col">@lang('Status')</th>
                                    <th scope="col">@lang('Submitted Date')</th>
                                    <th scope="col">@lang('Approved Date')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($userKyc as $item)
                                    <tr>
                                        <td data-label="@lang('Serial No.')">
                                            {{$loop->iteration}}
                                        </td>
                                        <td data-label="@lang('Kyc Type')">
                                                                    <span class="font-weight-bold">
                                                                        {{$item->kyc_type}}
                                                                    </span>
                                        </td>
                                        <td data-label="@lang('Kyc Status')">
                                            @if($item->status == 0)
                                                <span class="badge text-bg-warning">@lang('Pending')</span>
                                            @elseif($item->status == 1)
                                                <span class="badge text-bg-success">@lang('Accepted')</span>
                                            @elseif($item->status == 2)
                                                <span class="badge text-bg-danger">@lang('Rejected')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Submitted Date')">
                                            {{dateTime($item->created_at) }}
                                        </td>
                                        <td data-label="@lang('Approved Date')">
                                            {{ $item->approved_at ? dateTime($item->approved_at) : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <div class="text-center">
                                        @include('empty')
                                    </div>
                                @endforelse
                                </tbody>
                            </table>
                            {{ $userKyc->appends(request()->query())->links(template().'partials.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

