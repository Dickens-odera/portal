<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schools extends Model
{
    protected $table = 'schools';
    protected $fillable = ['school_name'];
    protected $guarded = ['school_id'];
}
