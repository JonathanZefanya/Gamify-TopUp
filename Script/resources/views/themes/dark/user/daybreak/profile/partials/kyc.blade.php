<div class="account-settings-profile-section">
    <div class="card">
        <div class="card-body pt-0">
            <form action="{{ route('user.kyc.verification.submit') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="account-settings-profile-section">
                    <div class="card">
                        <div class="card-header border-0 text-start text-md-center">
                            <h5 class="card-title">@lang('KYC Information')</h5>
                            <p>@lang('Verify your process instantly.')</p>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-md-8 mx-auto">
                                    <div class="row g-4">
                                        <div class="col-12 mb-2">
                                            <label class="form-label">@lang('Kyc Type')</label>
                                            <select class="cmn-select2 " name="kycType">
                                                <option value="">@lang('Select Kyc Type')</option>
                                                @foreach($kyc as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <div id="oldKyc">

                                            </div>
                                        </div>
                                        <div id="kycForm" class="mt-0">
                                        </div>

                                        <div class="btn-area mt-0">
                                            <button type="submit" class="cmn-btn">@lang('submit')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
