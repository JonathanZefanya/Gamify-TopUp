<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CardService;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\TopUpService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }


    public function getOrderMovement()
    {
        $orderRecords = DB::table('orders')
            ->where('user_id', auth()->id())
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
}
