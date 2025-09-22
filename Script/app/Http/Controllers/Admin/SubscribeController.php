<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubscribeController extends Controller
{
    public function index(Request $request)
    {
        $data['subscribeRecord'] = collect(Subscriber::selectRaw('COUNT(id) AS totalSubscribe')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) AS todaySubscribe')
            ->selectRaw('(COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) / COUNT(id)) * 100 AS todaySubscribePercentage')
            ->selectRaw('COUNT(CASE WHEN WEEK(created_at, 1) = WEEK(CURDATE(), 1) AND YEAR(created_at) = YEAR(CURDATE()) THEN id END) AS thisWeekSubscribe')
            ->selectRaw('(COUNT(CASE WHEN WEEK(created_at, 1) = WEEK(CURDATE(), 1) AND YEAR(created_at) = YEAR(CURDATE()) THEN id END) / COUNT(id)) * 100 AS thisWeekSubscribePercentage')
            ->selectRaw('COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN id END) AS thisMonthSubscribe')
            ->selectRaw('(COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN id END) / COUNT(id)) * 100 AS thisMonthSubscribePercentage')
            ->selectRaw('COUNT(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) THEN id END) AS thisYearSubscribe')
            ->selectRaw('(COUNT(CASE WHEN YEAR(created_at) = YEAR(CURDATE()) THEN id END) / COUNT(id)) * 100 AS thisYearSubscribePercentage')
            ->get()
            ->toArray())->collapse();

        return view('admin.subscribe.list', $data);
    }

    public function subscribeSearch(Request $request)
    {
        $filterName = $request->name;
        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0];
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $subscribes = Subscriber::orderBy('id', 'DESC')
            ->when(isset($filterName), function ($query) use ($filterName) {
                return $query->where('email', 'LIKE', '%' . $filterName . '%');
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
            ->when(!empty($request->search['value']), function ($query) use ($request) {
                $query->where(function ($subquery) use ($request) {
                    $subquery->where('email', 'LIKE', '%' . $request->search['value'] . '%');
                });
            });


        return DataTables::of($subscribes)
            ->addColumn('no', function () {
                static $counter = 0;
                $counter++;
                return $counter;
            })

            ->addColumn('email', function ($item) {
                return $item->email;
            })

            ->addColumn('subscribe_at', function ($item) {
                return dateTime($item->created_at, basicControl()->date_time_format);
            })

            ->rawColumns(['no','email', 'subscribe_at'])
            ->make(true);
    }
}
