<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'point', 'description_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    Public function description()
    {
        return $this->belongsTo('App\Models\PaymentDescription','description_id','id');
    }

        /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    Public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
