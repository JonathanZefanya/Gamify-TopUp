<?php

namespace App\Http\Controllers\Admin\Module;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopUpStoreRequest;
use App\Models\Category;
use App\Models\TopUp;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TopUpController extends Controller
{
    use Upload;

    public function topUpList(Request $request)
    {
        $data['topUps'] = collect(TopUp::when(isset($request->category_id), function ($query) use ($request) {
            $query->where('category_id', $request->category_id);
        })
            ->selectRaw('COUNT(id) AS totalTopUp')
            ->selectRaw('COUNT(CASE WHEN status = 1 THEN id END) AS activeTopUp')
            ->selectRaw('(COUNT(CASE WHEN status = 1 THEN id END) / COUNT(id)) * 100 AS activeTopUpPercentage')
            ->selectRaw('COUNT(CASE WHEN status = 0 THEN id END) AS inActiveTopUp')
            ->selectRaw('(COUNT(CASE WHEN status = 0 THEN id END) / COUNT(id)) * 100 AS inActiveTopUpPercentage')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) AS todayTopUp')
            ->selectRaw('(COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) / COUNT(id)) * 100 AS todayTopUpPercentage')
            ->selectRaw('COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN id END) AS thisMonthTopUp')
            ->selectRaw('(COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN id END) / COUNT(id)) * 100 AS thisMonthTopUpPercentage')
            ->get()
            ->toArray())->collapse();

        $data['category_id'] = $request->category_id ?? null;
        return view('admin.topUp.index', $data);
    }

    public function topUpListSearch(Request $request)
    {
        $search = $request->search['value'] ?? null;
        $filterName = $request->name;
        $categoryId = $request->category_id;
        $filterStatus = $request->filterStatus;
        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0];
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $topUps = TopUp::with(['category'])->orderBy('sort_by', 'ASC')
            ->withCount('activeServices')
            ->when(isset($categoryId), function ($query) use ($categoryId) {
                return $query->where('category_id', $categoryId);
            })
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
                    $subquery->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('region', 'LIKE', "%{$search}%")
                        ->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'LIKE', "%{$search}%");
                        });
                });
            });
        return DataTables::of($topUps)
            ->addColumn('checkbox', function ($item) {
                return '<input type="checkbox" id="chk-' . $item->id . '"
                                       class="form-check-input row-tic tic-check" name="check" value="' . $item->id . '"
                                       data-id="' . $item->id . '">';

            })
            ->addColumn('name', function ($item) {
                $url = getFile($item->image->preview_driver ?? null, $item->image->preview ?? null);
                return '<a class="d-flex align-items-center me-2">
                            <div class="list-group-item">
                                <i class="sortablejs-custom-handle bi-grip-horizontal list-group-icon"></i>
                              </div>
                            <div class="flex-shrink-0">
                                <div class="avatar avatar-sm avatar-circle">
                                    <img class="avatar-img" src="' . $url . '" alt="Image Description">
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="text-hover-primary mb-0">' . $item->name . '</h5>
                                <p class="text-hover-primary mb-0">' . $item->region . '</p>
                            </div>
                        </a>
                    ';
            })
            ->addColumn('active_service', function ($item) {
                return '<span class="badge bg-soft-primary text-primary">' . number_format($item->active_services_count) . '</span>';
            })
            ->addColumn('instant_delivery', function ($item) {
                if ($item->instant_delivery == 1) {
                    return '<span class="badge bg-soft-primary text-primary">' . trans('Yes') . '</span>';

                } else {
                    return '<span class="badge bg-soft-warning text-warning">' . trans('No') . '</span>';
                }
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
            ->addColumn('category', function ($item) {
                return '<a class="d-flex align-items-center me-2" href="javascript:void(0)">
                                <i class="' . $item->category?->icon . '"></i>
                                <div class="flex-grow-1 ms-3">
                                  <h5 class="text-hover-primary mb-0">' . $item->category?->name . '</h5>
                                </div>
                              </a>';

            })
            ->addColumn('created_at', function ($item) {
                return dateTime($item->created_at, basicControl()->date_time_format);
            })
            ->addColumn('action', function ($item) {
                if ($item->status) {
                    $statusBtn = "In-Active";
                    $statusChange = route('admin.topUpStatusChange') . '?id=' . $item->id . '&status=in-active';
                } else {
                    $statusBtn = "Active";
                    $statusChange = route('admin.topUpStatusChange') . '?id=' . $item->id . '&status=active';
                }
                $delete = route('admin.topUpDelete', $item->id);
                $edit = route('admin.topUpEdit', $item->id);
                $service = route('admin.topUpService.list') . '?top_up_id=' . $item->id;

                $html = '<div class="btn-group sortable" role="group" data-id ="' . $item->id . '">
                      <a href="' . $edit . '" class="btn btn-white btn-sm">
                        <i class="fal fa-edit me-1"></i> ' . trans("Edit") . '
                      </a>';

                $html .= '<div class="btn-group">
                      <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown">
                        <a href="' . $service . '" class="dropdown-item">
                            <i class="fas fa-dice dropdown-item-icon"></i> ' . trans("Service List") . '
                        </a>
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
            ->rawColumns(['checkbox', 'name', 'active_service', 'instant_delivery', 'status', 'category', 'created_at', 'action'])
            ->make(true);
    }

    public function topUpStore(TopUpStoreRequest $request)
    {
        if ($request->method() == 'GET') {
            $data['categories'] = Category::active()->type('top_up')->sort()->get();
            return view('admin.topUp.create', $data);
        } elseif ($request->method() == 'POST') {
            try {
                $topUp = new TopUp();
                $fillData = $request->except('_token');
                $orderFields = [
                    'field_value', 'field_placeholder', 'field_note',
                    'field_type', 'field_option_name', 'field_option_value'
                ];

                $fillData = $this->processOrderFields($fillData, $orderFields);
                $fillData['image'] = $this->processImages($fillData);

                $topUp->fill($fillData)->save();

                return back()->with('success', 'Top Up Created Successfully');
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }
    }

    public function topUpStatusChange(Request $request)
    {
        $topUp = TopUp::select(['id', 'status'])->findOrFail($request->id);
        try {
            if ($request->status == 'active') {
                $topUp->status = 1;
            } else {
                $topUp->status = 0;
            }
            $topUp->save();
            return back()->with('success', 'Status ' . ucfirst($request->status) . ' Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function topUpSort(Request $request)
    {
        $sortItems = $request->sort;
        foreach ($sortItems as $key => $value) {
            TopUp::where('id', $value)->update(['sort_by' => $key + 1]);
        }
    }

    public function topUpDelete($id)
    {
        try {
            $topUp = TopUp::findOrFail($id);
            $images = [
                ['driver' => $topUp->image->image_driver ?? null, 'path' => $topUp->image->image ?? null],
                ['driver' => $topUp->image->preview_driver ?? null, 'path' => $topUp->image->preview ?? null],
                ['driver' => $topUp->image->banner_driver ?? null, 'path' => $topUp->image->banner ?? null],
            ];
            foreach ($images as $image) {
                $this->fileDelete($image['driver'], $image['path']);
            }
            $topUp->delete();
            return back()->with('success', 'Deleted Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function topUpEdit(TopUpStoreRequest $request, $id)
    {
        $topUp = TopUp::FindOrFail($id);
        if ($request->method() == 'GET') {
            $categories = Category::active()->type('top_up')->sort()->get();
            return view('admin.topUp.edit', compact('topUp', 'categories'));
        } elseif ($request->method() == 'POST') {
            try {
                $fillData = $request->except('_token');
                $orderFields = [
                    'field_value', 'field_placeholder', 'field_note',
                    'field_type', 'field_option_name', 'field_option_value'
                ];

                $fillData = $this->processOrderFields($fillData, $orderFields);
                $fillData['image'] = $this->processImages($fillData, $topUp);

                $topUp->fill($fillData)->save();

                return back()->with('success', 'Top Up has been updated successfully');
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }
    }

    public function multipleDelete(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select row.');
            return response()->json(['error' => 1]);
        } else {
            TopUp::whereIn('id', $request->strIds)->get()->map(function ($query) {
                $images = [
                    ['driver' => $query->image->image_driver ?? null, 'path' => $query->image->image ?? null],
                    ['driver' => $query->image->preview_driver ?? null, 'path' => $query->image->preview ?? null],
                    ['driver' => $query->image->banner_driver ?? null, 'path' => $query->image->banner ?? null],
                ];
                foreach ($images as $image) {
                    $this->fileDelete($image['driver'], $image['path']);
                }
                $query->delete();
                return $query;
            });
            session()->flash('success', 'Top Up has been deleted successfully');
            return response()->json(['success' => 1]);
        }
    }

    public function multipleStatusChange(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select row.');
            return response()->json(['error' => 1]);
        } else {
            TopUp::select(['id', 'status'])->whereIn('id', $request->strIds)->get()->map(function ($query) {
                if ($query->status) {
                    $query->status = 0;
                } else {
                    $query->status = 1;
                }
                $query->save();
                return $query;
            });
            session()->flash('success', 'Top Up has been changed successfully');
            return response()->json(['success' => 1]);
        }
    }

    private function processOrderFields($fillData, $orderFields)
    {
        foreach ($orderFields as $field) {
            if (!empty($fillData[$field])) {
                foreach ($fillData[$field] as $key => $fieldNames) {
                    if ($field === 'field_option_name' || $field === 'field_option_value') {
                        $fillData = $this->processOptionFields($fillData, $field, $fieldNames, $key);
                    } else {
                        foreach ($fieldNames as $fieldValue) {
                            $fillData['order_information'][$key][$field] = $fieldValue;
                            if ($field == 'field_value') {
                                $fillData['order_information'][$key]['field_name'] = title2snake($fieldValue);
                            }
                        }
                    }
                }
            }
        }

        return $fillData;
    }

    private function processOptionFields($fillData, $field, $fieldNames, $key)
    {
        if (!empty($fieldNames[0])) {
            if ($field === 'field_option_name') {
                $fillData['optionNames'][$key] = $fieldNames;
            } else {
                $optionNames = isset($fillData['optionNames'][$key]) ? $fillData['optionNames'][$key] : [];
                foreach ($fieldNames as $i => $fieldValue) {
                    if (isset($optionNames[$i])) {
                        $fillData['order_information'][$key]['option'][$optionNames[$i]] = $fieldValue;
                    }
                }
            }
        }

        return $fillData;
    }

    private function processImages($fillData, $topUP = null)
    {

        $images = [
            'image' => $fillData['image'] ?? null,
            'preview' => $fillData['preview_image'] ?? null,
        ];

        $imageData = [];
        foreach ($images as $key => $image) {
            if ($image) {
                $uploadedImage = $this->uploadImage($image, $key, $topUP);
                if ($uploadedImage) {
                    $imageData[$key] = $uploadedImage['path'];
                    $imageData[$key . '_driver'] = $uploadedImage['driver'];
                }
            } else {
                $imageData[$key] = $topUP->image->{$key} ?? null;
                $imageData[$key . '_driver'] = $topUP->image->{$key . '_driver'} ?? null;
            }
        }

        return $imageData;
    }

    private function uploadImage($image, $key, $topUP = null)
    {
        try {
            return $this->fileUpload(
                $image,
                config('filelocation.topUp.path'),
                null,
                config('filelocation.topUp.' . $key . '_size'),
                'webp',
                60,
                $topUP->image->{$key} ?? null,
                $imageData[$key . '_driver'] = $topUP->image->{$key . '_driver'} ?? null,

            );
        } catch (\Exception $e) {
            return null;
        }
    }
}
