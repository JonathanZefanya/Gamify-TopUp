@extends(template().'layouts.user')
@section('title',trans('Api Key'))
@section('content')
    <div class="pagetitle">
        <h3 class="mb-1">@lang('Api Key')</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('Api Key')</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-50">
                <div class="card-header d-flex align-items-center justify-content-between pb-0 border-0">
                    <h5 class="mb-0">@lang('Api Key')</h5>
                    <button id="generateBtn" class="cmn-btn" data-bs-target="#confirmModal"
                            data-bs-toggle="modal">@lang('Generate Key')</button>
                </div>
                <div class="card-body p-sm-5">
                    <h6>@lang('Public Key:')</h6>
                    <div class="input-group mb-3">
                        <input id="public" type="password" class="form-control"
                               value="{{auth()->user()->public_key}}" aria-label="button-public"
                               aria-describedby="basic-addon2" readonly>
                        <div class="input-group-text" onclick="copyPublic()" id="button-public">
                            <i class="fa-regular fa-copy"></i> @lang('Copy')
                        </div>
                    </div>

                    <h6>@lang('Secret Key:')</h6>
                    <div class="input-group mb-3">
                        <input id="secret" type="password" class="form-control"
                               value="{{auth()->user()->secret_key}}" aria-label="button-secret"
                               aria-describedby="basic-addon2" readonly>
                        <div class="input-group-text" onclick="copySecret()" id="button-secret">
                            <i class="fa-regular fa-copy"></i>@lang('Copy')
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">@lang('Confirmation')</h5>
                    <button type="button" class="cmn-btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times"></i>
                    </button>
                </div>
                <form action="{{route('user.apiKey')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>@lang('Are you certain about generating a new API key? If you proceed with generating a new key, the previously used API key may be invalidated or affected. Please confirm before initiating the process to avoid any disruption.')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="cmn-btn3"
                                data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="cmn-btn">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script>
        'use strict';

        function copyPublic() {
            var copyText = document.getElementById("public");

            navigator.clipboard.writeText(copyText.value)
                .then(() => {
                    Notiflix.Notify.success(`Copied: ${copyText.value}`);
                })
                .catch(err => {
                    Notiflix.Notify.failure('Failed to copy text');
                    console.error('Error copying text: ', err);
                });
        }

        function copySecret() {
            var copyText = document.getElementById("secret");

            copyText.type = "text";
            navigator.clipboard.writeText(copyText.value)
                .then(() => {
                    Notiflix.Notify.success(`Copied: ${copyText.value}`);
                })
                .catch(err => {
                    Notiflix.Notify.failure('Failed to copy text');
                    console.error('Error copying text: ', err);
                })
                .finally(() => {
                    copyText.type = "password";
                });
        }
    </script>
@endpush
