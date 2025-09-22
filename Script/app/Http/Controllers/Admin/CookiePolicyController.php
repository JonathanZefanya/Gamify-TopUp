<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\Notify;
use App\Traits\Upload;
use Illuminate\Http\Request;

class CookiePolicyController extends Controller
{
    use Upload, Notify;
    public function cookiePolicySetting(){
        return view('admin.control_panel.cookie_policy_settings');
    }

    public function cookiePolicyUpdate (Request $request){

        $basic = basicControl();

        if ($request->hasFile('cookie_image')) {
            $photo = $this->fileUpload($request->cookie_image, config('filelocation.cookie.path'), null, null, 'webp', 60);

            $basic->cookie_image = $photo['path'] ?? null;
            $basic->cookie_image_driver = $photo['driver'] ?? null;
            $basic->save();
        }

        $basic->cookie_status = $request->cookie_status;
        $basic->cookie_heading = $request->cookie_heading;
        $basic->cookie_description = $request->cookie_description;
        $basic->cookie_button = $request->cookie_button;
        $basic->cookie_button_link = $request->cookie_button_link;
        $basic->save();


        return back()->with('success', 'cookie settings changed.');
    }
}
