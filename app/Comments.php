<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    /**
     * @var string $table
     */
    protected $table = "comments";
    /**
     * @var array $fillable
     */
    protected $fillable = [];
}
