<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Order;
use App\Models\Payout;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionLogController extends Controller
{
    public function transaction()
    {
        return view('admin.transaction.index');
    }

    public function transactionSearch(Request $request)
    {
        $search = $request->search['value'] ?? null;
        $filterTransactionId = $request->filterTransactionID;
        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0];
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $transaction = Transaction::query()->with(['user:id,username,firstname,lastname,image,image_driver'])
            ->whereHas('user')
            ->orderBy('id', 'DESC')
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where(function ($subquery) use ($search) {
                    $subquery->where('trx_id', 'LIKE', "%$search%")
                        ->orWhere('remarks', 'LIKE', "%{$search}%")
                        ->orWhereHas('user', function ($q) use ($search) {
                            $q->where('firstname', 'LIKE', "%$search%")
                                ->orWhere('lastname', 'LIKE', "%{$search}%")
                                ->orWhere('username', 'LIKE', "%{$search}%");
                        });
                });
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
            ->when(!empty($filterTransactionId), function ($query) use ($filterTransactionId) {
                return $query->where('trx_id', $filterTransactionId);
            });

        return DataTables::of($transaction)
            ->addColumn('no', function ($item) {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('trx', function ($item) {
                return $item->trx_id;
            })
            ->addColumn('base_amount', function ($item) {
                $statusClass = $item->trx_type == '+' ? 'text-success' : 'text-danger';
                return "<h6 class='mb-0 $statusClass '>" . $item->trx_type . ' ' . currencyPosition(getAmount($item->amount_in_base)) . "</h6>";
            })
            ->addColumn('user', function ($item) {
                $url = route("admin.user.view.profile", optional($item->user)->id);
                return '<a class="d-flex align-items-center me-2" href="' . $url . '">
                                <div class="flex-shrink-0">
                                    ' . optional($item->user)->profilePicture() . '
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <h5 class="text-hover-primary mb-0">' . optional($item->user)->firstname . ' ' . optional($item->user)->lastname . '</h5>
                                  <span class="fs-6 text-body">@' . optional($item->user)->username ?? 'Unknown' . '</span>
                                </div>
                              </a>';
            })
            ->addColumn('type', function ($item) {
                if ($item->transactional_type == Deposit::class) {
                    return 'Deposit';
                } elseif ($item->transactional_type == Order::class) {
                    return 'Order';
                }elseif ($item->transactional_type == Payout::class) {
                    return 'Payout';
                } else {
                    return '-';
                }
            })
            ->addColumn('remarks', function ($item) {
                return $item->remarks;
            })
            ->addColumn('date-time', function ($item) {
                return dateTime($item->created_at, 'd M Y h:i A');
            })
            ->rawColumns(['trx', 'base_amount', 'user', 'type', 'remarks', 'date-time'])
            ->make(true);
    }
}
