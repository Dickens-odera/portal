<?php

namespace App\Http\Controllers\Registrar;

use App\Applications;
use App\Http\Controllers\Controller;
use App\Listeners\RegistrarApplicationApprovalNotification;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
class RegistrarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:registrar');
    }

    public function index()
    {
        return view('registrar.dashboard');
    }
    /**
     * @param Illuinate\Http\Request $request
     * @return Illuminate\Support\Facades\Response
     */
    public function getApplication(Request $request)
    {
        //get approved/ non-apprived applicationsfrom the comments section
        $applications = DB::table('comments')
                                ->join('applications','comments.app_id','=','applications.app_id')
                                ->join('deans','comments.user_id','deans.id')
                                ->select('comments.*','applications.*','deans.name as dean')
                                ->where('comments.user_type','=','dean')
                                ->orderBy('comments.comment_id','desc')
                                // ->where('comments.comment','LIKE','%'.'Approved'.'%')
                                ->paginate(3);

                                //$applications = Applications::latest()->paginate(5);
        return view('registrar.applications.index',compact('applications'));
    }
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function getApplicationsTables()
    {
        $applications = Applications::all();
        return DataTables::of($applications)->addColumn('action', function($row){
            return "<a href='{{ route('student.application.show',$row->app_id) }}' class='btn btn-sm btn-success'<i class='fa fa-eye'</i>View More</a>";
                    "<a href='{{ route('student.application.show',$row->app_id) }}' class='btn btn-sm btn-success'<i class='fa fa-eye'</i>View More</a>";
        })->make();
    }
    public function approveStudentApplication(Student $student, Applications $applications)
    {
         event( new RegistrarApplicationApprovalNotification());
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Facades\Response
     */
    public function addStudent(Request $request)
    {
        Student::create($this->validateStudentDetails());
    }
    /**
     *@return void
     */
    private function validateStudentDetails()
    {
        return request()->validate([
            'surname'=>'string|required',
            'firstName'=>'string|nullable',
            'middleName'=>'string|nullable',
            'lastName'=>'string|nullable',
            'regNumber'=>'required',
            'email'=>'email|required|unique:students',
            'idNumber'=>'nullable'
        ]);
    }

}
