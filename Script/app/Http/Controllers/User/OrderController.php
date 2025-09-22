<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function topUpOrder(Request $request)
    {

        $status = null;
        if ($request->type == 'wait-sending') {
            $status = 0;
        } elseif ($request->type == 'complete') {
            $status = 1;
        } elseif ($request->type == 'refund') {
            $status = 2;
        }

        $data['orders'] = Order::with(['orderDetails', 'orderDetails.detailable'])
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
            ->when(isset($request->type) && $request->type != 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when(isset($request->search), function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('utr', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('amount', 'LIKE', '%' . $request->search . '%');
                })
                    ->orWhereHas('orderDetails', function ($query) use ($request) {
                        $query->where('name', 'LIKE', '%' . $request->search . '%');
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate(basicControl()->paginate);



        return view(template() . "user.".getDash() .".order.topup.index", $data);
    }

    public function cardOrder(Request $request)
    {
        $status = null;
        if ($request->type == 'wait-sending') {
            $status = 3;
        } elseif ($request->type == 'complete') {
            $status = 1;
        } elseif ($request->type == 'refund') {
            $status = 2;
        }

        $data['orders'] = Order::with(['orderDetails', 'orderDetails.detailable'])
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
            ->when(isset($request->type) && $request->type != 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when(isset($request->search), function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('utr', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('amount', 'LIKE', '%' . $request->search . '%');
                })
                    ->orWhereHas('orderDetails', function ($query) use ($request) {
                        $query->where('name', 'LIKE', '%' . $request->search . '%');
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate(basicControl()->paginate);

        return view(template() . "user." . getDash() . ".order.card.index", $data);
    }
}
