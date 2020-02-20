<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * @var string
     */
    protected $guard = 'student';
    /**
     * @var array
     */
    protected $hidden = ['password'];
    /** 
     * @var array
     */
    protected $fillable = ['student_name'];
}
