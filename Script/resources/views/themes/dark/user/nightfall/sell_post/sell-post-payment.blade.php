@extends(template() . 'layouts.user')
@section('title', trans('Make Payment'))

@section('content')
    <div class="pagetitle">
        <h3 class="mb-1">@lang('Payment')</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">@lang('Home')</a></li>
                <li class="breadcrumb-item active">@lang('Payment')</li>
            </ol>
        </nav>
    </div>
    <form action="{{route('user.sellPost.makePayment')}}" method="post"
          enctype="multipart/form-data">
        @csrf

        <div class="postPayment">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-15">@lang('How would you like to pay?')</h4>
                            @error('gateway')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                            <!-- Payment section start -->
                            <div class="payment-section">
                                <input type="hidden" class="sellPostId" name="sellPostId" value="{{$sellPost->id}}">
                                <ul class="payment-container-list">
                                    <li class="item">
                                        <input type="radio" class="form-check-input gateway-check" name="gateway"
                                               required
                                               id="gateway0"
                                               value="0"
                                               {{ (old('gateway') == 0) ? 'checked' : '' }}
                                               autocomplete="off"/>
                                        <label class="form-check-label" for="gateway0">
                                            <div class="image-area">
                                                <img src="{{ asset(template(true).'img/wallet.png') }}" alt="@lang('Wallet')">
                                            </div>
                                            <div class="content-area">
                                                <h5>@lang('Wallet Payment')</h5>
                                            </div>
                                        </label>
                                    </li>
                                    @foreach($gateways as $gateway)
                                        <li class="item">
                                            <input class="form-check-input gateway-check" type="radio"
                                                   name="gateway"
                                                   required
                                                   id="gateway{{$gateway->id}}"
                                                   value="{{$gateway->id}}"
                                                   {{ (old('gateway') == $gateway->id) ? 'checked' : '' }}
                                                   autocomplete="off"
                                            >
                                            <label class="form-check-label" for="gateway{{$gateway->id}}">
                                                <div class="image-area">
                                                    <img src="{{ getFile($gateway->driver,$gateway->image) }}" alt="{{$gateway->name}}">
                                                </div>
                                                <div class="content-area">
                                                    <h5>{{$gateway->name}}</h5>
                                                </div>
                                            </label>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="side-bar">

                    </div>
                </div>

                <div class="paymentModal">
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                         aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="staticBackdropLabel">@lang('Payment')</h4>
                                    <button type="button" class="cmn-btn-close text-light" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times text-light"></i>
                                    </button>
                                </div>
                                <div class="modal-body" id="paymentModalBody">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection
