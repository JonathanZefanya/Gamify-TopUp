<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BasicControl;
use App\Models\Page;
use Illuminate\Http\Request;

class TempleteController extends Controller
{
    public function index()
    {

        return view('admin.templete.home');
    }

    public function selectTemplete(Request $request)
    {
        $theme = $request->input('theme');
        if (!in_array($theme, array_keys(config('themes')))) {
            return response()->json(['error' => "Invalid Request"], 422);
        }

        $basic = BasicControl::firstOrCreate();
        $basic->theme = $theme;
        $basic->save();

        session()->forget('theme');

        $message = request()->theme_name . ' theme selected.';
        return response()->json(['message' => $message], 200);
    }
}
