<?php

namespace App\Http\Controllers\Admin\Module;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Coupon;
use App\Models\TopUp;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function couponList()
    {
        $data['coupons'] = Coupon::latest()->get();
        return view('admin.coupon.list', $data);
    }

    public function couponStore(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('admin.coupon.create');
        } elseif ($request->method() == 'POST') {
            $this->validate($request, [
                'title' => 'required',
                'code' => 'required|min:6|unique:coupons,code',
                'discount' => 'required|min:0',
                'discount_type' => 'required|in:percent,flat',
                'start_date' => 'required',
            ]);


            $coupon = Coupon::create([
                'title' => $request->title,
                'code' => $request->code,
                'discount' => $request->discount,
                'discount_type' => $request->discount_type,
                'used_limit' => $request->used_limit??0,
                'is_unlimited' => $request->is_unlimited == 'yes' ? 1 : 0,
                'start_date' => Carbon::createFromFormat('d M Y H:i', $request->start_date)->format('Y-m-d H:i:s'),
                'end_date' => $request->is_expired == 'no' ? null : Carbon::createFromFormat('d M Y H:i', $request->end_date)->format('Y-m-d H:i:s'),
            ]);

            return redirect()->route('admin.couponEdit', $coupon->id)->with('success', 'Coupon generated successfully');
        }
    }

    public function couponEdit(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        if ($request->method() == 'GET') {
            $data['topups'] = TopUp::latest()->get();
            $data['cards'] = Card::latest()->get();
            return view('admin.coupon.edit', $data, compact('coupon'));
        } elseif ($request->method() == 'POST') {
            $this->validate($request, [
                'title' => 'required',
                'code' => 'required|min:6|unique:coupons,code,' . $coupon->id,
                'discount' => 'required|min:0',
                'discount_type' => 'required|in:percent,flat',
                'start_date' => 'required',
            ]);


            $coupon->update([
                'title' => $request->title,
                'code' => $request->code,
                'apply_module' => $request->apply_module ?? [],
                'discount' => $request->discount,
                'discount_type' => $request->discount_type,
                'used_limit' => $request->used_limit,
                'is_unlimited' => $request->is_unlimited == 'yes' ? 1 : 0,
                'start_date' => Carbon::createFromFormat('d M Y H:i', $request->start_date)->format('Y-m-d H:i:s'),
                'end_date' => $request->is_expired == 'no' ? null : Carbon::createFromFormat('d M Y H:i', $request->end_date)->format('Y-m-d H:i:s'),
            ]);

            return back()->with('success', 'Updated Successfully');
        }
    }

    public function couponDelete($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return back()->with('success', 'Deleted Successfully');
    }

    public function couponMultipleStatusChange(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Coupon.');
            return response()->json(['error' => 1]);
        } else {
            Coupon::whereIn('id', $request->strIds)->get()->map(function ($query) {
                $query->status = $query->status ? 0 : 1;
                $query->save();
            });
            session()->flash('success', 'Status has been change');
            return response()->json(['success' => 1]);
        }
    }

    public function couponMultipleDelete(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select Coupon.');
            return response()->json(['error' => 1]);
        } else {
            Coupon::whereIn('id', $request->strIds)->get()->delete();
            session()->flash('success', 'Deleted Successfully');
            return response()->json(['success' => 1]);
        }
    }

    public function topUpTypeChange(Request $request, $type)
    {
        if ($type == 'permitted') {
            if ($request->strIds == null) {
                session()->flash('error', 'You do not select Coupon.');
                return response()->json(['error' => 1]);
            } else {
                $coupon = Coupon::find($request->couponId);
                if ($coupon) {
                    $existingLists = $coupon->top_up_list??[];
                    $mergeData = array_merge($existingLists, $request->strIds);
                    $coupon->top_up_list = array_unique($mergeData);
                    $coupon->save();

                    session()->flash('success', 'Permitted Successfully');
                    return response()->json(['success' => 1]);
                }
            }
        }

        if ($type == 'not_permitted') {
            if ($request->strIds == null) {
                session()->flash('error', 'You do not select Coupon.');
                return response()->json(['error' => 1]);
            } else {
                $coupon = Coupon::find($request->couponId);
                if ($coupon) {
                    $existingLists = $coupon->top_up_list??[];
                    $coupon->top_up_list = array_diff($existingLists, $request->strIds);;
                    $coupon->save();

                    session()->flash('success', 'Not Permitted Successfully');
                    return response()->json(['success' => 1]);
                }
            }
        }
    }

    public function cardTypeChange(Request $request, $type)
    {
        if ($type == 'permitted') {
            if ($request->strIds == null) {
                session()->flash('error', 'You do not select Coupon.');
                return response()->json(['error' => 1]);
            } else {
                $coupon = Coupon::find($request->couponId);
                if ($coupon) {
                    $existingLists = $coupon->card_list??[];
                    $mergeData = array_merge($existingLists, $request->strIds);
                    $coupon->card_list = array_unique($mergeData);
                    $coupon->save();

                    session()->flash('success', 'Permitted Successfully');
                    return response()->json(['success' => 1]);
                }
            }
        }

        if ($type == 'not_permitted') {
            if ($request->strIds == null) {
                session()->flash('error', 'You do not select Coupon.');
                return response()->json(['error' => 1]);
            } else {
                $coupon = Coupon::find($request->couponId);
                if ($coupon) {
                    $existingLists = $coupon->card_list??[];
                    $coupon->card_list = array_diff($existingLists, $request->strIds);;
                    $coupon->save();

                    session()->flash('success', 'Not Permitted Successfully');
                    return response()->json(['success' => 1]);
                }
            }
        }
    }
}
