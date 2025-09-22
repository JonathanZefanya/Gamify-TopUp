<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Notify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Notify;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['LastSeenActivity', 'imgPath', 'fullname'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();
        static::saved(function () {
            Cache::forget('userRecord');
        });
    }

    public function notifypermission()
    {
        return $this->morphOne(NotificationSettings::class, 'notifyable');
    }
    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
    public function getImgPathAttribute()
    {
        return getFile($this->image_driver, $this->image);
    }


    public function chatable()
    {
        return $this->morphOne(SellPostChat::class, 'chatable');
    }

    public function funds()
    {
        return $this->hasMany(Fund::class)->latest()->where('status', '!=', 0);
    }


    public function transaction()
    {
        return $this->hasOne(Transaction::class)->latest();
    }

    public function sellChats()
    {
        return $this->morphMany(SellPostChat::class, 'chatable');
    }
    public function getLastSeenActivityAttribute()
    {
        if (Cache::has('user-is-online-' . $this->id) == true) {
            return true;
        } else {
            return false;
        }
    }


    public function inAppNotification()
    {
        return $this->morphOne(InAppNotification::class, 'inAppNotificationable', 'in_app_notificationable_type', 'in_app_notificationable_id');
    }

    public function fireBaseToken()
    {
        return $this->morphMany(FireBaseToken::class, 'tokenable');
    }

    public function profilePicture()
    {
        $image = $this->image;
        if (!$image) {
            $active = $this->LastSeenActivity == false ? 'warning' : 'success';
            $firstLetter = substr($this->firstname, 0, 1);
            return '<div class="avatar avatar-sm avatar-soft-primary avatar-circle">
                        <span class="avatar-initials">' . $firstLetter . '</span>
                        <span class="avatar-status avatar-sm-status avatar-status-' . $active . '"></span>
                     </div>';

        } else {
            $url = getFile($this->image_driver, $this->image);
            $active = $this->LastSeenActivity == false ? 'warning' : 'success';
            return '<div class="avatar avatar-sm avatar-circle">
                        <img class="avatar-img" src="' . $url . '" alt="Image Description">
                        <span class="avatar-status avatar-sm-status avatar-status-' . $active . '"></span>
                     </div>';

        }
    }
    public function activities()
    {
        return $this->morphMany(ActivityLog::class, 'activityable');
    }
    public function sendPasswordResetNotification($token)
    {
        $this->mail($this, 'PASSWORD_RESET', $params = [
            'message' => '<a href="' . url('password/reset', $token) . '?email=' . $this->email . '" target="_blank">Click To Reset Password</a>'
        ], null, null, 'send');
    }

    public function notifySetting()
    {
        return $this->morphOne(NotificationSettings::class, 'notifyable');
    }


    public function topUp()
    {
        return $this->hasMany(TopUpSell::class, 'user_id')->latest();
    }
}
