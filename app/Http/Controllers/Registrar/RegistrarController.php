<?php

namespace App\Http\Controllers\Registrar;

use App\Applications;
use App\CODs;
use App\Comments;
use App\Deans;
use App\Departments;
use App\Http\Controllers\Controller;
use App\Listeners\RegistrarApplicationApprovalNotification;
use App\Programs;
use App\Registrar;
use App\Schools;
use App\Services\Registrar\RegistrarService;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Monolog\Registry;

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
    public function getAllApplications(Request $request, RegistrarService $registrarService)
    {
        return $registrarService->allApps($request);
    }
    /**
     * View a single application
     * 
     * @var \Illuminate\Http\Request 
     * @var int $applications_id
     * @var \App\Comments
     * @return \Illuminate\Http\Response
     */
    public function getSingleApplication(Request $request, $application_id = NULL, RegistrarService $registrarService)
    {
        return $registrarService->viewApp($request, $application_id);
    }
    /**
     * Lists all the incoming applications
     * 
     * @var \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAllIncomingApplications(Request $request, RegistrarService $registrarService)
    {
        return $registrarService->incomingApps($request);
    }
    /**
     * View a single application
     */
    public function getAnIncomingApplication(Request $request,RegistrarService $registrarService, $app_id = NULL)
    {
        return $registrarService->incomingApp($request, $app_id);
    }
    /**
     * Gets the details of a single outgoing application
     * 
     * @var \Illuminate\HTtp\Request $request
     * @var int $app_id
     * @return \Illuminate\Http\Response
     */
    public function getAnOutGoingApplication(Request $request, $app_id = NULL, RegistrarService $registrarService)
    {
        return $registrarService->outgoingApp($request, $app_id);
    }
    /**
     * Lists all the outgoing applications
     * 
     * @var \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function getAllOutgoingApplications(Request $request, RegistrarService $registrarService)
    {
        return $registrarService->outgoingApps($request);
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
        //notify the student on application status
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
