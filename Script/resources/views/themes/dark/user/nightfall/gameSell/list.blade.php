@extends(template().'layouts.user')
@section('title')
    @lang('Sell Post List')
@endsection
@section('content')
    <div class="pagetitle mt-20">
        <h4 class="mb-1">@lang('Sell Posts')</h4>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('Sell Posts')</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between pb-0 border-0">
            <h4>@lang('Sell Posts')</h4>
            <div class="btn-area">
                <button type="button" class="cmn-btn" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">@lang('Filter')<i
                        class="fa-regular fa-filter"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="cmn-table">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                        <tr>
                            <th scope="col">@lang('No.')</th>
                            <th scope="col">@lang('Title')</th>
                            <th scope="col">@lang('Category')</th>
                            <th scope="col">@lang('Price')</th>
                            <th scope="col">@lang('Status')</th>
                            <th scope="col">@lang('Date - Time')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($sellPost as $k => $row)
                            <tr>
                                <td data-label="@lang('No.')">{{++$k}}</td>
                                <td data-label="@lang('Title')">@lang($row->title)
                                    @if($row->payment_status == 1)
                                        <span class="badge text-bg-info">@lang('sold')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Category')">@lang(optional(optional($row->category)->details)->name)</td>
                                <td data-label="@lang('Price')"><span
                                        class="font-weight-bold"></span>{{currencyPosition($row->price)}}
                                </td>
                                <td data-label="@lang('Status')">
                                        <?php echo $row->statusMessage; ?>
                                </td>

                                <td data-label="@lang('Date - Time')">{{dateTime($row->created_at, 'd M, Y h:i A')}}</td>
                                <td data-label="More">
                                    <div class="dropdown">
                                        <button class="action-btn-secondary" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-regular fa-ellipsis-stroke-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item offerAccept"
                                                   href="{{ route('sellPost.details',[slug($row->title), $row->id]) }}">
                                                    <i class="fa-regular fa fa-eye"></i> @lang('Details')
                                                </a>
                                            </li>

                                            @if($row->payment_status != 1)
                                                <li><a class="dropdown-item offerAccept"
                                                       href="{{Route('user.sellPostEdit',$row->id)}}">
                                                        <i class="fa-regular fa fa-edit"></i> @lang('Edit')
                                                    </a>
                                                </li>

                                                <li><a class="dropdown-item notiflix-confirm"
                                                       href="javascript:void(0)"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#delete-modal"
                                                       data-route="{{route('user.sellPostDelete',$row->id)}}">
                                                        <i class="fa-regular fa fa-trash"></i> @lang('Delete')
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @include('empty')
                        @endforelse
                        </tbody>
                    </table>
                    {{ $sellPost->appends($_GET)->links(template().'partials.pagination') }}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-modal" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">@lang('Delete Confirm')</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to delete this?')</p>
                </div>

                <div class="modal-footer mt-10">
                    <form action="" method="post" class="deleteRoute">
                        @csrf
                        @method('delete')
                        <button type="submit" class="cmn-btn2">@lang('Yes')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">@lang('Sell Post Filter')</h5>
            <button type="button" class="cmn-btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fa-light fa-arrow-right"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <form action="{{route('user.sellList')}}" method="get">
                <div class="row g-4">
                    <div>
                        <label for="ProductName" class="form-label">@lang('Product Name')</label>
                        <input type="text" name="title" value="{{@request()->title}}" class="form-control"
                               placeholder="@lang('Search for Title')">
                    </div>
                    <div>
                        <label for="NumberOfSales" class="form-label">@lang('Date')</label>
                        <input type="date" name="date" class="form-control" value="{{@request()->date}}" id="date">
                    </div>

                    <div class="btn-area">
                        <button type="submit" class="cmn-btn">@lang('Filter')</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection
@push('style')
    <link rel="stylesheet" href="{{asset('assets/global/css/flatpickr.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
@endpush

@push('script')
    <script src="{{asset('assets/global/js/flatpickr.min.js')}}"></script>
    <script>
        "use strict";
        flatpickr("#date", {
            theme: "dark"
        });
        $(document).ready(function () {
            $('.notiflix-confirm').on('click', function () {
                let route = $(this).data('route');
                $('.deleteRoute').attr('action', route)
            })
        });
    </script>
@endpush
