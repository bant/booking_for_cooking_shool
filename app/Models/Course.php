<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
//    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'staff_id', 'price',
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

    Public function staff()
    {
        return $this->belongsTo('App\Models\Staff','staff_id','id');
    }
}