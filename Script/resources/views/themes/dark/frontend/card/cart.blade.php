@extends(template() . 'layouts.app')
@section('title',trans('Shopping Cart'))
@section('content')
    <section class="cart-section" id="chartArea">
        <div class="container">
            <div class="row g-4 g-sm-5">
                <div class="col-lg-8">
                    <div class="cart-table">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                <tr>
                                    <th scope="col">@lang('Product Details')</th>
                                    <th scope="col">@lang('Quantity')</th>
                                    <th scope="col">@lang('price')</th>
                                    <th scope="col">@lang('Total')</th>
                                </tr>
                                </thead>
                                <tbody id="calLoader">
                                <div>

                                </div>
                                <tr v-for="(item, index) in cartItems">
                                    <td data-label="Product Details">
                                        <div class="cart-item">
                                            <a href="#" class="img-box">
                                                <img :src="item.image" alt="...">
                                            </a>
                                            <div class="text-box">
                                                <h6 class="mb-1 title"><a href="#">@{{ item.name }}</a></h6>
                                                <small>@lang('Discount:') -@{{ item.discount }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Quantity">
                                        <div class="item-count">
                                            <button class="btn-inc-dec" v-if="item.quantity > 1"
                                                    @click.prevent="quantityUpdate(item.id,-1)"
                                                    data-decrease="data-decrease"><i
                                                    class="fa-regular fa-minus"></i></button>
                                            <button class="btn-inc-dec" v-else
                                                    @click.prevent="remove()"
                                                    data-decrease="data-decrease">
                                                <i class="fa-regular fa-trash"></i>
                                            </button>
                                            <input data-value="data-value" class="number" type="number"
                                                   v-model="item.quantity">
                                            <button class="btn-inc-dec" v-if="item.quantity < 10"
                                                    @click.prevent="quantityUpdate(item.id,1)"
                                                    data-increase="data-increase"><i
                                                    class="fa-regular fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td data-label="Amount">
                                        <span>@{{ item.price }}</span>
                                    </td>
                                    <td data-label="Total">
                                        <span>@{{ item.totalPrice }}</span>
                                    </td>
                                </tr>
                                <tr v-if="cartItems.length < 1">
                                    @include('empty')
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <form action="{{route('card.user.buy')}}" method="POST">
                            @csrf
                            <div class="card-body">
                                <h4 class="mb-20">@lang('Your cart total')</h4>
                                <div class="cmn-list2">
                                    <div class="item">
                                        <span>@lang('Subtotal') :</span>
                                        <h6 class="mb-0">@{{ totalSubtotal }}</h6>
                                    </div>
                                    <div class="item">
                                        <span>@lang('Discount') :</span>
                                        <h6 class="mb-0">@{{ totalDiscount }}</h6>
                                    </div>
                                    <hr>
                                    <div class="item">
                                        <h5>@lang('Total') :</h5>
                                        <h5 class="mb-0">@{{ totalPrice }}</h5>
                                    </div>
                                </div>
                                <button type="submit" class="cmn-btn mt-20 w-100">
                                    <span>@lang('Proceed To Checkout')</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('style')
    <style>
        .table-not-found img{
            height: 160px !important;
        }
    </style>
@endpush
@push('extra_scripts')
    <script>
        'use strict';
        Notiflix.Block.dots('#calLoader');
        let chartArea = new Vue({
            el: "#chartArea",
            data: {
                cartItems: [],
                totalSubtotal: null,
                totalDiscount: null,
                totalPrice: null,
                removeProductId: null,
                removeProductName: null,
                removeProductImage: null
            },
            mounted() {
                this.getCartsItem();
            },
            methods: {
                getCartsItem() {
                    let app = this;
                    axios.get("{{ route('cart.user.getCartItems') }}")
                        .then(function (response) {
                            Notiflix.Block.remove('#calLoader');
                            if (response.data.status) {
                                app.cartItems = response.data.items;
                                app.totalSubtotal = response.data.totalSubtotal;
                                app.totalDiscount = response.data.totalDiscount;
                                app.totalPrice = response.data.totalPrice;
                            }
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                },
                quantityUpdate(serviceId, type) {
                    Notiflix.Block.dots('#calLoader');
                    let app = this;
                    axios.post("{{route('cart.user.quantityUpdate')}}", {
                        serviceId: serviceId,
                        type: type,
                    })
                        .then(function (response) {
                            if (response.data.status) {
                                app.getCartsItem();
                            } else {
                                Notiflix.Notify.failure(response.data.message);
                            }
                        })
                        .catch(function (error) {

                        });
                },
                removePermission(item) {
                    this.removeProductId = item.id;
                    this.removeProductName = item.name;
                    this.removeProductImage = item.image;
                },
                remove() {
                    $('#modalRemove').hide();
                    Notiflix.Block.dots('#calLoader');
                    let app = this;
                    axios.post("{{route('cart.user.remove')}}", {
                        serviceId: app.removeProductId,
                    })
                        .then(function (response) {

                            if (response.data.status) {
                                app.getCartsItem();
                                cartCount();
                            } else {
                                Notiflix.Notify.failure(response.data.message);
                            }
                        })
                        .catch(function (error) {

                        });
                }
            }
        });

        const itemCounts = document.querySelectorAll('.item-count');
        itemCounts.forEach(itemCount => {
            const decreaseBtn = itemCount.querySelector('[data-decrease]');
            const increaseBtn = itemCount.querySelector('[data-increase]');
            const valueInput = itemCount.querySelector('[data-value]');

            decreaseBtn.addEventListener('click', () => {
                const currentValue = parseInt(valueInput.value);
                if (currentValue > 1) {
                    valueInput.value = currentValue - 1;
                }
            })
            increaseBtn.addEventListener('click', () => {
                const currentValue = parseInt(valueInput.value);
                valueInput.value = currentValue + 1;
            })
        })

    </script>
@endpush
