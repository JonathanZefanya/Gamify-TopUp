<div class="col-md-4 mb-3">
    <label class="form-label">@lang('Choose Image (optional)')</label>
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
    <span
        class="text-primary">@lang('Note: Image size should be ') {{config('filelocation.card.image_size')}} @lang('for better resolution')</span>
</div>

<div class="col-md-4 mb-3">
    <label class="form-label">@lang('Choose Preview Image (optional)')</label>
    <div class="mb-3 mb-md-0">
        <label class="form-check form-check-dashed" for="previewUploader">
            <img id="previewImg"
                 class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                 src="{{ getFile('local','abc', true) }}"
                 alt="@lang("File Storage Logo")"
                 data-hs-theme-appearance="default">

            <img id="previewImg"
                 class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                 src="{{ getFile('local','abc', true) }}"
                 alt="@lang("File Storage Logo")"
                 data-hs-theme-appearance="dark">
            <span class="d-block">@lang("Browse your file here")</span>
            <input type="file" class="js-file-attach form-check-input"
                   name="preview_image" id="previewUploader"
                   data-hs-file-attach-options='{
                                              "textTarget": "#previewImg",
                                              "mode": "image",
                                              "targetAttr": "src",
                                              "allowTypes": [".png", ".jpeg", ".jpg",".webp"]
                                           }'>
        </label>
        @error("preview_image")
        <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>
    <span
        class="text-primary">@lang('Note: Image size should be ') {{config('filelocation.card.preview_size')}} @lang('for better resolution')</span>
</div>
