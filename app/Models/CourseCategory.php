<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{

    // 「１対１」→ メソッド名は単数形
    Public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
