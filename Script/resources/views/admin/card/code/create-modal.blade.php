<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-hidden="true"
     data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{route('admin.cardServiceCode.store').'?service_id='.$service->id}}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h3>@lang('Add Codes')</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">@lang('Pass Code')</label>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <input type="text" name="passcode[]" placeholder="@lang('eg. UC102589632')"
                                       class="form-control" required>
                                <button class="btn btn-primary generate" type="button" id="button-addon2"><i
                                        class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="addedField">

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-end gap-3">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-success btn-sm">@lang('Add')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

