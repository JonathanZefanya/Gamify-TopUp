@extends(template().'layouts.user')
@section('title',trans('Sell Post Edit'))

@section('content')
    <!-- UPLOAD SELL POST -->
    <div class="container">
        <div class="row">
            <div class="pagetitle mt-20">
                <h4 class="mb-1">@lang('Edit Sell Post')</h4>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Edit Sell Post')</li>
                    </ol>
                </nav>
            </div>
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header pb-0 border-0">
                            <h4>@lang('Create New')</h4>
                        </div>
                        @include('errors.error')
                        <form action="{{ route('user.sellPostUpdate',$sellPost->id)}}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="price" class="form-label">@lang('Title')</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="title"
                                            value="{{$sellPost->title}}"
                                            id="exampleFormControlInput1"
                                            placeholder="Title" required
                                        />
                                        @if($errors->has('title'))
                                            <div
                                                class="error text-danger">@lang($errors->first('title')) </div>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <label for="price" class="form-label">@lang('Price')</label>
                                        <span class="info sellCharge" title="@lang("How much of this will i earn ?")"
                                              data-resource="{{$sellPost->sell_charge}}" data-bs-toggle="modal"
                                              data-bs-target="#sellCharge">
                                            <img class="info-icon"
                                                 src="{{ asset(template(true).'/img/info.png')}}"
                                                 alt="..."/>
                                        </span>

                                        <div class="input-group append">
                                            <input
                                                type="number"
                                                class="form-control price"
                                                name="price"
                                                value="{{old('price',$sellPost->price)}}"
                                                id="exampleFormControlInput1"
                                                placeholder="Price"
                                            />

                                            <button class="cmn-btn2"
                                                    type="button">{{basicControl()->base_currency}}</button>

                                        </div>

                                        @if($errors->has('price'))
                                            <div
                                                class="error text-danger">@lang($errors->first('price')) </div>
                                        @endif
                                    </div>
                                    @if(isset($sellPost) && !empty($sellPost->credential))
                                        <div class="col-md-12">
                                            <div class="dark-bg p-3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="header-box-title">
                                                            <h6>
                                                                @lang($sellPost->category->details->name.' Credential')
                                                                <span class="info" data-bs-toggle="tooltip"
                                                                      title="@lang("This credentials need for admin approval")">
                                                                    <img class="info-icon"
                                                                         src="{{ asset(template(true)) . '/img/info.png' }}"
                                                                         alt="..."/>
                                                                </span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    @forelse($sellPost->credential as $k => $v)
                                                        <div class="col-md-6">
                                                            @if ($v->type == 'text')
                                                                <div class="form-group">
                                                                    <label
                                                                        for="exampleFormControlInput1"
                                                                        class="form-label"
                                                                    >{{ trans($v->field_name) }}

                                                                        @if ($v->validation == 'required')
                                                                            <span
                                                                                class="text-danger">*</span>
                                                                        @endif
                                                                    </label>
                                                                    <input name="{{ $k }}" type="text" class="form-control"
                                                                           value="{{ trans($v->field_value) }}"
                                                                    @if ($v->validation == 'required')  @endif />

                                                                    @error($k)
                                                                    <span
                                                                        class="text-danger">{{ $message  }}</span>
                                                                    @enderror
                                                                </div>
                                                            @elseif($v->type == 'textarea')
                                                                <div class="form-group">
                                                                    <label
                                                                        for="exampleFormControlInput1"
                                                                        class="form-label"
                                                                    >{{ trans($v->field_name) }}

                                                                        @if ($v->validation == 'required')
                                                                            <span
                                                                                class="text-danger">*</span>
                                                                        @endif
                                                                    </label>

                                                                    <textarea name="{{ $k }}" class="form-control"
                                                                @if ($v->validation == 'required')  @endif>{{old($k)}}</textarea>
                                                                    @if ($errors->has($k))
                                                                        <span
                                                                            class="text-danger">{{ trans($errors->first($k)) }}</span>
                                                                    @endif

                                                                </div>
                                                            @elseif($v->type == 'file')
                                                                <div class="form-group">
                                                                    <label
                                                                        for="exampleFormControlInput1"
                                                                        class="form-label"
                                                                    >{{ trans($v->field_name) }}

                                                                        @if ($v->validation == 'required')
                                                                            <span
                                                                                class="text-danger">*</span>
                                                                        @endif
                                                                    </label>

                                                                    <input name="{{ $k }}" type="file" class="form-control"
                                                                           placeholder="{{ trans($v->field_value) }}"
                                                                    @if ($v->validation == 'required')   @endif />

                                                                    @if ($errors->has($k))
                                                                        <span
                                                                            class="text-danger">{{ trans($errors->first($k)) }}</span>
                                                                    @endif
                                                                </div>
                                                            @endif

                                                        </div>
                                                    @empty
                                                    @endforelse
                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                    @if(isset($sellPost) && !empty($sellPost->post_specification_form))
                                        <div class="col-md-12">
                                            <div class="dark-bg p-3">
                                                <div class="row">
                                                    <div class="header-box-title">
                                                        <h6>@lang($sellPost->category->details->name.' Specification')
                                                            <span class="info" data-bs-toggle="tooltip"
                                                                  title="@lang("This specification need for admin approval")">
                                                                    <img class="info-icon"
                                                                         src="{{ asset(template(true)) . '/img/info.png' }}"
                                                                         alt="..."/>
                                                                </span>
                                                        </h6>
                                                    </div>
                                                    @forelse($sellPost->post_specification_form as $k => $v)
                                                        <div class="col-md-6">
                                                            @if ($v->type == 'text')
                                                                <div class="form-group">
                                                                    <label
                                                                        for="exampleFormControlInput1"
                                                                        class="form-label"
                                                                    >{{ trans($v->field_name) }}

                                                                        @if ($v->validation == 'required')
                                                                            <span
                                                                                class="text-danger">*</span>
                                                                        @endif
                                                                    </label>
                                                                    <input name="{{ $k }}" type="text" class="form-control"
                                                                           value="{{ trans($v->field_value) }}"
                                                                    @if ($v->validation == 'required')  @endif />

                                                                    @error($k)
                                                                    <span
                                                                        class="text-danger">{{ $message  }}</span>
                                                                    @enderror
                                                                </div>
                                                            @elseif($v->type == 'textarea')
                                                                <div class="form-group">
                                                                    <label
                                                                        for="exampleFormControlInput1"
                                                                        class="form-label"
                                                                    >{{ trans($v->field_name) }}

                                                                        @if ($v->validation == 'required')
                                                                            <span
                                                                                class="text-danger">*</span>
                                                                        @endif
                                                                    </label>

                                                                    <textarea name="{{ $k }}" class="form-control"
                                                                @if ($v->validation == 'required')  @endif>{{old($k)}}</textarea>
                                                                    @if ($errors->has($k))
                                                                        <span
                                                                            class="text-danger">{{ trans($errors->first($k)) }}</span>
                                                                    @endif

                                                                </div>
                                                            @elseif($v->type == 'file')
                                                                <div class="form-group">
                                                                    <label
                                                                        for="exampleFormControlInput1"
                                                                        class="form-label"
                                                                    >{{ trans($v->field_name) }}

                                                                        @if ($v->validation == 'required')
                                                                            <span
                                                                                class="text-danger">*</span>
                                                                        @endif
                                                                    </label>

                                                                    <input name="{{ $k }}" type="file" class="form-control"
                                                                           placeholder="{{ trans($v->field_value) }}"
                                                                    @if ($v->validation == 'required')   @endif />

                                                                    @if ($errors->has($k))
                                                                        <span
                                                                            class="text-danger">{{ trans($errors->first($k)) }}</span>
                                                                    @endif
                                                                </div>
                                                            @endif

                                                        </div>
                                                    @empty
                                                    @endforelse
                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12">
                                        <label for="Comments" class="form-label">@lang('Description')</label>
                                        <textarea
                                            class="form-control"
                                            name="details"
                                            id="exampleFormControlTextarea1"
                                            rows="5"
                                            placeholder="Description" required
                                        >{{$sellPost->details}}</textarea>
                                        @if($errors->has('details'))
                                            <div
                                                class="error text-danger">@lang($errors->first('details')) </div>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <label
                                            for="exampleFormControlTextarea1"
                                            class="form-label">@lang('Message to the Reviewer')</label>
                                        <textarea
                                            class="form-control"
                                            name="comments"
                                            id="exampleFormControlTextarea1"
                                            rows="2"
                                            placeholder="@lang('Comments')" required>{{old('comments')}}</textarea>
                                        @if($errors->has('comments'))
                                            <div
                                                class="error text-danger">@lang($errors->first('comments')) </div>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <a href="javascript:void(0)" class="btn btn-success float-left mt-3 generate">
                                                <i class="fa fa-image"></i> @lang('Add Image')</a>
                                        </div>
                                        @if($errors->has('image'))
                                            <div
                                                class="error text-danger">@lang($errors->first('image')) </div>
                                        @endif
                                    </div>
                                    <div class="row addedField mt-3">
                                        @if($sellPost->image)
                                            @foreach($sellPost->image as $image)
                                                @php
                                                    $newString = \Illuminate\Support\Str::replaceFirst('sellingPost/', '', $image);
                                                @endphp
                                                <div class="col-sm-12 col-md-4 image-column d-block">
                                                    <input type="hidden" name="oldImage[]" value="{{ $image }}">

                                                    <div class="card shadow-sm mb-3">
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <div class="image-upload-wrapper position-relative" onclick="triggerFileInput(this)">
                                                                    <input type="file" name="image[]" class="image-input d-none" accept="image/*" onchange="previewImage(event, this)">
                                                                    <img id="preview" class="img-fluid rounded preview-image mx-auto d-block"
                                                                         src="{{ getFile($sellPost->image_driver, $image) }}"
                                                                         alt="@lang('preview image')">
                                                                    <button type="button" class="cmn-btn2 btn-sm position-absolute upload-btn">
                                                                        @lang('Choose Image')
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <button
                                                                class="btn btn-danger btn-sm btn-block removeFileExist"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#delete-modal"
                                                                data-route="{{ route('user.sell.image.delete', [$sellPost->id, $newString]) }}"
                                                                type="button"
                                                            >
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>

                                    <button type="submit" class="cmn-btn mt-30">@lang('Update Now')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="sellCharge" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">@lang('How Much You Earn')</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="withdraw-detail">
                        <div class="form-group mb-2">
                            <label>@lang('Price')</label>
                            <div class="input-group append">
                                <input type="number" class="form-control modal-price" value=""/>
                                <button class="cmn-btn2 copy-btn" type="button">{{basicControl()->base_currency}}</button>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <label>@lang('You will earn :')</label>
                                        <label class="earn ms-2"></label>
                                        <div class="input-group-append">
                                            <label class="ms-2">{{basicControl()->base_currency}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <label>@lang('Sell Charge :')</label>
                                            <label class="charge ms-2"></label>
                                            <div class="input-group-append">
                                                <label class="ms-2">{{basicControl()->base_currency}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="cmn-btn2" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-modal" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="delete-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="delete-modalLabel">@lang('Delete Confirm')</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-light fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to delete this?')</p>
                </div>
                <div class="modal-footer">
                    <form action="" method="post" class="deleteRoute">
                        @csrf
                        @method('delete')
                        <button type="submit" class="cmn-btn">@lang('Yes')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <style>
        .image-upload-wrapper {
            text-align: center;
            border: 2px dashed #ccc;
            padding: 15px;
            position: relative;
            cursor: pointer;
            border-radius: 8px;
            transition: border-color 0.3s ease;
        }
        .image-upload-wrapper:hover {
            border-color: #007bff;
        }
        .upload-btn {
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
        }
        .preview-image {
            max-height: 150px;
            object-fit: contain;
            margin-bottom: 10px;
        }
        .removeFile, .removeFileExist {
            position: absolute;
            top: 27px;
            right: 27px;
        }
        .cmn-btn2 {
            padding: 5px 11px !important;
        }
        .info-icon{
            cursor: pointer;
        }
    </style>
@endpush

@push('script')

    <script>
        "use strict";
        var sellCharge, price, totalCharge, sellerEarn;

        $(document).on('click', '.sellCharge', function () {
            sellCharge = $(this).data('resource');
            price = $('.price').val();
            if (price < 0) {
                $('.earn').text(0);
                $('.charge').text(0);
                return 0;
            }
            totalCharge = sellCharge * price / 100;
            sellerEarn = price - totalCharge;

            $('.modal-price').val(price);
            $('.earn').text(sellerEarn);
            $('.charge').text(totalCharge);

        });
        $(document).on('keyup', '.modal-price', function () {
            this.value = this.value.replace(/[^0-9\.]/g, '');
            price = $(this).val();
            if (price < 0) {
                $('.charge').text(0);
                $('.earn').text(0);
                return 0;
            }
            sellCharge = $('.sellCharge').data('resource');
            totalCharge = sellCharge * price / 100;
            sellerEarn = price - totalCharge;

            $('.charge').text(totalCharge);

            $('.earn').text(sellerEarn);
            $('.price').val(price);

        });
        document.addEventListener('DOMContentLoaded', function () {
            const deleteModal = document.getElementById('delete-modal');
            const deleteForm = deleteModal.querySelector('.deleteRoute');

            document.querySelectorAll('.removeFileExist').forEach(button => {
                button.addEventListener('click', function () {
                    const route = this.getAttribute('data-route');
                    deleteForm.setAttribute('action', route);
                });
            });
        });
        $(".generate").on('click', function () {
            var form = `
                <div class="col-sm-12 col-md-4 image-column">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="image-upload-wrapper position-relative" onclick="triggerFileInput(this)">
                                    <input type="file" name="image[]" class="image-input d-none" accept="image/*" onchange="previewImage(event, this)">
                                    <img id="preview" class="img-fluid rounded preview-image mx-auto d-block" src="{{ asset('assets/global/img/emptyImage.png') }}" alt="@lang('preview image')">
                                    <button type="button" class="cmn-btn2 btn-sm position-absolute upload-btn">
                                            @lang('Choose Image')
                                    </button>
                                </div>
                            </div>
                            <button class="btn btn-danger btn-sm btn-block removeFile" type="button">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>`;
            $('.addedField').append(form);
        });

        $(document).on('click', '.removeFile', function () {
            $(this).closest('.image-column').remove();
        });


        function triggerFileInput(wrapper) {
            const fileInput = wrapper.querySelector('.image-input');
            fileInput.click();
        }

        function previewImage(event, input) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = input.closest('.image-upload-wrapper').querySelector('.preview-image');
                    preview.src = e.target.result;

                    const hiddenInput = input.closest('.image-column').querySelector('input[name="oldImage[]"]');
                    if (hiddenInput) {
                        hiddenInput.name = 'changedImage[]';
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        $(document).on('change', "#category", function () {
            let value = $(this).find('option:selected').val();
            window.location.href = "{{route('user.sellCreate')}}/?category=" + value
        });

    </script>
@endpush
