<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

//    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'staff_id', 'price', 'category_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'staff_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function staff()
    {
        return $this->belongsTo('App\Models\Staff','staff_id','id');
    }

    /**
     * 
     * 
     */
    public function tax()
    {
        return ($this->price * 0.1);    // ★消費税
    }

    /**
     *
     */
    public function category()
    {
       return $this->hasOne('App\Models\CourseCategory','category_id', 'id');
    }

}
