<?php

namespace App\Http\Controllers\Registrar;

use App\Applications;
use App\Comments;
use App\Http\Controllers\Controller;
use App\Listeners\RegistrarApplicationApprovalNotification;
use App\Registrar;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use Illuminate\Support\Facades\Auth;
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
    public function getAllApplications(Request $request)
    {
        //get approved/ non-apprived applicationsfrom the comments section
        $applications = DB::table('comments')
                                ->join('applications','comments.app_id','=','applications.app_id')
                                ->join('deans','comments.user_id','deans.id')
                                ->select('comments.*','applications.*','deans.name as dean')
                                ->where('comments.user_type','=','dean')
                                ->orderBy('comments.comment_id','desc')
                                // ->where('comments.comment','LIKE','%'.'Approved'.'%')
                                ->paginate(4);

                                //$applications = Applications::latest()->paginate(5);
        return view('registrar.applications.index',compact('applications'));
    }
    /**
     * View a single application
     * 
     * @var \Illuminate\Http\Request 
     * @var int $applications_id
     * @var \App\Comments
     * @return \Illuminate\Http\Response
     */
    public function getSingleApplication(Request $request, $applications_id = NULL)
    {
        $applications_id = $request->app_id;
        if(!$applications_id)
        {
            $request->session()->flash('error','Invalid request format');
            return redirect()->back();
        }
        else
        {
            //$application = Comments::where('app_id','=',$applications_id)->first();
            $application = DB::table('comments')
            ->join('applications','comments.app_id','=','applications.app_id')
            ->select('comments.*','applications.*')
            ->where('comments.app_id','=',$applications_id)
            // ->where('comments.comment','LIKE','%'.'Approved'.'%')
            ->first();

            if(!$application)
            {
                $request->session()->flash('error','Application not found');
                return redirect()->back();
            }
            else
            {
                return view('registrar.applications.show', compact('application'));
            }
        }
    }
    /**
     * Lists all the incoming applications
     * 
     * @var \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAllIncomingApplications(Request $request)
    {
        try{
        $applications = DB::table('comments')
                                ->join('applications','comments.app_id','=','applications.app_id')
                                ->join('deans','comments.user_id','deans.id')
                                ->select('comments.*','applications.*','deans.name as dean')
                                ->where('comments.user_type','=','dean')
                                ->where('comments.app_type','incoming')
                                ->orderBy('comments.comment_id','desc')
                                // ->where('comments.comment','LIKE','%'.'Approved'.'%')
                                ->paginate(4);

        }catch(Exception $exception)
        {
            $request->session()->flash('error','No incoming applications forwarded yet');
            return redirect()->back();
        }
        if($applications)
        {
            return view('registrar.applications.incoming', compact('applications'));
        }
        else
        {
            $request->session()->flash('error','No incoming applications have been forwarded yet');
            return redirect()->back();
        }

    }
    /**
     * Lists all the outgoing applications
     * 
     * @var \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function getAllOutgoingApplications(Request $request)
    {
        try{
            $applications = DB::table('comments')
                                    ->join('applications','comments.app_id','=','applications.app_id')
                                    ->join('deans','comments.user_id','deans.id')
                                    ->select('comments.*','applications.*','deans.name as dean')
                                    ->where('comments.user_type','=','dean')
                                    ->where('comments.app_type','outgoing')
                                    ->orderBy('comments.comment_id','desc')
                                    // ->where('comments.comment','LIKE','%'.'Approved'.'%')
                                    ->paginate(1);
    
            }catch(Exception $exception)
            {
                $request->session()->flash('error','No incoming applications forwarded yet');
                return redirect()->back();
            }
            if($applications)
            {
                return view('registrar.applications.outgoing', compact('applications'));
            }
            else
            {
                $request->session()->flash('error','No incoming applications have been forwarded yet');
                return redirect()->back();
            }
    
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
