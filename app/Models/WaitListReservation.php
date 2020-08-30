<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WaitListReservation extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'schedule_id'
      ];

    Public function user()
    {
//        return $this->hasOne('App\Models\User','id','user_id');
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    Public function schedule()
    {
  //      return $this->hasMany('App\Models\Schedule','id','schedule_id');
        return $this->belongsTo('App\Models\Staff','staff_id','id');
    }
}
