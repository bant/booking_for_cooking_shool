<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;	//追記

class Staff extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;	// 追記

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_zoom'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ユーザーに関連する教室レコードを取得
     */
    public function room()
    {
   //     return $this->belongsTo('App\Models\Room','id','staff_id');
       return $this->hasOne('App\Models\Room','staff_id', 'id');
    }

    /**
     * ユーザーに関連する教室レコードを取得
     */
    public function zoom()
    {
   //     return $this->belongsTo('App\Models\Room','id','staff_id');
       return $this->hasOne('App\Models\Zoom','staff_id', 'id');
    }

    /**
     * ユーザーに関連する教室レコードを取得
     */
    public function courses()
    {
       return $this->hasMany('App\Models\Course','staff_id', 'id');
    }

    /**
     * Override to send for password reset notification.
     *
     * @param [type] $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\StaffPasswordResetNotification($token));
    }
}
