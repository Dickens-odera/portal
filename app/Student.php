<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Student extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    /**
     * @var string
     */
    protected $guard = 'student';
    /**
     * @var array
     *
    */
    protected $hidden = ['password','remember_token'];
    /**
     * @var array
     */
    protected $fillable = ['surnamame','middleName','lastName','email','password','idNumber','regNumber','username','student_id'];
    /**
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //student-applications relationship
    public function applications()
    {
        return $this->hasMany(Applications::class,'student_id');
    }
}
