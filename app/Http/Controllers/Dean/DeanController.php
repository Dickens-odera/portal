<?php

namespace App\Http\Controllers\Dean;

use App\Applications;
use App\Deans;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Schools;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
class DeanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:dean');
    }
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dean.dashboard');
    }

    /******************************** START OF APPLICATIONS MODULE  *************/
    /**
     * @return \Illuminate\Http\Response
     */
    public function getAllIncomingApplications()
    {
        $dean = Deans::where('id','=',Auth::user()->id)->first();
        $school = $dean->school->school_name;
        //dd($school);
        //get the application status
        $applications = Applications::where('preffered_school','=',$school)
                                        ->latest()
                                        ->paginate(3);
        //dd($applications);
        // $count = $applications->get()->all();
        if(!$applications)
        {
            request()->session()->flash('error','Applications Not Found');
            return redirect()->back();
        }
        else
        {
            return view('dean.applications.incoming', compact('applications','count'));
        }
    }
    /**
     * @param int $app_id
     * @return \Illuminate\Http\Response
     */
    public function getAnIncomingApplication($app_id = null)
    {
        $app_id = request()->app_id;
        if(!$app_id)
        {
            request()->session()->flash('error','Invalid Request Format');
            return redirect()->back();
        }
        else
        {
            $this->validate(request(),array('app_id'=>'required'));
            //get cod comments for both the current and receiving cods
            $application = Applications::where('app_id','=',$app_id)->first();
            if(!$application)
            {
                request()->session()->flash('error','Requested application not found');
                return redirect()->back();
            }
            else
            {
                return view('dean.applications.incoming-single-view', compact('application'));
            }
        }
    }
    /**
     * @return \Illuminate\Http\Response
     */
    public function submitFeedbackOnIncomingApp()
    {

    }
    /**
     * @return \Illuminate\Http\Response
     */
    public function getAllOutgoingApplications()
    {
        $dean = Deans::where('id','=',Auth::user()->id)->first();
        $applications = Applications::where('present_school','=',$dean->school->school_name)
                                        ->latest()
                                        ->paginate(5);
        if(!$applications)
        {
            request()->session()->flash('error','Applications not found');
            return redirect()->back();
        }
        else
        {
            return view('dean.applications.outgoing', compact('applications'));
        }
    }
    /**
     * @param int $app_id
     * @return \Illuminate\Http\Response
     */
    public function getAnOutGoingApplication($app_id = null)
    {
        $app_id = request()->app_id;
        if(!$app_id)
        {
            request()->session()->flash('error','Invalid request Format');
            return redirect()->back();
        }
        else
        {
            $this->validateApplication();
            $application = Applications::where('app_id','=',$app_id)->first();
            if(!$application)
            {
                request()->session()->flash('error','The requested application could not be found');
                return redirect()->back();
            }
            else
            {
                return view('dean.applications.outgoing-single-view',compact('application'));
            }
        }
    }
    /**
     * @return \Illuminate\Http\Response
     */
    public function submitFeedbackOnOutgoingApp()
    {
        //do something here
    }
    /******************************** END OF APPLICATIONS MODULE ********************/
    /**
     * @return array
     */
    private function data()
    {
        return array('name'=>request()->name,'description'=>request()->description);
    }
    /**
     * @return array
     */
    private function dean_id()
    {
        return  array('school_name'=>Auth::user()->school_id);

    }
    /**
     * @return array
     */
    private function validateApplication()
    {
        return $this->validate(request(),array('app_id'=>'required'));
    }
}
