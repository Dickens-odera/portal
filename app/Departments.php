<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'departments';
    /**
     * @var array $fillable
     */
    protected $fillable = ['school_id','programs','chair','name','dep_id'];
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
        return $this->belongsTo(Schools::class,'dep_id','school_id');
    }
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function program()
    {
        return $this->hasMany(Programs::class,'dep_id','program_id');
    }
}
