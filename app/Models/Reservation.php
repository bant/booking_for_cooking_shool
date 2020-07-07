<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{

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
        return $this->hasMany('App\Models\Schedule');
    }
}
