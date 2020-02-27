<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Students;
class Applications extends Model
{
    protected $table = 'applications';
    protected $fillable = ['student_id'];

    public function students()
    {
        $this->belongsTo('App\Students::class');
    }
}
