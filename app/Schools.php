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
    public function program()
    {
       return $this->hasMany(Programs::class,'school_id','program_id');
    }
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function dean()
    {
       return $this->hasOne(Deans::class,'school_id','id');
    }
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function cod()
    {
       return $this->hasMany(CODs::class,'school_id','id');
    }
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function department()
    {
        return $this->hasMany(Departments::class,'school_id','dep_id');
    }
}

