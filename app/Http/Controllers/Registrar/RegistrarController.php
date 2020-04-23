<?php

namespace App\Http\Controllers\Registrar;

use App\Applications;
use App\Http\Controllers\Controller;
use App\Listeners\RegistrarApplicationApprovalNotification;
use App\Services\Registrar\RegistrarService;
use App\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RegistrarController extends Controller
{
    /**
     * @var \App\Services\Registrar\RegistrarService
     */
    protected $registrarService;
    /**
     * create a new controller intance
     */
    public function __construct(RegistrarService  $registrarService)
    {
        $this->middleware('auth:registrar');
        $this->registrarService = $registrarService;
    }

    public function index()
    {
        return view('registrar.dashboard');
    }
    /**
     * @param Illuinate\Http\Request $request
     * @return Illuminate\Support\Facades\Response
     */
    public function getAllApplications(Request $request)
    {
        return $this->registrarService->allApps($request);
    }
    /**
     * View a single application
     * 
     * @var \Illuminate\Http\Request 
     * @var int $applications_id
     * @return \Illuminate\Http\Response
     */
    public function getSingleApplication(Request $request, $application_id = NULL)
    {
        return $this->registrarService->viewApp($request, $application_id);
    }
    /**
     * Lists all the incoming applications
     * 
     * @var \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAllIncomingApplications(Request $request)
    {
        return $this->registrarService->incomingApps($request);
    }
    /**
     * View a single application
     */
    public function getAnIncomingApplication(Request $request, $app_id = NULL)
    {
        return $this->registrarService->incomingApp($request, $app_id);
    }
    /**
     * Gets the details of a single outgoing application
     * 
     * @var \Illuminate\HTtp\Request $request
     * @var int $app_id
     * @return \Illuminate\Http\Response
     */
    public function getAnOutGoingApplication(Request $request, $app_id = NULL)
    {
        return $this->registrarService->outgoingApp($request, $app_id);
    }
    /**
     * Lists all the outgoing applications
     * 
     * @var \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function getAllOutgoingApplications(Request $request)
    {
        return $this->registrarService->outgoingApps($request);
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