@push('script')
    <script>
        'use strict';
        $('#loading').hide();

        var sellPostId, gatewayId;

        calculateAmount();

        $(document).on('click', '.gateway-check', function () {
            calculateAmount();
        });

        function calculateAmount() {
            $('#loading').hide();
            sellPostId = $('.sellPostId').val();
            gatewayId = $('.gateway-check:checked').val();

            let updatedWidth = window.innerWidth;
            window.addEventListener('resize', () => {
                updatedWidth = window.innerWidth;
            });

            let sellPost = {
                ...@json($sellPost),
                images: @json(array_map(fn($image) => getFile($sellPost->image_driver, $image), $sellPost->image))
            };
            let price = @json($price);
            let currencySymbol = "{{ basicControl()->base_currency }}";
            let AuthUserId = {{ Auth::check() ? Auth::id() : 'null' }};
            let loaderImage = "{{ asset(template(true).'img/loading.gif') }}";

            let html = `
                <div class="transferList">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="transfer-details-section">
                                <div class="game-box d-md-flex">
                                    <div class="img-box image-slider owl-carousel">
                                        ${sellPost.images.map(image => `
                                            <img src="${image}"
                                                 class="img-fluid"
                                                 alt="...">
                                        `).join('')}
                                    </div>
                                    <div class="w-100 d-block">
                                        <div class="row justify-content-between">
                                            <div class="col-md-12">
                                                <h6 class="name">${sellPost.title}</h6>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-3">
                                            <span class="game-level">
                                                @lang('Price'):
                                                <span>${price} ${currencySymbol}</span>
                                            </span>
                                            ${sellPost.payment_lock == 1
                ? (sellPost.lock_for == AuthUserId
                    ? `<span class="badge text-bg-secondary">@lang('Waiting Payment')</span>`
                    : (sellPost.user_id == AuthUserId
                        ? `<span class="badge text-bg-warning">@lang('Payment Processing')</span>`
                        : `<span class="badge text-bg-warning">@lang('Going to Sell')</span>`))
                : ''}
                                        </div>
                                         <div class="row g-2 mt-3 more-info">
                                            ${Array.isArray(sellPost.post_specification_form)
                ? sellPost.post_specification_form.map(spec => `
                                            <div class="col-6">
                                                <span>${spec.field_name}: ${spec.field_value}</span>
                                            </div>
                                                `).join('')
                : '<div class="col-12">@lang("No specifications available.")</div>'}
                                            </div>
                                        </div>
                                    </div>
                                <div>
                                    <p class="mt-4">
                                        ${sellPost.details}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="transfer-details-section">
                                <div class="order-box paymentCurrency" id="paymentCurrency">
                                    <h5>@lang('Select Payment Currency')</h5>
                                    <div class="input-box">
                                        <select class="js-example-basic-single form-control form-select sellselect"
                                                name="selectedCurrency"
                                                id="supported_currency">
                                            <option value="">@lang('Select Currency')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="payment-box estimate-box">
                                    <div class="payment-info">
                                        <div id="loading" class="text-center">
                                            <img src="${loaderImage}" alt="..." class="w-15">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end pt-3">
                                        <button class="cmn-btn w-100" type="submit">
                                            @lang('Buy now')
            </button>
        </div>
    </div>
</div>
</div>
</div>
</div>
`;

            if (updatedWidth <= 991) {
                $('.side-bar').html('');
                $('#paymentModalBody').html(html);
                let paymentModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
                paymentModal.show();
            } else {
                $('.side-bar').html(html);
            }

            $('.cmn-select2').select2({
                placeholder: "Select currency"
            });

            if (gatewayId != 0) {
                $('#paymentCurrency').removeClass('d-none');
                supportCurrency(gatewayId);
            } else {
                $('#paymentCurrency').addClass('d-none');
                checkCalc(sellPostId, gatewayId, null);
            }
        }


        function supportCurrency(selectedPaymentMethod) {
            if (!selectedPaymentMethod) {
                console.error('Selected Gateway is undefined or null.');
                return;
            }
            console.log(selectedPaymentMethod)

            $('#supported_currency').empty();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('supported.currency') }}",
                data: {gateway: selectedPaymentMethod},
                type: "GET",
                success: function (data) {
                    $('#supported_currency').html('');
                    if (data === "") {
                        let markup = `<option value="USD">USD</option>`;
                        $('#supported_currency').append(markup);
                    }

                    let markup = '<option value="">Selected Currency</option>';
                    $('#supported_currency').append(markup);
                    let res = data.data;
                    $(res).each(function (index, value) {
                        let markup = `<option value="${value}">${value}</option>`;
                        $('#supported_currency').append(markup);
                    });
                },
                error: function (error) {
                    console.error('AJAX Error:', error);
                }
            });
        }

        $(document).on('change', '#supported_currency', function () {
            let selectedCurrency = $('#supported_currency').val();
            checkCalc(sellPostId, gatewayId, selectedCurrency);
        });

        function checkCalc(sellPostId, gatewayId, selectedCurrency = null) {
            if (sellPostId == undefined || gatewayId == undefined) {
                return 0;
            }
            $('#loading').show();
            $.ajax({
                url: "{{route('ajaxCheckSellPostCalc')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    sellPostId,
                    gatewayId,
                    selectedCurrency
                },
                success(data) {

                    var htmlData = `
                    <h5>@lang('PURCHASE')</h5>
                        <ul>
                            <li >
                                @lang('Amount in base'):
                                <span>${data.amount} ${data.baseCurrency}</span>
                            </li>
                            <li>
                                @lang('Discount in base'):
                                <span>${data.discount} ${data.baseCurrency}</span>
                            </li>
                            <li>
                                @lang('Subtotal'):
                                <span>${data.subtotal} ${data.selectedCurrency ? data.selectedCurrency : data.baseCurrency}</span>
                                <input type="hidden" id="totalAmount" name="amount" value="${data.subtotal}">
                            </li>
                            <li>
                                @lang('Gateway Charge'):
                                <span>${data.charge} ${data.selectedCurrency ? data.selectedCurrency : data.baseCurrency}</span>
                            </li>
                            <li>
                                @lang('Payable'):
                                <span>${data.payable} ${data.selectedCurrency ? data.selectedCurrency : data.baseCurrency}</span>
                            </li>
                            ${(data.isCrypto == false) ? `
                            <li class="text-center">
                                ${data.in}
                            </li>
                            ` : ``}


                        </ul>`;

                    $('.payment-info').html(htmlData)
                },
                complete: function () {
                    $('#loading').hide();
                },
                error(err) {
                    var errors = err.responseJSON;
                    for (var obj in errors) {
                        Notiflix.Notify.failure(`${errors[obj]}`);
                    }

                }
            });
        }
    </script>
@endpush
