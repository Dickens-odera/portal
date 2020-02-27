<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Students;
class Applications extends Model
{
    protected $table = 'applications';
    protected $fillable = [
        'student_name','reg_number','student_phone','current_program','current_school','preffered_program',
        'preffered_school','kcse_index','kcse_year','kuccps_password','mean_grade','aggregate','cut_off_points',
        'weighted_clusters','sub_1','sub_2','sub_3','sub_4','sub_5','sub_6','sub_7','sub_8','grade_1','grade_2',
        'grade_3','grade_4','grade_5','grade_6','grade_7','grade_8','result_slip','transfer_reason',
    ];

    public function students()
    {
        $this->belongsTo('App\Students::class');
    }
}
