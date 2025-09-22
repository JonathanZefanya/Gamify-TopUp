<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\CardService;
use App\Models\Category;
use App\Models\Gateway;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Review;
use App\Traits\ApiValidation;
use App\Traits\MakeOrder;
use App\Traits\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    use ApiValidation, MakeOrder, Rating;

    public function getCard(Request $request)
    {
        try {
            $categoryId = $request->category_id;
            $sort_by = $request->sort_by;

            $data['cards'] = Card::select(['id', 'category_id', 'name', 'slug', 'status', 'image'])->where('status', 1)
                ->when($categoryId, function ($query, $categoryId) {
                    return $query->where('category_id', $categoryId);
                })
                ->when($sort_by, function ($query, $sort_by) {

                    if ($sort_by == 'all') {
                        $query->orderBy('sort_by', 'desc');
                    } elseif ($sort_by == 'popular') {
                        $query->orderBy('sell_count', 'desc');
                    } elseif ($sort_by == 'latest') {
                        $query->latest();
                    } elseif ($sort_by == 'trending') {
                        $query->where('trending', 1);
                    }elseif ($sort_by == 'date') {
                        $query->orderBy('created_at', 'asc');
                    }
                })
                ->get()->map(function ($query) {
                    $query->product_image = getFile($query->image->image_driver, $query->image->image);
                    return $query;
                })->makeHidden(['image', 'card_detail_route']);

            return response()->json($this->withSuccess($data));
        } catch (\Exception $e) {
            return response()->json($this->withErrors('Something went wrong'));
        }
    }
    public function cardCategories(Request $request)
    {
        try {
            $data['categories'] = Category::query()->where('status', 1)->where('type', 'card')->get();

            return response()->json($this->withSuccess($data));
        }catch (\Exception $e){
            return response()->json($this->withErrors($e->getMessage()));
        }
    }
    public function cardDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json($this->withErrors(collect($validator->errors())->collapse()));
        }

        try {
            $details = Card::with('services')->where('status', 1)->find($request->card_id);
            if (!$details) {
                return response()->json($this->withErrors('Card not found'));
            }
            if (!empty($details->description)) {
                $details->description = strip_tags($details->description);
            }

            if (!empty($details->guide)) {
                $details->guide = strip_tags($details->guide);
            }

            foreach ($details->services as $service) {
                $service->currency = basicControl()->base_currency;
                $service->currency_symbol = basicControl()->currency_symbol;
                $service->discountedAmount = $service->getDiscount();
                $service->discountedPriceWithoutDiscount = $service->price - $service->discountedAmount;

                if (isset($service->campaign_data)) {
                    $service->campaign_data->currency = basicControl()->base_currency;
                    $service->campaign_data->currency_symbol = basicControl()->currency_symbol;
                }
            }

            $details->product_image = getFile($details->image->image_driver, $details->image->image);

            $data['reviewStatic'] = $this->getTopReview(Card::class, $details->id);
            $data['details'] = $details->makeHidden(['card_detail_route', 'image']);

            $data['gateways'] = Gateway::where('status', 1)->get()->map(function ($gateway) {
                $gateway->image = getFile($gateway->driver, $gateway->image);
                unset($gateway->driver);
                return $gateway;
            });


            return response()->json($this->withSuccess($data));
        } catch (\Exception $e) {
            return response()->json($this->withErrors('Something went wrong'));
        }
    }



    public function cardServices(Request $request)
    {
        try {
            $cardId = $request->card_id;

            $data['services'] = CardService::where('status', 1)
                ->when($cardId, function ($query, $cardId) {
                    return $query->where('card_id', $cardId);
                })->get()->makeHidden(['image', 'image_driver']);

            return response()->json($this->withSuccess($data));
        } catch (\Exception $e) {
            return response()->json($this->withErrors('Something went wrong'));
        }
    }

    public function cardReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($this->withErrors(collect($validator->errors())->collapse()));
        }

        try {
            $reviews = Review::has('user')
                ->with(['user:id,firstname,lastname,image,image_driver'])
                ->where('status', 1)
                ->where('reviewable_type', Card::class)
                ->where('reviewable_id', $request->card_id)
                ->paginate(basicControl()->user_pagination);

            $reviews->getCollection()->transform(function ($review) {
                $review->user->imgPath = getFile($review->user->image_driver, $review->user->image);
                return $review->makeHidden(['reviewable_type', 'reviewable_id']);
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

    public function cardReviewPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_id' => 'required',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required|string|max:200',
        ]);
        if ($validator->fails()) {
            return response()->json($this->withErrors(collect($validator->errors())->collapse()));
        }

        try {
            $user = $this->user($request->header('publicKey'), $request->header('SecretKey'));

            $cardId = $request->card_id;
            $card = Card::select(['id', 'status', 'name'])->where('status', 1)->find($cardId);

            if (!$card) {
                return response()->json($this->withErrors('Data not found'));
            }

            $isHasOrder = OrderDetail::with(["detailable" => function ($query) use ($cardId) {
                $query->whereHas('card', function ($q) use ($cardId) {
                    $q->where('id', $cardId);
                });
            }])
                ->whereHas('order', function ($qq) {
                    $qq->where('payment_status', 1);
                })
                ->where('user_id', $user->id)
                ->where('detailable_type', CardService::class)
                ->exists();

            if ($isHasOrder) {
                Review::updateOrCreate([
                    'reviewable_type' => Card::class,
                    'reviewable_id' => $cardId,
                    'user_id' => $user->id,
                ], [
                    'rating' => $request->rating,
                    'comment' => $request->comment,
                ]);

                $this->reviewNotifyToAdmin($user, $card->name, $request->rating);
                return response()->json($this->withSuccess('Review Added Successfully'));
            }

            return response()->json($this->withErrors('You are not eligible for review'));
        } catch (\Exception $e) {
            return response()->json($this->withErrors('Something went wrong'));
        }
    }
}
