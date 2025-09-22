<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SellPostOffer;
use App\Models\SellPostPayment;
use App\Models\User;
use App\Traits\ApiValidation;
use Illuminate\Http\Request;

class MyOrderController extends Controller
{
    use ApiValidation;

    public function topUpOrder(Request $request)
    {
        $basic = basicControl();
        $search = $request->all();
        $dateSearch = $request->datetrx;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        try {
            $topUpOrders = tap(Order::with(['orderDetails', 'orderDetails.detailable'])
                ->with([
                    'orderDetails.detailable' => function ($query) {
                        $query->when(method_exists($query->getModel(), 'topUp'), function ($query) {
                            $query->with(['topUp.reviewByReviewer']);
                        });
                    }
                ])
                ->own()
                ->payment()
                ->type('topup')
                ->orderBy('id', 'DESC')
                ->when(@$search['transaction_id'], function ($query) use ($search) {
                    return $query->where('transaction', 'LIKE', "%{$search['transaction_id']}%");
                })
                ->when($date == 1, function ($query) use ($dateSearch) {
                    return $query->whereDate("created_at", $dateSearch);
                })
                ->paginate($basic->paginate), function ($paginatedInstance) use ($basic) {
                return $paginatedInstance->getCollection()->transform(function ($query) use ($basic) {
                    $array = [
                        'utr' => $query->utr ?? null,
                        'price' => getAmount($query->amount, $basic->fraction_number),
                        'currency' => $basic->base_currency ?? null,
                        'symbol' => $basic->currency_symbol ?? null,
                        'status' => $query->status == 1 ? 'Complete' : (($query->status == 2) ? 'Refunded' : 'Wait Sending'),
                        'dateTime' => $query->created_at ?? null,
                        'order_details' => [],
                    ];

                    foreach ($query->orderDetails as $detail) {
                        $array['order_details'][] = [
                            'utr' => $query->utr ?? null,
                            'rating' => $detail->detailable?->topUp?->reviewByReviewer?->rating ?? 0,
                            'image' => $detail->detailable?->image ? getFile($detail->detailable->image_driver, $detail->detailable->image) : null,
                            'discount' => getAmount($detail->discount, $basic->fraction_number),
                            'quantity' => $detail->qty,
                            'name' => $detail->detailable?->topUp?->name,
                            'service' => $detail->detailable?->name,
                            'base_price' => $detail->detailable?->price,
                            'currency' => $basic->base_currency ?? null,
                            'symbol' => $basic->currency_symbol ?? null,
                            'slug' => $detail->detailable->topUp->slug,
                        ];

                        $array['review_user_info'][] = [
                            'review' => [
                                'comment' => $detail->detailable->topUp->reviewByReviewer->comment ?? null,
                                'rating' => $detail->detailable->topUp->reviewByReviewer->rating ?? 0,
                                'status' => ($detail->detailable->topUp->reviewByReviewer->status ?? null) == 1 ? 'active' : 'inactive',
                            ],
                        ];

                    }
                    $array['informations'] = [];
                    if (!empty($query->info)) {
                        foreach ($query->info as $info) {
                            $array['informations'][$info->field] = $info->value;
                        }
                    }

                    return $array;
                });
            });


            if ($topUpOrders) {
                return response()->json($this->withSuccess($topUpOrders));
            } else {
                return response()->json($this->withErrors('No data found'));
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }
    public function cardOrder(Request $request)
    {
        $basic = basicControl();
        $search = $request->all();
        $dateSearch = $request->datetrx;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        try {
            $topUpOrders = tap(Order::with(['orderDetails', 'orderDetails.detailable'])
                ->with([
                    'orderDetails.detailable' => function ($query) {
                        $query->when(method_exists($query->getModel(), 'card'), function ($query) {
                            $query->with(['card.reviewByReviewer']);
                        });
                    }
                ])
                ->own()
                ->payment()
                ->type('card')
                ->orderBy('id', 'DESC')
                ->when(@$search['transaction_id'], function ($query) use ($search) {
                    return $query->where('transaction', 'LIKE', "%{$search['transaction_id']}%");
                })
                ->when($date == 1, function ($query) use ($dateSearch) {
                    return $query->whereDate("created_at", $dateSearch);
                })
                ->paginate($basic->paginate), function ($paginatedInstance) use ($basic) {
                return $paginatedInstance->getCollection()->transform(function ($query) use ($basic) {
                    $array = [
                        'utr' => $query->utr ?? null,
                        'price' => getAmount($query->amount, $basic->fraction_number),
                        'currency' => $basic->base_currency ?? null,
                        'symbol' => $basic->currency_symbol ?? null,
                        'status' => $query->status == 1 ? 'Complete' : (($query->status == 2) ? 'Refunded' : 'Wait Sending'),
                        'dateTime' => $query->created_at ?? null,
                        'order_details' => [],
                    ];

                    foreach ($query->orderDetails as $detail) {
                        $array['order_details'][] = [
                            'utr' => $query->utr ?? null,
                            'id' => $detail->detailable?->card?->id ?? null,
                            'rating' => $detail->detailable?->card?->avg_rating ?? null,
                            'image' => $detail->detailable?->image ? getFile($detail->detailable->image_driver, $detail->detailable->image) : null,
                            'card' => $detail->detailable->card->name ?? null,
                            'slug' => $detail->detailable->card->slug ?? null,
                            'service' => $detail->detailable->name ?? null,
                            'base_price' => $detail->detailable->price ?? null,
                            'currency' => $basic->base_currency ?? null,
                            'symbol' => $basic->currency_symbol ?? null,
                            'discount' => getAmount($detail->discount, $basic->fraction_number),
                            'quantity' => $detail->qty,
                            'card_codes' => empty($detail->card_codes)
                                ? []
                                : (json_decode($detail->card_codes, true) ?: []),
                            'stock_short' => "You have {$detail->stock_short} more code in wait sending list" ,
                        ];



                        $array['review_user_info'][] = [
                            'review' => [
                                'comment' => $detail->detailable->card->reviewByReviewer->comment ?? null,
                                'rating' => $detail->detailable->card->reviewByReviewer->rating ?? null,
                                'status' => ($detail->detailable->card->reviewByReviewer->status ?? null) == 1 ? 'active' : 'inactive',
                            ],
                        ];
                    }
                    $array['informations'] = [];
                    if (!empty($query->info)) {
                        foreach ($query->info as $info) {
                            $array['informations'][$info->field] = $info->value;
                        }
                    }

                    return $array;
                });
            });


            if ($topUpOrders) {
                return response()->json($this->withSuccess($topUpOrders));
            } else {
                return response()->json($this->withErrors('No data found'));
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }
    public function idPurchase(Request $request)
    {
        $basic = basicControl();
        $search = $request->all();
        $dateSearch = $request->datetrx;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        try {
            $idPurchases = tap(SellPostPayment::with('sellPost')->where('user_id', auth()->id())
                ->wherePayment_status(1)->orderBy('id', 'DESC')
                ->when(@$search['transaction_id'], function ($query) use ($search) {
                    return $query->where('transaction', 'LIKE', "%{$search['transaction_id']}%");
                })
                ->when($date == 1, function ($query) use ($dateSearch) {
                    return $query->whereDate("created_at", $dateSearch);
                })
                ->paginate($basic->paginate), function ($paginatedInstance) use ($basic) {
                return $paginatedInstance->getCollection()->transform(function ($query) use ($basic) {
                    $array['trx'] = $query->transaction ?? null;
                    $array['category'] = optional(optional(optional($query->sellPost)->category)->details)->name;
                    $array['title'] = optional($query->sellPost)->title;
                    $array['amount'] = getAmount($query->price, $basic->fraction_number);
                    $array['discount'] = getAmount($query->discount, $basic->fraction_number);
                    $array['currency'] = $basic->base_currency ?? null;
                    $array['symbol'] = $basic->currency_symbol ?? null;
                    $array['dateTime'] = $query->created_at ?? null;
                    $array['moreInformation'] = optional($query->sellPost)->credential ?? [];
                    return $array;
                });
            });

            if ($idPurchases) {
                return response()->json($this->withSuccess($idPurchases));
            } else {
                return response()->json($this->withErrors('No data found'));
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function myOrder(Request $request)
    {
        $basic = basicControl();
        $search = $request->all();
        $dateSearch = $request->datetrx;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        try {
            $myOffers = tap(SellPostPayment::with(['sellPost', 'sellPost.category.details'])
                ->whereUser_id(auth()->id())
                ->wherePayment_status(1)
                ->orderBy('id', 'DESC')
                ->when(@$search['transaction_id'], function ($query) use ($search) {
                    return $query->where('transaction', 'LIKE', "%{$search['transaction_id']}%");
                })
                ->when($date == 1, function ($query) use ($dateSearch) {
                    return $query->whereDate("created_at", $dateSearch);
                })
                ->paginate($basic->paginate), function ($paginatedInstance) use ($basic) {
                return $paginatedInstance->getCollection()->transform(function ($query) use ($basic) {
                    $array['id'] = $query->id ?? null;
                    $array['category'] = optional(optional($query->sellPost)->category)->details->name ?? null;
                    $array['title'] = optional($query->sellPost)->title;
                    $array['sellingStatus'] = optional($query->sellPost)->payment_status == 1 ? 'sold' : 'unsold';
                    $array['price'] = getAmount(optional($query->sellPost)->price, $basic->fraction_number);
                    $array['offerPrice'] = getAmount($query->amount, $basic->fraction_number);
                    $array['currency'] = $basic->base_currency ?? null;
                    $array['symbol'] = $basic->currency_symbol ?? null;
                    if ($query->status) {
                        $array['status'] = 'Accept';
                    } elseif ($query->status == 0) {
                        $array['status'] = 'Pending';
                    } elseif ($query->status == 2) {
                        $array['status'] = 'Reject';
                    } elseif ($query->status == 3) {
                        $array['status'] = 'Resubmission';
                    }
                    $array['dateTime'] = $query->created_at ?? null;
                    $array['sellPostId'] = $query->sell_post_id;
                    $array['credential'] = $query->sellPost?->credential;
                    $array['post_specification_form'] = $query->sellPost?->post_specification_form;
                    return $array;
                });
            });

            if ($myOffers) {
                return response()->json($this->withSuccess($myOffers));
            } else {
                return response()->json($this->withErrors('No data found'));
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }
}
