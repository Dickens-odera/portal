<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    /**
     * @var string $table
     */
    protected $table = 'subjects';
    /**
     * @var array $fillable
     */
    protected $fillable = ['name'];
}
