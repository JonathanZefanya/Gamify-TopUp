@php $j=0; @endphp
@foreach($topUp->order_information as $key => $info)
    <div class="col-md-6 mb-2 copyField">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-primary copyFormData">@lang('Copy')</button>
                    <h3 class="card-header-title">@lang('Order Information')</h3>
                    <button type="button"
                            class="btn btn-sm btn-danger removeContentDiv {{$j ? '':'d-none'}}">@lang('Remove')</button>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-2">
                    <input type="hidden" class="copyFieldLength" value="{{$key}}">
                    <div class="col-md-6">
                        <label class="form-label">@lang('Field Name')</label>
                        <input type="text" name="field_value[{{$key}}][]" class="form-control nameClass"
                               value="{{$info->field_value}}"
                               required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">@lang('Placeholder (optional)')</label>
                        <input type="text" name="field_placeholder[{{$key}}][]" value="{{$info->field_placeholder}}"
                               class="form-control placeholderClass">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label">@lang('Note (optional)')</label>
                        <input type="text" name="field_note[{{$key}}][]" value="{{$info->field_note}}"
                               class="form-control noteClass">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">@lang('Input Type')</label>
                        <select class="form-select typeClass" name="field_type[{{$key}}][]" required>
                            <option value="text" {{$info->field_type == 'text' ? 'selected':''}}>@lang('Text')</option>
                            <option
                                value="select" {{$info->field_type == 'select' ? 'selected':''}}>@lang('Select')</option>
                        </select>
                    </div>
                </div>
                @if(isset($info->option) && $info->field_type == 'select')
                    @php $i = 0; @endphp
                    @foreach($info->option as $optionKey => $option)
                        <div class="option-generator">
                            <div class="row align-items-center mb-2">
                                <div class="col-md-5">
                                    <label class="form-label">@lang('Option Name')</label>
                                    <input type="text" name="field_option_name[{{$key}}][]"
                                           placeholder="@lang('Enter Option Name')"
                                           value="{{$optionKey}}"
                                           class="form-control optionNameClass">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">@lang('Option Value')</label>
                                    <input type="text" name="field_option_value[{{$key}}][]"
                                           placeholder="@lang('Enter Option Value')"
                                           value="{{$option}}"
                                           class="form-control optionValueClass">
                                </div>
                                <div class="col-md-2 mt-4">
                                    @if($i)
                                        <button type="button" class="btn btn-sm btn-danger removeOptionData"><i
                                                class="fas fa-minus"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-primary addOptionData"><i
                                                class="fas fa-plus"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @php $i=1 @endphp
                    @endforeach
                @else
                    <div class="option-generator d-none">
                        <div class="row align-items-center mb-2">
                            <div class="col-md-5">
                                <label class="form-label">@lang('Option Name')</label>
                                <input type="text" name="field_option_name[{{$key}}][]"
                                       placeholder="@lang('Enter Option Name')"
                                       class="form-control optionNameClass">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">@lang('Option Value')</label>
                                <input type="text" name="field_option_value[{{$key}}][]"
                                       placeholder="@lang('Enter Option Value')"
                                       class="form-control optionValueClass">
                            </div>
                            <div class="col-md-2 mt-4">
                                <button type="button" class="btn btn-sm btn-primary addOptionData"><i
                                        class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @php $j =1; @endphp
@endforeach

