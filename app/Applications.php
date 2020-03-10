<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Applications extends Model
{
    protected $table = 'applications';
    protected $fillable = [
        'cluster_no','student_name','reg_number','student_phone','present_program','present_school','preffered_program',
        'preffered_school','kcse_index','kcse_year','kuccps_password','mean_grade','aggregate_points','cut_off_points',
        'weighted_clusters','subject_1','subject_2','subject_3','subject_4','subject_5','subject_6','subject_7','subject_8','grade_1','grade_2',
        'grade_3','grade_4','grade_5','grade_6','grade_7','grade_8','result_slip','transfer_reason','student_id','status'
    ];

    public function students()
    {
      return $this->belongsTo(Student::class);
    }
}
