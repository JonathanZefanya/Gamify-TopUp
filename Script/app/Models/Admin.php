<?php

namespace App\Models;

use App\Traits\Notify;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, Notify;

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
    ];

    protected $appends = ['imgPath', 'LastSeenActivity'];

    public function fireBaseToken()
    {
        return $this->morphMany(FireBaseToken::class, 'tokenable');
    }

    public function inAppNotification()
    {
        return $this->morphOne(InAppNotification::class, 'inAppNotificationable', 'in_app_notificationable_type', 'in_app_notificationable_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->mail($this, 'PASSWORD_RESET', $params = [
            'message' => '<a href="' . url('admin/password/reset', $token) . '?email=' . $this->email . '" target="_blank">Click To Reset Password</a>'
        ]);
    }

    public function profilePicture()
    {
        $disk = $this->image_driver;
        $image = $this->image ?? 'unknown';

        try {
            if ($disk == 'local') {
                $localImage = asset('/assets/upload') . '/' . $image;
                return \Illuminate\Support\Facades\Storage::disk($disk)->exists($image) ? $localImage : asset(config('location.default'));
            } else {
                return \Illuminate\Support\Facades\Storage::disk($disk)->exists($image) ? \Illuminate\Support\Facades\Storage::disk($disk)->url($image) : asset(config('filelocation.default'));
            }
        } catch (\Exception $e) {
            return asset(config('location.default'));
        }
    }
    public function chatable()
    {
        return $this->morphOne(SellPostChat::class, 'chatable');
    }
    public function activities()
    {
        return $this->morphMany(ActivityLog::class, 'activityable');
    }
    public function getImgPathAttribute()
    {
        return getFile($this->image_driver, $this->image);
    }
    public function getLastSeenActivityAttribute()
    {
        if (Cache::has('admin-is-online-' . $this->id)) {
            return true;
        } else {
            return false;
        }
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

}
