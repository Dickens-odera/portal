<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
    protected $fillable = ['name','email','dep_id'];
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
        $this->belongsTo('App\Departments::class','dep_id');
    }
}
