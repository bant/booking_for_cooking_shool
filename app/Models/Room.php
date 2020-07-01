<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
//    protected $fillable = ['subject', 'due_date', 'completed', 'description'];

  // 「１対１」→ メソッド名は単数形
  Public function owner()
  {
    // Profileモデルのデータを引っ張てくる
    return $this->hasOne('App\Models\Staff','id','owner_id');
  }
}
