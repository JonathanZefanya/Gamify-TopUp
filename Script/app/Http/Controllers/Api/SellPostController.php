<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Admin;
use App\Models\SellPost;
use App\Models\SellPostCategory;
use App\Models\SellPostChat;
use App\Models\SellPostOffer;
use App\Models\User;
use App\Traits\ApiValidation;
use App\Traits\Notify;
use App\Traits\Upload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SellPostController extends Controller
{
    use ApiValidation, Upload, Notify;

    public function sellPostCategory(Request $request)
    {
        if ($request->has('category_id')) {
            $data['category'] = SellPostCategory::with('details')->whereStatus(1)->find($request->category_id);
            if (!$data['category']) {
                return response()->json($this->withErrors('Data not found'));
            }
            $data['category']['image'] = getFile($data['category']->image_driver, $data['category']->image);
        } else {
            $data['categoryList'] = SellPostCategory::with('details')
                ->whereStatus(1)
                ->get()->map(function ($query) {
                    $query->image = getFile($query->image_driver, $query->image);
                    return $query;
                });
        }
        return response()->json($this->withSuccess($data));
    }

    public function sellPostCreate(Request $request)
    {
        $validate = Validator::make($request->all(),
            [
                'category' => 'required',
                'price' => 'required|numeric|min:1',
                'title' => 'required',
                'comments' => 'required',
                'image' => 'required'
            ]);

        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        $category = SellPostCategory::whereStatus(1)->find($request->category);
        if (!$category) {
            return response()->json($this->withErrors('Category not found'));
        }

        $rules = [];
        $inputFieldSpecification = [];
        if ($category->form_field != null) {
            foreach ($category->form_field as $key => $cus) {
                $rules[$key] = [$cus->validation];
                $inputFieldSpecification[$key . '.' . $cus->validation] = "The $key field is required.";

                if ($cus->type == 'file') {
                    array_push($rules[$key], 'image');
                    array_push($rules[$key], 'mimes:jpeg,jpg,png');
                    array_push($rules[$key], 'max:10240');

                    $inputFieldSpecification[$key . '.image'] = "The $key must be an image.";
                    $inputFieldSpecification[$key . '.mimes'] = "The $key must be type of png, jpeg, jpg.";
                    $inputFieldSpecification[$key . '.max'] = "The $key  may not be greater than 10240kb characters.";
                }
                if ($cus->type == 'text') {
                    array_push($rules[$key], 'max:191');
                    $inputFieldSpecification[$key . '.max'] = "The $key  may not be greater than 191 characters.";
                }
                if ($cus->type == 'textarea') {
                    array_push($rules[$key], 'max:3000');
                    $inputFieldSpecification[$key . '.max'] = "The $key  may not be greater than 3000 characters.";
                }
            }
        }

        $rulesSpecification = [];
        if ($category->post_specification_form != null) {
            foreach ($category->post_specification_form as $key => $cus) {
                $rulesSpecification[$key] = [$cus->validation];
                $inputFieldSpecification[$key . '.' . $cus->validation] = "The $key field is required.";

                if ($cus->type == 'file') {
                    array_push($rulesSpecification[$key], 'image');
                    array_push($rulesSpecification[$key], 'mimes:jpeg,jpg,png');
                    array_push($rulesSpecification[$key], 'max:10240');

                    $inputFieldSpecification[$key . '.image'] = "The $key must be an image.";
                    $inputFieldSpecification[$key . '.mimes'] = "The $key must be type of png, jpeg,10240kb characters.";

                }
                if ($cus->type == 'text') {
                    array_push($rulesSpecification[$key], 'max:191');
                    $inputFieldSpecification[$key . '.max'] = "The $key  may not be greater than 191 characters.";
                }
                if ($cus->type == 'textarea') {
                    array_push($rulesSpecification[$key], 'max:3000');
                    $inputFieldSpecification[$key . '.max'] = "The $key  may not be greater than 3000 characters.";
                }
            }
        }

        $purifiedData = $request->all();

        $newRules = array_merge($rules, $rulesSpecification);
        $validate = Validator::make($purifiedData, $newRules, $inputFieldSpecification);

        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        try {
            if ($request->has('image')) {
                $purifiedData['image'] = $request->image;
            }


            $gameSell = new SellPost();
            $gameSell->user_id = Auth()->user()->id;
            $gameSell->category_id = $purifiedData['category'];
            $gameSell->sell_charge = $category->sell_charge;


            $images = array();
            $imagesDriver = null;
            if ($request->hasFile('image')) {
                try {
                    $gameImage = $purifiedData['image'];
                    foreach ($gameImage as $file) {
                        $imageUp = $this->fileUpload($file, config('filelocation.sellingPost.path'), null, config('filelocation.sellingPost.thumb'), 'webp');
                        $images[] = $imageUp['path'];
                        $imagesDriver = $imageUp['driver'];
                    }
                } catch (\Exception $exp) {
                    return response()->json($this->withErrors('Image could not be uploaded.'));
                }
                $gameSell->image = $images;
                $gameSell->image_driver = $imagesDriver;
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

            if (isset($purifiedData['comments'])) {
                $gameSell->comments = $request->comments;
            }

            if (isset($purifiedData['status'])) {
                $gameSell->status = isset($purifiedData['status']) ? 1 : 0;
            }


            $collection = collect($request);
            $reqField = [];
            if ($category->form_field != null) {
                foreach ($collection as $k => $v) {
                    foreach ($category->form_field as $inKey => $inVal) {
                        if ($k != $inKey) {
                            continue;
                        } else {
                            if ($inVal->type == 'file') {
                                if ($request->hasFile($inKey)) {

                                    try {
                                        $image = $request->file($inKey);
                                        $location = config('location.sellingPost.path');
                                        $filename = $this->uploadImage($image, $location);;
                                        $reqField[$inKey] = [
                                            'field_name' => $inKey,
                                            'field_value' => $filename,
                                            'type' => $inVal->type,
                                            'validation' => $inVal->validation,
                                        ];

                                    } catch (\Exception $exp) {
                                        return response()->json($this->withErrors('Image could not be uploaded.'));
                                    }
                                }
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
                            if ($inVal->type == 'file') {
                                if ($request->hasFile($inKey)) {

                                    try {
                                        $image = $request->file($inKey);
                                        $location = config('location.sellingPost.path');
                                        $filename = $this->uploadImage($image, $location);
                                        $reqField[$inKey] = [
                                            'field_name' => $inKey,
                                            'field_value' => $filename,
                                            'type' => $inVal->type,
                                            'validation' => $inVal->validation,
                                        ];

                                    } catch (\Exception $exp) {
                                        return response()->json($this->withErrors('Image could not be uploaded.'));
                                    }

                                }
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
                }
                $gameSell['post_specification_form'] = $reqFieldSpecification;
            } else {
                $gameSell['post_specification_form'] = null;
            }

            $gameSell->save();
            return response()->json($this->withSuccess('Game Successfully Saved'));
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function sellPostList(Request $request)
    {
        $basic = basicControl();
        $search = $request->all();
        $dateSearch = $request->datetrx;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        try {
            $sellLists = tap(SellPost::whereUser_id(Auth()->user()->id)->orderBy('id', 'DESC')
                ->when(@$search['title'], function ($query) use ($search) {
                    return $query->where('title', 'LIKE', "%{$search['title']}%");
                })
                ->when($date == 1, function ($query) use ($dateSearch) {
                    return $query->whereDate("created_at", $dateSearch);
                })
                ->paginate($basic->paginate), function ($paginatedInstance) use ($basic) {
                return $paginatedInstance->getCollection()->transform(function ($query) use ($basic) {
                    $array['id'] = $query->id;
                    $array['title'] = $query->title ?? null;
                    $array['paymentStatus'] = $query->payment_status ? 'sold' : 'unsold';
                    $array['category'] = optional(optional($query->category)->details)->name;
                    $array['price'] = getAmount($query->price, $basic->fraction_number);
                    $array['currency'] = $basic->base_currency ?? null;
                    $array['symbol'] = $basic->currency_symbol ?? null;
                    if ($query->status == 1) {
                        $array['status'] = 'Approved';
                    } elseif ($query->status == 0) {
                        $array['status'] = 'Pending';
                    } elseif ($query->status == 2) {
                        $array['status'] = 'Re Submission';
                    } elseif ($query->status == 3) {
                        $array['status'] = 'Hold';
                    } elseif ($query->status == 4) {
                        $array['status'] = 'Soft Rejected';
                    } elseif ($query->status == 5) {
                        $array['status'] = 'Hard Rejected';
                    }
                    $array['dateTime'] = $query->created_at ?? null;
                    return $array;
                });
            });

            if ($sellLists) {
                return response()->json($this->withSuccess($sellLists));
            } else {
                return response()->json($this->withErrors('No data found'));
            }
        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }



    public function sellPostEdit(Request $request)
    {
        $data['sellPost'] = SellPost::where('user_id', auth()->id())->find($request->id);
        if (!$data['sellPost']) {
            return response()->json($this->withErrors('Data not found'));
        }

        $images = is_array($data['sellPost']->image) ? $data['sellPost']->image : (array) json_decode($data['sellPost']->image, true);

        if (!empty($images)) {
            $imagePath = [];
            foreach ($images as $key => $img) {
                $imagePath[$key] = getFile($data['sellPost']->image_driver, $img);
            }

            $data['sellPost']->imagePath = (object) $imagePath;
        }

        return response()->json($this->withSuccess($data));
    }


    public function sellPostUpdate(Request $request)
    {
        $purifiedData = $request->all();
        if ($request->has('image')) {
            $purifiedData['image'] = $request->image;
        }

        $rules = [
            'id' => 'required|numeric',
            'title' => 'required|max:40',
            'price' => 'required|numeric|min:1',
            'details' => 'required',
            'comments' => 'required',
            'image' => 'sometimes|required'
        ];
        $message = [
            'id.required' => 'Id field is required',
            'name.required' => 'Name field is required',
            'price.required' => 'Price field is required',
            'details.required' => 'Details field is required',
            'comments.required' => 'Comments field is required',
            'image.required' => 'Image field is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        DB::beginTransaction();
        try {

            $gameSell = SellPost::find($request->id);
            if (!$gameSell) {
                return response()->json($this->withErrors('sell post not found'));
            }

            $gameSell->user_id = Auth()->user()->id;

            $category = SellPostCategory::whereStatus(1)->findOrFail($gameSell->category_id);
            $rules = [];
            $inputField = [];
            if ($category->form_field != null) {
                foreach ($category->form_field as $key => $cus) {
                    $rules[$key] = [$cus->validation];
                    if ($cus->type == 'file') {
                        array_push($rules[$key], 'image');
                        array_push($rules[$key], 'mimes:jpeg,jpg,png');
                        array_push($rules[$key], 'max:10240');
                    }
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
                    if ($cus->type == 'file') {
                        array_push($rulesSpecification[$key], 'image');
                        array_push($rulesSpecification[$key], 'mimes:jpeg,jpg,png');
                        array_push($rulesSpecification[$key], 'max:10240');
                    }
                    if ($cus->type == 'text') {
                        array_push($rulesSpecification[$key], 'max:191');
                    }
                    if ($cus->type == 'textarea') {
                        array_push($rulesSpecification[$key], 'max:300');
                    }
                    $inputFieldSpecification[] = $key;
                }
            }


            $newRules = array_merge($rules, $rulesSpecification);


            $validate = Validator::make($purifiedData, $newRules);

            if ($validate->fails()) {
                return back()->withInput()->withErrors($validate);
            }

            $collection = collect($request);
            $reqField = [];
            $credentialChanges = '';
            if ($category->form_field != null) {
                foreach ($collection as $k => $v) {
                    foreach ($category->form_field as $inKey => $inVal) {
                        if ($k != $inKey) {
                            continue;
                        } else {
                            if ($inVal->type == 'file') {
                                if ($request->hasFile($inKey)) {
                                    try {
                                        $image = $request->file($inKey);
                                        $location = config('location.sellingPost.path');
                                        $filename = $this->uploadImage($image, $location);;
                                        $reqField[$inKey] = [
                                            'field_name' => $inKey,
                                            'field_value' => $filename,
                                            'type' => $inVal->type,
                                            'validation' => $inVal->validation,
                                        ];

                                    } catch (\Exception $exp) {
                                        return back()->with('error', 'Image could not be uploaded.')->withInput();
                                    }

                                }
                            } else {
                                $reqField[$inKey] = [
                                    'field_name' => $inKey,
                                    'field_value' => $v,
                                    'type' => $inVal->type,
                                    'validation' => $inVal->validation,
                                ];
                            }
                            if ($gameSell->credential->$inKey->field_value != $v) {
                                $credentialChanges .= "$inKey : " . $v . "<br>";
                            }
                        }
                    }
                }
                if (0 < strlen($credentialChanges)) {
                    $credentialChanges = "Changes Credentials <br>" . $credentialChanges;
                }


                $gameSell['credential'] = $reqField;
            } else {
                $gameSell['credential'] = null;
            }

            $collectionSpecification = collect($request);
            $reqFieldSpecification = [];
            $specificationChanges = '';
            if ($category->post_specification_form != null) {
                foreach ($collectionSpecification as $k => $v) {
                    foreach ($category->post_specification_form as $inKey => $inVal) {
                        if ($k != $inKey) {
                            continue;
                        } else {
                            if ($inVal->type == 'file') {
                                if ($request->hasFile($inKey)) {

                                    try {
                                        $image = $request->file($inKey);
                                        $location = config('location.sellingPost.path');
                                        $filename = $this->uploadImage($image, $location);;
                                        $reqField[$inKey] = [
                                            'field_name' => $inKey,
                                            'field_value' => $filename,
                                            'type' => $inVal->type,
                                            'validation' => $inVal->validation,
                                        ];

                                    } catch (\Exception $exp) {
                                        return back()->with('error', 'Image could not be uploaded.')->withInput();
                                    }

                                }
                            } else {
                                $reqFieldSpecification[$inKey] = [
                                    'field_name' => $inKey,
                                    'field_value' => $v,
                                    'type' => $inVal->type,
                                    'validation' => $inVal->validation,
                                ];
                                if ($gameSell->post_specification_form->$inKey->field_value != $v) {
                                    $specificationChanges .= "$inKey : " . $v . "<br>";
                                }
                            }
                        }
                    }
                }
                if (0 < strlen($specificationChanges)) {
                    $specificationChanges = "Changes Specification <br>" . $specificationChanges;
                }
                $gameSell['post_specification_form'] = $reqFieldSpecification;
            } else {
                $gameSell['post_specification_form'] = null;
            }

            $changeImage = '';
            $images = array();

            if ($request->hasFile('image')) {
                if ($gameSell->image != $request->image) {
                    $changeImage = ' Image has been updated ' . "<br>";
                }
                try {
                    $gameImage = $purifiedData['image'];
                    foreach ($gameImage as $file) {
                        $imageUp = $this->fileUpload($file, config('filelocation.sellingPost.path'), null, config('filelocation.sellingPost.thumb'), 'webp');
                        $images[] = $imageUp['path'];
                        $imagesDriver = $imageUp['driver'];
                    }
                    if (isset($request->changedImage) && count($request->changedImage) > 0) {
                        foreach ($request->changedImage as $imageOld) {
                            $this->fileDelete($gameSell->image_driver, $imageOld);
                        }
                    }
                    $oldImages = $request->oldImage ?? [];
                    $mergedImages = array_merge($images, $oldImages);

                    $gameSell->image = $mergedImages;
                    $gameSell->image_driver = $imagesDriver;

                } catch (\Exception $exp) {
                    return back()->with('error', 'Image could not be uploaded.');
                }
            }


            $changesTitle = '';
            if (isset($purifiedData['title'])) {
                if ($gameSell->title != $request->title) {
                    $changesTitle = 'Title ' . $gameSell->title . ' updated to ' . $request->title . "<br>";
                }
                $gameSell->title = $request->title;

            }

            $changesPrice = '';
            if (isset($purifiedData['price'])) {
                if ($gameSell->price != $request->price) {
                    $changesPrice = 'Price ' . $gameSell->price . ' updated to ' . $request->price . "<br>";
                }
                $gameSell->price = $request->price;
            }


            $changesDetails = '';
            if (isset($purifiedData['details'])) {
                if ($gameSell->details != $request->details) {
                    $changesDetails = "Details has been Updated <br>";
                }
                $gameSell->details = $request->details;
            }

            if (isset($purifiedData['comments'])) {
                $gameSell->comments = $request->comments;
            }

            $gameSell->status = 2;
            $gameSell->save();


            $user = Auth::user();

            if ($changesTitle . $changesPrice . $credentialChanges . $specificationChanges . $changesDetails . $changeImage != '') {
                $activity = new ActivityLog();
                $activity->sell_post_id = $request->id;
                $activity->title = "Resubmission";
                $activity->description = $changesTitle . $changesPrice . $changeImage . $credentialChanges . $specificationChanges . $changesDetails;
                $user->activities()->save($activity);
            }

            DB::commit();
            return response()->json($this->withSuccess('Successfully Updated'));
        } catch (\Exception$e) {
            DB::rollBack();
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function offerList(Request $request)
    {
        $data['sellPostAll'] = SellPost::whereUser_id(Auth::id())->whereStatus(1)->get();
        $dateTrx = $request->datetrx ?? null;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateTrx);

        $query = SellPostOffer::query();
        $data['sellPostOffer'] = $query->with([
            'user:id,firstname,lastname,email,image,image_driver',
            'sellPost' => function ($query) {
                $query->select('id', 'user_id', 'category_id', 'title', 'price', 'details', 'comments', 'sell_charge', 'image', 'image_driver', 'status', 'lock_for', 'lock_at', 'payment_lock', 'payment_status', 'payment_uuid')
                    ->addSelect(\DB::raw("
                CASE
                    WHEN status = 0 THEN 'Not Approved'
                    WHEN status = 1 THEN 'Approved'
                    WHEN status = 2 THEN 'Re-submission'
                    WHEN status = 3 THEN 'Hold'
                    WHEN status = 4 THEN 'Soft Rejected'
                    WHEN status = 5 THEN 'Hard Rejected'
                    ELSE 'Unknown'
                END as status
            "));
            }
        ])
            ->where('author_id', Auth::id())
            ->orWhere('user_id', auth()->id())
            ->whereHas('sellPost')
            ->whereHas('user')
            ->when(request('postId', false), function ($q, $postId) {
                $q->where('sell_post_id', $postId);
            })
            ->when(request('remark', false), function ($q, $remark) {
                $q->where('description', 'like', "%$remark%")
                    ->orWhereHas('user', function ($subQuery) use ($remark) {
                        $subQuery->where('firstname', 'like', "%$remark%")->orWhere('lastname', 'like', "%$remark%");
                    });
            })
            ->when($date == 1, function ($query) use ($dateTrx) {
                return $query->whereDate("created_at", $dateTrx);
            })
            ->when(!request('sortBy', false), function ($query, $sortBy) {
                $query->orderBy('updated_at', 'desc');
            })
            ->when(request('sortBy', false), function ($query, $sortBy) {
                if ($sortBy == 'latest') {
                    $query->orderBy('updated_at', 'desc');
                }
                if ($sortBy == 'processing') {
                    $query->whereHas('sellPost', function ($qq) {
                        $qq->where('payment_lock', 1)->where('payment_status', 0)->whereNotNull('lock_at')->whereDate('lock_at', '<=', Carbon::now()->subMinutes(config('basic.payment_expired')));
                    })
                        ->where('status', 1)->where('payment_status', 0)->orderBy('amount', 'desc');
                }
                if ($sortBy == 'complete') {
                    $query->whereHas('sellPost', function ($qq) {
                        $qq->where('payment_lock', 1)->where('payment_status', 1);
                    })
                        ->where('status', 1)->where('payment_status', 1)->orderBy('amount', 'desc');
                }
                if ($sortBy == 'low_to_high') {
                    $query->orderBy('amount', 'asc');
                }
                if ($sortBy == 'high_to_low') {
                    $query->orderBy('amount', 'desc');
                }
                if ($sortBy == 'pending') {
                    $query->whereStatus(0)->orderBy('amount', 'desc');
                }

                if ($sortBy == 'rejected') {
                    $query->whereStatus(2)->orderBy('amount', 'desc');
                }
                if ($sortBy == 'resubmission') {
                    $query->whereStatus(3)->orderBy('amount', 'desc');
                }
            })->paginate(basicControl()->paginate)
            ->through(function ($offer) {
                $statusLabels = [
                    0 => 'Pending',
                    1 => 'Accepted',
                    2 => 'Rejected',
                    3 => 'Resubmission',
                ];

                $sellPost = optional($offer->sellPost);

                if ($sellPost->payment_lock == 1 && $sellPost->lock_for == $offer->user_id && $sellPost->payment_status == 0
                    && \Carbon\Carbon::now() < \Carbon\Carbon::parse($sellPost->lock_at)->addMinutes(basicControl()->payment_expired)) {
                    $offer->status = 'Payment Processing';
                } elseif ($sellPost->payment_lock == 1 && $sellPost->lock_for == $offer->user_id && $sellPost->payment_status == 1) {
                    $offer->status = 'Payment Completed';
                } else {
                    $offer->status = $statusLabels[$offer->status] ?? 'Unknown';
                }

                return $offer;
            });

        return response()->json($this->withSuccess($data));
    }

    public function offerAccept(Request $request)
    {
        $purifiedData = $request->all();
        $rules = [
            'offer_id' => 'required',
            'description' => 'required',
        ];
        $message = [
            'description.required' => 'Description field is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);
        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        DB::beginTransaction();
        try {

            $offerDetails = SellPostOffer::find($request->offer_id);
            if (!$offerDetails) {
                return response()->json($this->withErrors('Offer record not found'));
            }

            if ($offerDetails->uuid != '') {
                return response()->json($this->withErrors('Offer Can not be accepted'));
            }
            if ($offerDetails->sell_post_id) {
                if (!$offerDetails->uuid) {
                    $offerDetails->uuid = Str::uuid();
                }
                $offerDetails->status = 1;
                $offerDetails->attempt_at = Carbon::now();
                $offerDetails->save();

                $user = Auth::user();
                $sellPostChat = new SellPostChat();
                $sellPostChat->sell_post_id = $offerDetails->sell_post_id;
                $sellPostChat->offer_id = $request->offer_id;
                $sellPostChat->description = $request->description;
                $user->sellChats()->save($sellPostChat);

                DB::commit();

                $user = $offerDetails->user;
                $msg = [
                    'title' => $offerDetails->sellPost->title,
                    'amount' => $offerDetails->amount . ' ' . basicControl()->base_currency,
                ];
                $action = [
                    "link" => route('user.offerChat', $offerDetails->uuid),
                    "icon" => "fa fa-money-bill-alt text-white"
                ];
                $this->userPushNotification($user, 'OFFER_ACCEPTED', $msg, $action);

                $this->sendMailSms($user, 'OFFER_ACCEPTED', [
                    'link' => route('user.offerChat', $offerDetails->uuid),
                    'title' => $offerDetails->sellPost->title,
                    'amount' => $offerDetails->amount . ' ' . basicControl()->base_currency,
                ]);

                return response()->json($this->withSuccess('Accepted Offer'));
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function offerReject(Request $request)
    {
        $purifiedData = $request->all();
        $rules = [
            'offer_id' => 'required',
        ];
        $validate = Validator::make($purifiedData, $rules);
        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        $sellPostOffer = SellPostOffer::findOrFail($request->offer_id);
        if (!$sellPostOffer) {
            return response()->json($this->withErrors('Offer record not found'));
        }
        if ($sellPostOffer->status != 2) {
            $sellPostOffer->update([
                'status' => 2
            ]);

            $user = $sellPostOffer->user;
            $msg = [
                'title' => $sellPostOffer->sellPost->title,
                'amount' => $sellPostOffer->amount . ' ' . basicControl()->base_currency,
            ];
            $action = [
                "link" => route('sellPost.details', [@slug($sellPostOffer->sellPost->title), $sellPostOffer->sellPost->id]),
                "icon" => "fa fa-money-bill-alt text-white"
            ];
            $this->userPushNotification($user, 'OFFER_REJECT', $msg, $action);

            $this->sendMailSms($user, 'OFFER_REJECT', [
                'link' => route('sellPost.details', [@slug($sellPostOffer->sellPost->title), $sellPostOffer->sellPost->id]),
                'title' => $sellPostOffer->sellPost->title,
                'amount' => $sellPostOffer->amount . ' ' . basicControl()->base_currency,
            ]);

            return response()->json($this->withSuccess('Reject Offer'));
        }
        return response()->json($this->withErrors('Already Rejected'));
    }

    public function offerRemove(Request $request)
    {
        $purifiedData = $request->all();
        $rules = [
            'offer_id' => 'required',
        ];
        $validate = Validator::make($purifiedData, $rules);
        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        $sellPostOffer = SellPostOffer::with('sellPost')->find($request->offer_id);
        if (!$sellPostOffer) {
            return response()->json($this->withErrors('Offer record not found'));
        }
        if ($sellPostOffer) {
            $sellPostOffer->delete();
        }
        return response()->json($this->withSuccess('Remove Offer'));
    }

    public function offerConversation(Request $request)
    {
        $rules = [
            'uuid' => 'required',
        ];
        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        $auth = Auth::user();
        $data['loginUserId'] = $auth->id;

        $offerRequest = SellPostOffer::where('uuid', $request->uuid)
            ->firstOrFail();

        $siteNotifications = SellPostChat::whereHasMorph(
            'chatable',
            [
                User::class,
                Admin::class,
            ],
            function ($query) use ($offerRequest) {
                $query->where([
                    'offer_id' => $offerRequest->id,
                    'sell_post_id' => $offerRequest->sell_post_id
                ]);
            }
        )->with('chatable:id,username,phone,image,image_driver,firstname,lastname')->get();

        $offerRequest = SellPostOffer::where('uuid', $request->uuid)
            ->whereHas('user')
            ->whereHas('author')
            ->where(function ($query) use ($auth) {
                $query->where('user_id', $auth->id)
                    ->orWhere('author_id', $auth->id);
            })
            ->with('sellPost')
            ->first();


        if (!$offerRequest) {
            return response()->json($this->withErrors('Offer record not found'));
        }

        if (Auth::check() && $offerRequest->author_id == Auth::id()) {
            $data['isAuthor'] = true;
        } else {
            $data['isAuthor'] = false;
        }

        $data['offerRequest'] = $offerRequest;
        $data['siteNotifications'] = $siteNotifications;
        return response()->json($this->withSuccess($data));
    }

    public function offerNewMessage(Request $request)
    {
        $rules = [
            'offer_id' => ['required'],
            'sell_post_id' => ['required'],
            'message' => ['required']
        ];

        $req = $request->all();
        $validator = Validator::make($req, $rules);
        if ($validator->fails()) {
            return response()->json($this->withErrors(collect($validator->messages())->collapse()));
        }
        $user = Auth::user();

        $sellPostOffer = SellPostOffer::where('id', $request->offer_id)
            ->where('sell_post_id', $request->sell_post_id)
            ->first();

        if (!$sellPostOffer) {
            return response()->json($this->withErrors('Offer record not found'));
        }

        $chat = new SellPostChat();
        $chat->description = $req['message'];
        $chat->sell_post_id = $sellPostOffer->sell_post_id;
        $chat->offer_id = $sellPostOffer->id;
        $log = $user->chatable()->save($chat);


        $data['id'] = $log->id;
        $data['chatable_id'] = $log->chatable_id;
        $data['chatable_type'] = $log->chatable_type;
        $data['chatable'] = [
            'fullname' => $log->chatable->fullname,
            'id' => $log->chatable->id,
            'image' => $log->chatable->image,
            'mobile' => $log->chatable->mobile,
            'imgPath' => $log->chatable->imgPath,
            'username' => $log->chatable->username,
        ];
        $data['description'] = $log->description;
        $data['is_read'] = $log->is_read;
        $data['is_read_admin'] = $log->is_read_admin;
        $data['formatted_date'] = $log->formatted_date;
        $data['created_at'] = $log->created_at;
        $data['updated_at'] = $log->updated_at;

        $this->sendRealTimeMessageThrowFirebase($sellPostOffer->author, $data, $sellPostOffer->uuid);
        $this->sendRealTimeMessageThrowFirebase($sellPostOffer->user, $data, $sellPostOffer->uuid);

        event(new \App\Events\OfferChatNotification($data, $sellPostOffer->uuid));

        return response()->json($this->withSuccess('Message Send'));
    }


    public function paymentLock(Request $request)
    {
        $purifiedData = $request->all();
        $rules = [
            'offer_id' => 'required|numeric',
            'amount' => 'required|numeric|min:1',
        ];
        $message = ['amount.required' => 'Amount field is required',];

        $validate = Validator::make($purifiedData, $rules, $message);
        if ($validate->fails()) {
            return response()->json($this->withErrors(collect($validate->errors())->collapse()));
        }

        try {
            $sellPostOffer = SellPostOffer::with('sellPost')->find($request->offer_id);
            if (!$sellPostOffer) {
                return response()->json($this->withErrors('Offer record not found'));
            }

            if ($sellPostOffer->sellPost->payment_uuid != '') {
                return response()->json($this->withErrors('Payment can not be lock'));
            }

            if ($sellPostOffer->author_id != Auth::id()) {
                return response()->json($this->withErrors('404 not found'));
            }
            if ($sellPostOffer->sellPost->payment_lock == 1) {
                return response()->json($this->withErrors('Payment Allready Lock'));
            }

            $sellPostOffer->amount = $request->amount;
            $sellPostOffer->save();
            $sellPost = $sellPostOffer->sellPost;
            $sellPost->payment_lock = 1;
            $sellPost->lock_for = $sellPostOffer->user_id;
            $sellPost->lock_at = Carbon::now();
            $sellPost->payment_uuid = str::uuid();
            $sellPost->save();

            $user = $sellPostOffer->user;

            $msg = [
                'title' => $sellPostOffer->sellPost->title,
                'amount' => $request->amount . ' ' . basicControl()->base_currency,
            ];
            $action = [
                "link" => route('user.sellPost.payment.url', $sellPostOffer->sellPost->payment_uuid),
                "icon" => "fa fa-money-bill-alt text-white"
            ];
            $this->userPushNotification($user, 'PAYMENT_LOCK', $msg, $action);

            $this->sendMailSms($user, 'PAYMENT_LOCK', [
                'link' => route('user.sellPost.payment.url', $sellPostOffer->sellPost->payment_uuid),
                'title' => $sellPostOffer->sellPost->title,
                'amount' => $request->amount . ' ' . basicControl()->base_currency,
            ]);

            return response()->json($this->withSuccess('Payment Lock'));

        } catch (\Exception $e) {
            return response()->json($this->withErrors($e->getMessage()));
        }
    }

    public function sellPostDelete(Request $request)
    {
        $sellPost = SellPost::findOrFail($request->id);
        $old_images = $sellPost->image;

        if (!empty($old_images) && count($old_images) > 0) {
            foreach ($old_images as $img) {
                $this->fileDelete($sellPost->image_driver, $img);
            }
        }

        $sellPost->delete();
        return response()->json($this->withSuccess('Successfully Deleted'));
    }
}
