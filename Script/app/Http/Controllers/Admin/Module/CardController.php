<?php

namespace App\Http\Controllers\Admin\Module;

use App\Http\Controllers\Controller;
use App\Http\Requests\CardStoreRequest;
use App\Models\Card;
use App\Models\Category;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CardController extends Controller
{
    use Upload;

    public function list(Request $request)
    {
        $data['cards'] = collect(Card::with(['category'])
            ->when(isset($request->category_id), function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->selectRaw('COUNT(id) AS totalCard')
            ->selectRaw('COUNT(CASE WHEN status = 1 THEN id END) AS activeCard')
            ->selectRaw('(COUNT(CASE WHEN status = 1 THEN id END) / COUNT(id)) * 100 AS activeCardPercentage')
            ->selectRaw('COUNT(CASE WHEN status = 0 THEN id END) AS inActiveCard')
            ->selectRaw('(COUNT(CASE WHEN status = 0 THEN id END) / COUNT(id)) * 100 AS inActiveCardPercentage')
            ->selectRaw('COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) AS todayCard')
            ->selectRaw('(COUNT(CASE WHEN DATE(created_at) = CURRENT_DATE THEN id END) / COUNT(id)) * 100 AS todayCardPercentage')
            ->selectRaw('COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN id END) AS thisMonthCard')
            ->selectRaw('(COUNT(CASE WHEN MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE()) THEN id END) / COUNT(id)) * 100 AS thisMonthCardPercentage')
            ->get()
            ->toArray())->collapse();

        $data['category_id'] = $request->category_id ?? null;
        return view('admin.card.index', $data);
    }

    public function search(Request $request)
    {
        $search = $request->search['value'] ?? null;
        $filterName = $request->name;
        $categoryId = $request->category_id;
        $filterStatus = $request->filterStatus;
        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0];
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $cards = Card::with(['category'])->orderBy('sort_by', 'ASC')
            ->withCount([
                'activeServices',
            ])
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
            })->get();

        return DataTables::of($cards)
            ->addColumn('checkbox', function ($item) {
                return '<input type="checkbox" id="chk-' . $item->id . '"
                                       class="form-check-input row-tic tic-check" name="check" value="' . $item->id . '"
                                       data-id="' . $item->id . '">';

            })
            ->addColumn('name', function ($item) {
                $url = getFile($item->image->preview_driver ?? null, $item->image->preview ?? null);
                return '<a class="d-flex align-items-center me-2" href="javascript:void(0)">
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
            ->addColumn('active_code', function ($item) {
                return '<span class="badge bg-soft-secondary text-dark">' . number_format($item->activeCodeCount()) . '</span>';
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
                                <i class="'.$item->category?->icon.'"></i>
                                <div class="flex-grow-1 ms-3">
                                  <h5 class="text-hover-primary mb-0">' . $item->category?->name . '</h5>
                                </div>
                              </a>';

            })
            ->addColumn('trending', function ($item) {
                if ($item->trending == 1) {
                    return '<span class="badge bg-soft-primary text-primary">
                    <span class="legend-indicator bg-primary"></span>' . trans('Yes') . '
                  </span>';

                } else {
                    return '<span class="badge bg-soft-secondary text-secondary">
                    <span class="legend-indicator bg-secondary"></span>' . trans('No') . '
                  </span>';
                }
            })
            ->addColumn('category', function ($item) {
                return '<a class="d-flex align-items-center me-2" href="javascript:void(0)">
                                <i class="'.$item->category?->icon.'"></i>
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
                    $statusChange = route('admin.card.statusChange') . '?id=' . $item->id . '&status=in-active';
                } else {
                    $statusBtn = "Active";
                    $statusChange = route('admin.card.statusChange') . '?id=' . $item->id . '&status=active';
                }
                $delete = route('admin.card.delete', $item->id);
                $trending = route('admin.card.trending', $item->id);
                $edit = route('admin.card.edit', $item->id);
                $service = route('admin.cardService.list') . '?card_id=' . $item->id;

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
                        <a class="dropdown-item trending_btn" href="javascript:void(0)" data-bs-target="#trending"
                           data-bs-toggle="modal" data-route="' . $trending . '">
                          <i class="fal fa-chart-line-up dropdown-item-icon"></i> ' . trans("Manage Trending") . '
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
            ->rawColumns(['checkbox', 'name', 'active_service', 'active_code','trending', 'instant_delivery', 'status', 'category', 'created_at', 'action'])
            ->make(true);
    }

    public function store(CardStoreRequest $request)
    {
        if ($request->method() == 'GET') {
            $data['categories'] = Category::active()->type('card')->sort()->get();
            return view('admin.card.create', $data);
        } elseif ($request->method() == 'POST') {
            try {
                $card = new Card();
                $fillData = $request->except('_token');
                $fillData['image'] = $this->processImages($fillData);

                $card->fill($fillData)->save();

                return back()->with('success', 'Card Created Successfully');
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }
    }

    public function statusChange(Request $request)
    {
        $card = Card::select(['id', 'status'])->findOrFail($request->id);
        try {
            if ($request->status == 'active') {
                $card->status = 1;
            } else {
                $card->status = 0;
            }
            $card->save();
            return back()->with('success', 'Status ' . ucfirst($request->status) . ' Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function sort(Request $request)
    {
        $sortItems = $request->sort;
        foreach ($sortItems as $key => $value) {
            Card::where('id', $value)->update(['sort_by' => $key + 1]);
        }
    }

    public function trending($id){
        try {
            $card = Card::select(['id', 'trending'])->findOrFail($id);

            $card->trending = ($card->trending == 0) ? 1 : 0;
            $card->save();

            $message = ($card->trending == 0) ? 'Removed From Trending List.' : 'Added To Trending List.';

            return back()->with('success', $message);
        }catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }

    }
    public function delete($id)
    {
        try {
            $card = Card::findOrFail($id);
            $images = [
                ['driver' => $card->image->image_driver ?? null, 'path' => $card->image->image ?? null],
                ['driver' => $card->image->preview_driver ?? null, 'path' => $card->image->preview ?? null],
                ['driver' => $card->image->banner_driver ?? null, 'path' => $card->image->banner ?? null],
            ];
            foreach ($images as $image) {
                $this->fileDelete($image['driver'], $image['path']);
            }
            $card->delete();
            return back()->with('success', 'Deleted Successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(CardStoreRequest $request, $id)
    {
        $card = Card::FindOrFail($id);
        if ($request->method() == 'GET') {
            $categories = Category::active()->type('card')->sort()->get();
            return view('admin.card.edit', compact('card', 'categories'));
        } elseif ($request->method() == 'POST') {
            try {
                $fillData = $request->except('_token');
                $fillData['image'] = $this->processImages($fillData, $card);

                $card->fill($fillData)->save();

                return back()->with('success', 'Card has been updated successfully');
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
            Card::whereIn('id', $request->strIds)->get()->map(function ($query) {
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
            session()->flash('success', 'Card has been deleted successfully');
            return response()->json(['success' => 1]);
        }
    }
    public function multipleTrending(Request $request)
    {
        if (empty($request->strIds)) {
            session()->flash('error', 'No rows were selected.');
            return response()->json(['error' => 1]);
        }

        Card::whereIn('id', $request->strIds)->each(function ($card) {
            $card->trending = !$card->trending;
            $card->save();
        });

        session()->flash('success', 'Trending status has been updated successfully.');
        return response()->json(['success' => 1]);
    }

    public function multipleStatusChange(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select row.');
            return response()->json(['error' => 1]);
        } else {
            Card::select(['id', 'status'])->whereIn('id', $request->strIds)->get()->map(function ($query) {
                if ($query->status) {
                    $query->status = 0;
                } else {
                    $query->status = 1;
                }
                $query->save();
                return $query;
            });
            session()->flash('success', 'Card has been changed successfully');
            return response()->json(['success' => 1]);
        }
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
                config('filelocation.card.path'),
                null,
                config('filelocation.card.' . $key . '_size'),
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
