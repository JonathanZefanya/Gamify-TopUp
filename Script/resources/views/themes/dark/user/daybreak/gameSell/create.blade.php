@extends(template().'layouts.user')
@section('title',trans('Sell Post Create'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="pagetitle mt-20">
                <h4 class="mb-1">@lang('New Sell Post')</h4>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('New Sell Post')</li>
                    </ol>
                </nav>
            </div>
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header pb-0 border-0">
                            <h4>@lang('Create New')</h4>
                        </div>
                        <form action="{{route('user.sellStore')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">@lang('Category')</label>
                                        <select
                                            class="form-select cmn-select2" name="category"
                                            id="category"
                                            aria-label="@lang('Category Select')">
                                            <option selected disabled>@lang('Select Category')</option>
                                            @foreach($categoryList as $item)
                                                <option value="{{$item->id}}" @if(@$category->id==$item->id) selected @endif
                                                >@lang(@optional($item->details)->name)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="price" class="form-label">@lang('Title')</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="title"
                                            value="{{old('title')}}"
                                            id="exampleFormControlInput1"
                                            placeholder="Title"
                                        />
                                        @if($errors->has('title'))
                                            <div
                                                class="error text-danger">@lang($errors->first('title')) </div>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <label for="price" class="form-label">@lang('Price')</label>
                                        @if(isset($category) && !empty($category->sell_charge))
                                            <span class="info sellCharge cursor-pointer" data-resource="{{$category->sell_charge}}"
                                                  data-bs-toggle="modal" data-bs-target="#sellCharge"
                                                  title="@lang("How much of this will i earn")">
                                                    <img class="info-icon"
                                                         src="{{ asset(template(true)) . '/img/info.png' }}" alt="..."/>
                                                </span>
                                        @endif
                                        <div class="input-group append">
                                            <input
                                                type="number"
                                                class="form-control price"
                                                name="price"
                                                value="{{old('price')}}"
                                                id="exampleFormControlInput1"
                                                placeholder="Price"
                                            />

                                            <button class="cmn-btn2"
                                                    type="button">{{basicControl()->base_currency}}</button>

                                        </div>

                                        @if($errors->has('price'))
                                            <div
                                                class="error text-danger">@lang($errors->first('price'))
                                            </div>
                                        @endif
                                    </div>
                                    @if(isset($category) && !empty($category->form_field))
                                        <div class="col-md-12">
                                            <div class="dark-bg p-3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="header-box-title">

                                                            <h6>@lang('Please Enter '.$category->details->name.' credentials')
                                                                <span class="info" data-bs-toggle="tooltip"
                                                                      title="@lang("This credentials need for admin approval")">
                                                                        <img class="info-icon"
                                                                             src="{{ asset(template(true)) . '/img/info.png' }}"
                                                                             alt="..."/>
                                                                    </span>
                                                            </h6>
                                                        </div>
                                                    </div>

                                                    @forelse($category->form_field as $k => $v)
                                                        <div class="col-md-6">
                                                            @if ($v->type == 'text')
                                                                <div class="form-group">
                                                                    <label
                                                                        for="exampleFormControlInput1"
                                                                        class="form-label"
                                                                    >{{ trans($v->field_level) }}

                                                                        @if ($v->validation == 'required')
                                                                            <span class="text-danger">*</span>
                                                                        @endif
                                                                    </label>
                                                                    <input name="{{ $k }}" type="text" class="form-control"
                                                                           value="{{old($k)}}"
                                                                           placeholder="{{ trans($v->field_level) }}"
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
                                                                    >{{ trans($v->field_level) }}

                                                                        @if ($v->validation == 'required')
                                                                            <span class="text-danger">*</span>
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
                                                                    >{{ trans($v->field_level) }}

                                                                        @if ($v->validation == 'required')
                                                                            <span class="text-danger">*</span>
                                                                        @endif
                                                                    </label>

                                                                    <input name="{{ $k }}" type="file" class="form-control"
                                                                           placeholder="{{ trans($v->field_level) }}"
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
                                    @if(isset($category) && !empty($category->post_specification_form))
                                        <div class="col-md-12">
                                            <div class="dark-bg p-3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="header-box-title">
                                                            <h6>@lang('Please Enter '.$category->details->name.' Specification')
                                                                <span class="info" data-bs-toggle="tooltip"
                                                                      title="@lang("This Specification need for admin approval")">
                                                                        <img class="info-icon"
                                                                             src="{{ asset(template(true)) . '/img/info.png' }}"
                                                                             alt="..."/>
                                                                    </span>
                                                            </h6>
                                                        </div>
                                                    </div>

                                                    @forelse($category->post_specification_form as $k => $v)
                                                        <div class="col-md-6">
                                                            @if ($v->type == 'text')
                                                                <div class="form-group">
                                                                    <label
                                                                        for="exampleFormControlInput1"
                                                                        class="form-label"
                                                                    >{{ trans($v->field_level) }}

                                                                        @if ($v->validation == 'required')
                                                                            <span class="text-danger">*</span>
                                                                        @endif
                                                                    </label>
                                                                    <input name="{{ $k }}" type="text" class="form-control"
                                                                           value="{{old($k)}}"
                                                                           placeholder="{{ trans($v->field_level) }}"
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
                                                                    >{{ trans($v->field_level) }}

                                                                        @if ($v->validation == 'required')
                                                                            <span class="text-danger">*</span>
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
                                                                    >{{ trans($v->field_level) }}

                                                                        @if ($v->validation == 'required')
                                                                            <span class="text-danger">*</span>
                                                                        @endif
                                                                    </label>

                                                                    <input name="{{ $k }}" type="file" class="form-control"
                                                                           placeholder="{{ trans($v->field_level) }}"
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
                                            placeholder="Description"
                                        >{{old('details')}}</textarea>
                                        @if($errors->has('details'))
                                            <div class="error text-danger">@lang($errors->first('details')) </div>
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
                                            placeholder="Comment"
                                        >{{old('comments')}}</textarea>
                                        @if($errors->has('comments'))
                                            <div
                                                class="error text-danger">@lang($errors->first('comments')) </div>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <a href="javascript:void(0)" class="btn btn-success float-left mt-3 generate">
                                                <i class="fa fa-image"></i> @lang('Add Image')
                                            </a>
                                        </div>
                                        @if($errors->has('image'))
                                            <div class="error text-danger">@lang($errors->first('image'))</div>
                                        @endif
                                    </div>
                                    <div class="row addedField mt-3"></div>

                                    <button type="submit" class="cmn-btn mt-30">@lang('Create')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sellCharge" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content ">
                <div class="modal-header modal-colored-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('How Much You Earn')</h4>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-hidden="true"><i class="fa-light fa-xmark"></i></button>
                </div>

                <div class="modal-body">
                    <div class="withdraw-detail">

                        <div class="form-group mb-2">
                            <label>@lang('Price')</label>
                            <div class="input-group">
                                <input type="text" class="form-control modal-price" value="">
                                <div class="input-group-append">
                                    <button class="cmn-btn2 copy-btn"
                                            type="button">{{basicControl()->base_currency}}</button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <div class="input-group">
                                        <label>@lang('You will earn')</label>
                                        <label class="earn ms-2"></label>
                                        <div class="input-group-append">
                                            <label class="ms-2">{{basicControl()->base_currency}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">

                                    <div class="input-group">
                                        <label>@lang('Sell Charge')</label>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')
                    </button>
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
        .removeFile {
            position: absolute;
            top: 27px;
            right: 27px;
        }
        .cmn-btn2 {
            padding: 5px 11px !important;
        }
        .cmn-btn2.copy-btn{
            height: 45px;
            border-radius: 0 5px 5px 0;
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
                $('.earn').val(0);
                $('.charge').val(0);
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


        $('#image').change(function () {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#image_preview_container').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });


        $(".generate").on('click', function () {
            var form = `
        <div class="col-sm-12 col-md-4 image-column">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="form-group">
                        <div class="image-upload-wrapper position-relative" onclick="triggerFileInput(this)">
                            <input type="file" name="image[]" class="image-input d-none" accept="image/*" onchange="previewImage(event, this)">
                            <img id="preview" class="img-fluid rounded preview-image mx-auto d-block mb-2" src="{{ asset('assets/global/img/emptyImage.png') }}" alt="@lang('preview image')">
                            <button type="button" class="cmn-btn2 btn-sm position-absolute upload-btn mt-3">
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

        function triggerFileInput(wrapper) {
            const input = wrapper.querySelector('.image-input');
            input.click();
        }

        function previewImage(event, input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const wrapper = input.closest('.image-upload-wrapper');
                    const previewImage = wrapper.querySelector('.preview-image');
                    const uploadButton = wrapper.querySelector('.upload-btn');
                    previewImage.src = e.target.result;
                    uploadButton.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        }

        $(document).on('click', '.removeFile', function () {
            $(this).closest('.image-column').remove();
        });

        $(document).on('change', "#category", function () {
            let value = $(this).find('option:selected').val();
            window.location.href = "{{route('user.sellCreate')}}/?category=" + value
        });

    </script>
@endpush
