<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    /**
     * @var string
     */
    protected $table = 'departments';
    /**
     * @var array
     */
    protected $fillable = array('school_id','programs','chair');
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function cod()
    {
       return $this->hasOne(CODs::class,'dep_id','dep_id');
    }
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function school()
    {
        return $this->belongsTo(\App\Schools::class,'school_id','school_id');
    }
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function program()
    {
        return $this->hasMany(Programs::class,'dep_id','program_id');
    }
}
