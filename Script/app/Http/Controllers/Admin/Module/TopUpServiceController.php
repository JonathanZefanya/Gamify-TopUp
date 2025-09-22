<?php

namespace App\Http\Controllers\Admin\Module;

use App\Exports\TopUpServiceExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopUpServiceRequest;
use App\Imports\TopUpServiceImport;
use App\Models\TopUp;
use App\Models\TopUpService;
use App\Traits\Sample;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class TopUpServiceController extends Controller
{
    use Upload, Sample;

    public function serviceList(Request $request)
    {
        $data['topUp'] = TopUp::select(['id', 'name'])->findOrFail($request->top_up_id);
        $data['services'] = collect(TopUpService::with(['topUp'])->where('top_up_id', $request->top_up_id)->selectRaw('COUNT(id) AS totalService')
            ->selectRaw('COUNT(CASE WHEN status = 1 THEN id END) AS activeService')
            ->selectRaw('(COUNT(CASE WHEN status = 1 THEN id END) / COUNT(id)) * 100 AS activeServicePercentage')
            ->selectRaw('COUNT(CASE WHEN status = 0 THEN id END) AS inActiveService')
            ->selectRaw('(COUNT(CASE WHEN status = 0 THEN id END) / COUNT(id)) * 100 AS inActiveServicePercentage')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) AS todayService')
            ->selectRaw('(COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) / COUNT(id)) * 100 AS todayServicePercentage')
            ->selectRaw('COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN id END) AS thisMonthService')
            ->selectRaw('(COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN id END) / COUNT(id)) * 100 AS thisMonthServicePercentage')
            ->get()
            ->toArray())->collapse();

        return view('admin.topUp.service.index', $data);
    }

    public function serviceSearch(Request $request)
    {
        $search = $request->search['value'] ?? null;
        $filterName = $request->name;
        $filterStatus = $request->filterStatus;
        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0];
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $services = TopUpService::orderBy('sort_by', 'ASC')->where('top_up_id', $request->top_up_id)
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
                    $subquery->where('name', 'LIKE', "%$search%");
                    $subquery->orWhere('price', 'LIKE', "%$search%");
                    $subquery->orWhere('discount', 'LIKE', "%$search%");
                });
            });
        return DataTables::of($services)
            ->addColumn('checkbox', function ($item) {
                return '<input type="checkbox" id="chk-' . $item->id . '"
                                       class="form-check-input row-tic tic-check" name="check" value="' . $item->id . '"
                                       data-id="' . $item->id . '">';

            })
            ->addColumn('name', function ($item) {
                $url = getFile($item->image_driver ?? null, $item->image ?? null);
                $offerContent = $item->is_offered ? '<div class="trending-content"><i class="fa-light fa-badge-percent"></i>' . trans('Campaign') . '</div>' : '';
                return '<a class="d-flex align-items-center me-2">
                                <div class="list-group-item">
                                <i class="sortablejs-custom-handle bi-grip-horizontal list-group-icon"></i>
                                 </div>
                                <div class="flex-shrink-0 trending-notification">
                                ' . $offerContent . '
                                  <div class="avatar avatar-sm avatar-circle">
                                    <img class="avatar-img" src="' . $url . '" alt="Image Description">
                                  </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <h5 class="text-hover-primary mb-0">' . $item->name . '</h5>
                                </div>
                              </a>';

            })
            ->addColumn('price', function ($item) {
                return '<span class="badge bg-soft-primary text-primary">' . basicControl()->currency_symbol . formatAmount($item->price - $item->getDiscount()) . '</span> <sup class="badge bg-soft-dark text-dark ms-1">' . basicControl()->currency_symbol . formatAmount($item->getDiscount()) . ' off</sup>';
            })
            ->addColumn('discount', function ($item) {
                $showType = "%";
                if ($item->discount_type == 'flat') {
                    $showType = basicControl()->base_currency;
                }
                return '<span class="badge bg-soft-danger text-danger">' . $item->discount . ' ' . $showType . '</span>';
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
                    $statusChange = route('admin.topUpService.statusChange') . '?id=' . $item->id . '&status=in-active';
                } else {
                    $statusBtn = "Active";
                    $statusChange = route('admin.topUpService.statusChange') . '?id=' . $item->id . '&status=active';
                }
                $delete = route('admin.topUpService.delete', $item->id);
                $edit = route('admin.topUpService.update', $item->id);
                $image = getFile($item->image_driver ?? null, $item->image ?? null);
                $html = '<div class="btn-group sortable" role="group" data-id ="' . $item->id . '">
                      <a href="javascript:void(0)" class="btn btn-white btn-sm edit_btn" data-bs-target="#editModal" data-bs-toggle="modal"
                      data-route="' . $edit . '" data-name="' . $item->name . '" data-price="' . $item->price . '" data-discount="' . $item->discount . '"
                      data-discount_type="' . $item->discount_type . '" data-image="' . $image . '">
                        <i class="fal fa-edit me-1"></i> ' . trans("Edit") . '
                      </a>';

                $html .= '<div class="btn-group">
                      <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown">
                        <a href="' . $statusChange . '" class="dropdown-item">
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
            ->rawColumns(['checkbox', 'name', 'price', 'discount', 'status', 'created_at', 'action'])
            ->make(true);
    }

    public function serviceStore(TopUpServiceRequest $request)
    {
        TopUp::select(['id'])->findOrFail($request->top_up_id);
        try {
            $service = new TopUpService();
            $fillData = $request->except('_token');
            $service->fill($fillData)->save();
            return back()->with('success', 'Service Created Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function serviceUpdate(TopUpServiceRequest $request, $id)
    {
        $service = TopUpService::findOrFail($id);
        try {
            $fillData = $request->except('_token');
            $service->fill($fillData)->save();
            return back()->with('success', 'Service Updated Successfully');
        } catch (\Exception $e) {
            return back() > with('error', $e->getMessage());
        }
    }

    public function serviceStatusChange(Request $request)
    {
        $service = TopUpService::select(['id', 'status'])->findOrFail($request->id);
        try {
            if ($request->status == 'active') {
                $service->status = 1;
            } else {
                $service->status = 0;
            }
            $service->save();
            return back()->with('success', 'Status ' . ucfirst($request->status) . ' Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function serviceSort(Request $request)
    {
        $sortItems = $request->sort;
        foreach ($sortItems as $key => $value) {
            TopUpService::where('id', $value)->update(['sort_by' => $key + 1]);
        }
    }

    public function serviceDelete($id)
    {
        $service = TopUpService::findOrFail($id);
        try {
            $this->fileDelete($service->image_driver, $service->image);
            $service->delete();
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
            TopUpService::whereIn('id', $request->strIds)->get()->map(function ($query) {
                $this->fileDelete($query->image_driver, $query->image);
                $query->delete();
                return $query;
            });
            session()->flash('success', 'Service has been deleted successfully');
            return response()->json(['success' => 1]);
        }
    }

    public function multipleStatusChange(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select row.');
            return response()->json(['error' => 1]);
        } else {
            TopUpService::select(['id', 'status'])->whereIn('id', $request->strIds)->get()->map(function ($query) {
                if ($query->status) {
                    $query->status = 0;
                } else {
                    $query->status = 1;
                }
                $query->save();
                return $query;
            });
            session()->flash('success', 'Service has been changed successfully');
            return response()->json(['success' => 1]);
        }
    }

    public function serviceExport(Request $request)
    {
        try {
            return Excel::download(new TopUpServiceExport($request), 'services.csv');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function serviceSample()
    {
        try {
            return $this->csvSampleDownload('topUp-service-sample.csv', 'topUp-service-sample');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function serviceImport(Request $request)
    {
        $this->validate($request, [
            'importFile' => 'required|file|mimes:csv',
        ]);

        $topUp = TopUp::select(['id'])->findOrFail($request->topUp);
        try {
            Excel::import(new TopUpServiceImport($topUp->id), $request->file('importFile'));
            return back()->with('success', 'Services Imported Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
