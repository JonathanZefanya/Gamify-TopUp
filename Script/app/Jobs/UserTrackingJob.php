<?php

namespace App\Jobs;

use App\Helpers\UserSystemInfo;
use App\Models\UserTracking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Stevebauman\Location\Facades\Location;

class UserTrackingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userId;
    public $ip;
    public $remark;

    /**
     * Create a new job instance.
     */
    public function __construct($userId, $ip, $remark)
    {
        $this->userId = $userId;
        $this->ip = $ip;
        $this->remark = $remark;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $currentUser = Location::get($this->ip);

        $userTracking = new UserTracking();

        $userTracking->user_id = $this->userId;
        $userTracking->ip = $this->ip;
        $userTracking->country_name = $currentUser->countryName;
        $userTracking->country_code = $currentUser->countryCode;
        $userTracking->region_name = $currentUser->regionName;
        $userTracking->city_name = $currentUser->cityName;
        $userTracking->latitude = $currentUser->latitude;
        $userTracking->longitude = $currentUser->longitude;
        $userTracking->timezone = $currentUser->timezone;
        $userTracking->device = UserSystemInfo::get_device();
        $userTracking->remark = $this->remark;

        $userTracking->save();
    }
}
