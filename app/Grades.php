<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grades extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'grades';
    /**
     * @var array $fillable
     */
    protected $fillable = ['name','points'];
}
