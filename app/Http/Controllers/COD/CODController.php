<?php

namespace App\Http\Controllers\COD;

use App\Applications;
use App\CODs;
use App\Departments;
use App\Http\Controllers\Controller;
use App\Programs;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class CODController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:cod');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cod.dashboard');
    }
    /*=======================================  APPLICATIONS ==============================*/
    /**
     * @return \Illuminate\Http\Response
     */
    public function getAllApplications()
    {
        $cod = CODs::where('id','=',Auth::user()->id)->first();
        $school = $cod->school;
        //$school_name = $school->school_name;
        //dd($school_name);
        $department = $cod->department;
        $school_name = $department->school->school_name;
        $department_name = $department->name;
        //dd($department->program);
        $dep = Departments::where('dep_id','=',Auth::user()->department->dep_id)->first();
        $test_programs = DB::select('select name from programs where programs.dep_id = :id',['id'=>Auth::user()->department->dep_id]);
        $p = Programs::where('dep_id','=',Auth::user()->department->dep_id)->pluck('name');
        //dd($p);
        //dd($test_programs);
        //dd($dep->program);
        $applications = Applications::where('preffered_school','=',$school_name)
                                    ->whereIn('preffered_program',$p)
                                    ->latest()
                                    ->paginate(2);
        //dd($applications);
        if(!$applications)
        {
            request()->session()->flash('error','No applications found');
            return redirect()->back();
        }
        else
        {
            return view('cod.applications.index', compact('applications'));
        }
    }
    /**
     * @param string $application_id
     * @return \Illuminate\Http\Response
     */
    public function getApplication($application_id = null)
    {
        $application_id = request()->app_id;
        if(!$application_id)
        {
            request()->session()->flash('error','Invalid Request Format');
            return redirect()->back()->withInput(request()->all());
        }
        else
        {
            $validator = Validator::make(request()->all(),array('app_id'=>'required'));
            if($validator->fails())
            {
                request()->session()->flash('error',$validator->errors());
                return redirect()->back();
            }
            else
            {
                $application = Applications::where('app_id','=',$application_id)->first();
                if(!$application)
                {
                    request()->session()->flash('error','Application Not Found');
                    return redirect()->back();
                }
                else
                {
                    //$email = $application->students->email;
                    //dd($email);
                    return view('cod.applications.show',compact('application'));
                }
            }
        }
    }
    /**
     * @return \Illuminate\Http\Response
     */
    public function getAllOutgoingApplications()
    {
        $user = CODs::where('id','=',Auth::user()->id)->first();
        $school = $user->school->school_name;
        $dep = $user->department->program;
        //dd($dep);
        $p = Programs::where('dep_id','=',Auth::user()->department->dep_id)->pluck('name');
        $applications = Applications::where('present_school','=',$school)
                                        ->whereIn('present_program',$p)
                                        ->latest()
                                        ->paginate(5);
        //dd($applications);
        //dd($p);
        if(!$applications)
        {
            request()->session()->flash('error','No applications at the moment');
            return redirect()->back();
        }
        else
        {
            return view('cod.applications.outgoing.all',compact('applications'));
        }
    }
    /**
     * @return \Illuminate\Http\Response
     */
    public function getAllIncomingApplications()
    {
        $user = CODs::where('id','=',Auth::user()->id)->first();
        $school = $user->school->school_name;
        $dep = $user->department->program;
        //dd($dep);
        $p = Programs::where('dep_id','=',Auth::user()->department->dep_id)->pluck('name');
        $applications = Applications::where('preffered_school','=',$school)
                                        ->whereIn('preffered_program',$p)
                                        ->latest()
                                        ->paginate(5);
        //dd($applications);
        //dd($p);
        if(!$applications)
        {
            request()->session()->flash('error','No applications at the moment');
            return redirect()->back();
        }
        else
        {
            return view('cod.applications.incoming.all',compact('applications'));
        }
    }
    /**
     * @param int $app_id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAnIncomingApplication(Request $request,$app_id = null)
    {
        $app_id = $request->app_id;
        if(!$app_id)
        {
            $request->session()->flash('error','Invalid Request Format');
            return redirect()->back();
        }
        else
        {
            $this->validate($request,array('app_id'=>'required'));
            $application = Applications::where('app_id','=',$app_id)->first();
            //dd($application);
            if(!$application)
            {
                $request()->session()->flash('error','Application Not Found');
                return redirect()->back();
            }
            else
            {
                return view('cod.applications.incoming.single-view',compact('application'));
            }
        }
    }
    /**
     * @param string $app_id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAnOutgoingApplication(Request $request,$app_id = null)
    {
        $app_id = $request->app_id;
        if(!$app_id)
        {
            $request->session()->flash('error','Invalid Request Format');
            return redirect()->back();
        }
        else
        {
            $this->validate($request,array('app_id'=>'required'));
            $application = Applications::where('app_id','=',$app_id)->first();
            //dd($application);
            if(!$application)
            {
                $request()->session()->flash('error','Application Not Found');
                return redirect()->back();
            }
            else
            {
                return view('cod.applications.outgoing.single-view',compact('application'));
            }
        }
    }
/*================================================ END OF APPLICATIONS =================================== */
}
