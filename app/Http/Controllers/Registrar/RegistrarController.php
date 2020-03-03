<?php

namespace App\Http\Controllers\Registrar;

use App\Applications;
use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;
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
        //$applications = Applications::latest()->get();
        //return view('registrar.applications.index',compact('applications'));
        return view('registrar.applications.index');

    }
    public function getApplicationsTables()
    {
        $applications = Applications::all();
        return DataTables::of($applications)->addColumn('action', function($row){
            return "<a href='{{ route('student.application.show',$row->app_id) }}' class='btn btn-sm btn-success'<i class='fa fa-eye'</i>View More</a>";
                    "<a href='{{ route('student.application.show',$row->app_id) }}' class='btn btn-sm btn-success'<i class='fa fa-eye'</i>View More</a>";
        })->make();
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
