<?php

namespace App\Http\Controllers\Admin\Module;

use App\Exports\CodeExport;
use App\Http\Controllers\Controller;
use App\Imports\CodeImport;
use App\Models\CardService;
use App\Models\Code;
use App\Traits\Sample;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CardServiceCodeController extends Controller
{
    use Sample;

    public function list(Request $request)
    {
        $data['service'] = CardService::with('card')->select(['id', 'name', 'card_id'])->findOrFail($request->service_id);
        $data['services'] = CardService::select(['id', 'name', 'card_id', 'sort_by', 'created_at'])
            ->where('card_id', $data['service']->card_id)->orderBy('sort_by', 'ASC')->get();
        $data['codes'] = collect(Code::serviceWise(CardService::class, $request->service_id)
            ->selectRaw('COUNT(id) AS totalCode')
            ->selectRaw('COUNT(CASE WHEN status = 1 THEN id END) AS activeCode')
            ->selectRaw('(COUNT(CASE WHEN status = 1 THEN id END) / COUNT(id)) * 100 AS activeCodePercentage')
            ->selectRaw('COUNT(CASE WHEN status = 0 THEN id END) AS inActiveCode')
            ->selectRaw('(COUNT(CASE WHEN status = 0 THEN id END) / COUNT(id)) * 100 AS inActiveCodePercentage')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) AS todayCode')
            ->selectRaw('(COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) / COUNT(id)) * 100 AS todayCodePercentage')
            ->selectRaw('COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN id END) AS thisMonthCode')
            ->selectRaw('(COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN id END) / COUNT(id)) * 100 AS thisMonthCodePercentage')
            ->get()
            ->toArray())->collapse();

        return view('admin.card.code.index', $data);
    }

    public function search(Request $request)
    {
        $search = $request->search['value'] ?? null;
        $filterName = $request->name;
        $filterStatus = $request->filterStatus;
        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0];
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $codes = Code::serviceWise(CardService::class, $request->service_id)->orderBy('id', 'desc')->when(isset($filterName), function ($query) use ($filterName) {
            return $query->where('passcode', 'LIKE', '%' . $filterName . '%');
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
                    $subquery->where('passcode', 'LIKE', "%$search%");
                });
            });
        return DataTables::of($codes)
            ->addColumn('checkbox', function ($item) {
                return '<input type="checkbox" id="chk-' . $item->id . '"
                                       class="form-check-input row-tic tic-check" name="check" value="' . $item->id . '"
                                       data-id="' . $item->id . '">';

            })
            ->addColumn('passcode', function ($item) {
                $element = "referralsKeyCode" . $item->id;
                return '<div class="input-group input-group-sm input-group-merge table-input-group">
                        <input id="' . $element . '" type="text" class="form-control" readonly value="' . $item->passcode . '">
                        <a class="js-clipboard input-group-append input-group-text" onclick="copyFunction(\'' . $element . '\')" href="javascript:void(0)" title="Copy to clipboard">
                            <i id="referralsKeyCodeIcon' . $item->id . '" class="bi-clipboard"></i>
                        </a>
                    </div>';
            })
            ->addColumn('status', function ($item) {
                if ($item->status == 1) {
                    return '<span class="badge bg-soft-success text-success">
                    <span class="legend-indicator bg-success"></span>' . trans('Active') . '
                  </span>';

                } else {
                    return '<span class="badge bg-soft-danger text-danger">
                    <span class="legend-indicator bg-danger"></span>' . trans('In Active') . '
                  </span>';
                }
            })
            ->addColumn('created_at', function ($item) {
                return dateTime($item->created_at, basicControl()->date_time_format);
            })
            ->rawColumns(['checkbox', 'passcode', 'status', 'created_at'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $service = CardService::select(['id'])->findOrFail($request->service_id);
        try {
            if ($request->passcode && 0 < count($request->passcode)) {
                foreach ($request->passcode as $code) {
                    Code::firstOrCreate([
                        'codeable_type' => CardService::class,
                        'codeable_id' => $service->id,
                        'passcode' => $code
                    ]);
                }
            }
            return back()->with('success', 'Code Added Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function multipleDelete(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select row.');
            return response()->json(['error' => 1]);
        } else {
            Code::whereIn('id', $request->strIds)->get()->map(function ($query) {
                $query->delete();
                return $query;
            });
            session()->flash('success', 'Code has been deleted successfully');
            return response()->json(['success' => 1]);
        }
    }

    public function multipleStatusChange(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select row.');
            return response()->json(['error' => 1]);
        } else {
            Code::select(['id', 'status'])->whereIn('id', $request->strIds)->get()->map(function ($query) {
                if ($query->status) {
                    $query->status = 0;
                } else {
                    $query->status = 1;
                }
                $query->save();
                return $query;
            });
            session()->flash('success', 'Code Status has been changed successfully');
            return response()->json(['success' => 1]);
        }
    }

    public function export(Request $request)
    {
        try {
            $data = collect([
                'codeable_id' => $request->service_id,
                'codeable_type' => CardService::class,
            ])->all();
            return Excel::download(new CodeExport($data), 'codes.csv');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function sample()
    {
        try {
            return $this->csvSampleDownload('code.csv', 'code-sample');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'importFile' => 'required|file|mimes:csv',
        ]);

        CardService::select(['id'])->findOrFail($request->service_id);

        try {
            $data = collect([
                'codeable_id' => $request->service_id,
                'codeable_type' => CardService::class,
            ])->all();
            Excel::import(new CodeImport($data), $request->file('importFile'));
            return back()->with('success', 'Codes Imported Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
