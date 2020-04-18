<?php 
namespace App\Services\Admin;

use App\CODs;
use App\Deans;
use App\Registrar;
use App\Schools;
use App\Student;
use Illuminate\Support\Facades\DB;

class AdminService
{
    //query data to be rendered to the admin dashboard
    public function data()
    {
        $cods_queries = DB::table('cods')
            ->join('departments','cods.dep_id','=','departments.dep_id')
            ->join('schools','cods.school_id','=','schools.school_id')
            ->select('cods.*','departments.name as department','schools.school_name as school')
            ->take(3)
            ->get();
        $cod_count = count(CODs::all());
        $dean_count = count(Deans::all());
        $registrar_count = count(Registrar::all());
        $school_count = count(Schools::all());
        $student_count = count(Student::all());
        
        return view('admin.dashboard', compact(['cods_queries','cod_count','dean_count','registrar_count','school_count','student_count']));

    }
}

?>