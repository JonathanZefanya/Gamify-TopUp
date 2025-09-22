@extends(template().'layouts.user')
@section('title',__('Payout'))

@section('content')

    <div class="pagetitle">
        <h3 class="mb-1">@lang('Payout Confirm')</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('Payout Confirm')</li>
            </ol>
        </nav>
    </div>
    <div class="row gy-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.payout.confirm',$payout->trx_id) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            @if($payoutMethod->supported_currency)
                                <div class="col-md-12">
                                    <label for="from_wallet" class="mb-2">@lang('Select Bank Currency')</label>
                                    <div class="input-box search-currency-dropdown">
                                        <input type="text" name="currency_code"
                                               placeholder="Selected"
                                               autocomplete="off"
                                               value="{{ $payout->payout_currency_code }}"
                                               class="form-control transfer-currency @error('currency_code') is-invalid @enderror">

                                        @error('currency_code')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            @if($payoutMethod->code == 'paypal')
                                <div class="row">
                                    <div class="col-md-12 mt-2">
                                        <label for="from_wallet">@lang('Select Recipient Type')</label>
                                        <div class="form-group search-currency-dropdown">
                                            <select id="from_wallet" name="recipient_type"
                                                    class="form-control form-control-sm" required>
                                                <option value="" disabled=""
                                                        selected="">@lang('Select Recipient')</option>
                                                <option value="EMAIL">@lang('Email')</option>
                                                <option value="PHONE">@lang('phone')</option>
                                                <option value="PAYPAL_ID">@lang('Paypal Id')</option>
                                            </select>
                                            @error('recipient_type')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif


                            @if(isset($payoutMethod->inputForm))
                                @foreach($payoutMethod->inputForm as $key => $value)
                                    @if($value->type == 'text')
                                        <label for="{{ $value->field_name }}">@lang($value->field_label)</label>
                                        <div class="input-box mt-2 d-flex flex-column">
                                            <input type="text" name="{{ $value->field_name }}"
                                                   placeholder="{{ __(snake2Title($value->field_name)) }}"
                                                   autocomplete="off"
                                                   value="{{ old(snake2Title($value->field_name)) }}"
                                                   class="form-control @error($value->field_name) is-invalid @enderror">
                                            <div class="invalid-feedback">
                                                @error($value->field_name) @lang($message) @enderror
                                            </div>
                                        </div>
                                    @elseif($value->type == 'textarea')
                                        <label for="{{ $value->field_name }}"
                                               class="mt-3">@lang($value->field_label)</label>
                                        <div class="input-box mt-2 d-flex flex-column">
                                            <textarea
                                                class="form-control @error($value->field_name) is-invalid @enderror"
                                                name="{{$value->field_name}}"
                                                rows="2">{{ old($value->field_name) }}</textarea>
                                            <div
                                                class="invalid-feedback">@error($value->field_name) @lang($message) @enderror</div>
                                        </div>
                                    @elseif($value->type == 'file')
                                        <div class="image-upload-container">
                                            <label for="image-upload"
                                                   id="image-label" class="form-label">@lang($value->field_label)</label>
                                            <div class="image-preview-container d-none" id="imagePreviewContainer">
                                                <div class="image-preview" id="imagePreview"></div>
                                            </div>
                                            <label for="imageUpload" class="upload-label">
                                                <input type="file" id="imageUpload" class="file-input @error($value->field_name) is-invalid @enderror" name="{{ $value->field_name }}" accept="image/*" onchange="previewImage(event)">
                                                <span class="upload-button">@lang('Upload Image')</span>
                                            </label>
                                        </div>

                                    @endif
                                @endforeach
                            @endif
                            <div class="input-box col-12">
                                <button type="submit" class="cmn-btn">@lang('submit') <span></span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="custom-card bg-gradient contact-box">
                <div class="card-body gradient-bg">
                    <ul class="list-group list-group-numbered">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold-500">@lang('Payout Method')</div>
                            </div>
                            <span class="">{{ __($payoutMethod->name) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold-500">@lang('Request Amount')</div>

                            </div>
                            <span
                                class=" ">{{ (getAmount($payout->amount)) }} {{ $payout->payout_currency_code }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold-500">@lang('Charge')</div>
                            </div>
                            <span
                                class="text-danger">{{ (getAmount($payout->charge)) }} {{ $payout->payout_currency_code }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold-500">@lang('Amount In Base Currency')</div>
                            </div>
                            <span
                                class=" ">{{ (getAmount($payout->amount_in_base_currency)) }} {{ basicControl()->base_currency }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    <style>
        .image-upload-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            font-family: Arial, sans-serif;
        }

        .upload-label {
            display: inline-block;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .upload-label:hover {
            background-color: #45a049;
        }

        .file-input {
            display: none;
        }

        .image-preview-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .preview-label {
            font-size: 14px;
            color: #555;
            font-weight: bold;
        }

        .image-preview {
            width: 200px;
            height: 200px;
            border: 2px dashed #ccc;
            border-radius: 10px;
            overflow: hidden;
            background-color: #f9f9f9;
            color: #888;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


    </style>
@endpush
@push('extra_scripts')
    <script src="{{ asset('assets/dashboard/js/jquery.uploadPreview.min.js') }}"></script>
@endpush
@push('script')
    <script>
        'use strict'
        function previewImage(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('imagePreview');
            const previewWrapper = document.getElementById('imagePreviewContainer');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewContainer.innerHTML = `<img src="${e.target.result}" alt="Image Preview">`;
                    previewWrapper.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.innerHTML = '';
                previewWrapper.classList.add('d-none');
            }
        }
    </script>
@endpush

@push('script')
@endpush
