@extends('admin.layouts.app')
@section('page_title',__('Update Direct Top Up'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                                           href="javascript:void(0);">@lang('Update Direct Top Up')</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@yield('page_title')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@yield('page_title')</h1>
                </div>
            </div>
        </div>

        <div class="content container-fluid">
            <div class="row justify-content-lg-center">
                <div class="col-lg-12">
                    <div class="d-grid gap-3 gap-lg-5">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h4 class="card-title mt-2">@lang("Update Direct Top Up")</h4>
                            </div>
                            <div class="card-body mt-2">
                                <form action="{{route('admin.topUpEdit',$topUp->id)}}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"
                                                       for="Category">@lang('Category')</label>
                                                <div class="tom-select-custom">
                                                    <select
                                                        class="js-select form-select"
                                                        id="dateFormatLabel" name="category_id">
                                                        @foreach($categories as $value)
                                                            <option
                                                                value="{{ $value->id }}" {{ ($topUp->category_id == $value->id ? ' selected' : '') }}>{{ $value->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('category_id')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"
                                                       for="Name">@lang('Name')</label>
                                                <input type="text" class="form-control" name="name"
                                                       value="{{$topUp->name}}"
                                                       id="Name"
                                                       placeholder="@lang('eg. Mobile Legends Diamonds')"
                                                       aria-label="@lang('name')"
                                                       autocomplete="off">
                                                @error('name')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"
                                                       for="Symbol">@lang('Region')</label>
                                                <input type="text" class="form-control" name="region"
                                                       value="{{$topUp->region}}"
                                                       id="Region"
                                                       placeholder="@lang('eg. Global,Asia Pacific')"
                                                       aria-label="@lang('region')"
                                                       autocomplete="off">
                                                @error('region')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"
                                                       for="Code">@lang('Note (optional)')</label>
                                                <input type="text" class="form-control" name="note"
                                                       value="{{$topUp->note}}"
                                                       id="Note"
                                                       placeholder="@lang('Enter Your Top Up Note')"
                                                       aria-label="@lang('note')"
                                                       autocomplete="off">
                                                @error('note')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="row form-check form-switch my-4"
                                                   for="instant_delivery">
                                            <span class="col-8 col-sm-9 ms-0">
                                              <span class="d-block text-dark">@lang("Instant Delivery")</span>
                                              <span
                                                  class="d-block fs-5">@lang("Enable Instant Delivery for Top Up")</span>
                                            </span>
                                                <span class="col-4 col-sm-3 text-end">
                                                    <input type="hidden" value="0" name="instant_delivery"/>
                                                    <input
                                                        class="form-check-input @error('instant_delivery') is-invalid @enderror"
                                                        type="checkbox" name="instant_delivery"
                                                        id="status" value="1"
                                                        {{$topUp->instant_delivery == '1' ? 'checked':''}}>
                                                </span>
                                                @error('instant_delivery')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </label>

                                            <label class="row form-check form-switch my-4"
                                                   for="status">
                                            <span class="col-8 col-sm-9 ms-0">
                                              <span class="d-block text-dark">@lang("Status")</span>
                                              <span
                                                  class="d-block fs-5">@lang("Display the Direct Top Up on the front page.")</span>
                                            </span>
                                                <span class="col-4 col-sm-3 text-end">
                                                    <input type="hidden" value="0" name="status"/>
                                                    <input
                                                        class="form-check-input @error('status') is-invalid @enderror"
                                                        type="checkbox" name="status"
                                                        id="status" value="1"
                                                        {{$topUp->status == '1' ? 'checked':''}}>
                                                </span>
                                                @error('status')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </label>

                                            <div class="row">
                                                @include('admin.topUp.partials.edit-image')
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-4 showField">
                                        @include('admin.topUp.partials.edit-dynamic-field')
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label"
                                                       for="Code">@lang('Description (optional)')</label>
                                                <textarea class="form-control" id="description"
                                                          name="description">{{$topUp->description}}</textarea>
                                                @error('description')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label"
                                                       for="Code">@lang('Guide (optional)')</label>
                                                <textarea class="form-control" id="guide"
                                                          name="guide">{{$topUp->guide}}</textarea>
                                                @error('guide')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-start">
                                        <button type="submit" class="btn btn-primary">@lang('Save Change')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset("assets/admin/js/hs-file-attach.min.js") }}"></script>
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.2.0/tinymce.min.js"></script>
@endpush

@push('script')
    <script>
        'use strict';

        tinymce.init({
            selector: 'textarea#description',
            menubar: true,
            height:350,
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss markdown',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media',
        });

        tinymce.init({
            selector: 'textarea#guide',
            menubar: true,
            height:350,
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss markdown',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media',
        });

        $(document).on('change', '.typeClass', function () {
            if ($(this).val() === 'select') {
                $(this).closest('.row').next('.option-generator').removeClass('d-none');
            } else {
                $(this).closest('.row').next('.option-generator').addClass('d-none');
            }
        });

        $(document).on('click', '.addOptionData', function () {
            let copyFieldLength = $(this).closest('.card-body').find('.copyFieldLength').val();
            let optionDataHtml = `<div class="row align-items-center mb-2">
                    <div class="col-md-5">
                        <label class="form-label">@lang('Option Name')</label>
                        <input type="text" name="field_option_name[${copyFieldLength}][]" placeholder="@lang('Enter Option Name')"
                               class="form-control optionNameClass">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">@lang('Option Value')</label>
                        <input type="text" name="field_option_value[${copyFieldLength}][]" placeholder="@lang('Enter Option Value')"
                               class="form-control optionValueClass">
                    </div>
                    <div class="col-md-2 mt-4">
                        <button type="button" class="btn btn-sm btn-danger removeOptionData"><i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>`;
            let optionDataWrapper = $(this).closest('.option-generator');
            $(optionDataWrapper).append(optionDataHtml);
        });

        $(document).on("click", '.removeOptionData', function () {
            $(this).closest('.row').remove();
        });

        $(document).on('click', '.copyFormData', function () {
            let addFieldForm = $(this).closest('.copyField').clone();
            addFieldForm.find('.removeContentDiv').removeClass('d-none');
            if (!addFieldForm.find('.option-generator').hasClass('d-none')) {
                addFieldForm.find('.typeClass').val('select').trigger('change');
            }

            $('.showField').append(addFieldForm);
            let previousLength = $(this).closest('.card-body').find('.copyFieldLength').val();
            let newLength = parseInt(previousLength) + 1;
            $(this).closest('.card-body').find('.copyFieldLength').val(newLength);


            $(addFieldForm).find('.nameClass').attr('name', 'field_value[' + newLength + '][]');
            $(addFieldForm).find('.placeholderClass').attr('name', 'field_placeholder[' + newLength + '][]');
            $(addFieldForm).find('.noteClass').attr('name', 'field_note[' + newLength + '][]');
            $(addFieldForm).find('.typeClass').attr('name', 'field_type[' + newLength + '][]');
            $(addFieldForm).find('.optionNameClass').attr('name', 'field_option_name[' + newLength + '][]');
            $(addFieldForm).find('.optionValueClass').attr('name', 'field_option_value[' + newLength + '][]');
        });

        $(document).on('click', '.removeContentDiv', function () {
            $(this).closest('.copyField').remove();
        });


        $(document).ready(function () {
            new HSFileAttach('.js-file-attach')
            HSCore.components.HSTomSelect.init('.js-select', {
                maxOptions: 5000
            })
        });

    </script>
@endpush
