<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zoom extends Model
{
  protected $fillable = [
    'name',
    'staff_id',
    'description'
  ];


  // 「１対１」→ メソッド名は単数形
  public function staff()
  {
    return $this->belongsTo('App\Models\Staff');
  }
}
