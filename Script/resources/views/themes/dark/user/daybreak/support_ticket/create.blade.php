@extends(template().'layouts.user')
@section('title',trans('Create Ticket'))
@section('content')
    <div class="container">
        <div class="pagetitle mt-20">
            <h4 class="mb-1">@lang('Ticket Create')</h4>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Ticket Create')</li>
                </ol>
            </nav>
        </div>
        <div class="card">
            <div class="card-header border-0 pb-0">
                <h4 class="title">@lang('Create a new ticket')</h4>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <form action="{{route('user.ticket.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="col-12">
                            <label for="Subject" class="form-label">@lang('Subject')</label>
                            <input type="text" name="subject"
                                   value="{{ old('subject') }}"
                                   class="form-control"
                                   placeholder="@lang('Enter Subject')">
                            @error('subject')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                        </div>
                        <div class="col-12 mt-3">
                            <label for="Message" class="form-label">@lang('Message')</label>
                            <textarea class="form-control" id="Message" rows="3" name="message" placeholder="@lang('Enter Your Message')"> {{ old('message') }}</textarea>
                            @error('message')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="Upload-File" class="form-label pt-2">@lang('Upload File')</label>
                            <div class="previewImage"></div>
                            <div class="attach-file">
                                <div class="prev">@lang('Upload File')</div>
                                <input class="form-control" type="file" id="Upload-File" name="attachments[]" multiple>

                            </div>
                            @error('attachments')
                                <span class="text-danger">@lang($message)</span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <button type="submit" class="cmn-btn mt-30"><i class="fa-regular fa-circle-plus"></i>@lang('Create') <span></span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <style>
        .form-control{
            height: 39px !important;
        }
    </style>
@endpush
@push('script')
    <script>
        document.getElementById('Upload-File').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.querySelector('.previewImage');
            previewContainer.innerHTML = '';

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.style.maxWidth = '100px';
                        imgElement.style.margin = '5px';
                        previewContainer.appendChild(imgElement);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    </script>
@endpush
