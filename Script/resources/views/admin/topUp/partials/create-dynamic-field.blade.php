<div class="col-md-6 mb-2 copyField">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-sm btn-primary copyFormData">@lang('Copy')</button>
                <h3 class="card-header-title">@lang('Order Information')</h3>
                <button type="button" class="btn btn-sm btn-danger removeContentDiv d-none">@lang('Remove')</button>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-2">
                <input type="hidden" class="copyFieldLength" value="1">
                <div class="col-md-6">
                    <label class="form-label">@lang('Field Name')</label>
                    <input type="text" name="field_value[1][]" class="form-control nameClass"
                           placeholder="@lang('Enter Field Name')"
                           required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">@lang('Placeholder (optional)')</label>
                    <input type="text" name="field_placeholder[1][]" placeholder="@lang('Enter Placeholder')"
                           class="form-control placeholderClass">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <label class="form-label">@lang('Note (optional)')</label>
                    <input type="text" name="field_note[1][]" placeholder="@lang('Enter Note')"
                           class="form-control noteClass">
                </div>
                <div class="col-md-6">
                    <label class="form-label">@lang('Input Type')</label>
                    <select class="form-select typeClass" name="field_type[1][]" required>
                        <option value="text">@lang('Text')</option>
                        <option value="select">@lang('Select')</option>
                    </select>
                </div>
            </div>
            <div class="option-generator d-none">
                <div class="row align-items-center mb-2">
                    <div class="col-md-5">
                        <label class="form-label">@lang('Option Name')</label>
                        <input type="text" name="field_option_name[1][]" placeholder="@lang('Enter Option Name')"
                               class="form-control optionNameClass">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">@lang('Option Value')</label>
                        <input type="text" name="field_option_value[1][]" placeholder="@lang('Enter Option Value')"
                               class="form-control optionValueClass">
                    </div>
                    <div class="col-md-2 mt-4">
                        <button type="button" class="btn btn-sm btn-primary addOptionData"><i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
