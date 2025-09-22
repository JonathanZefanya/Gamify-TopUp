<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\UserTrackingJob;
use App\Models\Campaign;
use App\Models\CardService;
use App\Models\Category;
use App\Models\ContentDetails;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\Language;
use App\Models\Order;
use App\Models\Payout;
use App\Models\SellPost;
use App\Models\SellPostOffer;
use App\Models\SellPostPayment;
use App\Models\SupportTicket;
use App\Models\TopUp;
use App\Models\TopUpService;
use App\Models\Transaction;
use App\Traits\ApiValidation;
use App\Traits\MakeOrder;
use App\Traits\Notify;
use App\Traits\PaymentValidationCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    use ApiValidation, Notify;

    public function language(Request $request)
    {
        try {
            if (!$request->id) {
                $data['languages'] = Language::select(['id', 'name', 'short_name'])->where('status', 1)->get();
                return response()->json($this->withSuccess($data));
            }
            $lang = Language::where('status', 1)->find($request->id);
            if (!$lang) {
                return response()->json($this->withErrors('Record not found'));
            }

            $json = file_get_contents(resource_path('lang/') . $lang->short_name . '.json');
            if (empty($json)) {
                return response()->json($this->withErrors('File Not Found.'));
            }

            $json = json_decode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return response()->json($this->withSuccess($json));
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function appConfig()
    {
        try {
            $basic = basicControl();
            $data['baseColor'] = $basic['app_color'];
            $data['version'] = $basic['app_version'];
            $data['appBuild'] = $basic['app_build'];
            $data['isMajor'] = $basic['is_major'];
            $data['paymentSuccessUrl'] = route('success');
            $data['paymentFailedUrl'] = route('failed');

            $data['top_up_module'] = $basic['top_up'] ? 'on' : 'off';
            $data['card_module'] = $basic['card'] ? 'on' : 'off';
            $data['sell_post_module'] = $basic['sell_post'] ? 'on' : 'off';

            return response()->json($this->withSuccess($data));
        } catch (\Exception $exception) {
            return response()->json($this->withErrors($exception->getMessage()));
        }
    }

    public function transaction()
    {
        $basic = basicControl();
        try {
            $array = [];
            $transactions = tap(auth()->user()->transaction()->orderBy('id', 'DESC')
                ->paginate($basic->paginate), function ($paginatedInstance) use ($array, $basic) {
                return $paginatedInstance->getCollection()->transform(function ($query) use ($array, $basic) {
                    if ($query->transactional_type == \App\Models\Deposit::class){
                        $type = 'deposit';
                    }elseif ($query->transactional_type == \App\Models\Order::class){
                        $type = 'order';
                    }elseif ($query->transactional_type == \App\Models\Payout::class){
                        $type = 'payout';
                    }elseif ($query->transactional_type == \App\Models\SellPostPayment::class){
                        $type = 'Sell Post';
                    }else{
                        $type = '-';
                    }

                    $array['transactionId'] = $query->trx_id ?? null;
                    $array['color'] = ($query->trx_type == '+') ? 'success' : 'danger';
                    $array['amount'] = $query->amount_in_base;
                    $array['remarks'] = $query->remarks ?? null;
                    $array['trx_type'] = $query->trx_type;
                    $array['type'] = $type;
                    $array['currency'] = basicControl()->base_currency;
                    $array['currency_symbol'] = basicControl()->currency_symbol;



                    $array['time'] = $query->created_at ?? null;
                    return $array;
                });
            });

            if ($transactions) {
                return response()->json($this->withSuccess($transactions));
            } else {
                return response()->json($this->withErrors('No data found'));
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function campaign()
    {
        $data['campaign'] = Campaign::firstOrNew();
        $data['trendingTopUpServices'] = TopUpService::has('topUp')->with(['topUp:id,slug,avg_rating,total_review'])
            ->where('status', 1)
            ->where('is_offered', 1)->orderBy('sort_by', 'ASC')->get();

        return response()->json($this->withSuccess($data));
    }

    public function transactionSearch(Request $request)
    {
        $basic = basicControl();
        $search = $request->all();
        $dateSearch = $request->datetrx;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        try {
            $array = [];
            $transactions = tap(Transaction::where('user_id', auth()->id())->with('user')
                ->when(@$search['transaction_id'], function ($query) use ($search) {
                    return $query->where('trx_id', 'LIKE', "%{$search['transaction_id']}%");
                })
                ->when(@$search['remark'], function ($query) use ($search) {
                    return $query->where('remarks', 'LIKE', "%{$search['remark']}%");
                })
                ->when($date == 1, function ($query) use ($dateSearch) {
                    return $query->whereDate("created_at", $dateSearch);
                })
                ->orderBy('id', 'DESC')
                ->paginate(basicControl()->paginate), function ($paginatedInstance) use ($array, $basic) {
                return $paginatedInstance->getCollection()->transform(function ($query) use ($array, $basic) {
                    if ($query->transactional_type == \App\Models\Deposit::class){
                        $type = 'deposit';
                    }elseif ($query->transactional_type == \App\Models\Order::class){
                        $type = 'order';
                    }elseif ($query->transactional_type == \App\Models\Payout::class){
                        $type = 'payout';
                    }elseif ($query->transactional_type == \App\Models\SellPostPayment::class){
                        $type = 'Sell Post';
                    }else{
                        $type = '-';
                    }
                    $array['transactionId'] = $query->trx_id ?? null;
                    $array['color'] = ($query->trx_type == '+') ? 'success' : 'danger';
                    $array['amount'] = $query->amount_in_base  ?? null;
                    $array['remarks'] = $query->remarks ?? null;
                    $array['time'] = $query->created_at ?? null;
                    $array['trx_type'] = $query->trx_type;
                    $array['type'] = $type;
                    $array['currency'] = basicControl()->base_currency;
                    $array['currency_symbol'] = basicControl()->currency_symbol;

                    return $array;
                });
            });

            if ($transactions) {
                return response()->json($this->withSuccess($transactions));
            } else {
                return response()->json($this->withErrors('No data found'));
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function paymentHistory()
    {
        $basic = basicControl();
        try {
            $array = [];
            $funds = tap(Deposit::query()->where('user_id', auth()->id())->where('status', '!=', 0)->orderBy('id', 'DESC')
                ->with('gateway')
                ->latest()
                ->paginate($basic->paginate), function ($paginatedInstance) use ($array, $basic) {
                    return $paginatedInstance->getCollection()->transform(function ($query) use ($array, $basic) {
                        $array['transactionId'] = $query->trx_id ?? null;
                        $array['gateway'] = optional($query->gateway)->name ?? null;
                        $array['gatewayimage'] = getFile($query->gateway->driver, $query->gateway->image) ?? null;
                        $array['currency_symbol'] = basicControl()->currency_symbol ?? null;
                        $array['currency'] = basicControl()->base_currency ?? null;
                        $array['amount'] = $query->amount_in_base;
                        $array['status'] = match ($query->status) {
                            1 => 'Successful',
                            2 => 'Pending',
                            3 => 'Rejected',
                            default => 'Unknown',
                        };
                        $array['time'] = $query->created_at;
                        return $array;
                    });
                });

            if ($funds) {
                return response()->json($this->withSuccess($funds));
            } else {
                return response()->json($this->withErrors('No data found'));
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function paymentHistorySearch(Request $request)
    {
        $basic = basicControl();
        $search = $request->all();

        $dateSearch = $request->date_time;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        try {
            $array = [];
            $funds = tap(Deposit::query()->where('user_id', auth()->id())->where('status', '!=', 0)
                ->when(isset($search['name']), function ($query) use ($search) {
                    return $query->where('trx_id', 'LIKE', $search['name']);
                })
                ->when($date == 1, function ($query) use ($dateSearch) {
                    return $query->whereDate("created_at", $dateSearch);
                })
                ->when(isset($search['status']), function ($query) use ($search) {
                    return $query->where('status', $search['status']);
                })
                ->with('gateway')
                ->latest()
                ->paginate($basic->paginate), function ($paginatedInstance) use ($array, $basic) {
                return $paginatedInstance->getCollection()->transform(function ($query) use ($array, $basic) {
                    $array['transactionId'] = $query->trx_id ?? null;
                    $array['gateway'] = optional($query->gateway)->name ?? null;
                    $array['gatewayimage'] = getFile($query->gateway->driver, $query->gateway->image) ?? null;
                    $array['currency_symbol'] = basicControl()->currency_symbol ?? null;
                    $array['currency'] = basicControl()->base_currency ?? null;
                    $array['amount'] = $query->amount_in_base;
                    $array['status'] = match ($query->status) {
                        1 => 'Successful',
                        2 => 'Pending',
                        3 => 'Rejected',
                        default => 'Unknown',
                    };
                    $array['time'] = $query->created_at;
                    return $array;
                });
            });

            if ($funds) {
                return response()->json($this->withSuccess($funds));
            } else {
                return response()->json($this->withErrors('No data found'));
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function payoutHistory()
    {
        $basic = basicControl();
        try {
            $array = [];
            $payoutLogs = tap(Payout::whereUser_id(auth()->id())->where('status', '!=', 0)->latest()
                ->with('user', 'method')
                ->paginate(basicControl()->paginate), function ($paginatedInstance) use ($array, $basic) {
                return $paginatedInstance->getCollection()->transform(function ($query) use ($array, $basic) {
                    $array['transactionId'] = $query->trx_id ?? null;
                    $array['gateway'] = getFile(optional($query->method)->driver, optional($query->method)->logo)  ?? null;
                    $array['gatewayImage'] = optional($query->method)->name ?? null;
                    $array['amount'] = getAmount($query->amount, $basic->fraction_number);
                    $array['payoutCurrency'] = $query->payout_currency_code;
                    $array['amountInBase'] = currencyPosition($query->amount_in_base_currency);
                    $array['currency'] = $basic->base_currency ?? null;
                    $array['symbol'] = $basic->currency_symbol ?? null;
                    $array['status'] = ($query->status == 1) ? 'Pending' : (($query->status == 2) ? 'Complete' : 'Cancel');
                    $array['time'] = $query->created_at ?? null;
                    $array['adminFeedback'] = $query->feedback ?? null;
                    $array['paymentInformation'] = [];
                    if ($query->information) {
                        foreach ($query->information as $key => $info) {
                            if ($info->type == 'file') {
                                $array['paymentInformation'][$key] = getFile($info->field_driver, $info->field_value);
                            } else {
                                $array['paymentInformation'][$key] = $info->field_value ?? $info->field_name;
                            }
                        }
                    }
                    return $array;
                });
            });

            if ($payoutLogs) {
                return response()->json($this->withSuccess($payoutLogs));
            } else {
                return response()->json($this->withErrors('No data found'));
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function payoutHistorySearch(Request $request)
    {
        $basic = basicControl();
        $search = $request->all();

        $dateSearch = $request->date_time;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        try {
            $array = [];
            $payoutLogs = tap(Payout::orderBy('id', 'DESC')->where('user_id', auth()->id())
                ->where('status', '!=', 0)
                ->when(isset($search['name']), function ($query) use ($search) {
                    return $query->where('trx_id', 'LIKE', $search['name']);
                })
                ->when($date == 1, function ($query) use ($dateSearch) {
                    return $query->whereDate("created_at", $dateSearch);
                })
                ->when(isset($search['status']), function ($query) use ($search) {
                    return $query->where('status', $search['status']);
                })
                ->with('user', 'method')
                ->paginate($basic->paginate), function ($paginatedInstance) use ($array, $basic) {
                return $paginatedInstance->getCollection()->transform(function ($query) use ($array, $basic) {
                    $array['transactionId'] = $query->trx_id ?? null;
                    $array['gatewayImage'] = getFile(optional($query->method)->driver, optional($query->method)->logo)  ?? null;
                    $array['gateway'] = optional($query->method)->name ?? null;
                    $array['amount'] = getAmount($query->amount, $basic->fraction_number) ?? 0;
                    $array['payoutCurrency'] = $query->payout_currency_code;
                    $array['amountInBase'] = currencyPosition($query->amount_in_base_currency);
                    $array['currency'] = $basic->base_currency ?? null;
                    $array['symbol'] = $basic->currency_symbol ?? null;
                    $array['status'] = ($query->status == 1) ? 'Pending' : (($query->status == 2) ? 'Complete' : 'Cancel');
                    $array['time'] = $query->created_at ?? null;
                    $array['adminFeedback'] = $query->feedback ?? null;
                    $array['paymentInformation'] = [];
                    if ($query->information) {
                        foreach ($query->information as $key => $info) {
                            if ($info->type == 'file') {
                                $array['paymentInformation'][$key] = getFile($info->field_driver, $info->field_value);
                            } else {
                                $array['paymentInformation'][$key] = $info->field_value ?? $info->field_name;
                            }
                        }
                    }
                    return $array;
                });
            });

            if ($payoutLogs) {
                return response()->json($this->withSuccess($payoutLogs));
            } else {
                return response()->json($this->withErrors('No data found'));
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function paymentView($deposit_id)
    {
        $deposit = Deposit::latest()->find($deposit_id);
        try {
            if ($deposit) {
                $getwayObj = 'App\\Services\\Gateway\\' . $deposit->gateway->code . '\\Payment';
                $data = $getwayObj::prepareData($deposit, $deposit->gateway);
                $data = json_decode($data);

                if (isset($data->error)) {
                    $result['status'] = false;
                    $result['message'] = $data->message;
                    return response($result, 200);
                }

                if (isset($data->redirect)) {
                    return redirect($data->redirect_url);
                }

                if ($data->view) {
                    $parts = explode(".", $data->view);
                    $desiredValue = end($parts);
                    $newView = 'mobile-payment.' . $desiredValue;
                    return view($newView, compact('data', 'deposit'));
                }

                abort(404);
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function getGateways()
    {
        $gateways = Gateway::where('status', 1)->get()->map(function ($query) {
            $query->image = getFile($query->driver, $query->image );
            if ($query->id < 1000) {
                $query->makeHidden(['extra_parameters']);
            }
            return $query;
        });

        $data['gateways'] = $gateways;
        return response()->json($this->withSuccess($data));
    }

    public function pusherConfig()
    {
        try {
            $data['apiKey'] = env('PUSHER_APP_KEY');
            $data['cluster'] = env('PUSHER_APP_CLUSTER');
            $data['channel'] = 'user-notification.' . Auth::id();
            $data['event'] = 'UserNotification';

            $data['chattingChannel'] = 'offer-chat-notification.' . Auth::id();

            return response()->json($this->withSuccess($data));
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function dashboard()
    {
        $banner = ContentDetails::whereHas('content', function ($query) {
            $query->where('name', 'app_page');
        })->first();

        if ($banner) {
            $data['banner'] = $banner->description;
            $data['banner']->image = getFile(@$banner->content->media->image->driver, @$banner->content->media->image->path);
        }

        $user = auth()->user();
        $basic = basicControl();
        $data['orderInfo'] = Order::payment()->own()
            ->selectRaw('COUNT(CASE WHEN order_for = "topup" THEN id END) AS totalTopUpOrder')
            ->selectRaw('COUNT(CASE WHEN order_for = "card" THEN id END) AS totalCardOrder')
            ->first();

        $data['baseCurrency'] = $basic->base_currency;
        $data['baseCurrencySymbol'] = $basic->currency_symbol;
        $data['walletBalance'] = $user->balance;
        $data['sellingPost'] = SellPost::tobase()->where('user_id', $user->id)->where('status', 1)->count();
        $data['soldPost'] = SellPost::tobase()->where('user_id', $user->id)->where('status', 1)->where('payment_status', 1)->count();
        $data['buyPost'] = SellPostPayment::tobase()->where('user_id', $user->id)->where('payment_status', 1)->count();
        $data['supportTickets'] = SupportTicket::tobase()->where('user_id', $user->id)->count();
        $data['payoutBalance'] = Payout::tobase()->where('user_id', $user->id)->where('status', 2)->sum('amount_in_base_currency');
        $data['myProposal'] = SellPostOffer::tobase()->where('user_id', $user->id)->count();


        $data['upcoming'] = collect(SellPostPayment::where('payment_status', 1)->where('payment_release', 0)
            ->selectRaw('SUM(price) as upComingAmount')
            ->selectRaw('COUNT(id) AS upComingPayment')
            ->get()->toArray())->collapse();

        return response()->json($this->withSuccess($data));
    }

    public function getCategory()
    {
        try {
            $data['categories'] = Category::active()->sort()->get()
                ->makeHidden(['status','sort_by','deleted_at','created_at','updated_at']);
            return response()->json($this->withSuccess($data));
        } catch (\Exception $e) {
            return response()->json($this->withErrors('Something went wrong'));
        }
    }

    public function getCampaign()
    {
        $data['campaign'] = Campaign::firstOrNew();

        $data['campaign']['topups'] = TopUpService::where('status',1)->where('is_offered',1)
            ->get()->makeHidden(['image','image_driver','is_offered','sort_by']);

        $data['campaign']['cards'] = CardService::where('status',1)->where('is_offered',1)
            ->get()->makeHidden(['image','image_driver','is_offered','sort_by']);

        return response()->json($this->withSuccess($data));
    }

    public function apiKey(Request $request)
    {
        $user = auth()->user();
        $public_key = $user->public_key;
        $secret_key = $user->secret_key;
        if (!$public_key || !$secret_key) {
            $user->public_key = 'pk' . bin2hex(random_bytes(20));
            $user->secret_key = 'sk' . bin2hex(random_bytes(20));
            $user->save();
        }

        return response()->json($this->withSuccess(['public_key' => $public_key, 'secret_key' => $secret_key]));
    }
    public function apiKeyUpdate(Request $request)
    {
        $user = auth()->user();
        $user->public_key = 'pk' . bin2hex(random_bytes(20));
        $user->secret_key = 'sk' . bin2hex(random_bytes(20));
        $user->save();

        $remark = 'Generated API key';
        UserTrackingJob::dispatch($user->id, request()->ip(), $remark);

        return response()->json($this->withSuccess(['Api key generated successfully']));
    }

}
