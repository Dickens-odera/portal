<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
