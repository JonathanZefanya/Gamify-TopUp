<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\CardService;
use App\Models\Category;
use App\Models\Gateway;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Review;
use App\Traits\MakeOrder;
use App\Traits\PaymentValidationCheck;
use App\Traits\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    use MakeOrder, PaymentValidationCheck, Rating;

    protected $theme;

    public function __construct()
    {
        $this->theme = template();
    }

    public function cardList(Request $request)
    {
        $data['categories'] = Category::type('card')->active()->sort()
            ->withCount(['cards as active_children' => function ($q) {
                $q->where('status', 1)->whereHas('activeServices');
            }])
            ->get(['id', 'name', 'icon', 'type', 'status', 'sort_by']);

        $data['cards'] = Card::select(['id', 'category_id', 'region', 'status',
            'name', 'slug', 'image', 'total_review', 'avg_rating', 'sell_count'])
            ->where('status', 1)
            ->when(isset($request->category) && !empty($request->category), function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })
            ->when(isset($request->filter) && !empty($request->filter), function ($query) use ($request) {
                if ($request->filter == 'all') {
                    $query->orderBy('sort_by', 'desc');
                } elseif ($request->filter == '1') {
                    $query->orderBy('sell_count', 'desc');
                } elseif ($request->filter == '2') {
                    $query->latest();
                } elseif ($request->filter == '3') {
                    $query->where('trending', 1);
                } elseif ($request->filter == '4') {
                    $query->orderBy('created_at', 'asc');
                }
            })
            ->whereHas('activeServices')
            ->paginate(10);

        return view(template() . 'frontend.card.index', $data);
    }

    public function getCard(Request $request)
    {
        $offset = request()->get('offset', 0);
        $limit = request()->get('limit', 6);

        if (!$request->catId) {
            $data['categories'] = Category::type('card')->active()->sort()
                ->withCount(['cards as active_children' => function ($q) {
                    $q->where('status', 1)->whereHas('activeServices');
                }])
                ->get(['id', 'name', 'icon', 'type', 'status', 'sort_by']);
        }

        $data['cards'] = Card::select(['id', 'category_id', 'region', 'status',
            'name', 'slug', 'image', 'total_review', 'avg_rating'])
            ->where('status', 1)
            ->when(isset($request->catId), function ($query) use ($request) {
                return $query->where('category_id', $request->catId);
            })
            ->whereHas('activeServices')
            ->skip($offset)
            ->take($limit)
            ->get();

        return response()->json($data, 200);
    }

    public function cardDetails($slug = null)
    {
        $data['card'] = Card::with(['activeServices', 'activeServices.activeCodes'])->where(['status' => 1, 'slug' => $slug])->firstOrFail();

        $data['relatedCards'] = Card::select(['id', 'name', 'status', 'image', 'region', 'slug'])->where('id', '!=', $data['card']->id)
            ->where('status', 1)->where('name', 'LIKE', '%' . $data['card']->name . '%')->take(6)->get();

        $data['otherCards'] = Card::select(['id', 'name', 'status', 'image', 'region', 'slug'])
            ->where('id', '!=', $data['card']->id)->where('status', 1)->take(6)->get();

        $data['reviewStatic'] = $this->getTopReview(Card::class, $data['card']->id);

        return view($this->theme . 'frontend.card.details', $data);
    }

    public function singleOrder(Request $request)
    {
        $service = CardService::where('status', 1)->find($request->serviceId);

        if (!$service) {
            return response()->json(['status' => false, 'message' => 'Service not found']);
        }

        DB::beginTransaction();
        try {
            $quantity = $request->quantity;
            $totalAmount = showActualPrice($service) * $quantity;
            $quantities[$service->id] = $quantity;

            $order = $this->orderCreate($totalAmount, 'card');
            $this->orderDetailsCreate($order, $service, CardService::class, $quantities);
            DB::commit();

            return response()->json(['status' => true, 'route' => route('card.user.order', ['utr' => $order->utr])]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Something went wrong']);
        }
    }

    public function buy(Request $request)
    {
        DB::beginTransaction();
        try {
            $cartItems = session()->get('cart');

            $ids = [];
            $quantities = [];
            if (!empty($cartItems)) {
                foreach ($cartItems as $cart) {
                    $ids[] = $cart['id'];
                    $quantities[$cart['id']] = $cart['quantity'];
                }
            }

            $services = CardService::whereHas('card', function ($query) {
                $query->where('status', 1);
            })->where('status', 1)->whereIn('id', $ids)->get();

            $totalAmount = 0;
            if (!empty($services)) {
                foreach ($services as $service) {
                    if (isset($quantities[$service->id])) {
                        $totalAmount += (showActualPrice($service) * $quantities[$service->id]);
                    }
                }
            }

            $order = $this->orderCreate($totalAmount, 'card');

            $this->orderDetailsCreate($order, $services, CardService::class, $quantities);
            DB::commit();

            return redirect()->route('card.user.order', ['utr' => $order->utr]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }
    }


    public function order(Request $request)
    {
        $order = Order::select(['id', 'amount', 'payment_status', 'status',
            'order_for', 'utr', 'created_at', 'user_id', 'discount'])
            ->where(['utr' => $request->utr, 'payment_status' => 0, 'status' => 0, 'order_for' => 'card'])->firstOrFail();

        if ($request->method() == 'GET') {
            $gateways = Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get();
            return view(template() . 'frontend.card.order', compact('order', 'gateways'));
        } elseif ($request->method() == 'POST') {
            if ($order->amount > 0) {
                if (isset($request->gateway_id) && $request->gateway_id == '-1') {
                    $payByWallet = $this->payByWallet($order);
                    if (!$payByWallet['status']) {
                        return back()->with('error', $payByWallet['message']);
                    }

                    return redirect()->route('user.cardOrder', ['type' => 'all'])
                        ->with('success', 'Order has been placed successfully');
                }
                $validationRules = [
                    'gateway_id' => 'required|integer|min:1',
                    'supported_currency' => 'required',
                ];

                $validate = Validator::make($request->all(), $validationRules);
                if ($validate->fails()) {
                    return back()->withErrors($validate)->withInput();
                }

                $gateway = Gateway::select(['id', 'status'])->where('status', 1)->findOrFail($request->gateway_id);
                $checkAmountValidate = $this->validationCheck($order->amount, $gateway->id, $request->supported_currency, null, 'yes');

                if (!$checkAmountValidate['status']) {
                    return back()->with('error', $checkAmountValidate['message']);
                }

                $deposit = $this->depositCreate($checkAmountValidate, Order::class, $order->id);
                session()->forget('cart');
                return redirect(route('payment.process', $deposit->trx_id));
            } else {
                return back()->with('error', 'Unable to processed order');
            }
        }
    }

    public function addReview(Request $request)
    {
        $this->validate($request, [
            'cardId' => 'required',
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required|string|max:200',
        ]);

        try {
            $cardId = $request->cardId;
            $card = Card::select(['id', 'status', 'name'])->where('status', 1)->findOrFail($cardId);

            $isHasOrder = OrderDetail::with(["detailable" => function ($query) use ($cardId) {
                $query->whereHas('card', function ($q) use ($cardId) {
                    $q->where('id', $cardId);
                });
            }])
                ->whereHas('order', function ($qq) {
                    $qq->where('payment_status', 1);
                })
                ->where('user_id', auth()->id())
                ->where('detailable_type', CardService::class)
                ->exists();

            if ($isHasOrder) {
                Review::updateOrCreate([
                    'reviewable_type' => Card::class,
                    'reviewable_id' => $cardId,
                    'user_id' => auth()->id(),
                ], [
                    'rating' => $request->rating,
                    'comment' => $request->comment,
                ]);

                $this->reviewNotifyToAdmin(auth()->user(), $card->name, $request->rating);
                return back()->with('success', 'Review Added Successfully');
            }
            return back()->with('error', 'You are not eligible for review');
        } catch (\Exception $e) {
            return back()->with('error', 'You are not eligible for review');
        }
    }

}
