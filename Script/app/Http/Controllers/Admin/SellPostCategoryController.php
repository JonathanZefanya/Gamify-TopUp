<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\SellPost;
use App\Models\Language;
use App\Models\SellPostCategory;
use App\Models\SellPostCategoryDetail;
use App\Models\SellPostChat;
use App\Models\SellPostOffer;
use App\Traits\Notify;
use App\Traits\SellPostTrait;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SellPostCategoryController extends Controller
{
    use Upload, Notify, SellPostTrait;

    public function category()
    {
        $manageCategory = SellPostCategory::with(['details'])->withCount('activePost')->latest()->get();
        return view('admin.sellPostCategory.categoryList', compact('manageCategory'));
    }

    public function categoryCreate()
    {
        $languages = Language::all();
        return view('admin.sellPostCategory.categoryCreate', compact('languages'));
    }

    public function categoryStore(Request $request, $language)
    {

        $purifiedData = $request->all();
        DB::beginTransaction();
        try {
            if ($request->has('image')) {
                $purifiedData['image'] = $request->image;
            }

            $rules = [
                'name.*' => 'required|max:40',
                'sell_charge' => 'sometimes|required|numeric|min:1',
                'image' => 'required|mimes:jpg,jpeg,png',
            ];
            $message = [
                'name.*.required' => 'Name field is required',
                'name.*.max' => 'This field may not be greater than :max characters',
                'image.required' => 'Image is required',
                'sell_charge.required' => 'Sell Charge  is required',
            ];

            $validate = Validator::make($purifiedData, $rules, $message);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }

            $category = new SellPostCategory();

            $input_form = [];
            if ($request->has('field_name')) {
                for ($a = 0; $a < count($request->field_name); $a++) {
                    $arr = array();
                    $arr['field_name'] = clean($request->field_name[$a]);
                    $arr['field_level'] = $request->field_name[$a];
                    $arr['type'] = $request->type[$a];
                    $arr['validation'] = $request->validation[$a];
                    $input_form[$arr['field_name']] = $arr;
                }
            }

            $input_post = [];
            if ($request->has('field_specification')) {
                for ($a = 0; $a < count($request->field_specification); $a++) {
                    $arr = array();
                    $arr['field_name'] = clean($request->field_specification[$a]);
                    $arr['field_level'] = $request->field_specification[$a];
                    $arr['type'] = $request->type[$a];
                    $arr['validation'] = $request->validation_specification[$a];
                    $input_post[$arr['field_name']] = $arr;
                }
            }

            if (isset($purifiedData['field_name'])) {
                $category->form_field = $input_form;
            }

            if (isset($purifiedData['field_specification'])) {
                $category->post_specification_form = $input_post;
            }

            if ($request->has('status')) {
                $category->status = $request->status;
            }

            if ($request->has('sell_charge')) {
                $category->sell_charge = $request->sell_charge;
            }


            if ($request->hasFile('image')) {
                try {
                    $imageUp = $this->fileUpload($purifiedData['image'], config('filelocation.sellPostCategory.path'), null, config('filelocation.sellPostCategory.size'), 'webp');
                    $category->image = $imageUp['path'];
                    $category->image_driver = $imageUp['driver'];
                } catch (\Exception $exp) {
                    return back()->with('error', 'Image could not be uploaded.');
                }
            }

            $category->save();

            $category->details()->create([
                'language_id' => $language,
                'name' => $purifiedData["name"][$language],
            ]);

            DB::commit();

            return back()->with('success', 'Category Successfully Saved');
        } catch (\Exception$e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function categoryEdit($id)
    {
        $languages = Language::all();
        $categoryDetails = SellPostCategoryDetail::with('sellPostCategory')->where('sell_post_category_id', $id)->get()->groupBy('language_id');
        return view('admin.sellPostCategory.categoryEdit', compact('languages', 'categoryDetails', 'id'));
    }


    public function categoryUpdate(Request $request, $id, $language_id)
    {
        $purifiedData = $request->all();
        DB::beginTransaction();

        try {
            if ($request->has('image')) {
                $purifiedData['image'] = $request->image;
            }

            $rules = [
                'name.*' => 'required|max:40',
                'sell_charge' => 'sometimes|required|numeric|min:1',
            ];
            $message = [
                'name.*.required' => 'Name field is required',
                'name.*.max' => 'This field may not be greater than :max characters',
                'sell_charge.required' => 'Sell Charge  is required',
            ];

            $validate = Validator::make($purifiedData, $rules, $message);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }

            $input_form = [];
            if ($request->has('field_name')) {
                for ($a = 0; $a < count($request->field_name); $a++) {
                    $arr = array();
                    $arr['field_name'] = clean($request->field_name[$a]);
                    $arr['field_level'] = $request->field_name[$a];
                    $arr['type'] = $request->type[$a];
                    $arr['validation'] = $request->validation[$a];
                    $input_form[$arr['field_name']] = $arr;
                }
            }

            $input_post = [];
            if ($request->has('field_specification')) {
                for ($a = 0; $a < count($request->field_specification); $a++) {
                    $arr = array();
                    $arr['field_name'] = clean($request->field_specification[$a]);
                    $arr['field_level'] = $request->field_specification[$a];
                    $arr['type'] = $request->type[$a];
                    $arr['validation'] = $request->validation_specification[$a];
                    $input_post[$arr['field_name']] = $arr;
                }
            }

            $category = SellPostCategory::findOrFail($id);

            if ($request->hasFile('image')) {
                $imageUp = $this->fileUpload($purifiedData['image'], config('filelocation.sellPostCategory.path'), null, config('filelocation.sellPostCategory.size'), 'webp', null, $category->image, $category->image_driver);
                $category->image = $imageUp['path'];
                $category->image_driver = $imageUp['driver'];
            }

            if (isset($purifiedData['field_name'])) {
                $category->form_field = $input_form;
            }

            if (isset($purifiedData['field_specification'])) {
                $category->post_specification_form = $input_post;
            }

            if (isset($purifiedData['sell_charge'])) {
                $category->sell_charge = $request->sell_charge;
            }


            if ($request->has('status')) {
                $category->status = $request->status;
            }
            $category->save();

            $category->details()->updateOrCreate([
                'language_id' => $language_id
            ],
                [
                    'name' => $purifiedData["name"][$language_id],
                ]
            );
            DB::commit();

            return back()->with('success', 'Category Successfully Updated');

        } catch (\Exception$e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

    }

    public function statusSellMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Category.');
            return response()->json(['error' => 1]);
        } else {
            SellPostCategory::whereIn('id', $request->strIds)->get()->map(function ($query) {
                $query->status = $query->status ? 0 : 1;
                $query->save();
            });
            session()->flash('success', 'Status has been active');
            return response()->json(['success' => 1]);
        }
    }

    public function categoryDelete($id)
    {
        $categoryData = SellPostCategory::findOrFail($id);
        if (0 < $categoryData->post->count()) {
            session()->flash('warning', 'This Category has a lot of post');
            return back();
        }

        $this->fileDelete($categoryData->image_driver, $categoryData->image);

        $categoryData->delete();
        return back()->with('success', 'Category has been deleted');
    }

    public function sellList($status = null)
    {
        $data['value'] = $this->getValueByStatus($status);
        abort_if(!isset($data['value']), 404);

        $data['sellPost'] = collect(SellPost::selectRaw('COUNT(id) AS totalPost')
            ->selectRaw('COUNT(CASE WHEN status = 1 THEN id END) AS approvalPost')
            ->selectRaw('(COUNT(CASE WHEN status = 1 THEN id END) / COUNT(id)) * 100 AS approvalPostPercentage')
            ->selectRaw('COUNT(CASE WHEN status = 0 THEN id END) AS pendingPost')
            ->selectRaw('(COUNT(CASE WHEN status = 0 THEN id END) / COUNT(id)) * 100 AS pendingPostPercentage')
            ->selectRaw('COUNT(CASE WHEN status = 3 THEN id END) AS holdPost')
            ->selectRaw('(COUNT(CASE WHEN status = 3 THEN id END) / COUNT(id)) * 100 AS holdPostPercentage')
            ->selectRaw('COUNT(CASE WHEN status = 5 THEN id END) AS hardPost')
            ->selectRaw('(COUNT(CASE WHEN status = 5 THEN id END) / COUNT(id)) * 100 AS hardPostPercentage')
            ->get()
            ->toArray())->collapse();

        return view('admin.sellPostList.index', $data);
    }

    public function sellListSearch(Request $request, $status = null)
    {
        $search = $request->search['value'] ?? null;
        $filterName = $request->name;
        $filterUser = $request->user;
        $filterDate = explode('-', $request->filterDate);
        $startDate = $filterDate[0];
        $endDate = isset($filterDate[1]) ? trim($filterDate[1]) : null;

        $posts = SellPost::status($status)->latest()
            ->has('user')
            ->when(isset($filterName), function ($query) use ($filterName) {
                return $query->where('title', 'LIKE', '%' . $filterName . '%');
            })
            ->when(isset($filterUser), function ($query) use ($filterUser) {
                $query->whereHas('user', function ($qq) use ($filterUser) {
                    $qq->where('firstname', 'LIKE', '%' . $filterUser . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $filterUser . '%')
                        ->orWhere('username', 'LIKE', '%' . $filterUser . '%');
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
            ->when(!empty($search), function ($query) use ($search) {
                return $query->where(function ($subquery) use ($search) {
                    $subquery->where('title', 'LIKE', '%' . $search . '%')
                        ->orWhereHas('category.details', function ($qq) use ($search) {
                            $qq->where('name', 'LIKE', '%' . $search . '%');
                        });
                });
            });
        return DataTables::of($posts)
            ->addColumn('title', function ($item) {
                $extra = null;
                if ($item->payment_status) {
                    $extra = '<span class="badge bg-success">' . trans('Sold') . '</span>
                             <span class="badge bg-secondary">' . $item->sellPostPayment?->transaction . '</span>';
                }
                return $item->title . ' ' . $extra;

            })
            ->addColumn('category', function ($item) {
                return optional($item->category)->details->name??null;
            })
            ->addColumn('price', function ($item) {
                return '<h5>' . currencyPosition($item->price) . '</h5>';
            })
            ->addColumn('user', function ($item) {
                $url = route("admin.user.edit", $item->user_id);
                return '<a class="d-flex align-items-center me-2" href="' . $url . '">
                                <div class="flex-shrink-0">
                                  ' . optional($item->user)->profilePicture() . '
                                </div>
                                <div class="flex-grow-1 ms-3">
                                  <h5 class="text-hover-primary mb-0">' . optional($item->user)->firstname . ' ' . optional($item->user)->lastname . '</h5>
                                  <span class="fs-6 text-body">@' . optional($item->user)->username . '</span>
                                </div>
                              </a>';
            })
            ->addColumn('status', function ($item) {
                return $item->statusMessage;
            })
            ->addColumn('date_at', function ($item) {
                return dateTime($item->created_at, basicControl()->date_time_format);
            })
            ->addColumn('action', function ($item) {
                $conversion = route('admin.sellPost.offer', [$item->id]);
                $edit = route('admin.sell.details', $item->id);

                $html = '<div class="btn-group sortable" role="group">
                      <a href="' . $edit . '" class="btn btn-white btn-sm">
                        <i class="fal fa-edit me-1"></i> ' . trans("Edit") . '
                      </a>';

                $html .= '<div class="btn-group">
                      <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="userEditDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userEditDropdown">
                        <a href="' . $conversion . '" class="dropdown-item">
                            <i class="fas fa-comments dropdown-item-icon"></i> ' . trans("Conversation") . '
                        </a>
                      </div>
                    </div>';

                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['title', 'category', 'price', 'user', 'status', 'date_at', 'action'])
            ->make(true);
    }

    public function sellDetails($id)
    {
        $data['activity'] = ActivityLog::whereSell_post_id($id)->with('activityable:id,username,image,image_driver')->orderBy('id', 'desc')->get();

        $data['category'] = SellPostCategory::with('details')->whereStatus(1)->get();
        $data['sellPost'] = SellPost::findOrFail($id);

        return view('admin.sellPostList.edit', $data);
    }

    public function SellUpdate(Request $request, $id)
    {
        $purifiedData = $request->all();

        try {
            if ($request->has('image')) {
                $purifiedData['image'] = $request->image;
            }

            $rules = [
                'title' => 'required|max:40',
                'price' => 'required',
                'details' => 'required',
            ];
            $message = [
                'title.required' => 'Title field is required',
                'price.required' => 'Price field is required',
                'details.required' => 'Details field is required',
            ];

            $validate = Validator::make($purifiedData, $rules, $message);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }


            $gameSell = SellPost::findOrFail($id);
            $gameSell->category_id = $request->category;

            $category = SellPostCategory::whereStatus(1)->findOrFail($gameSell->category_id);
            $rules = [];
            $inputField = [];
            if ($category->form_field != null) {
                foreach ($category->form_field as $key => $cus) {
                    $rules[$key] = [$cus->validation];
                    if ($cus->type == 'text') {
                        array_push($rules[$key], 'max:191');
                    }
                    if ($cus->type == 'textarea') {
                        array_push($rules[$key], 'max:300');
                    }
                    $inputField[] = $key;
                }
            }

            $rulesSpecification = [];
            $inputFieldSpecification = [];
            if ($category->post_specification_form != null) {
                foreach ($category->post_specification_form as $key => $cus) {
                    $rulesSpecification[$key] = [$cus->validation];
                    if ($cus->type == 'text') {
                        array_push($rulesSpecification[$key], 'max:191');
                    }
                    if ($cus->type == 'textarea') {
                        array_push($rulesSpecification[$key], 'max:300');
                    }
                    $inputFieldSpecification[] = $key;
                }
            }

            $collection = collect($request);
            $reqField = [];
            if ($category->form_field != null) {
                foreach ($collection as $k => $v) {
                    foreach ($category->form_field as $inKey => $inVal) {
                        if ($k != $inKey) {
                            continue;
                        } else {
                            $reqField[$inKey] = [
                                'field_name' => $inKey,
                                'field_value' => $v,
                                'type' => $inVal->type,
                                'validation' => $inVal->validation,
                            ];
                        }
                    }
                }
                $gameSell['credential'] = $reqField;
            } else {
                $gameSell['credential'] = null;
            }


            $collectionSpecification = collect($request);
            $reqFieldSpecification = [];
            if ($category->post_specification_form != null) {
                foreach ($collectionSpecification as $k => $v) {
                    foreach ($category->post_specification_form as $inKey => $inVal) {
                        if ($k != $inKey) {
                            continue;
                        } else {
                            $reqFieldSpecification[$inKey] = [
                                'field_name' => $inKey,
                                'field_value' => $v,
                                'type' => $inVal->type,
                                'validation' => $inVal->validation,
                            ];
                        }
                    }
                }
                $gameSell['post_specification_form'] = $reqFieldSpecification;
            } else {
                $gameSell['post_specification_form'] = null;
            }


            $images = array();
            if ($request->hasFile('image')) {

                try {
                    $gameImage = $purifiedData['image'];
                    $gamesellDriver = $gameSell->image_driver ?? 'local';
                    $oldImages = $request->oldImage ?? [];
                    $images = [];
                    $imagesDriver = [];

                    foreach ($gameImage as $file) {
                        $imageUp = $this->fileUpload($file, config('filelocation.sellingPost.path'), null, config('filelocation.sellingPost.thumb'), 'webp');
                        $images[] = $imageUp['path'];
                        $imagesDriver[] = $imageUp['driver'];
                    }
                    if (isset($request->changedImage) && count($request->changedImage) > 0) {
                        foreach ($request->changedImage as $key => $imageOld) {
                            if ($imageOld == 'changed') {
                                $this->fileDelete($gamesellDriver, $oldImages[$key]);
                                unset($oldImages[$key]);
                            }
                        }
                    }

                    $mergedImages = array_merge($oldImages, $images);

                    $gameSell->image = $mergedImages;
                    $gameSell->image_driver = $imagesDriver['0'];

                } catch (\Exception $exp) {
                    return back()->with('error', 'Image could not be uploaded.');
                }
            }

            if (isset($purifiedData['title'])) {
                $gameSell->title = $request->title;
            }
            if (isset($purifiedData['price'])) {
                $gameSell->price = $request->price;
            }

            if (isset($purifiedData['credential'])) {
                $gameSell->credential = $request->credential;
            }

            if (isset($purifiedData['details'])) {
                $gameSell->details = $request->details;
            }

            if (isset($purifiedData['status'])) {
                $gameSell->status = isset($purifiedData['status']) ? 1 : 0;
            }


            $gameSell->save();


            return back()->with('success', 'Successfully Updated');
        } catch (\Exception$e) {

            return back();
        }
    }

    public function sellAction(Request $request)
    {
        DB::beginTransaction();
        try {
            $gameSell = SellPost::findOrFail($request->sell_post_id);
            $gameSell->status = $request->status;
            $gameSell->save();


            $title = $gameSell->activityTitle;
            $admin = Auth::user();

            $activity = new ActivityLog();
            $activity->title = $title;
            $activity->sell_post_id = $request->sell_post_id;
            $activity->description = $request->comments;

            $admin->activities()->save($activity);
            DB::commit();

            $user = $gameSell->user;
            $msg = [
                'title' => $gameSell->title,
                'status' => $title,
                'comments' => $request->comments

            ];
            $action = [
                "link" => route('sellPost.details', [@$gameSell->title, $request->sell_post_id]),
                "icon" => "fa fa-money-bill-alt text-white"
            ];
            $this->userPushNotification($user, 'SELL_APPROVE', $msg, $action);

            $this->sendMailSms($user, 'SELL_APPROVE', [
                'title' => $gameSell->title,
                'status' => $title,
                'short_comment' => $request->comments
            ]);

            return back()->with('success', 'Update Successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

    }

    public function SellDelete($id, $imgDelete)
    {
        $images = [];
        $galleryImage = SellPost::findOrFail($id);
        $old_images = $galleryImage->image;

        if (!empty($old_images)) {
            foreach ($old_images as $file) {
                $newString = Str::replaceFirst('sellingPost/', '', $file);
                if ($newString == $imgDelete) {
                    $this->fileDelete($galleryImage->image_driver, $file);
                } else {
                    $images[] = $file;
                }
            }
        }
        $galleryImage->image = $images;
        $galleryImage->save();
        return back()->with('success', 'Image has been deleted');
    }

    public function sellPostOffer($sellPostId)
    {
        $sellPostOffer = SellPostOffer::with(['user', 'lastMessage'])->whereSell_post_id($sellPostId)
            ->get()
            ->sortByDesc('lastMessage.created_at');

        $offer = null;
        if (0 < count($sellPostOffer)) {
            $offer = $sellPostOffer->first();

            if (!$offer->uuid) {
                $offer->uuid = Str::uuid();
                $offer->save();
            }

            return redirect()->route('admin.sellPost.conversation', $offer->uuid);
        } else {
            $offer = null;
        }


        $data['sellPostOffer'] = $sellPostOffer;
        $data['offer'] = $offer;
        return view('admin.sellPostList.offerList', $data);
    }

    public function conversation($uuid)
    {
        $offer = SellPostOffer::with(['user', 'lastMessage'])->where('uuid', $uuid)
            ->firstOrFail();

        $data['sellPostOffer'] = SellPostOffer::with(['user', 'lastMessage'])->whereSell_post_id($offer->sell_post_id)
            ->get()
            ->sortByDesc('lastMessage.created_at');

        $data['persons'] = SellPostChat::where([
            'offer_id' => $offer->id,
            'sell_post_id' => $offer->sell_post_id
        ])
            ->with('chatable')
            ->get()->pluck('chatable')->unique('chatable');

        $data['offer'] = $offer;

        return view('admin.sellPostList.offerList', $data);
    }

}
