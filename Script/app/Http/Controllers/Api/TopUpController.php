<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateReviewAndRatingJob;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Review;
use App\Models\TopUp;
use App\Models\TopUpService;
use App\Traits\ApiValidation;
use App\Traits\MakeOrder;
use App\Traits\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TopUpController extends Controller
{
    use ApiValidation, MakeOrder, Rating;

    public function getTopUp(Request $request)
    {
        try {
            $categoryId = $request->category_id;

            $data['topUps'] = TopUp::select(['id', 'category_id', 'name', 'slug', 'status', 'image'])->where('status', 1)
                ->when($categoryId, function ($query, $categoryId) {
                    return $query->where('category_id', $categoryId);
                })->get()->map(function ($query) {
                    $query->product_image = getFile($query->image->image_driver, $query->image->image);
                    return $query;
                })->makeHidden(['image', 'top_up_detail_route']);

            return response()->json($this->withSuccess($data));
        } catch (\Exception $e) {
            return response()->json($this->withErrors('Something went wrong'));
        }
    }

    public function topUpDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'top_up_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json($this->withErrors(collect($validator->errors())->collapse()));
        }

        try {
            $details = TopUp::where('status', 1)->find($request->top_up_id);
            if (!$details) {
                return response()->json($this->withErrors('Top Up not found'));
            }

            $details->product_image = getFile($details->image->image_driver, $details->image->image);

            $data['details'] = $details->makeHidden(['top_up_detail_route', 'image']);
            return response()->json($this->withSuccess($data));
        } catch (\Exception $e) {
            return response()->json($this->withErrors('Something went wrong'));
        }
    }

    public function topUpServices(Request $request)
    {
        try {
            $topUpId = $request->top_up_id;

            $data['services'] = TopUpService::where('status', 1)
                ->when($topUpId, function ($query, $topUpId) {
                    return $query->where('top_up_id', $topUpId);
                })->get()->makeHidden(['image', 'image_driver']);

            return response()->json($this->withSuccess($data));
        } catch (\Exception $e) {
            return response()->json($this->withErrors('Something went wrong'));
        }
    }

    public function topUpReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'top_up_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($this->withErrors(collect($validator->errors())->collapse()));
        }

        try {
            $reviews = Review::has('user')
                ->with(['user:id,firstname,lastname,image,image_driver'])
                ->where('status', 1)
                ->where('reviewable_type', TopUp::class)
                ->where('reviewable_id', $request->top_up_id)
                ->latest()
                ->paginate(basicControl()->user_pagination);

            $reviews->getCollection()->transform(function ($review) {
                $review->user->imgPath = getFile($review->user->image_driver, $review->user->image);
                return $review->makeHidden(['reviewable_type', 'reviewable_id', 'user_id']);
            });

            return response()->json($this->withSuccess([
                'reviews' => $reviews->items(),
                'pagination' => [
                    'total' => $reviews->total(),
                    'per_page' => $reviews->perPage(),
                    'current_page' => $reviews->currentPage(),
                    'last_page' => $reviews->lastPage(),
                    'next_page_url' => $reviews->nextPageUrl(),
                    'prev_page_url' => $reviews->previousPageUrl(),
                ],
            ]));
        } catch (\Exception $e) {
            return response()->json($this->withErrors('Something went wrong'));
        }
    }

    public function topUpReviewPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topUpId' => 'required',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required|string|max:200',
        ]);
        if ($validator->fails()) {
            return response()->json($this->withErrors(collect($validator->errors())->collapse()));
        }

        try {
            $user = $this->user($request->header('publicKey'), $request->header('SecretKey'));

            $topUpId = $request->topUpId;
            $topUp = TopUp::select(['id', 'status', 'name'])->where('status', 1)->find($topUpId);

            if (!$topUp) {
                return response()->json($this->withErrors('Data not found'));
            }

            $isHasOrder = OrderDetail::with(["detailable" => function ($query) use ($topUpId) {
                $query->whereHas('topUp', function ($q) use ($topUpId) {
                    $q->where('id', $topUpId);
                });
            }])
                ->whereHas('order', function ($qq) {
                    $qq->where('payment_status', 1);
                })
                ->where('user_id', $user->id)
                ->where('detailable_type', TopUpService::class)
                ->exists();

            if ($isHasOrder) {
                $review = Review::updateOrCreate([
                    'reviewable_type' => TopUp::class,
                    'reviewable_id' => $topUpId,
                    'user_id' => $user->id,
                ], [
                    'rating' => $request->rating,
                    'comment' => $request->comment,
                ]);

                UpdateReviewAndRatingJob::dispatch($review->id, TopUp::class, $topUpId);

                $this->reviewNotifyToAdmin($user, $topUp->name, $request->rating);
                return response()->json($this->withSuccess('Review Added Successfully'));
            }

            return response()->json($this->withErrors('You are not eligible for review'));
        } catch (\Exception $e) {
            return response()->json($this->withErrors('Something went wrong'));
        }
    }

    public function topUpOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topUpId' => ['required', 'numeric'],
            'serviceId' => ['required', 'numeric']
        ]);
        if ($validator->fails()) {
            return response()->json($this->withErrors(collect($validator->errors())->collapse()));
        }

        DB::beginTransaction();
        try {
            $service = TopUpService::whereHas('topUp', function ($query) {
                $query->where('status', 1);
            })->where('status', 1)->find($request->serviceId);

            if (!$service) {
                return response()->json($this->withErrors('Data not found'));
            }

            $topUp = $service->topUp;

            $rules = [];
            if ($topUp->order_information != null) {
                foreach ($topUp->order_information as $cus) {
                    $rules[$cus->field_name] = ['required'];
                    if ($cus->field_type == 'select') {
                        $options = implode(',', array_keys((array)$cus->option));
                        array_push($rules[$cus->field_name], 'in:' . $options);
                    }
                }
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json($this->withErrors(collect($validator->errors())->collapse()));
            }

            $info = [];

            if ($topUp->order_information != null) {
                foreach ($topUp->order_information as $cus) {
                    if (isset($request->{$cus->field_name})) {
                        $info[$cus->field_name] = [
                            'field' => $cus->field_value,
                            'value' => $request->{$cus->field_name},
                        ];
                    }
                }
            }

            $user = $this->user($request->header('publicKey'), $request->header('SecretKey'));
            $order = $this->orderCreate(showActualPrice($service), 'topup', $info, 'API', $user);
            $this->orderDetailsCreate($order, $service, TopUpService::class);

            $payByWallet = $this->payByWallet($order, $user);
            if (!$payByWallet['status']) {
                DB::rollBack();
                return response()->json($this->withErrors($payByWallet['message']));
            }
            DB::commit();
            return response()->json($this->withSuccess('Order has been placed successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($this->withErrors('Something went wrong'));
        }
    }

    public function getTopUpOrder(Request $request)
    {
        try {
            $user = $this->user($request->header('publicKey'), $request->header('SecretKey'));
            $orders = [];
            $data['orders'] = Order::with(['orderDetails', 'orderDetails.detailable',
                'orderDetails.detailable.topUp'])
                ->where('user_id', $user->id)
                ->payment()
                ->type('topup')
                ->orderBy('id', 'desc')
                ->get()->map(function ($query) use ($orders) {
                    $orders['orderId'] = $query->utr;
                    $orders['amount'] = $query->amount;
                    $orders['currency'] = basicControl()->base_currency;
                    $orders['currency_symbol'] = basicControl()->currency_symbol;
                    $orders['status'] = $query->status;
                    $orders['date'] = $query->created_at;
                    $orders['info'] = $query->info;

                    if (!empty($query->orderDetails)) {
                        foreach ($query->orderDetails as $detail) {
                            $orders['order_details'][] = [
                                'name' => $detail->name,
                                'image' => $detail->image_path,
                                'currency' => basicControl()->base_currency,
                                'currency_symbol' => basicControl()->currency_symbol,
                                'price' => $detail->price,
                                'qty' => $detail->qty,
                                'topUp_name' => $detail->detailable?->topUp?->name,
                                'rating' => $detail->detailable?->topUp?->avg_rating,
                            ];
                        }
                    }
                    return $orders;
                });

            return response()->json($this->withSuccess($data));
        }catch (\Exception $e){
            return response()->json($this->withErrors('Something went wrong'));
        }
    }
}
