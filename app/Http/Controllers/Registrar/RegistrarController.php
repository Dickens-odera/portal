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
            try{
            //$application = Comments::where('app_id','=',$applications_id)->first();
            $application = DB::table('comments')
                            ->join('applications','comments.app_id','=','applications.app_id')
                            ->select('comments.*','applications.*')
                            ->where('comments.app_id','=',$applications_id)
                            // ->where('comments.comment','LIKE','%'.'Approved'.'%')
                            ->first();
            }catch(Exception $exception)
            {
                $request->session()->flash('error','The specified application could not be found');
                return redirect()->back();
            }
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
     * View a single application
     * 
     * @var \Illuminate\Http\Request $request
     * @var int $app_id
     * @return \Illuminate\Http\Response
     */
    public function getAnIncomingApplication(Request $request, $app_id = NULL)
    {
        $app_id = $request->app_id;
        if(!$app_id)
        {
            $request->session()->flash('error','Invalid request format');
            return redirect()->back();
        }
        else
        {
            $validator = Validator::make($request->all(), array('app_id'=>'required'));
            if($validator->fails())
            {
                $request->session()->flash('error',$validator->errors()->all());
                return redirect()->back();
            }
            else
            {
                try{
                    $application = Applications::where('app_id','=',$app_id)->first();
                    $programs = Programs::where('name','=',$application->preffered_program)->first();
                    $dean = Deans::where('school_id','=',$programs->school_id)->first();
                    $school = Schools::where('school_id','=',$dean->school_id)->first();
                    $cods = CODs::where('dep_id','=',$programs->dep_id)->first();
                    $department = Departments::where('dep_id','=',$cods->dep_id)->first();
                    $comments = Comments::where('user_id','=',$cods->id)
                                            ->where('app_id','=',$app_id)
                                            ->where('app_type','=','incoming')
                                            // ->orWhere('app_type','=','outgoing')
                                            ->where('user_type','=','cod')
                                            ->first();
                    $dean_comment = Comments::where('user_id','=',$dean->id)
                                                ->where('user_type','=','dean')
                                                ->where('app_id','=',$app_id)
                                                ->where('app_type','=','incoming')
                                                // ->orWhere('app_type','=','outgoing')
                                                ->first();
                    //dd($dean_comment);
                return view('registrar.applications.incoming-single-view', compact('application','school', 'comments','department','cods','dean_comment','dean'));
                }catch(Exception $exception)
                {
                    $request->session()->flash('error','Application not found');
                }
            }
        }
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
        $app_id = $request->app_id;
        if(!$app_id)
        {
            $request->session()->flash('error','Invalid request format');
            return redirect()->back();
        }
        else
        {
            $validator = Validator::make($request->all(), array('app_id'=>'required'));
            if($validator->fails())
            {
                $request->session()->flash('error',$validator->errors()->all());
                return redirect()->back();
            }
            else
            {
                try{
                    $application = Applications::where('app_id','=',$app_id)->first();
                    $programs = Programs::where('name','=',$application->present_program)->first();
                    $dean = Deans::where('school_id','=',$programs->school_id)->first();
                    $school = Schools::where('school_id','=',$dean->school_id)->first();
                    $cods = CODs::where('dep_id','=',$programs->dep_id)->first();
                    $department = Departments::where('dep_id','=',$cods->dep_id)->first();
                    $comments = Comments::where('user_id','=',$cods->id)
                                            ->where('app_id','=',$app_id)
                                            ->where('app_type','=','outgoing')
                                            // ->orWhere('app_type','=','incoming')
                                            ->where('user_type','=','cod')
                                            ->first();
                    $dean_comment = Comments::where('user_id','=',$dean->id)
                                                ->where('user_type','=','dean')
                                                ->where('app_id','=',$app_id)
                                                ->where('app_type','=','outgoing')
                                                // ->orWhere('app_type','=','incoming')
                                                ->first();
                    //dd($dean_comment);
                return view('registrar.applications.outgoing-single-view', compact('application','school', 'comments','department','cods','dean_comment','dean'));
                }catch(Exception $exception)
                {
                    $request->session()->flash('error','Application not found');
                }
            }
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
                                    ->paginate(4);
    
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
