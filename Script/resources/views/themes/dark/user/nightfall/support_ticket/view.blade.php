@extends(template().'layouts.user')
@section('title',trans('View Ticket'))
@section('content')
    <div class="pagetitle">
        <h3 class="mb-1">@lang('View Ticket')</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('View Ticket')</li>
            </ol>
        </nav>
    </div>
    <div class="user-profile-section">
        <div class="container message-container">
            <div class="row g-0">
                <div class=" col-md-12">
                    <div class="chat-box">
                        <div class="header-section">
                            <div class="profile-info">
                                <div class="thumbs-area">
                                    <img src="{{getFile($admin->image_driver,$admin->image)}}" alt="{{$admin->name}}">
                                </div>
                                <div class="content-area">
                                    <div class="title">{{ $admin->name }}</div>
                                    <div class="description">
                                        @if($ticket->status == 0)
                                            @lang('Open')
                                        @elseif($ticket->status == 1)
                                            @lang('Answered')
                                        @elseif($ticket->status == 2)
                                            @lang('Replied')
                                        @else
                                            @lang('Closed')
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="btn-area">
                                @if($ticket->status != 3)
                                    <button type="button" data-bs-target="#closeTicketModal" data-bs-toggle="modal"
                                            class="cmn-btn">@lang('Close')</button>
                                @endif
                            </div>
                        </div>
                        <div class="chat-box-inner" id="chatBox">
                            @if(count($ticket->messages) > 0)
                                @foreach($ticket->messages->sortBy('id') as $item)
                                    @if($item->admin_id == null)
                                        <div class="message-bubble message-bubble-right">
                                            <div class="message-thumbs">
                                                <img
                                                    src="{{getFile(auth()->user()->image_driver,auth()->user()->image)}}"
                                                    alt="...">
                                            </div>
                                            <div class="message-text-box">
                                                <p class="message-text">{{ __($item->message) }}</p>
                                                @if(0 < count($item->attachments))
                                                    <button type="button"
                                                            data-files="{{$item->attachments}}"
                                                            class="file-img-box-link right"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#imageModal">
                                                        <div class="file"><i class="fa-regular fa-file"></i></div>
                                                        <div
                                                            class="text">{{count($item->attachments)}} @lang('Files')</div>
                                                    </button>
                                                @endif
                                                <p class="message-time"> {{ __($item->created_at->format(basicControl()->date_time_format)) }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="message-bubble message-bubble-left">
                                            <div class="message-thumbs">
                                                <img src="{{getFile($admin->image_driver,$admin->image)}}" alt="...">
                                            </div>
                                            <div class="message-text-box">
                                                <p class="message-text">{{ __($item->message) }}</p>
                                                @if(0 < count($item->attachments))
                                                    <button type="button"
                                                            data-files="{{$item->attachments}}"
                                                            class="file-img-box-link right"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#imageModal">
                                                        <div class="file"><i class="fa-regular fa-file"></i></div>
                                                        <div
                                                            class="text">{{count($item->attachments)}} @lang('Files')</div>
                                                    </button>
                                                @endif

                                                <p class="message-time">{{ __($item->created_at->format(basicControl()->date_time_format)) }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="select-box">
                            <p class="select-files-count"></p>
                        </div>
                        @if($ticket->status != 3)
                            <form action="{{ route('user.ticket.reply', $ticket->id)}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="chat-box-bottom">
                                    <div class="cmn-btn-group2 d-flex justify-content-sm-end ">
                                        <div class="dropdown dropup">
                                            <input type="file" id="upload" name="attachments[]" multiple>
                                            <button class="message-send-btn" type="button">
                                                <i class="fa-regular fal fa-paperclip"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <textarea class="form-control" name="message" id="exampleFormControlTextarea1"
                                              rows="3">{{ old('message') }}</textarea>
                                    <button type="submit" name="reply_ticket" value="1" class="message-send-btn"><i
                                            class="fa-thin fa-paper-plane"></i></button>

                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="closeTicketModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">@lang('Confirmation !')</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('user.ticket.reply', $ticket->id) }}">
                        @csrf
                        @method('PUT')
                        <p>
                            @lang('Are you want to close ticket')?
                        </p>
                        <div class="modal-footer">
                            <button type="button" class="cmn-btn3 text-white" data-bs-dismiss="modal">@lang('Close')</button>
                            <button type="submit" name="reply_ticket"
                                    value="2" class="cmn-btn">@lang('Confirm')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="imageModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">@lang("Files")</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="file-img-box" id="showFile">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cmn-btn" data-bs-dismiss="modal">@lang('Close')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js_libs')
    <script src="{{ asset(template(true) . 'js/fancybox.umd.js') }}"></script>
@endpush
@push('script')
    <script>
        'use strict';

        $(document).on("click", ".file-img-box-link", function () {
            let files = $(this).data('files');
            $('#showFile').html('');
            let item = "";
            if (files.length > 0) {
                for (let i = 0; i < files.length; i++) {
                    console.log(files[i].image);
                    item += `<div class="item">
                            <div class="w-100">
                                <a data-fancybox="gallery" href="${files[i].image}">
                                    <img class="rounded" src="${files[i].image}"/>
                                </a>
                            </div>
                            <button type="button" data-link="${files[i].image}"
                                    class="cmn-btn download"><i class="fas fa-download"></i></button>
                        </div>`;
                }
                $('#showFile').html(item);
            }
        });

        $(document).on('change', '#upload', function () {
            let fileCount = $(this)[0].files.length;
            $('.select-files-count').text(fileCount + ' file(s) selected')
        });

        $(document).on("click", '.download', function () {
            let link = $(this).data('link');
            const anchor = document.createElement('a');
            anchor.href = link;
            anchor.download = link.substring(link.lastIndexOf('/') + 1);
            document.body.appendChild(anchor);
            anchor.click();
            document.body.removeChild(anchor);
        });

        document.addEventListener("DOMContentLoaded", function () {
            var chatBox = document.getElementById("chatBox");
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    </script>
@endpush
