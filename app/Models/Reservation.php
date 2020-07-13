<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'schedule_id'
      ];

    Public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    Public function schedules()
    {
        return $this->hasMany('App\Models\Schedule','id','schedule_id');
    }
}
