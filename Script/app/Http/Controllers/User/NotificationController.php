<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\NotificationSettings;
use App\Models\NotificationTemplate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $data['user'] = User::with('notifypermission')->where('id', Auth::id())->firstOr(function () {
            throw new \Exception('The notification templete was not found.');
        });
        $data['notificationTemplates'] = NotificationTemplate::where('notify_for', 0)->get();


        return view(template() . 'user.'.getDash().'.profile.notification_settings', $data);
    }
    public function notificationSettingsChanges(Request $request)
    {
        try {
            $user = Auth::user();
            $userTemplate = NotificationSettings::where('notifyable_id', $user->id)
                ->where('notifyable_type', User::class)
                ->firstOr(function () {
                    throw new \Exception('Notification Template not found.');
                });

            $userTemplate->template_email_key = $request->email_key;
            $userTemplate->template_sms_key = $request->sms_key;
            $userTemplate->template_in_app_key = $request->in_app_key;
            $userTemplate->template_push_key = $request->push_key;
            $userTemplate->save();

            return back()->with('success', 'Notification Permission Updated Successfully.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
