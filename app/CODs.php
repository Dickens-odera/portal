<?php

namespace App;

use App\Notifications\CODResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Schools;
class CODs extends Authenticatable
{
    use Notifiable;
    /**
     * @var string|null $table
     */
    protected $table = 'cods';
    /**
     * @var string
     */
    protected $guard = 'cod';
    /**
     * @var array
     *
    */
    protected $hidden = ['password','remember_token'];
    /**
     * @var array
     */
    protected $fillable = ['name','email','dep_id','school_id'];
    /**
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function department()
    {
       return $this->belongsTo(Departments::class,'dep_id','dep_id');
    }
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
        $this->notify(new CODResetPasswordNotification($token));
    }
}
