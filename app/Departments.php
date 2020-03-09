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
        $this->hasOne('App\CODs::class');
    }
}
