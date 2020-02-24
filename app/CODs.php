<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
class CODs extends Authenticatable
{
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
    protected $fillable = ['name','email'];
    /**
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
