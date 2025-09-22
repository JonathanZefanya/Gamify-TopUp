@extends(template().'layouts.user')
@section('title',trans('Identity Verification'))
@section('content')
    <div class="pagetitle d-flex align-items-center justify-content-between mb-3">
        <div>
            <h3 class="mb-1">@lang('Identity Verification')</h3>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Identity Verification')</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('user.kyc.history') }}" class="cmn-btn2 float-end">@lang('History')</a>
    </div>
    <div class="row">
        <div class="account-settings-profile-section">
            <div class="card">
                <div class="card-body pt-0">
                    <form action="{{ route('user.kyc.verification.submit') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="account-settings-profile-section">
                            <div class="card">
                                <div class="card-header border-0 text-start text-md-center">
                                    <h5 class="card-title">@lang('KYC Information')</h5>
                                    <p>@lang('Verify your process instantly.')</p>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-md-8 mx-auto">
                                            <div class="row g-4">
                                                <div class="col-12 mb-2">
                                                    <label class="form-label">@lang('Kyc Type')</label>
                                                    <select class="cmn-select2 " name="kycType">
                                                        <option value="">@lang('Select Kyc Type')</option>
                                                        @foreach($kyc as $item)
                                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="oldKyc">

                                                    </div>
                                                </div>
                                                <div id="kycForm" class="mt-0">
                                                </div>

                                                <div class="btn-area mt-0">
                                                    <button type="submit" class="cmn-btn">@lang('submit')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset(template(true) . 'css/flatpickr.min.css')}}">
    <style>
        .form-control{
            height: 39px !important;
        }
        .input-box {
            position: relative;
            display: flex;
            align-items: flex-start !important;
            flex-direction: column;
        }
        #oldKyc{
            margin-top: 20px;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset(template(true).'js/flatpickr.js')}}"></script>
    <script>
        function previewFile(event) {
            const input = event.target;
            const previewId = input.id.replace('_input', '_preview');
            const preview = document.getElementById(previewId);
            const file = input.files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
                preview.style.display = 'block';
                preview.style.height = '100px';
                preview.style.width = '100px';
                preview.style.borderRadius = '10px';
                preview.style.margin = '10px';
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "{{ asset('assets/themes/light/img/no_image.png')}}";
                preview.style.display = 'none';
            }
        }
        $(document).ready(function() {
            $('select[name="kycType"]').change(function() {
                $('#kycForm').empty();
                let selectedKyc = $(this).val();
                if (selectedKyc) {
                    let ajaxUrl = "{{ route('user.kycFrom.details') }}";
                    let csrfToken = $('[name="_token"]').val();

                    $.ajax({
                        url: ajaxUrl,
                        type: 'GET',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            kycTypeID: selectedKyc
                        },
                        success: function(response) {
                            let statusMessage = '';
                            let kycName = response.kyc.name;

                            if (response.status === 0) {
                                statusMessage = `<div class="alert alert-warning mt-1 d-flex justify-content-between" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fa-sharp fa-light fa-triangle-exclamation pe-2 alertIcon"></i>
                                    ${kycName} submitted and Pending Now.
                                </div>
                             </div>`;
                            } else if (response.status === 1) {
                                statusMessage = `<div class="alert alert-success mt-1 d-flex justify-content-between" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fa-sharp fa-light fa-triangle-exclamation pe-2 alertIcon"></i>
                                ${kycName} Already Submitted and Also Verified.
                            </div>
                         </div>`;
                            } else if (response.status === 2) {
                                let rejectReason = response.reason;
                                statusMessage = `<div class="alert alert-danger mt-1" role="alert">
                                <i class="fa-sharp fa-light fa-triangle-exclamation pe-2 alertIcon"></i>
                                Your previous ${kycName} submission was rejected due to ${rejectReason}.
                                Please resubmit your ${kycName} with accurate and complete information.
                             </div>`;
                            }

                            $('#oldKyc').html(statusMessage);

                            if (response.status !== 0 && response.status !== 1) {
                                let inputFormHtml = '';
                                $.each(response.kyc.input_form, function(key, value) {
                                    if (value.type === "text" || value.type === "number") {
                                        inputFormHtml += `
                                    <div class="input-box col-md-12 pb-3">
                                        <label for="${value.field_name}" class="form-label">${value.field_label}</label>
                                        <input type="${value.type}" class="form-control"
                                            name="${value.field_name}"
                                            id="${value.field_name}"
                                            placeholder="${value.field_label}"
                                            autocomplete="off"/>
                                        @if($errors->has('${value.field_name}'))
                                        <div class="error text-danger">@lang($errors->first('${value.field_name}'))</div>
                                        @endif
                                        </div>`;
                                    } else if (value.type === "date") {
                                        inputFormHtml += `
                                    <div class="input-box col-md-12 pb-3">
                                        <label for="${value.field_name}" class="form-label">${value.field_label}</label>
                                        <input type="text" id="${value.field_name}" class="form-control flatpickr"
                                            name="${value.field_name}"
                                            placeholder="${value.field_label}"
                                            autocomplete="off"/>
                                        <div class="error text-danger" id="${value.field_name}_error">@lang($errors->first('${value.field_name}'))</div>
                                    </div>`;
                                    } else if (value.type === "textarea") {
                                        inputFormHtml += `
                                    <div class="input-box col-md-12 pb-3">
                                        <label for="" class="form-label">${value.field_label}</label>
                                        <textarea class="form-control" id="" cols="30" rows="2"
                                            name="${value.field_name}"></textarea>
                                        @if($errors->has('${value.field_name}'))
                                        <div class="error text-danger">@lang($errors->first('${value.field_name}'))</div>
                                        @endif
                                        </div>`;
                                    } else if (value.type === "file") {
                                        inputFormHtml += `
                                    <div class="input-box col-12 pb-3">
                                        <label for="" class="form-label">${value.field_label}</label>
                                        <div class="attach-file w-100">
                                            <img id="${value.field_name}_preview" src="" alt="Image Preview" style="display:none; max-width: 100%; margin-top: 10px;"/>
                                            <input class="form-control" accept="image/*" name="${value.field_name}" type="file" id="${value.field_name}_input" onchange="previewFile(event)"/>
                                        </div>
                                    </div>`;
                                    }
                                });
                                $('#kycForm').html(inputFormHtml);
                                const today = new Date().toISOString().split('T')[0];

                                flatpickr('.flatpickr', {
                                    enableTime: false,
                                    dateFormat: "Y-m-d"
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            $('.cmn-select2').select2();
        });
    </script>
@endpush

