<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;	//追記

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;	// 追記

    protected $dates = ['deleted_at'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Override to send for password reset notification.
     *
     * @param [type] $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\UserPasswordResetNotification($token));
    }

    /**
     * 
     */
    public function checkProfile()
    {
        if (is_null($this->kana))
            return false;
        if (is_null($this->zip_code))
            return false;
        if (is_null($this->pref))
            return false;
        if (is_null($this->address))
            return false;
        if (is_null($this->tel))
            return false;
        
        return true;
    }

    Public function reservations()
    {
        return $this->hasMany('App\Models\Reservation');
    }
}
