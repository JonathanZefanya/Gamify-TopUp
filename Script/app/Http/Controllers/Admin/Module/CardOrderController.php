<?php

namespace App\Http\Controllers\Admin\Module;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Traits\MakeOrder;
use App\Traits\Notify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CardOrderController extends Controller
{
    use Notify, MakeOrder;

    public function list(Request $request)
    {
        $status = -1;
        if ($request->type == 'pending') {
            $status = 3;
        } elseif ($request->type == 'complete') {
            $status = 1;
        } elseif ($request->type == 'refund') {
            $status = 2;
        }

        $data['orders'] = collect(Order::payment()->type('card')->selectRaw('COUNT(id) AS totalOrder')
            ->selectRaw('COUNT(CASE WHEN status = 0 THEN id END) AS pendingOrder')
            ->selectRaw('(COUNT(CASE WHEN status = 0 THEN id END) / COUNT(id)) * 100 AS pendingOrderPercentage')
            ->selectRaw('COUNT(CASE WHEN status = 1 THEN id END) AS completeOrder')
            ->selectRaw('(COUNT(CASE WHEN status = 1 THEN id END) / COUNT(id)) * 100 AS completeOrderPercentage')
            ->selectRaw('COUNT(CASE WHEN status = 2 THEN id END) AS refundOrder')
            ->selectRaw('(COUNT(CASE WHEN status = 2 THEN id END) / COUNT(id)) * 100 AS refundOrderPercentage')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) AS todayOrder')
            ->selectRaw('(COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) / COUNT(id)) * 100 AS todayOrderPercentage')
            ->when($status != '-1', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->get()
            ->toArray())->collapse();

        $data['status'] = $status;
        return view('admin.card.order.index', $data);
    }

    public function listSearch(Request $request)
    {
        $search = $request->search['value'] ?? null;
        $filterName = $request->name;
        $filterService = $request->service;
        $status = $request->type;
        $filterStatus = $request->filterStatus;
        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0];
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $orders = Order::with(['user:id,firstname,lastname,username,image,image_driver', 'gateway:id,name',
         'orderDetails','orderDetails.detailable.card:id,name'])
            ->payment()->type('card')->orderBy('id', 'desc')
            ->when($status != '-1', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when(isset($filterName), function ($query) use ($filterName) {
                return $query->where('utr', 'LIKE', '%' . $filterName . '%');
            })
            ->when(isset($filterService), function ($query) use ($filterService) {
                $query->whereHas('orderDetails', function ($qq) use ($filterService) {
                    $qq->where('name', 'LIKE', '%' . $filterService . '%');
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
                    $subquery->where('utr', 'LIKE', "%$search%")
                        ->orWhere('amount', 'LIKE', "%$search%");
                })
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('firstname', 'LIKE', "%$search%")
                            ->orWhere('lastname', 'LIKE', "%$search%")
                            ->orWhere('username', 'LIKE', "%$search%");
                    });
            });
        return DataTables::of($orders)
            ->addColumn('order', function ($item) {
                return $item->utr;
            })
            ->addColumn('date', function ($item) {
                return dateTime($item->created_at);
            })
            ->addColumn('card', function ($item) {
                $div = "";
                $extra = 0;
                foreach ($item->orderDetails as $key => $detail) {
                    if ($key < 3) {
                        $div .= '<span class="avatar" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Ella Lauda" data-bs-original-title="Ella Lauda">
              <img class="avatar-img" src="' . $detail->image_path . '" alt="Image Description">
            </span>';
                    } else {
                        $extra++;
                    }
                }

                if ($extra) {
                    $div .= '<span class="avatar avatar-light avatar-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Sam Kart, Amanda Harvey and 1 more">
          <span class="avatar-initials">+' . $extra . '</span>
        </span>';
                }

                // Convert order details to JSON format
                $orderDetailsJson = htmlspecialchars(json_encode($item->orderDetails), ENT_QUOTES, 'UTF-8');

                return '<div class="avatar-group avatar-group-xs avatar-circle">
                ' . $div . '
                 <span class="avatar avatar-light avatar-circle seeAll" data-bs-toggle="modal" data-bs-target="#sellAll"
                  data-detail="' . $orderDetailsJson . '">
                  <a href="javascript:void(0)"><span class="avatar-initials"><i class="fa-light fa-arrow-right"></i></span></a>
                </span>
              </div>';
            })
            ->addColumn('total_amount', function ($item) {
                return '<h6>' . currencyPosition($item->amount) . '</h6>';
            })
            ->addColumn('payment_method', function ($item) {
                if ($item->payment_method_id == '-1') {
                    return 'Wallet';
                } else {
                    return $item->gateway?->name;
                }
            })
            ->addColumn('user', function ($item) {
                $url = route('admin.user.view.profile', $item->user_id);
                return '<a class="d-flex align-items-center me-2" href="' . $url . '">
                                <div class="flex-shrink-0">
                                  ' . $item->user?->profilePicture() . '
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <h5 class="text-hover-primary mb-0">' . $item->user?->firstname . ' ' . $item->user?->lastname . '</h5>
                                  <span class="fs-6 text-body">' . $item->user?->username . '</span>
                                </div>
                              </a>';

            })
            ->addColumn('status', function ($item) {
                if ($item->status == 3) {
                    return '<span class="badge bg-soft-warning text-warning">
                    <span class="legend-indicator bg-warning"></span>' . trans('Pending (stock-short)') . '
                  </span>';

                } elseif ($item->status == 1) {
                    return '<span class="badge bg-soft-success text-success">
                    <span class="legend-indicator bg-success"></span>' . trans('Complete') . '
                  </span>';
                } elseif ($item->status == 2) {
                    return '<span class="badge bg-soft-secondary text-secondary">
                    <span class="legend-indicator bg-secondary"></span>' . trans('Refund') . '
                  </span>';
                }
            })
            ->addColumn('action', function ($item) {
                $complete = route('admin.orderCard.complete');
                $cancel = route('admin.orderCard.cancel');
                $view = route('admin.orderCard.view') . '?orderId=' . $item->utr;
                $html = '<div class="btn-group" role="group">
                      <a href="' . $view . '" class="btn btn-white btn-sm">
                        <i class="fal fa-eye me-1"></i> ' . trans("View") . '
                      </a>';

                if ($item->status == 3) {
                    $html .= '<div class="btn-group">
                      <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown">
                        <a class="dropdown-item actionBtn" href="javascript:void(0)" data-bs-target="#orderStep"
                           data-bs-toggle="modal" data-type="complete" data-id="' . $item->utr . '" data-route="' . $complete . '">
                          <i class="fal fa-check dropdown-item-icon"></i> ' . trans("Complete Order") . '
                       </a>

                       <a class="dropdown-item actionBtn" href="javascript:void(0)" data-bs-target="#orderStep"
                           data-bs-toggle="modal" data-type="cancel" data-id="' . $item->utr . '" data-route="' . $cancel . '">
                          <i class="fal fa-times dropdown-item-icon"></i> ' . trans("Cancel Order") . '
                       </a>
                      </div>
                    </div>';
                }

                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['order', 'date','card', 'total_amount', 'payment_method', 'user', 'status', 'action'])
            ->make(true);
    }

    public function view(Request $request)
    {
        $data['order'] = Order::with(['orderDetails',
            'user:id,firstname,lastname,email,phone_code,phone,image_driver,image,balance', 'gateway:id,name'])
            ->where('utr', $request->orderId)->firstOrFail();

        $data['userTotalOrderCount'] = Order::type('card')->where('user_id', $data['order']->user_id)->count();
        return view('admin.card.order.view', $data);
    }

    public function complete(Request $request)
    {
        $order = Order::with(['orderDetails:id,order_id,status,name', 'user'])->payment()->type('card')
            ->where('status', 3)->where('utr', $request->orderId)->firstOrFail();

        try {
            $order->status = 1;
            $order->save();

            if (!empty($order->orderDetails)) {
                foreach ($order->orderDetails as $detail) {
                    $detail->status = 1;
                    $detail->save();
                }
            }

            $params = [
                'order_id' => $order->utr,
            ];

            $action = [
                "link" => route('user.cardOrder') . '?type=complete',
                "icon" => "fa fa-money-bill-alt text-white"
            ];

            $this->sendMailSms($order->user, 'CARD_ORDER_COMPLETE', $params);
            $this->userPushNotification($order->user, 'CARD_ORDER_COMPLETE', $params, $action);
            $this->userFirebasePushNotification($order->user, 'CARD_ORDER_COMPLETE', $params);

            return back()->with('success', 'Order has been completed');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function cancel(Request $request)
    {
        $order = Order::with(['orderDetails:id,order_id,status,name', 'user'])->payment()->type('card')
            ->where('status', 3)->where('utr', $request->orderId)->firstOrFail();

        try {
            $order->status = 2;
            $order->save();

            $order->user->balance += $order->amount;
            $order->user->save();

            $this->newTransaction($order->user_id, $order->amount, 'Order Refund For Card', '+', $order->id, Order::class);

            if (!empty($order->orderDetails)) {
                foreach ($order->orderDetails as $detail) {
                    $detail->status = 2;
                    $detail->save();
                }
            }

            $params = [
                'order_id' => $order->utr,
            ];

            $action = [
                "link" => route('user.cardOrder') . '?type=refund',
                "icon" => "fa fa-money-bill-alt text-white"
            ];

            $this->sendMailSms($order->user, 'CARD_ORDER_CANCEL', $params);
            $this->userPushNotification($order->user, 'CARD_ORDER_CANCEL', $params, $action);
            $this->userFirebasePushNotification($order->user, 'CARD_ORDER_CANCEL', $params);

            return back()->with('success', 'Order has been canceled');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function codeSend(Request $request)
    {
        if (!$request->orderDetailsId) {
            return back()->with('error', 'Something went wrong. Please try again');
        }

        if (!$request->passcode) {
            return back()->with('error', 'Passcode is required');
        }

        $passcodes = array_filter($request->passcode);

        $orderDetail = OrderDetail::select(['id', 'user_id', 'order_id', 'name', 'qty', 'stock_short', 'status', 'card_codes'])
            ->with(['order:id,status,utr', 'user'])->findOrFail($request->orderDetailsId);

        try {
            $stock_short = max(0, $orderDetail->qty - count($passcodes));

            $orderDetail->card_codes = $passcodes;
            $orderDetail->stock_short = $stock_short;
            $orderDetail->status = ($stock_short == 0) ? 1 : 3;
            $orderDetail->save();

            $isStockShortExits = OrderDetail::where('order_id', $orderDetail->order_id)->where('status', 3)->exists();

            if (!$isStockShortExits) {
                $orderDetail->order->status = 1;
                $orderDetail->order->save();
            }

            $params = [
                'order_id' => $orderDetail->order?->utr,
                'service_name' => $orderDetail->name ?? null,
            ];

            $action = [
                "link" => route('user.cardOrder') . '?type=all',
                "icon" => "fa fa-money-bill-alt text-white"
            ];

            $this->sendMailSms($orderDetail->user, 'CARD_CODE_SEND', $params);
            $this->userPushNotification($orderDetail->user, 'CARD_CODE_SEND', $params, $action);
            $this->userFirebasePushNotification($orderDetail->user, 'CARD_CODE_SEND', $params);

            return back()->with('success', 'Code has been send');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }
}
