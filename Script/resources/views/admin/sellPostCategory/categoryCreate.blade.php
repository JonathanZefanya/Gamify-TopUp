@extends('admin.layouts.app')
@section('page_title', __('Create Category'))
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
                                                           href="javascript:void(0)">@lang('Category')</a></li>
                            <li class="breadcrumb-item active"
                                aria-current="page">@lang('Create Category')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Create Category')</h1>
                </div>
            </div>
        </div>

        <div>
            <ul class="nav nav-segment mb-2" role="tablist">
                @foreach ($languages as $key => $language)
                    <li class="nav-item">
                        <a class="nav-link @error('errActive') @if($language->id == $message) active @endif @else @if($loop->first) active @endif  @enderror"
                           id="nav-one-eg1-tab"
                           href="#nav-one-{{ $key }}"
                           data-bs-toggle="pill"
                           data-bs-target="#nav-one-{{ $key }}"
                           role="tab" aria-controls="nav-one-{{ $key }}"
                           aria-selected="@error('errActive') @if($language->id == $message) true @else false @endif @else @if($loop->first) true @else false @endif  @enderror">
                            @lang($language->name)
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="tab-content">
            @foreach($languages as $key => $language)
                <div
                    class="tab-pane fade @error('errActive') @if($language->id == $message) show active @endif @else @if($loop->first) show active @endif  @enderror"
                    id="nav-one-{{ $key }}"
                    role="tabpanel" aria-labelledby="nav-one-{{ $key }}-tab">
                    <div class="row justify-content-lg-center">
                        <form method="post" action="{{ route('admin.sellPostCategoryStore', $language->id) }}"
                              class="mt-4"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"
                                               for="Name">@lang('Category Name')</label>
                                        <input type="text" class="form-control" name="name[{{ $language->id }}]"
                                               value="{{ old('name' . '.' . $language->id) }}"
                                               aria-label="@lang('name')"
                                               autocomplete="off">
                                        @error('name' . '.' . $language->id)
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    @if ($loop->index == 0)
                                        <div class="mb-3">
                                            <label class="form-label"
                                                   for="SellCharge">@lang('Sell Charge')</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="sell_charge"
                                                       value="{{old('sell_charge')}}"
                                                       id="SellCharge"
                                                       aria-label="@lang('SellCharge')"
                                                       autocomplete="off">
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                            @error('sell_charge')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif
                                </div>
                                @if ($loop->index == 0)
                                    <div class="col-md-6">
                                        <label class="row form-check form-switch my-4"
                                               for="status">
                                            <span class="col-8 col-sm-9 ms-0">
                                              <span class="d-block text-dark">@lang("Status")</span>
                                              <span
                                                  class="d-block fs-5">@lang("Display the category on the front page.")</span>
                                            </span>
                                            <span class="col-4 col-sm-3 text-end">
                                                    <input type="hidden" value="0" name="status"/>
                                                    <input
                                                        class="form-check-input @error('status') is-invalid @enderror"
                                                        type="checkbox" name="status"
                                                        id="status" value="1"
                                                        {{old('status') == '1' ? 'checked':''}}>
                                                </span>
                                            @error('status')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </label>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">@lang('Choose Image')</label>
                                                <div class="mb-3 mb-md-0">
                                                    <label class="form-check form-check-dashed" for="logoUploader">
                                                        <img id="otherImg"
                                                             class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                             src="{{ getFile('local','abc', true) }}"
                                                             alt="@lang("File Storage Logo")"
                                                             data-hs-theme-appearance="default">

                                                        <img id="otherImg"
                                                             class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                                                             src="{{ getFile('local','abc', true) }}"
                                                             alt="@lang("File Storage Logo")"
                                                             data-hs-theme-appearance="dark">
                                                        <span class="d-block">@lang("Browse your file here")</span>
                                                        <input type="file" class="js-file-attach form-check-input"
                                                               name="image" id="logoUploader"
                                                               data-hs-file-attach-options='{
                                              "textTarget": "#otherImg",
                                              "mode": "image",
                                              "targetAttr": "src",
                                              "allowTypes": [".png", ".jpeg", ".jpg",".webp"]
                                           }'>
                                                    </label>
                                                    @error("image")
                                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <span class="text-primary">@lang('Note: Image size should be ') {{config('filelocation.sellPostCategory.size')}} @lang('for better resolution')</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @if ($loop->index == 0)
                                <div class="row">
                                    <div class="card-body">
                                        <span class="divider-end">
                                            <a href="javascript:void(0)" class="btn btn-dark btn-sm btn-rounded"
                                               id="generate"><i class="fa fa-plus-circle"></i>
                                                {{ trans('Add Field') }}</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <h4>@lang('User Credential Form')</h4>
                                    <div class="addedField mt-1">

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="card-body">
                                        <span class="divider-end">
                                            <a href="javascript:void(0)" class="btn btn-dark btn-sm btn-rounded"
                                               id="generate-specification"><i class="fa fa-plus-circle"></i>
                                                {{ trans('Add Field') }}</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <h4>@lang('User Specification Form')</h4>
                                    <div class="addedSpecification mt-1">

                                    </div>
                                </div>
                            @endif
                            <div class="d-flex justify-content-start">
                                <button type="submit" class="btn btn-primary">@lang('Create')</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

@push('css-lib')
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/hs-file-attach.min.js') }}"></script>

@endpush

@push('script')
    <script>
        'use strict';
        $(document).ready(function () {

            $("#generate").on('click', function () {
                var form = `<div class="col-md-12 mb-2">
                <div class="form-group">
                    <div class="input-group">
                        <input name="field_name[]" class="form-control " type="text" value="" required placeholder="{{ trans('Field Name') }}">

                        <select name="type[]"  class="form-control d-none">
                            <option value="text">{{ trans('Input Text') }}</option>
                            <option value="textarea">{{ trans('Textarea') }}</option>
                            <option value="file">{{ trans('File upload') }}</option>
                        </select>

                        <select name="validation[]"  class="form-control  ">
                            <option value="required">{{ trans('Required') }}</option>
                            <option value="nullable">{{ trans('Optional') }}</option>
                        </select>

                        <span class="input-group-btn">
                            <button class="btn btn-white delete_desc" type="button">
                                <i class="bi-trash"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div> `;

                $('.addedField').append(form)
            });


            $(document).on('click', '.delete_desc', function () {
                $(this).closest('.input-group').parent().remove();
            });

            $("#generate-specification").on('click', function () {
                var form = `<div class="col-md-12 mb-2">
                <div class="form-group">
                    <div class="input-group">
                        <input name="field_specification[]" class="form-control " type="text" value="" required placeholder="{{ trans('Field Name') }}">

                        <select name="type[]"  class="form-control d-none">
                            <option value="text">{{ trans('Input Text') }}</option>
                            <option value="textarea">{{ trans('Textarea') }}</option>
                            <option value="file">{{ trans('File upload') }}</option>
                        </select>

                        <select name="validation_specification[]"  class="form-control">
                            <option value="required">{{ trans('Required') }}</option>
                            <option value="nullable">{{ trans('Optional') }}</option>
                        </select>

                        <span class="input-group-btn">
                            <button class="btn btn-white delete_desc" type="button">
                                <i class="bi-trash"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div> `;

                $('.addedSpecification').append(form)
            });


            $(document).on('click', '.delete_desc', function () {
                $(this).closest('.input-group').parent().remove();
            });

            new HSFileAttach('.js-file-attach')

        });
    </script>
@endpush
