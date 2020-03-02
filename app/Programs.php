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
    protected $fillable = ['name','description','school_id'];
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function school()
    {
        $this->belongsTo('App\Schools:class','school_id');
    }
}
