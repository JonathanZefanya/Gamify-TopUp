<?php

namespace App\Jobs;

use App\Models\SellPost;
use App\Models\SupportTicket;
use App\Traits\Upload;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UserAllRecordDeleteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Upload;

    public $userID;

    /**
     * Create a new job instance.
     */
    public function __construct($userID)
    {
        $this->userID = $userID;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::table('deposits')->where('user_id', $this->userID)->delete();
        DB::table('orders')->where('user_id', $this->userID)->delete();
        DB::table('order_details')->where('user_id', $this->userID)->delete();
        DB::table('reviews')->where('user_id', $this->userID)->delete();
        DB::table('transactions')->where('user_id', $this->userID)->delete();
        DB::table('user_logins')->where('user_id', $this->userID)->delete();
        DB::table('orders')->where('user_id', $this->userID)->delete();
        DB::table('order_details')->where('user_id', $this->userID)->delete();
        DB::table('roles')->where('user_id', $this->userID)->delete();
        DB::table('sell_post_payments')->where('user_id', $this->userID)->delete();
        DB::table('user_trackings')->where('user_id', $this->userID)->delete();

        SellPost::where('user_id', $this->userID)->get()->map(function ($item) {
            $item->image->map(function ($img) use ($item){
                $this->fileDelete($item->image_driver, $img);
                $img->delete();
            });
            $item->delete();
        });
        DB::table('sell_posts')->where('user_id', $this->userID)->delete();


        SupportTicket::where('user_id', $this->userID)->get()->map(function ($item) {
            $item->messages()->get()->map(function ($message) {
                if (count($message->attachments) > 0) {
                    foreach ($message->attachments as $img) {
                        $this->fileDelete($img->driver, $img->file);
                        $img->delete();
                    }
                }
            });
            $item->messages()->delete();
            $item->delete();
        });


        DB::table('in_app_notifications')->where('in_app_notificationable_id', $this->userID)->where('in_app_notificationable_type','App\Models\User')->delete();
    }
}
