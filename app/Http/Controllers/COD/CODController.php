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
        //dd($school->school_name);
        //dd($school_name);
        $department = $cod->department;
        //dd($department->name);
        $cods = DB::table('cods')
                    ->join('departments','cods.dep_id','=','departments.dep_id')
                    ->select('cods.*','departments.name as department')
                    ->get();
        $department = Departments::where('dep_id','=',Auth::user()->dep_id)->first();
        $program = Programs::where('dep_id','=',$department->dep_id)->first();
        $programs = DB::table('programs')
                            ->join('departments','programs.dep_id','=','programs.dep_id')
                            ->select('programs.name as program','departments.dep_id as dep_id','departments.name as department')
                            ->first();
        $applications = Applications::whereIn('present_program',(array)$program)
                                    ->orwhereIn('preffered_program',(array)$program)
                                    ->latest()
                                    ->paginate(10);
        //dd($applications);
        if(!$applications)
        {
            request()->session()->flash('error','No applications found');
            return redirect()->back();
        }
        else
        {
            return view('cod.applications.index', compact('applications','programs','department'));
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
        //$dep = $user->department->name;
        //dd($dep);
        $department = Departments::where('dep_id','=',Auth::user()->dep_id)->first();
        $program = Programs::where('dep_id','=',$department->dep_id)->pluck('name');
        $p = Programs::where('dep_id','=',Auth::user()->department->dep_id)->pluck('name');
        $applications = Applications::where('present_school','=',$school)
                                        ->whereIn('present_program',(array)$program)
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
            return view('cod.applications.outgoing.all',compact('applications','department'));
        }
    }
    /**
     * @return \Illuminate\Http\Response
     */
    public function getAllIncomingApplications()
    {
        $user = CODs::where('id','=',Auth::user()->id)->first();
        $school = $user->school->school_name;
        //$p = Programs::where('dep_id','=',Auth::user()->department->dep_id)->pluck('name');
        $department = Departments::where('dep_id','=',Auth::user()->dep_id)->first();
        $program = Programs::where('dep_id','=',$department->dep_id)
                                //->first()
                                ->pluck('name');
        $applications = Applications::where('preffered_school','=',$school)
                                        ->whereIn('preffered_program',(array)$program)
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
            return view('cod.applications.incoming.all',compact('applications','department'));
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
