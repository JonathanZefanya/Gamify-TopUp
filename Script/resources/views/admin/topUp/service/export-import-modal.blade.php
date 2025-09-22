<div class="modal fade" id="exportProductsModal" tabindex="-1" aria-labelledby="exportProductsModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exportProductsModalLabel">@lang('Export Service')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>@lang('This CSV file provides detailed information on top-up services, including relevant data for each service offered.')</p>

                <div class="modal-footer gap-3">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal"
                            aria-label="Close">@lang('Cancel')
                    </button>
                    <a href="{{route('admin.topUpService.export').'?topUp='.$topUp->id}}"
                       class="btn btn-primary">@lang('Export Service')</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Export Products Modal -->

<!-- Import Products Modal -->
<div class="modal fade" id="importProductsModal" tabindex="-1" aria-labelledby="importProductsModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="importProductsModalLabel">@lang('Import services by CSV')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('admin.topUpService.import').'?topUp='.$topUp->id}}" method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p><a class="link"
                          href="{{route('admin.topUpService.sample')}}">@lang('Download a sample CSV template')</a> @lang('to see an example of the format
                    required').
                    </p>

                    <label class="form-check form-check-dashed" for="importUploader">
                        <img id="importImg"
                             class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                             src="{{ asset('assets\admin\img\oc-browse.svg') }}"
                             alt="@lang("File Storage Logo")"
                             data-hs-theme-appearance="default">

                        <img id="importImg"
                             class="avatar avatar-xl avatar-4x3 avatar-centered h-100 mb-2"
                             src="{{ asset('assets\admin\img\oc-browse-light.svg') }}"
                             alt="@lang("File Storage Logo")"
                             data-hs-theme-appearance="dark">
                        <span class="d-block" id="importFilename">@lang("Browse your file here")</span>
                        <input type="file" class="js-file-attach form-check-input"
                               name="importFile" id="importUploader"
                               data-hs-file-attach-options='{
                                              "textTarget": "#importImg",
                                              "mode": "simple",
                                              "allowTypes": [".csv"]
                                           }'>
                    </label>
                    @error('importFile')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal"
                            aria-label="Close">@lang('Cancel')
                    </button>
                    <button type="submit" class="btn btn-primary">@lang('Upload and continue')</button>
                </div>
            </form>
        </div>
    </div>
</div>
