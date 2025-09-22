@extends('admin.layouts.app')
@section('page_title', __('Sell Post'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0)">@lang('Sell Post')</a></li>
                            <li class="breadcrumb-item active"
                                aria-current="page">@lang(optional($sellPost->category)->details->name)</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang(optional($sellPost->category)->details->name)</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card card-lg mb-lg-5">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-header-title">`@lang(optional($sellPost->category)->details->name)
                                ` @lang('Post')</h4>
                            <div>
                                {!! $sellPost->statusMessage !!}
                                <a class="btn btn-icon btn-sm btn-white" data-bs-toggle="modal" data-bs-target="#action"
                                   href="#">
                                    <i class="bi-list-ul me-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('admin.sell.update',$sellPost->id)}}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <input type="hidden" name="category" value="{{$sellPost->category_id}}">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 mb-3">
                                    <label for="title" class="form-label"> @lang('Title') </label>
                                    <input type="text" name="title"
                                           class="form-control  @error('title') is-invalid @enderror"
                                           value="{{$sellPost->title}}">
                                    <div class="invalid-feedback">
                                        @error('title')
                                        @lang($message)
                                        @enderror
                                    </div>
                                    <div class="valid-feedback"></div>
                                </div>

                                <div class="col-sm-12 col-md-12 mb-3 header-box-title">
                                    <label for="title" class="form-label"> @lang('Price') </label>
                                    <span class="info sellCharge" title="@lang("How much of this will i earn ?")"
                                          data-resource="{{$sellPost->sell_charge}}" data-bs-toggle="modal"
                                          data-bs-target="#sellCharge" style="cursor: pointer">
                                        <img class="info-icon" src="{{ asset(template(true)) . '/img/info.png' }}"
                                             alt="..."/>
                                    </span>
                                    <div class="input-group">
                                        <input type="text" name="price"
                                               class="form-control price"
                                               value="{{$sellPost->price}}">
                                        <div class="input-group-prepend">
                                            <button type="button" class="form-control"
                                                    value="">{{basicControl()->base_currency}}</button>
                                        </div>
                                    </div>

                                    <div class="invalid-feedback">
                                        @error('price')
                                        @lang($message)
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 my-3">
                                    <div class="form-group ">
                                        <label for="details" class="form-label"> @lang('Details') </label>
                                        <textarea
                                            class="form-control summernote @error('details') is-invalid @enderror"
                                            name="details" id="summernote" rows="15" value="">{{$sellPost->details}}
                                        </textarea>

                                        <div class="invalid-feedback">
                                            @error('details')
                                            @lang($message)
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 my-3">
                                    <div class="form-group ">
                                        <label for="comments" class="form-label"> @lang('Comments') </label>
                                        <textarea
                                            class="form-control summernote @error('comments') is-invalid @enderror"
                                            name="comments" id="summernote" rows="10" value="">{{$sellPost->comments}}
                                        </textarea>

                                        <div class="invalid-feedback">
                                            @error('comments')
                                            @lang($message)
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                @if(isset($sellPost) && !empty($sellPost->credential))
                                    <div class="col-md-12 custom-back mb-4">
                                        <div class="dark-bg p-3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="header-box-title">
                                                        <h5>@lang($sellPost->category->details->name.' Credential')
                                                        </h5>
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
                                                                        <span class="text-danger">*</span>
                                                                    @endif
                                                                </label>
                                                                <input name="{{ $k }}" type="text"
                                                                       class="form-control"
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
                                                                >{{ trans($v->field_name) }}

                                                                    @if ($v->validation == 'required')
                                                                        <span class="text-danger">*</span>
                                                                    @endif
                                                                </label>

                                                                <input name="{{ $k }}" type="file"
                                                                       class="form-control"
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
                                    <div class="col-md-12 custom-back">
                                        <div class="dark-bg p-3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="header-box-title">
                                                        <h5>@lang($sellPost->category->details->name.' Specification')
                                                        </h5>
                                                    </div>
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
                                                                        <span class="text-danger">*</span>
                                                                    @endif
                                                                </label>
                                                                <input name="{{ $k }}" type="text"
                                                                       class="form-control"
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
                                                                >{{ trans($v->field_name) }}

                                                                    @if ($v->validation == 'required')
                                                                        <span class="text-danger">*</span>
                                                                    @endif
                                                                </label>

                                                                <input name="{{ $k }}" type="file"
                                                                       class="form-control"
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

                                <div class="col-lg-12 col-md-6 mt-3 mb-4">
                                    <span class="divider-end">
                                            <a href="javascript:void(0)"
                                               class="btn btn-dark btn-sm btn-rounded generate"><i
                                                    class="fa fa-image"></i>
                                                @lang('Add More')</a>
                                        </span>
                                    <div class="invalid-feedback">
                                        @error('image')
                                        @lang($message)
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row addedField mt-3">
                                        @if(isset($sellPost->image))
                                            @foreach($sellPost->image as $index => $image)
                                                <input type="hidden" name="oldImage[]" value="{{ $image }}">
                                                <input type="hidden" name="changedImage[]" value="" id="changedImage{{$index}}">

                                                <div class="col-md-4 mb-3">
                                                    <div class="mb-3 mb-md-0">
                                                        <label class="form-check form-check-dashed position-relative" for="logoUploader{{$index}}">
                                                            <img id="otherImg{{$index}}"
                                                                 class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                                 src="{{ getFile($sellPost->image_driver, $image, true) }}"
                                                                 alt="@lang('File Storage Logo')"
                                                                 data-hs-theme-appearance="default">

                                                            <img id="otherImg{{$index}}"
                                                                 class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                                 src="{{ getFile($sellPost->image_driver, $image, true) }}"
                                                                 alt="@lang('File Storage Logo')"
                                                                 data-hs-theme-appearance="dark">
                                                            <span class="d-block">@lang('Browse your file here')</span>

                                                            @php
                                                                $newString = \Illuminate\Support\Str::replaceFirst('sellingPost/', '', $image);
                                                            @endphp
                                                            <button class="btn btn-white delete_btn removeFile z9"
                                                                    data-route="{{ route('admin.sell.image.delete', [$sellPost->id, $newString]) }}"
                                                                    data-bs-toggle="modal" data-bs-target="#delete"
                                                                    type="button" title="Delete Image">
                                                                <i class="bi-trash"></i>
                                                            </button>
                                                            <input type="file" class="js-file-attach form-check-input"
                                                                   name="image[]" id="logoUploader{{$index}}"
                                                                   data-hs-file-attach-options='{
                                                                      "textTarget": "#otherImg{{$index}}",
                                                                      "mode": "image",
                                                                      "targetAttr": "src",
                                                                      "allowTypes": [".png", ".jpeg", ".jpg", ".webp"]
                                                                   }'>
                                                        </label>

                                                        @error("image")
                                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <span class="text-primary">
                                                        @lang('Note: Image size should be ') {{ config('filelocation.sellingPost.thumb') }} @lang('for better resolution')
                                                    </span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                    class="btn waves-effect waves-light btn-rounded btn-primary btn-block mt-3">@lang('Save Changes')
                            </button>
                        </form>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fa fa-history"></i> @lang('Activity Log')</h5>
                        <ul class="step mt-4">
                            @forelse($activity as $k => $row)

                                <li class="step-item">
                                    <div class="step-content-wrapper">
                                        <div class="step-avatar">
                                            <img class="step-avatar-img"
                                                 src="{{getFile(optional($row->activityable)->image_driver,optional($row->activityable)->image)}}"
                                                 alt="{{optional($row->activityable)->username}}">
                                        </div>

                                        <div class="step-content">
                                            <h5 class="mb-1">@lang($row->title) ({{diffForHumans($row->created_at)}}
                                                )</h5>

                                            <p class="fs-5 mb-1">@lang($row->description)
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <div class="text-center ms-6 p-4">
                                    <img class="dataTables-image mb-3"
                                         src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description"
                                         data-hs-theme-appearance="default">
                                    <img class="dataTables-image mb-3"
                                         src="{{ asset('assets/admin/img/oc-error-light.svg') }}"
                                         alt="Image Description" data-hs-theme-appearance="dark">
                                    <p class="mb-0">@lang('No data to show')</p>
                                </div>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sell Charge -->
    <div class="modal fade" id="sellCharge" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-light fa-money-check"></i> @lang('How Much You Earn')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="price" class="font-weight-bold"> @lang('Price') </label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ basicControl()->currency_symbol }}</span>
                            </div>
                            <input type="text" name="" class="form-control edit-price modal-price"
                                   value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <label>@lang('Seller Earn')</label>
                                    <label class="earn ms-2">0</label>
                                    <div class="input-group-prepend">
                                        <label class="ms-2">{{basicControl()->base_currency}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <label>@lang('You will earn')</label>
                                    <label class="charge ms-2"></label>
                                    <div class="input-group-prepend">
                                        <label class="ms-2">{{basicControl()->base_currency}}</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Action Modal -->
    <div class="modal fade" id="action" data-bs-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> @lang('Action')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.sellPostAction') }}" method="post">
                    @csrf
                    <input type="hidden" name="sell_post_id" value="{{$sellPost->id}}">
                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <label class="font-weight-bold mb-2">@lang('Status') </label>
                            <select class="form-control" name="status" aria-label=".form-select-lg example" required>

                                <option value="" selected disabled>@lang('Select Status')</option>
                                <option value="1">@lang('Approve')
                                </option>
                                <option value="3">@lang('Hold')
                                </option>
                                <option value="4">@lang('Soft Rejected')
                                </option>
                                <option value="5">@lang('Hard Rejected')
                                </option>

                            </select>
                        </div>


                        <div class="form-group">
                            <label for="comments" class="font-weight-bold mb-2"> @lang('Comment') </label>
                            <textarea name="comments" rows="4" class="form-control" value="" required></textarea>

                            @error('comments')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-soft-primary"><span>@lang('Submit')</span></button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('admin.delete-modal')
@endsection


@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/summernote-bs5.min.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/summernote-bs5.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/hs-file-attach.min.js') }}"></script>

@endpush

@push('script')
    <script>
        "use strict";

        document.querySelectorAll('.js-file-attach').forEach(function(input, index) {
            input.addEventListener('change', function() {
                var hiddenInput = document.getElementById('changedImage' + index);
                hiddenInput.value = 'changed';
            });
        });
        $(document).on('click', '.delete_btn', function () {
            let route = $(this).data('route');
            $('#deleteModalBody').text('Are you sure you want to proceed with the deletion of this image?');
            $('.deleteModalRoute').attr('action', route);
        });

        new HSFileAttach('.js-file-attach')
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

        $(document).ready(function (e) {

            $(document).ready(function () {
                $('.notiflix-confirm').on('click', function () {
                    var route = $(this).data('route');
                    $('.deleteRoute').attr('action', route)
                })
            });
            $('#image').change(function () {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#image_preview_container').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });


            $('.summernote').summernote({
                height: 250,
                callbacks: {
                    onBlurCodeview: function () {
                        let codeviewHtml = $(this).siblings('div.note-editor').find('.note-codable')
                            .val();
                        $(this).val(codeviewHtml);
                    }
                }
            });

            var i = 100;
            $(".generate").on('click', function () {

                var form = `<div class="col-md-4 mb-3 image-column">
                                                    <div class="mb-3 mb-md-0">
                                                        <label class="form-check form-check-dashed position-relative"
                                                               for="logoUploader${i}">
                                                            <img id="otherImg${i}"
                                                                 class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                                 src="{{ getFile('dummy','dummy', true) }}"
                                                                 alt="@lang("File Storage Logo")"
                                                                 data-hs-theme-appearance="default">

                                                            <img id="otherImg${i}"
                                                                 class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                                 src="{{ getFile('dummy','dummy', true) }}"
                                                                 alt="@lang("File Storage Logo")"
                                                                 data-hs-theme-appearance="dark">
                                                            <span class="d-block">@lang("Browse your file here")</span>
                                                            <button type="button"
                                                                class="btn btn-white delete_desc notiflix-confirm removeFile z9 ">
                                                                <i class="bi-trash"></i>
                                                            </button>
                                                            <input type="file" class="js-file-attach form-check-input"
                                                                   name="image[]" id="logoUploader${i}"
                                                                   data-hs-file-attach-options='{
                                              "textTarget": "#otherImg${i}",
                                              "mode": "image",
                                              "targetAttr": "src",
                                              "allowTypes": [".png", ".jpeg", ".jpg",".webp"]
                                           }'>
                                                        </label>
                                                        @error("image")
                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                        @enderror
                </div>
                <span class="text-primary">@lang('Note: Image size should be ') {{config('filelocation.sellingPost.thumb')}} @lang('for better resolution')</span>
                                                </div>`;

                $('.addedField').append(form)
                i++;
                new HSFileAttach('.js-file-attach')
            });


            $(document).on('click', '.delete_desc', function () {
                $(this).parents('.image-column').remove();
            });


            $(document).on('change', '.image-preview', function () {
                let currentIndex = $('.image-preview').index(this);
                $(this).attr('name', `image[${currentIndex}]`);
                let reader = new FileReader();
                let _this = this;
                reader.onload = (e) => {
                    $(_this).siblings('.preview-image').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

        });


    </script>

    @if ($errors->any())
        @php
            $collection = collect($errors->all());
            $errors = $collection->unique();
        @endphp
        <script>
            "use strict";
            @foreach ($errors as $error)
            Notiflix.Notify.failure("{{ trans($error) }}");
            @endforeach
        </script>
    @endif
@endpush
