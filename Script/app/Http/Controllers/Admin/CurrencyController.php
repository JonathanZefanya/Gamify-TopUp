<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyStoreRequest;
use App\Models\Currency;
use App\Traits\CurrencyRateUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mockery\Exception;
use Yajra\DataTables\Facades\DataTables;

class CurrencyController extends Controller
{
    use CurrencyRateUpdate;

    public function currencyList()
    {
        return view('admin.currency.index');
    }

    public function currencyListSearch(Request $request)
    {
        $basicControl = basicControl();
        $search = $request->search['value'] ?? null;
        $filterName = $request->name;
        $filterStatus = $request->filterStatus;
        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0];
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $currencies = Currency::orderBy('sort_by', 'ASC')
            ->when(isset($filterName), function ($query) use ($filterName) {
                return $query->where('name', 'LIKE', '%' . $filterName . '%');
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
                    $subquery->where('name', 'LIKE', "%$search%")
                        ->orWhere('code', 'LIKE', "%$search%")
                        ->orWhere('rate', 'LIKE', "%$search%");
                });
            });
        return DataTables::of($currencies)
            ->addColumn('checkbox', function ($item) {
                return '<input type="checkbox" id="chk-' . $item->id . '"
                                       class="form-check-input row-tic tic-check" name="check" value="' . $item->id . '"
                                       data-id="' . $item->id . '">';

            })
            ->addColumn('name', function ($item) {
                return '<span>' . $item->name . '(' . $item->symbol . ')' . '</span>';

            })
            ->addColumn('code', function ($item) {
                return '<span>' . $item->code . '</span>';

            })
            ->addColumn('rate', function ($item) use ($basicControl) {
                $rate = number_format($item->rate, 4);
                return "<span class='text-dark'> 1 $basicControl->base_currency = $rate $item->code </span>";

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
            ->addColumn('action', function ($item) {
                if ($item->status) {
                    $statusBtn = "In-Active";
                    $statusChange = route('admin.currencyStatusChange') . '?id=' . $item->id . '&status=in-active';
                } else {
                    $statusBtn = "Active";
                    $statusChange = route('admin.currencyStatusChange') . '?id=' . $item->id . '&status=active';
                }
                $delete = route('admin.currencyDelete', $item->id);

                $html = '<div class="btn-group sortable" role="group" data-id ="' . $item->id . '">
                      <a href="javascript:void(0)" class="btn btn-white btn-sm edit_btn" data-bs-target="#editModal" data-bs-toggle="modal"
                       data-name="' . $item->name . '" data-code="' . $item->code . '" data-symbol="' . $item->symbol . '" data-rate="' . $item->rate . '"
                       data-route="' . route('admin.currencyEdit', $item->id) . '">
                        <i class="fal fa-edit me-1"></i> ' . trans("Edit") . '
                      </a>';

                $html .= '<div class="btn-group">
                      <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown">
                        <a href="' . $statusChange . '" class="dropdown-item edit_user_btn">
                            <i class="fal fa-badge dropdown-item-icon"></i> ' . trans($statusBtn) . '
                        </a>
                        <a class="dropdown-item delete_btn" href="javascript:void(0)" data-bs-target="#delete"
                           data-bs-toggle="modal" data-route="' . $delete . '">
                          <i class="fal fa-trash dropdown-item-icon"></i> ' . trans("Delete") . '
                       </a>
                      </div>
                    </div>';

                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['checkbox', 'name', 'code', 'rate', 'status', 'created_at', 'action'])
            ->make(true);
    }

    public function currencyCreate(CurrencyStoreRequest $request)
    {
        try {
            $currency = new Currency();
            $fillData = $request->except('_token');
            $currency->fill($fillData)->save();
            return back()->with('success', 'Currency Added Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function currencyEdit(CurrencyStoreRequest $request, $id)
    {
        $currency = Currency::findOrFail($id);
        try {
            $fillData = $request->except('_token');
            $currency->fill($fillData)->save();
            return back()->with('success', 'Currency Updated Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function currencyStatusChange(Request $request)
    {
        $currency = Currency::select(['id', 'status'])->findOrFail($request->id);
        try {
            if ($request->status == 'active') {
                $currency->status = 1;
            } else {
                $currency->status = 0;
            }
            $currency->save();
            return back()->with('success', 'Status ' . ucfirst($request->status) . ' Successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function currencySort(Request $request)
    {
        $sortItems = $request->sort;
        foreach ($sortItems as $key => $value) {
            Currency::where('id', $value)->update(['sort_by' => $key + 1]);
        }
    }

    public function currencyDelete($id)
    {
        try {
            Currency::findOrFail($id)->delete();
            return back()->with('success', 'Deleted Successfully');
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
            Currency::whereIn('id', $request->strIds)->get()->map(function ($query) {
                $query->delete();
                return $query;
            });
            session()->flash('success', 'Currency has been deleted successfully');
            return response()->json(['success' => 1]);
        }
    }

    public function multipleStatusChange(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select row.');
            return response()->json(['error' => 1]);
        } else {
            Currency::whereIn('id', $request->strIds)->get()->map(function ($query) {
                if ($query->status) {
                    $query->status = 0;
                } else {
                    $query->status = 1;
                }
                $query->save();
                return $query;
            });
            session()->flash('success', 'Currency status has been changed successfully');
            return response()->json(['success' => 1]);
        }
    }

    public function multipleRateUpdate(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select row.');
            return response()->json(['error' => 1]);
        } else {
            $currencies = Currency::select(['id', 'code', 'rate'])->whereIn('id', $request->strIds)->get();
            $currencyCodes = implode(',', $currencies->pluck('code')->toArray());

            $response = $this->fiatRateUpdate(basicControl()->base_currency, $currencyCodes);

            if ($response['status']) {
                foreach ($response['res'] as $key => $apiRes) {
                    $apiCode = substr($key, -3);
                    $matchingCurrencies = $currencies->where('code', $apiCode);

                    if ($matchingCurrencies->isNotEmpty()) {
                        $matchingCurrencies->each(function ($currency) use ($apiRes) {
                            $currency->update([
                                'rate' => $apiRes,
                            ]);
                        });
                    }
                }
            } else {
                session()->flash('error', $response['res']);
            }

            session()->flash('success', 'Rate Updated successfully');
            return response()->json(['success' => 1]);
        }
    }
}
