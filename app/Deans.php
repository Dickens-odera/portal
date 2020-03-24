<?php

namespace App;

use App\Notifications\DeanResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Deans extends Authenticatable
{
    use Notifiable;
    /**
     * @var string
     */
    protected $guard = 'dean';
    /**
     * @var array
     *
    */
    protected $hidden = ['password','remember_token'];
    /**
     * @var array
     */
    protected $fillable = ['name','email','school_id'];
    /**
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function school()
    {
        return $this->belongsTo(Schools::class,'school_id','school_id');
    }
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new DeanResetPasswordNotification($token));
    }
}

