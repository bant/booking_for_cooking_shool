<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


/*
Schema::create('schedules', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->unsignedBigInteger('owner_id');
    $table->foreign('owner_id')->references('id')->on('staff');
    $table->boolean('is_zoom')->nullable();
    $table->string('title');
    $table->string('description');
    $table->dateTime('start');
    $table->dateTime('end');
    $table->timestamps();
});
*/
class Schedule extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'owner_id', 'description', 'start', 'end',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'owner_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
//    protected $casts = [
//        'email_verified_at' => 'datetime',
//    ];

    // 「１対１」→ メソッド名は単数形
    Public function staff()
    {
        // Profileモデルのデータを引っ張てくる
        return $this->hasMany('App\Models\Staff','id','owner_id');
    }
}
