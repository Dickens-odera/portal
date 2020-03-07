<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Programs;
class Schools extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'schools';
    /**
     * @var array $fillable
     */
    protected $fillable = ['school_name'];
    /**
     * @var array $guarded
     */
    protected $guarded = ['school_id'];
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function programs()
    {
        $this->hasMany('App\Programs::class','program_id');
    }
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function dean()
    {
        $this->hasMany('App\Deans::class','school_id');
    }
}

