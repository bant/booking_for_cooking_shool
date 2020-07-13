<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Schedule extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'staff_id', 'course_id', 'is_zoom', 'start', 'end',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'staff_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
//    protected $casts = [
//        'email_verified_at' => 'datetime',
//    ];


    Public function staff()
    {
        // Profileモデルのデータを引っ張てくる
//        return $this->hasMany('App\Models\Staff','id','staff_id');
        return $this->belongsTo('App\Models\Staff','staff_id','id');
    }

    Public function course()
    {
        return $this->belongsTo('App\Models\Course','course_id','id');
    }
 

}
