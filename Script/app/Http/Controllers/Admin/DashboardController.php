<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\Order;
use App\Models\Payout;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserKyc;
use App\Traits\Notify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    use Upload, Notify;

    public function index()
    {
        $data['firebaseNotify'] = config('firebase');
        $data['latestUser'] = User::latest()->limit(5)->get();
        $statistics['schedule'] = $this->dayList();
        return view('admin.dashboard-alternative', $data, compact("statistics"));
    }

    public function monthlyDepositWithdraw(Request $request)
    {
        $keyDataset = $request->keyDataset;

        $dailyTransaction = $this->dayList();

        Transaction::when($keyDataset == '0', function ($query) {
            $query->whereMonth('created_at', Carbon::now()->month);
        })
            ->when($keyDataset == '1', function ($query) {
                $lastMonth = Carbon::now()->subMonth();
                $query->whereMonth('created_at', $lastMonth->month);
            })
            ->select(
                DB::raw('SUM(amount_in_base) as totalTransaction'),
                DB::raw('DATE_FORMAT(created_at,"Day %d") as date')
            )
            ->groupBy(DB::raw("DATE(created_at)"))
            ->get()->map(function ($item) use ($dailyTransaction) {
                $dailyTransaction->put($item['date'], $item['totalTransaction']);
            });

        return response()->json([
            "totalTransaction" => currencyPosition($dailyTransaction->sum()),
            "dailyTransaction" => $dailyTransaction,
        ]);
    }

    public function saveToken(Request $request)
    {
        $admin = Auth::guard('admin')->user()
            ->fireBaseToken()
            ->create([
                'token' => $request->token,
            ]);
        return response()->json([
            'msg' => 'token saved successfully.',
        ]);
    }


    public function dayList()
    {
        $totalDays = Carbon::now()->endOfMonth()->format('d');
        $daysByMonth = [];
        for ($i = 1; $i <= $totalDays; $i++) {
            array_push($daysByMonth, ['Day ' . sprintf("%02d", $i) => 0]);
        }

        return collect($daysByMonth)->collapse();
    }

    protected function followupGrap($todaysRecords, $lastDayRecords = 0)
    {

        if (0 < $lastDayRecords) {
            $percentageIncrease = (($todaysRecords - $lastDayRecords) / $lastDayRecords) * 100;
        } else {
            $percentageIncrease = 0;
        }
        if ($percentageIncrease > 0) {
            $class = "bg-soft-success text-success";
        } elseif ($percentageIncrease < 0) {
            $class = "bg-soft-danger text-danger";
        } else {
            $class = "bg-soft-secondary text-body";
        }

        return [
            'class' => $class,
            'percentage' => round($percentageIncrease, 2)
        ];
    }


    public function chartUserRecords()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $userRecord = collect(User::selectRaw('COUNT(id) AS totalUsers')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN id END) AS currentDateUserCount')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) THEN id END) AS previousDateUserCount')
            ->get()->makeHidden(['last-seen-activity', 'fullname'])
            ->toArray())->collapse();
        $followupGrap = $this->followupGrap($userRecord['currentDateUserCount'], $userRecord['previousDateUserCount']);

        $userRecord->put('followupGrapClass', $followupGrap['class']);
        $userRecord->put('followupGrap', $followupGrap['percentage']);

        $current_month_data = DB::table('users')
            ->select(DB::raw('DATE_FORMAT(created_at,"%e %b") as date'), DB::raw('count(*) as count'))
            ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), $currentMonth)
            ->orderBy('created_at', 'asc')
            ->groupBy('date')
            ->get();

        $current_month_data_dates = $current_month_data->pluck('date');
        $current_month_datas = $current_month_data->pluck('count');
        $userRecord['chartPercentageIncDec'] = fractionNumber($userRecord['totalUsers'] - $userRecord['currentDateUserCount'], false);
        return response()->json(['userRecord' => $userRecord, 'current_month_data_dates' => $current_month_data_dates, 'current_month_datas' => $current_month_datas]);
    }

    public function chartTicketRecords()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $ticketRecord = collect(SupportTicket::selectRaw('COUNT(id) AS totalTickets')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN id END) AS currentDateTicketsCount')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) THEN id END) AS previousDateTicketsCount')
            ->selectRaw('count(CASE WHEN status = 2  THEN status END) AS replied')
            ->selectRaw('count(CASE WHEN status = 1  THEN status END) AS answered')
            ->selectRaw('count(CASE WHEN status = 0  THEN status END) AS pending')
            ->get()
            ->toArray())->collapse();

        $followupGrap = $this->followupGrap($ticketRecord['currentDateTicketsCount'], $ticketRecord['previousDateTicketsCount']);
        $ticketRecord->put('followupGrapClass', $followupGrap['class']);
        $ticketRecord->put('followupGrap', $followupGrap['percentage']);

        $current_month_data = DB::table('support_tickets')
            ->select(DB::raw('DATE_FORMAT(created_at,"%e %b") as date'), DB::raw('count(*) as count'))
            ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), $currentMonth)
            ->orderBy('created_at', 'asc')
            ->groupBy('date')
            ->get();

        $current_month_data_dates = $current_month_data->pluck('date');
        $current_month_datas = $current_month_data->pluck('count');
        $ticketRecord['chartPercentageIncDec'] = fractionNumber($ticketRecord['totalTickets'] - $ticketRecord['currentDateTicketsCount'], false);
        return response()->json(['ticketRecord' => $ticketRecord, 'current_month_data_dates' => $current_month_data_dates, 'current_month_datas' => $current_month_datas]);
    }

    public function chartOrderRecords()
    {
        $currentMonth = Carbon::now()->format('Y-m');
        $orderRecords = collect(Order::payment()->selectRaw('COUNT(id) AS totalOrder')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN id END) AS currentDateOrderCount')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) THEN id END) AS previousDateOrderCount')
            ->get()
            ->toArray())->collapse();
        $followupGrap = $this->followupGrap($orderRecords['currentDateOrderCount'], $orderRecords['previousDateOrderCount']);
        $orderRecords->put('followupGrapClass', $followupGrap['class']);
        $orderRecords->put('followupGrap', $followupGrap['percentage']);


        $current_month_data = DB::table('orders')->where('payment_status', 1)
            ->select(DB::raw('DATE_FORMAT(created_at,"%e %b") as date'), DB::raw('count(*) as count'))
            ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), $currentMonth)
            ->orderBy('created_at', 'asc')
            ->groupBy('date')
            ->get();

        $current_month_data_dates = $current_month_data->pluck('date');
        $current_month_datas = $current_month_data->pluck('count');
        $orderRecords['chartPercentageIncDec'] = fractionNumber($orderRecords['totalOrder'] - $orderRecords['currentDateOrderCount'], false);
        return response()->json(['orderRecord' => $orderRecords, 'current_month_data_dates' => $current_month_data_dates, 'current_month_datas' => $current_month_datas]);
    }

    public function chartTransactionRecords()
    {
        $currentMonth = Carbon::now()->format('Y-m');

        $transaction = collect(Transaction::selectRaw('COUNT(id) AS totalTransaction')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN id END) AS currentDateTransactionCount')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) THEN id END) AS previousDateTransactionCount')
            ->whereRaw('YEAR(created_at) = YEAR(NOW()) AND MONTH(created_at) = MONTH(NOW())')
            ->get()
            ->toArray())
            ->collapse();

        $followupGrap = $this->followupGrap($transaction['currentDateTransactionCount'], $transaction['previousDateTransactionCount']);
        $transaction->put('followupGrapClass', $followupGrap['class']);
        $transaction->put('followupGrap', $followupGrap['percentage']);


        $current_month_data = DB::table('transactions')
            ->select(DB::raw('DATE_FORMAT(created_at,"%e %b") as date'), DB::raw('count(*) as count'))
            ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), $currentMonth)
            ->orderBy('created_at', 'asc')
            ->groupBy('date')
            ->get();

        $current_month_data_dates = $current_month_data->pluck('date');
        $current_month_datas = $current_month_data->pluck('count');
        $transaction['chartPercentageIncDec'] = fractionNumber($transaction['totalTransaction'] - $transaction['currentDateTransactionCount'], false);
        return response()->json(['transactionRecord' => $transaction, 'current_month_data_dates' => $current_month_data_dates, 'current_month_datas' => $current_month_datas]);
    }


    public function chartLoginHistory()
    {
        $userLoginsData = DB::table('user_logins')
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->select('browser', 'os', 'get_device')
            ->get();

        $userLoginsBrowserData = $userLoginsData->groupBy('browser')->map->count();
        $data['browserKeys'] = $userLoginsBrowserData->keys();
        $data['browserValue'] = $userLoginsBrowserData->values();

        $userLoginsOSData = $userLoginsData->groupBy('os')->map->count();
        $data['osKeys'] = $userLoginsOSData->keys();
        $data['osValue'] = $userLoginsOSData->values();

        $userLoginsDeviceData = $userLoginsData->groupBy('get_device')->map->count();
        $data['deviceKeys'] = $userLoginsDeviceData->keys();
        $data['deviceValue'] = $userLoginsDeviceData->values();

        return response()->json(['loginPerformance' => $data]);
    }

    public function chartTopUpOrderRecords()
    {
        $currentTime = Carbon::now();
        $data['topUpOrderToday'] = $this->getDataForTimeRange($currentTime, $currentTime->copy()->subHours(24), 'topup')[0] ?? null;
        $data['topUpOrderYesterday'] = $this->getDataForTimeRange($currentTime->copy()->subHours(24), $currentTime->copy()->subHours(24), 'topup')[0] ?? null;
        $data['totalTopUpOrder'] = Order::payment()->type('topup')->count();
        return response()->json(['topUpOrderRecord' => $data]);
    }

    public function chartCardOrderRecords()
    {
        $currentTime = Carbon::now();
        $data['cardOrderToday'] = $this->getDataForTimeRange($currentTime, $currentTime->copy()->subHours(24), 'card')[0] ?? null;
        $data['cardOrderYesterday'] = $this->getDataForTimeRange($currentTime->copy()->subHours(24), $currentTime->copy()->subHours(24), 'card')[0] ?? null;
        $data['totalCardOrder'] = Order::payment()->type('card')->count();
        return response()->json(['cardOrderRecord' => $data]);
    }

    public function chartAddFundRecords()
    {
        $currentTime = Carbon::now();
        $data['cardAddFundToday'] = $this->getDataForTimeRange($currentTime, $currentTime->copy()->subHours(24), 'fund')[0] ?? null;
        $data['cardAddFundYesterday'] = $this->getDataForTimeRange($currentTime->copy()->subHours(24), $currentTime->copy()->subHours(24), 'fund')[0] ?? null;
        $data['totalAddFund'] = Deposit::where('status', 1)->where('payment_method_id', '!=', '-1')->sum('amount_in_base');
        $data['currencySymbol'] = basicControl()->currency_symbol;
        return response()->json(['addFundRecord' => $data]);
    }

    public function chartOrderMovement()
    {
        $orderRecords = DB::table('orders')
            ->where('payment_status', 1)
            ->selectRaw('
        MONTH(created_at) as month,
        COUNT(CASE WHEN order_for = "topup" THEN 1 END) AS topUpOrder,
        COUNT(CASE WHEN order_for = "card" THEN 1 END) AS cardOrder
    ')
            ->whereYear('created_at', date('Y'))  // Optional: Filter by current year
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();


        // Initialize monthly data arrays with zeros
        $monthlyData = [
            'topUp' => array_fill(0, 12, 0),
            'card' => array_fill(0, 12, 0),
        ];

        foreach ($orderRecords as $record) {
            $monthIndex = $record->month - 1; // Adjust month to zero-based index for JavaScript
            $monthlyData['topUp'][$monthIndex] = $record->topUpOrder;
            $monthlyData['card'][$monthIndex] = $record->cardOrder;
        }

        return response()->json([
            'orderFigures' => [
                'horizontalBarChatInbox' => $monthlyData
            ]
        ]);
    }

    function getDataForTimeRange($start, $end, $type)
    {
        $hours = [];
        $counts = [];

        for ($i = 0; $i < 24; $i++) {
            if ($i % 2 == 0) {
                $hour = $start->copy()->subHours($i + 1);
                $formattedHour = $hour->format('hA');
                $hours[] = $formattedHour;

                if ($type == 'topup' || $type == 'card') {
                    $count = DB::table('orders')
                        ->where('payment_status', 1)
                        ->where('order_for', $type)
                        ->where('updated_at', '>=', $hour)
                        ->where('updated_at', '<', $hour->copy()->addHours(2))
                        ->count();
                } elseif ($type == 'fund') {
                    $count = DB::table('deposits')
                        ->where('status', 1)
                        ->where('payment_method_id', '!=', '-1')
                        ->where('updated_at', '>=', $hour)
                        ->where('updated_at', '<', $hour->copy()->addHours(2))
                        ->count();
                }
                $counts[] = $count;
            }
        }
        $hours = array_reverse($hours);
        $counts = array_reverse($counts);

        $data[] = [
            'hours' => $hours,
            'counts' => $counts,
        ];
        return $data;
    }

}
