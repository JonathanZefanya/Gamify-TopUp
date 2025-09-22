@extends(template().'layouts.user')
@section('title',trans('Collection List'))
@section('content')
    <div class="pagetitle">
        <h3 class="mb-1">@lang('Collection List')</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('Collection List')</li>
            </ol>
        </nav>
    </div>
    <main id="main" class="main">
        <div class="container">
            <!-- table container -->
            <div class="table-container">
                <div class="card mt-50">
                    <div class="card-header d-flex justify-content-between align-items-center border-0 flex-wrap gap-3">
                        <h4 class="mb-0">@lang('Collection List')</h4>
                    </div>
                    <div class="card-body">
                        <div class="cmn-table">
                            <div class="table-responsive overflow-hidden">
                                <table class="table table-striped align-middle">
                                    <thead>
                                    <tr>
                                        <th scope="col">@lang('SL')</th>
                                        <th scope="col">@lang('Game')</th>
                                        <th scope="col">@lang('Type')</th>
                                        <th scope="col">@lang('Added Date')</th>
                                        <th scope="col">@lang('Action')</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if(count($collections) > 0)
                                        @foreach($collections as $key => $collection)
                                            @php
                                                if($collection->collectable_type == 'App\Models\Card'){
                                                       $type =  "Card";
                                                       $route =  route("card.details")."?id=".$collection->collectable_id."&name=".slug($collection->collectable?->name);
                                                }else{
                                                  $type =  "Direct Top Up";
                                                  $route =  route("topUp.details")."?id=".$collection->collectable_id."&name=".slug($collection->collectable?->name);
                                                }
                                            @endphp
                                            <tr>
                                                <td data-label="@lang('SL')">
                                                    <span>{{++$key}}</span>
                                                </td>
                                                <td data-label="@lang('Game')">
                                                    <div class="type">
                                                        <a href="{{$route}}" class="icon icon-sent"><img
                                                                src="{{getFile($collection->collectable?->image->preview_driver,$collection->collectable?->image->preview)}}"
                                                                alt="icon"></a>
                                                        <span>{{$collection->collectable?->name}}</span>
                                                    </div>
                                                </td>
                                                <td data-label="@lang('Type')" class="name-data">
                                                    <span
                                                        class="name">{{$type}}</span>
                                                </td>

                                                <td data-label="@lang('Added Date')">
                                                    <span>{{dateTime($collection->created_at,basicControl()->date_time_format)}}</span>
                                                </td>
                                                <td data-label="@lang('Action')" class="td-btn">
                                                    <a href="{{$route}}" class="btn-1"> @lang('Buy Now')
                                                    </a>
                                                    <a href="javascript:void(0)"
                                                       data-route="{{route('user.orderCollectionRemove',$collection->id)}}"
                                                       data-bs-target="#removeModal"
                                                       data-bs-toggle="modal" class="btn-1 remove_btn"> @lang('Remove')
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @include('empty')
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- table container -->
        </div>
    </main>
    {{ $collections->appends($_GET)->links(template().'partials.pagination') }}
    <!-- user table -->

    <!-- Modal section 2 start -->
    <div class="modal fade" id="removeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">@lang("Remove Confirmation")</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <p>@lang('Are you want to remove this game from this collection')</p>
                    </div>
                    <div class="modal-footer">
                        <form action="" method="POST" class="removeForm">
                            @csrf
                            @method('delete')
                            <button type="button" class="cmn-btn3" data-bs-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="cmn-btn">@lang('Yes')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal section 2 end -->
@endsection

@push('script')
    <script>
        'use strict';
        $(document).on("click", ".remove_btn", function () {
            $('.removeForm').attr('action', $(this).data('route'));
        });
    </script>
@endpush
