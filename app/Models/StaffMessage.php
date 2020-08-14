<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffMessage extends Model
{
    protected $fillable = [
        'staff_id',
        'message'
      ];

    // 「１対１」→ メソッド名は単数形
    Public function staff()
    {
        return $this->belongsTo('App\Models\Staff');
    }
}
