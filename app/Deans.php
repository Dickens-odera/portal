<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Deans extends Authenticatable
{
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
    protected $fillable = ['name','email'];
    /**
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
