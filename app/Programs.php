<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Schools;
class Programs extends Model
{
    /**
     * @var string $table
     */
    protected $table = "programs";
    /**
     * @var array $fillable
     */
    protected $fillable = ['name','description','school_id','dep_id'];
    /**
     * @return \Illuminate\Http\Response
     */
    public function school()
    {
       return $this->belongsTo(Schools::class,'school_id','school_id');
    }
    /**
     * @return \Illuminate\Http\Response
     */
    public function department()
    {
        return $this->belongsTo(Departments::class,'dep_id','dep_id');
    }
}
