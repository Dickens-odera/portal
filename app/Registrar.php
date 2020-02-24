<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Registrar extends Authenticatable
{
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
}
