<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\Card;
use App\Models\CardService;
use App\Models\Deposit;
use App\Models\Order;
use App\Models\TopUp;
use App\Models\TopUpService;
use App\Traits\ApiPayment;
use App\Traits\ApiValidation;
use App\Traits\MakeOrder;
use App\Traits\Rating;
use App\Traits\Upload;
use App\Models\Category;
use App\Models\Gateway;
use Facades\App\Services\BasicService;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ShopController extends Controller
{
    use ApiValidation, Upload, ApiPayment, Rating, MakeOrder;

    public function addFund(Request $request)
    {
        $rules = [
            'amount' => 'required',
            'gateway' => 'required', 'numeric',
            'selectedCurrency' => 'required',
        ];

        $message = [
            'gateway.required' => 'Please select a gateway',
            'selectedCurrency.required' => 'Please select a currency',
        ];

        $validate = Validator::make($request->all(), $rules, $message);

        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        $checkAmountValidate = $this->validationCheck($request->amount, $request->gateway, $request->selectedCurrency);

        if (!$checkAmountValidate['status']) {
            return response()->json($this->withErrors($checkAmountValidate['message']));
        }

        $deposit = Deposit::create([
            'user_id' => auth()->id(),
            'payment_method_id' => $checkAmountValidate['gateway_id'],
            'payment_method_currency' => $checkAmountValidate['currency'],
            'amount' => $checkAmountValidate['amount'],
            'percentage_charge' => $checkAmountValidate['percentage_charge'],
            'fixed_charge' => $checkAmountValidate['fixed_charge'],
            'payable_amount' => $checkAmountValidate['payable_amount'],
            'amount_in_base' => $checkAmountValidate['payable_amount_baseCurrency'],
            'charge_base_currency' => $checkAmountValidate['charge_baseCurrency'],
            'status' => 0,
        ]);

        $val['trxId'] = $deposit->trx_id;
        return response()->json($this->withSuccess($val));
    }

    public function topUpList(Request $request)
    {
        $basic = basicControl();

        $topUp = $basic->top_up
            ? TopUp::query()->with(['services'])->whereStatus(1)->get()
            : collect();

        if ($request->has('sortByCategory') || $request->has('search') || $request->has('category_id')) {
            if ($request->filled('sortByCategory')) {
                $category = (int)$request->sortByCategory;
                $topUp = $topUp->filter(function ($item) use ($category) {
                    return $item->category_id == $category;
                });
            }

            if ($request->has('search')) {
                $search = strtolower($request->search);
                $topUp = $topUp->filter(function ($item) use ($search) {
                    return str_contains(strtolower($item->name), $search);
                });
            }
            if ($request->has('sort_by')) {
                $topUp = $topUp->when($request->has('sort_by') && !empty($request->sort_by), function ($query) use ($request) {
                    if ($request->sort_by == 'all') {
                        $query->orderBy('sort_by', 'desc');
                    } elseif ($request->sort_by == 'top_rated') {
                        $query->orderBy('avg_rating', 'desc');
                    } elseif ($request->sort_by == 'desc') {
                        $query->latest();
                    } elseif ($request->sort_by == 'asc') {
                        $query->orderBy('created_at', 'asc');
                    }
                });
            }

            if ($request->has('offered')) {
                $offered = (int)$request->offered;
                $topUp = $topUp->filter(function ($item) use ($offered) {
                    return $item->services->contains(fn($service) => $service->offered_sell == $offered);
                });
            }

            if ($request->filled('category_id')) {
                $category = (int)$request->category_id;

                $topUp = $topUp->filter(function ($item) use ($category) {
                    return $item->category_id == $category;
                });
            }
        }

        $perPage = config(basicControl()->paginate, 10);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $totalItems = $topUp->count();

        $paginatedItems = new LengthAwarePaginator(
            $topUp->forPage($currentPage, $perPage),
            $totalItems,
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        $data = [
            "current_page" => $paginatedItems->currentPage(),
            "items" => array_values($paginatedItems->items()),
            "first_page_url" => $paginatedItems->url(1),
            "from" => ($currentPage - 1) * $perPage + 1,
            "last_page" => $paginatedItems->lastPage(),
            "last_page_url" => $paginatedItems->url($paginatedItems->lastPage()),
            "links" => $paginatedItems->linkCollection(),
            "next_page_url" => $paginatedItems->nextPageUrl(),
            "path" => $paginatedItems->path(),
            "per_page" => $perPage,
            "prev_page_url" => $paginatedItems->previousPageUrl(),
            "to" => min($currentPage * $perPage, $totalItems),
            "total" => $totalItems
        ];

        return response()->json($this->withSuccess($data));
    }

    public function topUpCategories(Request $request)
    {
        try {
            $data['categories'] = Category::query()->where('status', 1)->where('type', 'top_up')->get();

            return response()->json($this->withSuccess($data));
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function topUpDetails(Request $request)
    {
        try {
            $slug = $request->query('slug');

            if (!$slug) {
                return response()->json($this->withErrors('Slug is required.'));
            }

            $topUp = TopUp::with('activeServices')
                ->where('status', 1)
                ->where('slug', $slug)
                ->firstOrFail();

            if (!empty($topUp->order_information)) {
                $topUp->order_information = array_values((array)$topUp->order_information);
            }

            if (!empty($topUp->description)) {
                $topUp->description = strip_tags($topUp->description);
            }

            if (!empty($topUp->guide)) {
                $topUp->guide = strip_tags($topUp->guide);
            }

            foreach ($topUp->activeServices as $service) {
                $service->currency = basicControl()->base_currency;
                $service->currency_symbol = basicControl()->currency_symbol;
                $service->discountedAmount = $service->getDiscount();
                $service->discountedPriceWithoutDiscount = $service->price - $service->discountedAmount;

                if (isset($service->campaign_data)) {
                    $service->campaign_data->currency = basicControl()->base_currency;
                    $service->campaign_data->currency_symbol = basicControl()->currency_symbol;
                }
            }

            $reviewStatic = $this->getTopReview(TopUp::class, $topUp->id);

            $gateways = Gateway::where('status', 1)
                ->orderBy('sort_by')
                ->get()
                ->map(function ($gateway) {
                    $gateway->image = getFile($gateway->driver, $gateway->image);
                    return $gateway;
                });

            return response()->json($this->withSuccess([
                'topUp' => $topUp,
                'reviewStatic' => $reviewStatic,
                'gateways' => $gateways,
            ]));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json($this->withErrors('Top-up not found.'), 404);
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()), 500);
        }
    }

    public function topUpOrder(Request $request)
    {
        $rules = [
            'topUpId' => ['required', 'numeric'],
            'serviceId' => ['required', 'numeric'],
        ];

        $message = [
            'serviceId.required' => 'Please select a recharge option',
        ];

        $validate = Validator::make($request->all(), $rules, $message);

        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        try {
            $service = TopUpService::whereHas('topUp', function ($query) {
                $query->where('status', 1);
            })->where('status', 1)->findOrFail($request->serviceId);
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

            $validate = Validator::make($request->all(), $rules, $message);
            if ($validate->fails()) {
                return response()->json($this->withErrors(collect($validate->errors())->collapse()));
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

            $order = $this->orderCreate(showActualPrice($service), 'topup', $info);
            $this->orderDetailsCreate($order, $service, TopUpService::class);


            return response()->json($this->withSuccess(['utr' => $order->utr]));
        } catch (\Exception $e) {
            return response()->json($this->withErrors('Something went wrong'));
        }
    }

    public function topUpMakePayment(Request $request)
    {
        $rules = [
            'gateway_id' => ['nullable', 'numeric'],
            'supported_currency' => 'nullable',
        ];

        $message = [
            'gateway_id.required' => 'Please select a gateway',
        ];

        $validate = Validator::make($request->all(), $rules, $message);

        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        DB::beginTransaction();
        try {
            $order = Order::where('utr', $request->utr)->first();
            if (!$order) {
                return response()->json($this->withErrors('Order not found.'));
            }

            if ($order->amount > 0) {
                if (isset($request->gateway_id) && $request->gateway_id == '-1') {

                    $payByWallet = $this->payByWallet($order);

                    if (!$payByWallet['status']) {
                        return response()->json($this->withErrors($payByWallet['message']));
                    }
                    DB::commit();
                    return response()->json($this->withSuccess(['Order has been placed successfully']));
                }

                $gateway = Gateway::select(['id', 'status'])->where('status', 1)->find($request->gateway_id);
                if (!$gateway) {
                    return response()->json($this->withErrors('Gateway not found.'));
                }
                $checkAmountValidate = $this->validationCheck($order->amount, $gateway->id, $request->supported_currency, null, 'yes');

                if (!$checkAmountValidate['status']) {
                    return response()->json($this->withErrors($checkAmountValidate['message']));
                }

                $deposit = $this->depositCreate($checkAmountValidate, Order::class, $order->id);
                DB::commit();
                return response()->json($this->withSuccess(['id' => $deposit->id]));
            } else {
                return response()->json($this->withErrors('Unable to processed order'));
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($this->withErrors('Something went wrong'));
        }
    }

    public function cardOrder(Request $request)
    {
        $rules = [
            'serviceIds' => ['required'],
            'quantity' => ['required'],
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        try {
            $services = CardService::whereHas('card', function ($query) {
                $query->where('status', 1);
            })->where('status', 1)->whereIn('id', $request->serviceIds)->get();

            $totalAmount = 0;
            if (!empty($services)) {
                foreach ($services as $key => $service) {
                    $totalAmount += (showActualPrice($service) * $request->quantity[$key]);
                }
            }

            $order = $this->orderCreate($totalAmount, 'card', null, 'API', auth()->user());

            $this->orderDetailsCreate($order, $services, CardService::class, $request->quantity);

            return response()->json($this->withSuccess(['utr' => $order->utr]));

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($this->withErrors('Something went wrong'));
        }
    }

    public function cardMakePayment(Request $request)
    {
        $rules = [
            'utr' => ['required'],
            'gateway_id' => ['nullable', 'numeric'],
            'selectedCurrency' => 'nullable',
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        DB::beginTransaction();
        try {

            $order = Order::where('utr', $request->utr)->first();
            if (!$order) {
                return response()->json($this->withErrors('Order not found.'));
            }

            if ($order->amount > 0) {
                if (isset($request->gateway_id) && $request->gateway_id == '-1') {
                    $payByWallet = $this->payByWallet($order);
                    if (!$payByWallet['status']) {
                        return response()->json($this->withErrors($payByWallet['message']));
                    }

                    DB::commit();
                    return response()->json($this->withSuccess(['Order has been placed successfully']));
                }

                $gateway = Gateway::select(['id', 'status'])->where('status', 1)->findOrFail($request->gateway_id);
                if (!$gateway) {
                    return response()->json($this->withErrors('Gateway not found.'));
                }

                $checkAmountValidate = $this->validationCheck($order->amount, $gateway->id, $request->supported_currency, null, 'yes');

                if (!$checkAmountValidate['status']) {
                    return response()->json($this->withErrors($checkAmountValidate['message']));
                }

                $deposit = $this->depositCreate($checkAmountValidate, Order::class, $order->id);
                DB::commit();
                return response()->json($this->withSuccess(['id' => $deposit->id]));
            } else {
                return response()->json($this->withErrors('Unable to processed order'));
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($this->withErrors('Something went wrong'));
        }
    }

}
