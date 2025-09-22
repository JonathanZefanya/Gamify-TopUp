<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="setAsDefaultModalLabel"
     data-bs-backdrop="static"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="setAsDefaultModalLabel"><i
                        class="fas fa-plus"></i> @lang("Add Currency")</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('admin.currencyCreate')}}" method="post">
                @csrf
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
                        <label class="form-label">@lang('Code')</label>
                        <div class="col-md-12">
                            <input type="text" name="code" class="form-control" value="{{old('code')}}" required>
                            @error("code")
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label class="form-label">@lang('Symbol')</label>
                        <div class="col-md-12">
                            <input type="text" name="symbol" class="form-control" value="{{old('symbol')}}" required>
                            @error("symbol")
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label class="form-label">@lang('Rate')</label>
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text">1 {{basicControl()->base_currency}}</span>
                                <input type="number" step="0.0001" name="rate" class="form-control"
                                       value="{{old('code')}}" required>
                                <span class="input-group-text currencyCode">USD</span>
                                @error("rate")
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-white" data-bs-dismiss="modal">@lang("Close")</button>
                    <button type="submit" class="btn btn-sm btn-primary">@lang("Add")</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="setAsDefaultModalLabel"
     data-bs-backdrop="static"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="setAsDefaultModalLabel"><i
                        class="fas fa-edit"></i> @lang("Update Currency")</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" class="editRoute">
                @csrf
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
                        <label class="form-label">@lang('Code')</label>
                        <div class="col-md-12">
                            <input type="text" name="code" class="form-control editCode" value="{{old('code')}}"
                                   required>
                            @error("code")
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label class="form-label">@lang('Symbol')</label>
                        <div class="col-md-12">
                            <input type="text" name="symbol" class="form-control editSymbol" value="{{old('symbol')}}" required>
                            @error("symbol")
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label class="form-label">@lang('Rate')</label>
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text">1 {{basicControl()->base_currency}}</span>
                                <input type="number" step="0.0001" name="rate" class="form-control editRate"
                                       value="{{old('code')}}" required>
                                <span class="input-group-text currencyCode">USD</span>
                                @error("rate")
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-white" data-bs-dismiss="modal">@lang("Close")</button>
                    <button type="submit" class="btn btn-sm btn-primary">@lang("Save Change")</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal -->
