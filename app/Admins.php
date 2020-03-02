<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
class Admins extends Authenticatable
{
    use Notifiable;
    /**
     *@var string $guard
     */
    protected $guard = 'admin';
    /**
     * @var string $table
     */
    protected $table = 'admins';
    /**
     * @var array $hidden
     */
    protected $hidden = ['password','remember_token'];
    /**
     * @var array $fillable
     */
    protected $fillable = ['name','email','password'];
    /**
     * @var array $casts
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
