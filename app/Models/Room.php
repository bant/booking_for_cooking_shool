<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
  protected $fillable = [
    'name',
    'staff_id',
    'address',
    'description'
  ];


  // 「１対１」→ メソッド名は単数形
  Public function staff()
  {
    return $this->belongsTo('App\Models\Staff');
  }
}
