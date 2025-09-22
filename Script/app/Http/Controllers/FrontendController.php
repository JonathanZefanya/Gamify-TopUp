<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Card;
use App\Models\CardService;
use App\Models\Currency;
use App\Models\Gateway;
use App\Models\Language;
use App\Models\PageDetail;
use App\Models\SellPost;
use App\Models\SellPostCategory;
use App\Models\SellPostOffer;
use App\Models\Subscriber;
use App\Models\TopUp;
use App\Models\TopUpService;
use App\Traits\Frontend;
use App\Traits\PaymentValidationCheck;
use App\Traits\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class FrontendController extends Controller
{
    use Frontend, Rating, PaymentValidationCheck;


    public function page($slug = '/')
    {
        $selectedTheme = getTheme() ?? 'light';
        $existingSlugs = collect([]);
        DB::table('pages')->select('slug')->get()->map(function ($item) use ($existingSlugs) {
            $existingSlugs->push($item->slug);
        });
        if (!in_array($slug, $existingSlugs->toArray())) {
            abort(404);
        }
        try {
            $pageDetails = PageDetail::with(['page'])
                ->whereHas('page', function ($query) use ($slug, $selectedTheme) {
                    $query->where(['slug' => $slug, 'template_name' => $selectedTheme]);
                })->first();

            $pageSeo = [
                'page_title' => optional($pageDetails->page)->page_title,
                'meta_title' => optional($pageDetails->page)->meta_title,
                'meta_keywords' => implode(',', optional($pageDetails->page)->meta_keywords ?? []),
                'meta_description' => optional($pageDetails->page)->meta_description,
                'og_description' => optional($pageDetails->page)->og_description,
                'meta_robots' => optional($pageDetails->page)->meta_robots,
                'meta_image' => getFile(optional($pageDetails->page)->meta_image_driver, optional($pageDetails->page)->meta_image),
                'breadcrumb_image' => optional($pageDetails->page)->breadcrumb_status ?
                    getFile(optional($pageDetails->page)->breadcrumb_image_driver, optional($pageDetails->page)->breadcrumb_image) : null,
            ];

            $sectionsData = $this->getSectionsData($pageDetails->sections, $pageDetails->content, $selectedTheme);
            return view("themes.{$selectedTheme}.page", compact('sectionsData', 'pageSeo'));
        } catch (\Exception $exception) {

            \Cache::forget('ConfigureSetting');
            if ($exception->getCode() == 404) {
                abort(404);
            }
            if ($exception->getCode() == 403) {
                abort(403);
            }
            if ($exception->getCode() == 401) {
                abort(401);
            }
            if ($exception->getCode() == 503) {
                return redirect()->route('maintenance');
            }
            if ($exception->getCode() == "42S02") {
                die($exception->getMessage());
            }
            if ($exception->getCode() == 1045) {
                die("Access denied. Please check your username and password.");
            }
            if ($exception->getCode() == 1044) {
                die("Access denied to the database. Ensure your user has the necessary permissions.");
            }
            if ($exception->getCode() == 1049) {
                die("Unknown database. Please verify the database name exists and is spelled correctly.");
            }
            if ($exception->getCode() == 2002) {
                die("Unable to connect to the MySQL server. Check the database host and ensure the server is running.");
            }
            return redirect()->route('instructionPage');

        }
    }

    public function reviewList(Request $request)
    {
        $type = $request->type;
        $id = $request->id;
        if (!$type || !$id) {
            abort(404);
        }

        if ($type == 'topup') {
            $class = TopUp::class;
        } elseif ($type == 'card') {
            $class = Card::class;
        } else {
            abort(404);
        }

        $data['game'] = $class::select(['id', 'status', 'name', 'region', 'image', 'total_review', 'avg_rating'])
            ->where('status', 1)->findOrFail($id);
        $data['reviewStatic'] = $this->getAllReviews($class, $id);
        return view(template() . 'frontend.review', $data);
    }

    public function contactSend(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'con_email' => 'required|email|max:91',
            'subject' => 'required|max:100',
            'message' => 'required|max:1000',
        ]);
        $requestData = $request->except('_token', '_method');

        $name = $requestData['name'];
        $email_from = $requestData['con_email'];
        $subject = $requestData['subject'];
        $message = $requestData['message'] . "<br>Regards<br>" . $name;
        $from = $email_from;

        Mail::to(basicControl()->sender_email)->send(new SendMail($from, $subject, $message));
        return back()->with('success', 'Mail has been sent');
    }

    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|min:8|max:100|unique:subscribers',
        ]);

        $purifiedData = $request->all();
        $purifiedData = (object)$purifiedData;

        $subscribe = new Subscriber();
        $subscribe->email = $purifiedData->email;
        $subscribe->save();

        return back()->with('success', 'Subscribed successfully');
    }

    public function navSearch(Request $request)
    {
        $query = $request->input('query');

        $topUpResult = TopUp::where('name', 'LIKE', '%' . $query . '%')->where('status', 1)->get();
        foreach ($topUpResult as $topUp) {
            $topUp->typeOf = 'topUp';
            $topUp->details_route = $topUp->top_up_detail_route;
            $topUp->preview = $topUp->preview_image;
        }

        $topUpServiceResult = TopUpService::with('topUp')->where('name', 'LIKE', '%' . $query . '%')->where('status', 1)->get();
        foreach ($topUpServiceResult as $topUpSerVice) {
            $topUpSerVice->typeOf = 'topUp Service';
            $topUpSerVice->details_route = optional($topUpSerVice->topUp)->top_up_detail_route;
            $topUpSerVice->preview = $topUpSerVice->image_path;
        }

        $cardResult = Card::where('name', 'LIKE', '%' . $query . '%')->where('status', 1)->get();
        foreach ($cardResult as $card) {
            $card->typeOf = 'card';
            $card->details_route = $card->card_detail_route;
            $card->preview = $card->preview_image;
        }
        $cardServiceResult = CardService::with('card')->where('name', 'LIKE', '%' . $query . '%')->where('status', 1)->get();
        foreach ($cardServiceResult as $cardService) {
            $cardService->typeOf = 'card Service';
            $cardService->details_route = optional($cardService->card)->card_detail_route;
            $cardService->preview = $cardService->image_path;
        }
        $results = collect();

        $results = $results->merge($topUpResult)->merge($topUpServiceResult)->merge($cardResult)->merge($cardServiceResult);

        return response()->json($results);
    }

    public function sellPost(Request $request)
    {
        $data['category'] = SellPostCategory::with('details')
            ->withCount([
                'activePost' => function ($query) {
                    $query->where('payment_status', '!=', '1')->where('status', 1);
                }
            ])
            ->where('status', 1)
            ->get();

        $baseQuery = SellPost::where('status', 1)
            ->where('payment_status', '!=', 1);
        $prices = $baseQuery->pluck('price');

        $rangeMin = $prices->min() ?? 10;
        $rangeMax = $prices->max() ?? 1000;

        list($min, $max) = array_pad(explode(';', $request->my_range, 2), 2, 0);

        $data['max'] = $request->has('my_range') ? $max : $rangeMax;
        $data['min'] = $request->has('my_range') ? $min : $rangeMin;
        $data['rangeMin'] = $rangeMin;
        $data['rangeMax'] = $rangeMax;

        $data['sellPost'] = $baseQuery
            ->when($request->has('category'), function ($query) use ($request) {
                $categories = collect($request->category)->map(function ($category) {
                    return Str::of($category)->replace('-', ' ')->title();
                });

                $query->whereHas('category.details', function ($query) use ($categories) {
                    $query->where(function ($query) use ($categories) {
                        foreach ($categories as $category) {
                            $query->orWhere('name', 'like', '%' . $category . '%');
                        }
                    });
                });
            })
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
            })
            ->when($request->has('my_range'), function ($q) use ($min, $max) {
                $q->whereBetween('price', [$min, $max]);
            })
            ->when($request->has('sort'), function ($q) use ($request) {
                if ($request->sort == 'ltoh') {
                    $q->orderBy('price', 'asc');
                } elseif ($request->sort == 'htol') {
                    $q->orderBy('price', 'desc');
                } else {
                    $q->orderBy('updated_at', 'desc');
                }
            })
            ->paginate(9);

        return view(template() . 'frontend.sell_post.sell-post', $data);
    }

    public function sellPostDetails($slug = 'sell-post-details', $id)
    {
        $loginUser = SellPost::whereId($id)->pluck('user_id');

        if (Auth::check() == true && Auth::id() == $loginUser[0]) {
            $sellPost = SellPost::whereId($id)->first();
        } else {
            $sellPost = SellPost::where('id', $id)
                ->where('status', 1)
                ->first();
        }

        $data['sellPostOffer'] = SellPostOffer::has('user')->with('user')
            ->whereSell_post_id($id)->orderBy('amount', 'desc')->take(3)->get();
        $data['price'] = $sellPost->price;
        if (Auth::check()) {
            $user = Auth::user();
            $checkMyProposal = SellPostOffer::where([
                'user_id' => $user->id,
                'sell_post_id' => $sellPost->id,
                'status' => 1,
                'payment_status' => 0,
            ])->first();
            if ($checkMyProposal) {
                $data['price'] = (int)$checkMyProposal->amount;
            }
        }
        $data['sellPost'] = $sellPost;

        return view(template() . 'frontend.sell_post.sell-post-details', $data);
    }

    public function ajaxCheckSellPostCalc(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'sellPostId' => 'required',
            'gatewayId' => 'required',
            'selectedCurrency' => 'nullable|required_unless:gatewayId,0'
        ]);
        if ($validator->fails()) {
            return response($validator->messages(), 422);
        }

        $sellPostId = $request->sellPostId;
        $sellPost = SellPost::where('id', $sellPostId)
            ->where('status', 1)
            ->first();

        if (!$sellPost) {
            return response()->json(['error' => 'This post already sold or not available to sell'], 422);
        }


        $price = $sellPost->price;
        if (Auth::check()) {
            $user = Auth::user();
            $checkMyProposal = SellPostOffer::where([
                'user_id' => $user->id,
                'sell_post_id' => $sellPost->id,
                'status' => 1,
                'payment_status' => 0,
            ])->first();
            if ($checkMyProposal) {
                $price = (int)$checkMyProposal->amount;
            }
        }

        $basic = basicControl();
        $discount = 0;

        $reqAmount = $price;
        $payable = $reqAmount - $discount;

        if ($request->gatewayId == '0') {
            return [
                'amount' => getAmount($reqAmount, 2),
                'discount' => getAmount($discount, 2),
                'subtotal' => getAmount($payable, 2),
                'charge' => 0 . ' ' . $basic->base_currency,
                'payable' => getAmount($payable, 2),
                'gateway_currency' => null,
                'baseCurrency' => $basic->base_currency,
                'isCrypto' => false,
                'gatewayId' => 0,
                'in' => trans("You need to pay ") . getAmount($payable, 2) . ' ' . $basic->base_currency . ' By ' . 'Wallet',
            ];
        } else {
            $gate = Gateway::where('id', $request->gatewayId)->where('status', 1)->first();
            if (!$gate) {
                return response()->json(['error' => 'Invalid Gateway'], 422);
            }
        }

        if (1000 > $gate->id) {
            $method_currency = (checkTo($gate->currencies, $gate->currency) == 1) ? 'USD' : $gate->currency;
            $isCrypto = (checkTo($gate->currencies, $gate->currency) == 1) ? true : false;
        } else {
            $method_currency = $gate->currency;
            $isCrypto = false;
        }

        $checkAmountValidate = $this->validationCheck($payable, $gate->id, $request->selectedCurrency, null, 'yes');
        if (!$checkAmountValidate['status']) {
            return response()->json(['error' => 'This currency is not available for this transaction'], 422);
        }

        return [
            'amount' => getAmount($reqAmount, 2),
            'discount' => getAmount($discount, 2),
            'subtotal' => getAmount($checkAmountValidate['amount'], 2),
            'charge' => getAmount($checkAmountValidate['charge'], 2),
            'payable' => getAmount($checkAmountValidate['payable_amount'], 2),
            'gateway_currency' => trans($gate->currency),
            'isCrypto' => $isCrypto,
            'gatewayId' => $request->gatewayId,
            'selectedCurrency' => $checkAmountValidate['currency'],
            'baseCurrency' => $basic->base_currency,
            'in' => trans("You need to pay ") . getAmount($checkAmountValidate['payable_amount'], 2) . ' ' . $checkAmountValidate['currency'] . ' By ' . $gate->name,
        ];

    }

    public function settingChange(Request $request)
    {
        $request->validate([
            'language' => 'required|exists:languages,short_name',
            'currency' => 'sometimes|exists:currencies,id',
        ]);


        $language = Language::where('short_name', $request->language)->firstOrFail();
        Artisan::call('cache:clear');
        session()->forget(['lang', 'rtl']);
        session()->put('lang', $language->short_name);
        session()->put('rtl', $language->rtl);

        $currency = Currency::where('status', 1)->find($request->currency);
        if ($currency) {
            session()->forget(['currency_code', 'currency_symbol', 'currency_rate']);
            session()->put('currency_code', $currency->code ?? basicControl()->base_currency);
            session()->put('currency_symbol', $currency->symbol ?? basicControl()->currency_symbol);
            session()->put('currency_rate', $currency->rate ?? 1);
        }

        return back()->with('success', 'Update Successfully');
    }
}
