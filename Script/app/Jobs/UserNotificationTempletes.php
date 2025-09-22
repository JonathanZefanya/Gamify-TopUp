<?php

namespace App\Jobs;

use App\Models\NotificationSettings;
use App\Models\NotificationTemplate;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserNotificationTempletes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $userID;
    public function __construct($userID)
    {
        $this->userID = $userID;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $template_keys = NotificationTemplate::where('notify_for', 0)
            ->where(function ($query) {
                $query->whereNotNull('email')
                    ->orWhereNotNull('push')
                    ->orWhereNotNull('sms')
                    ->orWhereNotNull('in_app');
            })
            ->pluck('template_key');

        $notifyFor = new NotificationSettings();
        $notifyFor->notifyable_id = $this->userID;
        $notifyFor->notifyable_type = User::class;
        $notifyFor->template_email_key = $template_keys;
        $notifyFor->template_sms_key = $template_keys;
        $notifyFor->template_push_key = $template_keys;
        $notifyFor->template_in_app_key = $template_keys;
        $notifyFor->save();
    }
}
