<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    protected $fillable = [
        'user_id',
        'message'
    ];

    // 「１対１」→ メソッド名は単数形
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
