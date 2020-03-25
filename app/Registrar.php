<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\RegistrarResetPasswordNotification;
class Registrar extends Authenticatable
{
    use Notifiable;
    /**
     * @var string $table
     */
    protected $table = "registrars";
    /**
     * @var string
     */
    protected $guard = 'registrar';
    /**
     * @var array
     *
    */
    protected $hidden = ['password','remember_token'];
    /**
     * @var array
     */
    protected $fillable = ['name','email'];
    /**
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * Send password reset notification to the registrar
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new RegistrarResetPasswordNotification($token));
    }
}
