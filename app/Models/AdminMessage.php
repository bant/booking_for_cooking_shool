<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminMessage extends Model
{
    protected $fillable = [
        'admin_id',
        'message'
      ];

    // 「１対１」→ メソッド名は単数形
    Public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }
}
