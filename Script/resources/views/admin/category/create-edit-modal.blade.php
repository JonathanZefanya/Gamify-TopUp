<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-hidden="true"
     data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" class="actionRoute" action="{{route('admin.categoryCreate').'?type='.$type}}"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h3>@lang('Create Category')</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label class="form-label">@lang('Name')</label>
                        <div class="col-md-12">
                            <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
                            @error("name")
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label class="form-label">@lang('Icon')</label>
                        <div class="col-md-12">
                            <input type="text" name="icon" class="form-control" value="{{old('icon')}}" required>
                            @error("icon")
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
                    <h3>@lang('Update Category')</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <label class="form-label">@lang('Name')</label>
                        <div class="col-md-12">
                            <input type="text" name="name" class="form-control editName" value="{{old('name')}}"
                                   required>
                            @error("name")
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label class="form-label">@lang('Icon')</label>
                        <div class="col-md-12">
                            <input type="text" name="icon" class="form-control editIcon" value="{{old('icon')}}"
                                   required>
                            @error("icon")
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
