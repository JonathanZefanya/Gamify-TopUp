<?php

namespace App\Http\Controllers\Admin\Module;

use App\Http\Controllers\Controller;
use App\Models\GiftCardSell;
use App\Models\SellPostPayment;
use App\Models\TopUpSell;
use App\Models\VoucherSell;
use App\Traits\Notify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SellSummaryController extends Controller
{
    use Notify;

    public function postSellTran()
    {
        $data['sell'] = collect(SellPostPayment::selectRaw('COUNT(id) AS totalSell')
            ->selectRaw('COUNT(CASE WHEN payment_release = 1 THEN id END) AS releaseSell')
            ->selectRaw('(COUNT(CASE WHEN payment_release = 1 THEN id END) / COUNT(id)) * 100 AS releaseSellPercentage')
            ->selectRaw('COUNT(CASE WHEN payment_release = 0 THEN id END) AS upcomingSell')
            ->selectRaw('(COUNT(CASE WHEN payment_release = 0 THEN id END) / COUNT(id)) * 100 AS upcomingSellPercentage')
            ->selectRaw('COUNT(CASE WHEN payment_release = 2 THEN id END) AS holdSell')
            ->selectRaw('(COUNT(CASE WHEN payment_release = 2 THEN id END) / COUNT(id)) * 100 AS holdSellPercentage')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) AS todaySell')
            ->selectRaw('(COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) / COUNT(id)) * 100 AS todaySellPercentage')
            ->wherePayment_status(1)
            ->get()
            ->toArray())->collapse();

        return view('admin.sell_summary.postSell', $data);
    }

    public function postSellSearch(Request $request)
    {
        $search = $request->search['value'] ?? null;
        $filterName = $request->name;
        $filterStatus = $request->filterStatus;
        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0];
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $sells = SellPostPayment::with(['user', 'sellPost', 'sellPost.user'])->wherePayment_status(1)->latest()
            ->when(isset($filterName), function ($query) use ($filterName) {
                return $query->where(function ($subquery) use ($filterName) {
                    $subquery->where('transaction', 'LIKE', '%' . $filterName . '%')
                        ->orWhereHas('sellPost', function ($qq) use ($filterName) {
                            $qq->where('title', 'LIKE', '%' . $filterName . '%');
                        })
                        ->orWhereHas('user', function ($qq) use ($filterName) {
                            $qq->where('firstname', 'LIKE', '%' . $filterName . '%')
                                ->orWhere('lastname', 'LIKE', '%' . $filterName . '%')
                                ->orWhere('username', 'LIKE', '%' . $filterName . '%');
                        });
                });
            })
            ->when(isset($filterStatus), function ($query) use ($filterStatus) {
                if ($filterStatus != "all") {
                    return $query->where('status', $filterStatus);
                }
            })
            ->when(!empty($request->filterDate) && $endDate == null, function ($query) use ($startDate) {
                $startDate = Carbon::createFromFormat('d/m/Y', trim($startDate));
                $query->whereDate('created_at', $startDate);
            })
            ->when(!empty($request->filterDate) && $endDate != null, function ($query) use ($startDate, $endDate) {
                $startDate = Carbon::createFromFormat('d/m/Y', trim($startDate));
                $endDate = Carbon::createFromFormat('d/m/Y', trim($endDate));
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where(function ($subquery) use ($search) {
                    $subquery->where('transaction', 'LIKE', '%' . $search . '%')
                        ->orWhere('price', 'LIKE', '%' . $search . '%')
                        ->orWhereHas('sellPost', function ($qq) use ($search) {
                            $qq->where('title', 'LIKE', '%' . $search . '%');
                        })
                        ->orWhereHas('user', function ($qq) use ($search) {
                            $qq->where('firstname', 'LIKE', '%' . $search . '%')
                                ->orWhere('lastname', 'LIKE', '%' . $search . '%')
                                ->orWhere('username', 'LIKE', '%' . $search . '%');
                        });
                });
            });
        return DataTables::of($sells)
            ->addColumn('trx', function ($item) {
                return $item->transaction;
            })
            ->addColumn('title', function ($item) {
                $route = route('sellPost.details', [slug(optional(@$item->sellPost)->title), optional(@$item->sellPost)->id]);
                return '<a href="' . $route . '">' . optional($item->sellPost)->title . '</a>';
            })
            ->addColumn('payment', function ($item) {
                return currencyPosition($item->price);
            })
            ->addColumn('seller_get', function ($item) {
                $extra = null;
                if (0 < $item->admin_amount) {
                    $extra = '<span class="badge bg-soft-danger text-danger ms-1">
                     ' . currencyPosition($item->admin_amount) . ' Charges</span>';
                }
                return currencyPosition($item->seller_amount) . $extra;
            })
            ->addColumn('seller', function ($item) {
                $url = route('admin.user.edit', optional($item->sellPost)->user_id);

                return '<a class="d-flex align-items-center me-2" href="' . $url . '">
                            <div class="flex-shrink-0">
                                ' . optional(optional($item->sellPost)->user)->profilePicture() . '
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="text-hover-primary mb-0">' . $item->user?->fullname . '</h5>
                                <span class="fs-6 text-body">' . $item->user?->username . '</span>
                            </div>
                        </a>
                    ';
            })
            ->addColumn('buyer', function ($item) {
                $url = route('admin.user.edit', $item->user_id);

                return '<a class="d-flex align-items-center me-2" href="' . $url . '">
                            <div class="flex-shrink-0">
                                ' . optional($item->user)->profilePicture() . '
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="text-hover-primary mb-0">' . $item->user?->fullname . '</h5>
                                <span class="fs-6 text-body">' . $item->user?->username . '</span>
                            </div>
                        </a>
                    ';
            })
            ->addColumn('status', function ($item) {
                if ($item->payment_release == 1) {
                    return '<span class="badge bg-soft-success text-success">
                    <span class="legend-indicator bg-success"></span>' . trans('Released') . '
                  </span>';

                } elseif ($item->payment_release == 0) {
                    return '<span class="badge bg-soft-warning text-warning">
                    <span class="legend-indicator bg-warning"></span>' . trans('Upcoming') . '
                  </span>';

                } else {
                    return '<span class="badge bg-soft-danger text-danger">
                    <span class="legend-indicator bg-danger"></span>' . trans('Hold') . '
                  </span>';
                }
            })
            ->addColumn('payment_at', function ($item) {
                return dateTime($item->created_at, basicControl()->date_time_format);
            })
            ->addColumn('action', function ($item) {

                $resourceJson = htmlspecialchars(json_encode($item->sellPost->credential), ENT_QUOTES, 'UTF-8');

                if ($item->payment_release == 0) {
                    $btnName = 'Hold Payment';
                    $icon = 'fa-light fa-lock dropdown-item-icon';
                    $modalTarget = '#hold-modal';
                    $class = 'holdBtn';
                } elseif ($item->payment_release == 2) {
                    $btnName = 'Unhold Payment';
                    $icon = 'fa-light fa-unlock dropdown-item-icon';
                    $modalTarget = '#unhold-modal';
                    $class = 'unholdBtn';
                }


                $html = '<div class="btn-group" role="group">
                      <a href="#" class="btn btn-white btn-sm edit_button" data-bs-toggle="modal" data-bs-target="#myModal"
                                        data-info=\'' . $resourceJson . '\'>
                        <i class="fal fa-eye me-1"></i> ' . trans('Credentials') . '
                      </a>';
                if (in_array($item->payment_release, [0, 2])) {
                    $html .= '<div class="btn-group">
                      <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown">
                        <a href="javascript:void(0)" class="dropdown-item ' . $class . '" data-resource="' . $item->id . '"
                            data-bs-target="' . $modalTarget . '" data-bs-toggle="modal">
                            <i class="' . $icon . '"></i> ' . trans($btnName) . '
                        </a>
                      </div>
                    </div>';
                }

                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['trx', 'title', 'payment', 'seller_get', 'seller', 'buyer', 'status', 'payment_at', 'action'])
            ->make(true);
    }

    public function paymentHold(Request $request)
    {
        $hold = SellPostPayment::findOrFail($request->id);
        $hold->payment_release = 2;
        $hold->save();

        return back()->with('success', 'Update Successfully');
    }

    public function paymentUnhold(Request $request)
    {
        $hold = SellPostPayment::findOrFail($request->id);
        $hold->payment_release = 0;
        $hold->save();

        return back()->with('success', 'Update Successfully');
    }

}
