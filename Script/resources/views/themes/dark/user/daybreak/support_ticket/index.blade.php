@extends(template().'layouts.user')
@section('title',trans('Support Ticket'))
@section('content')
    <div class="container">
        <div class="pagetitle mt-20">
            <h4 class="mb-1">@lang('support Ticket')</h4>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('support Ticket')</li>
                </ol>
            </nav>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between pb-0 border-0 ticketListHeader" >
                <h4>@lang('Support Ticket')</h4>
                <div class="btn-area">
                    <a href="{{route('user.ticket.create')}}" class="cmn-btn2"><i class="fa-regular fa-circle-plus"></i>@lang('Create Ticket')</a>
                </div>
            </div>

            <div class="card-body">
                <div class="cmn-table">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                            <tr>
                                <th scope="col">@lang('Subject')</th>
                                <th scope="col">@lang('Status')</th>
                                <th scope="col">@lang('Last Reply')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>

                            @if(count($tickets) > 0)
                                @foreach($tickets as $ticket)
                                    <tr>
                                        <td data-label="@lang('Transaction ID')">
                                            <span> [{{ trans('Ticket#').$ticket->ticket }}] {{ $ticket->subject }}</span>
                                        </td>
                                        <td data-label="@lang('Status')">
                                            @if($ticket->status == 0)
                                                <span class="badge text-bg-primary">@lang('Open')</span>
                                            @elseif($ticket->status == 1)
                                                <span class="badge text-bg-success">@lang('Answered')</span>
                                            @elseif($ticket->status == 2)
                                                <span class="badge text-bg-warning">@lang('Replied')</span>
                                            @elseif($ticket->status == 3)
                                                <span class="badge text-bg-danger">@lang('Closed')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Last Reply')">
                                            {{diffForHumans($ticket->last_reply) }}
                                        </td>

                                        <td data-label="@lang('Action')">
                                            <a href="{{ route('user.ticket.view', $ticket->ticket) }}"
                                               class="cmn-btn2"><i class="fa-regular fa-eye"></i>@lang('View')
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
        {{ $tickets->appends($_GET)->links(template().'partials.pagination') }}
    </div>

    <!-- user table -->
@endsection

