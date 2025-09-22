<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-hidden="true"
     data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{route('admin.topUpService.store').'?top_up_id='.$topUp->id}}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h3>@lang('Create Service')</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label class="form-label">@lang('Name')</label>
                        <div class="col-md-12">
                            <input type="text" name="name" placeholder="@lang('eg. Weekly Membership')"
                                   class="form-control" value="{{old('name')}}" required>
                            @error("name")
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label class="form-label">@lang('Price')</label>
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-text"
                                      id="basic-addon1">{{basicControl()->currency_symbol}}</span>
                                <input type="number" step="0.001" min="0" name="price" placeholder="@lang('10')"
                                       class="form-control" value="{{old('price')}}"
                                       required>
                            </div>
                            @error("price")
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label class="form-label">@lang('Discount (optional)')</label>
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-text"
                                      id="basic-addon1">{{basicControl()->currency_symbol}}</span>
                                <input type="number" name="discount" step="0.001" min="0" value="{{old('discount')}}"
                                       class="form-control"
                                       placeholder="@lang('2')"
                                       aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <select class="form-select input-group-text" name="discount_type" id="basic-addon2">
                                    <option
                                        value="percentage" {{old('discount_type') == 'percentage' ? 'selected':''}}>@lang('Percentage')</option>
                                    <option
                                        value="flat" {{old('discount_type') == 'flat' ? 'selected':''}}>@lang('Flat')</option>
                                </select>
                            </div>
                            @error("discount")
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label class="form-label">@lang('Image (optional)')</label>
                        <div class="col-md-12">
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
                            <strong>@lang('Image size should be '){{config('filelocation.topUpService.size')}} @lang('for better resolution')</strong>
                            @error("image")
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-end gap-3">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-success btn-sm">@lang('Create')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true"
     data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" class="editRoute" action=""
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h3>@lang('Update Service')</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label class="form-label">@lang('Name')</label>
                        <div class="col-md-12">
                            <input type="text" name="name" placeholder="@lang('eg. Weekly Membership')"
                                   class="form-control editName" value="" required>
                            @error("name")
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label class="form-label">@lang('Price')</label>
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-text"
                                      id="basic-addon1">{{basicControl()->currency_symbol}}</span>
                                <input type="number" step="0.001" min="0" name="price" placeholder="@lang('10')"
                                       class="form-control editPrice" value=""
                                       required>
                            </div>
                            @error("price")
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label class="form-label">@lang('Discount (optional)')</label>
                        <div class="col-md-12">
                            <div class="input-group">
                                <span class="input-group-text"
                                      id="basic-addon1">{{basicControl()->currency_symbol}}</span>
                                <input type="number" name="discount" step="0.001" min="0" value=""
                                       class="form-control editDiscount"
                                       placeholder="@lang('2')"
                                       aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <select class="form-select input-group-text editDiscountType" name="discount_type"
                                        id="basic-addon2">
                                    <option
                                        value="percentage">@lang('Percentage')</option>
                                    <option
                                        value="flat">@lang('Flat')</option>
                                </select>
                            </div>
                            @error("discount")
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label class="form-label">@lang('Image (optional)')</label>
                        <div class="col-md-12">
                            <label class="form-check form-check-dashed" for="updateUploader">
                                <img id="updateImg"
                                     class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2 editImage"
                                     src="{{ getFile('local','abc', true) }}"
                                     alt="@lang("File Storage Logo")"
                                     data-hs-theme-appearance="default">

                                <img id="updateImg"
                                     class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2 editImage"
                                     src="{{ getFile('local','abc', true) }}"
                                     alt="@lang("File Storage Logo")"
                                     data-hs-theme-appearance="dark">
                                <span class="d-block">@lang("Browse your file here")</span>
                                <input type="file" class="js-file-attach form-check-input"
                                       name="image" id="updateUploader"
                                       data-hs-file-attach-options='{
                                              "textTarget": "#updateImg",
                                              "mode": "image",
                                              "targetAttr": "src",
                                              "allowTypes": [".png", ".jpeg", ".jpg",".webp"]
                                           }'>
                            </label>
                            <strong>@lang('Image size should be '){{config('filelocation.topUpService.size')}} @lang('for better resolution')</strong>
                            @error("image")
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-end gap-3">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-success btn-sm">@lang('Save Change')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
