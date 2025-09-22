<?php

namespace App\Http\Controllers\Admin\Module;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    use Upload;

    public function categoryList(Request $request)
    {
        if (!in_array($request->type, ['top_up', 'card'])) {
            return back()->with('error', 'Something went wrong');
        }
        $data['categories'] = collect(Category::selectRaw('COUNT(id) AS totalCategory')
            ->selectRaw('COUNT(CASE WHEN status = 1 THEN id END) AS activeCategory')
            ->selectRaw('(COUNT(CASE WHEN status = 1 THEN id END) / COUNT(id)) * 100 AS activeCategoryPercentage')
            ->selectRaw('COUNT(CASE WHEN status = 0 THEN id END) AS inActiveCategory')
            ->selectRaw('(COUNT(CASE WHEN status = 0 THEN id END) / COUNT(id)) * 100 AS inActiveCategoryPercentage')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) AS todayCategory')
            ->selectRaw('(COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) / COUNT(id)) * 100 AS todayCategoryPercentage')
            ->selectRaw('COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN id END) AS thisMonthCategory')
            ->selectRaw('(COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN id END) / COUNT(id)) * 100 AS thisMonthCategoryPercentage')
            ->where('type', $request->type)
            ->get()
            ->toArray())->collapse();
        $data['pageTitle'] = snake2Title($request->type) . ' Category';
        $data['type'] = $request->type;
        return view('admin.category.index', $data);
    }


    public function categoryListSearch(Request $request)
    {
        $search = $request->search['value'] ?? null;
        $filterName = $request->name;
        $filterStatus = $request->filterStatus;
        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0];
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $categories = Category::orderBy('sort_by', 'ASC')->where('type', $request->type)
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
                });
            });
        return DataTables::of($categories)
            ->addColumn('name', function ($item) {
                return '<a class="d-flex align-items-center me-2">
                                <div class="list-group-item">
                                    <i class="sortablejs-custom-handle bi-grip-horizontal list-group-icon"></i>
                                  </div>
                                <i class="' . $item->icon . '"></i>
                                <div class="flex-grow-1 ms-3">
                                  <h5 class="text-hover-primary mb-0">' . $item->name . '</h5>
                                </div>
                              </a>';

            })
            ->addColumn('active_service', function ($item) use ($request) {
                return '<span class="badge bg-soft-primary text-primary">' . number_format($item->active_children) . '</span>';
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
                    $statusChange = route('admin.categoryStatusChange') . '?id=' . $item->id . '&status=in-active';
                } else {
                    $statusBtn = "Active";
                    $statusChange = route('admin.categoryStatusChange') . '?id=' . $item->id . '&status=active';
                }
                $delete = route('admin.categoryDelete', $item->id);
                if ($item->type == 'top_up') {
                    $childRoute = route('admin.topUpList') . '?category_id=' . $item->id;
                } elseif ($item->type == 'card') {
                    $childRoute = route('admin.card.list') . '?category_id=' . $item->id;
                } elseif ($item->type == 'game') {
                    $childRoute = route('admin.game.list') . '?category_id=' . $item->id;
                }
                $html = '<div class="btn-group sortable" role="group" data-id ="' . $item->id . '">
                      <a href="javascript:void(0)" class="btn btn-white btn-sm edit_btn" data-bs-target="#editModal" data-bs-toggle="modal"
                       data-name="' . $item->name . '" data-icon="' . $item->icon . '"
                       data-route="' . route('admin.categoryEdit', $item->id) . '">
                        <i class="fal fa-edit me-1"></i> ' . trans("Edit") . '
                      </a>';

                $html .= '<div class="btn-group">
                      <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown">
                        <a class="dropdown-item" href="' . $childRoute . '">
                          <i class="fal fa-eye dropdown-item-icon"></i> ' . trans("Child") . '
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
            ->rawColumns(['name', 'active_service', 'status', 'created_at', 'action'])
            ->make(true);
    }

    public function categoryCreate(CategoryStoreRequest $request)
    {
        if (!in_array($request->type, ['top_up', 'card'])) {
            return back()->with('error', 'Something went wrong');
        }
        try {
            $category = new Category();
            $fillData = $request->except('_token');
            $category->fill($fillData)->save();
            return back()->with('success', 'Category Created Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function categoryEdit(CategoryUpdateRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        try {
            $fillData = $request->except('_token');
            $category->fill($fillData)->save();
            return back()->with('success', 'Category Updated Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function categoryStatusChange(Request $request)
    {
        $category = Category::select(['id', 'status'])->findOrFail($request->id);
        try {
            if ($request->status == 'active') {
                $category->status = 1;
            } else {
                $category->status = 0;
            }
            $category->save();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', 'Status ' . ucfirst($request->status) . ' Successfully');
    }

    public function categorySort(Request $request)
    {
        $sortItems = $request->sort;
        foreach ($sortItems as $key => $value) {
            Category::where('id', $value)->update(['sort_by' => $key + 1]);
        }
    }

    public function categoryDelete($id)
    {
        try {
            Category::findOrFail($id)->delete();
            return back()->with('success', 'Deleted Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
