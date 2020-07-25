<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
}
