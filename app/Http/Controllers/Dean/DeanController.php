<?php

namespace App\Http\Controllers\Dean;

use App\Applications;
use App\CODs;
use App\Deans;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Schools;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use App\Comments;
use App\Departments;
use App\Programs;
use App\Notifications\DeanToRegistrarNotification;
use App\Registrar;
use Exception;
use Illuminate\Support\Facades\DB;

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
     * List all the incoming applications
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Comments $comments
     * @return \Illuminate\Http\Response
     */
    public function getAllIncomingApplications(Request $request,Comments $comments)
    {
        $dean = Deans::where('id','=',Auth::user()->id)->first();
        $school = $dean->school->school_name;
        $cod = CODs::where('school_id','=',$dean->school_id)->first();
        //dd($cod->id);
        //dd($school);
        //get the application status
        try{
        $applications = DB::table('comments')
                        ->join('applications','comments.app_id','=','applications.app_id')
                        ->join('cods','comments.user_id','=','cods.id')
                        ->select('comments.*','applications.*','cods.*')
                        ->where('comments.app_type','=','incoming')
                        ->where('comments.user_type','=','cod')
                        ->where('cods.school_id','=',Auth::user()->school->school_id)
                        ->orderBy('comment_id','DESC')
                        ->paginate(5);
        }catch(Exception $exception)
        {
            $request->session()->flash('error','No incoming applications available yet');
            return redirect()->route('dean.dashboard');
        }
        if(!$applications)
        {
            request()->session()->flash('error','Applications Not Found');
            return redirect()->back();
        }
        else
        {
            return view('dean.applications.incoming', compact('applications'));
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
            request()->session()->flash('error','Invalid request Format');
            return redirect()->back();
        }
        else
        {
            $this->validateApplication();
            //get the comments
            $application = Applications::where('app_id','=',$app_id)->first();
            $dean = Deans::where('id','=',Auth::user()->id)->first();
            $school = Schools::where('school_id','=',$dean->school_id)->first();
            $programs = Programs::where('name','=',$application->preffered_program)->first();
            $cods = CODs::where('dep_id','=',$programs->dep_id)->first();
            $department = Departments::where('dep_id','=',$cods->dep_id)->first();
            $comments = Comments::where('user_id','=',$cods->id)
                                    ->where('app_id','=',$app_id)
                                    ->where('app_type','=','incoming')
                                    ->where('user_type','=','cod')
                                    ->first();
            $dean_comment = Comments::where('user_id','=',$dean->id)
                                        ->where('user_type','=','dean')
                                        ->where('app_id','=',$app_id)
                                        ->where('app_type','=','incoming')
                                        ->first();
            // $comments = DB::table('comments')
            //                 ->join('applications','comments.app_id','=','applications.app_id')
            //                 ->join('cods','comments.user_id','=','cods.id')
            //                 ->join('departments','cods.dep_id','=','departments.dep_id')
            //                 ->select('comments.*','applications.*','cods.name as cod_name','departments.name as department')
            //                 ->where('comments.app_id','=',$app_id)
            //                 ->where('comments.app_type','=','outgoing')
            //                 ->get();
            if(!$application)
            {
                request()->session()->flash('error','The requested application could not be found');
                return redirect()->back();
            }
            else
            {
                return view('dean.applications.incoming-single-view',compact('application','school', 'comments','department','cods','dean_comment','dean'));
            }
        }
    }
    /**
     * Send the registrar feedback on incoming applications
     * 
     * @var \Illuminate\Http\Request
     * @var int $app_id
     * @return \Illuminate\Http\Response
     */
    public function submitFeedbackOnIncomingApp(Request $request, $app_id = NULL)
    {
        //do something here
        $app_id = $request->app_id;
        if(!$app_id)
        {
            $request->session()->flash('error','Invalid request format');
            return redirect()->back()->withInput($request->only('comment'));
        }
        else
        {
            $validator = Validator::make($request->all(), array('comment'=>'required'));
            if($validator->fails())
            {
                $request->session()->flash('error',$validator->errors());
                return redirect()->back()->withInput($request->all());
            }
            else
            {
                $user = Auth::user();
                $dean = Deans::where('id','=',$user->id)->first();
                $existing_comment = Comments::where('app_id','=',$app_id)
                                            ->where('app_type','=','incoming')
                                            ->where('user_type','=','dean')
                                            ->where('user_id','=',$dean->id)
                                            ->first();
                if($existing_comment)
                {
                    $request->session()->flash('error','You had submitted feedback to this application earlier on, no action needed');
                    return redirect()->back();
                }
                if(Comments::create(array(
                    'comment'=>$request->comment,
                    'user_id'=>$dean->id,
                    'user_type'=>'dean',
                    'app_id'=>$app_id,
                    'app_type'=>'incoming'
                ))){
                    //send mail or sms to registrar
                    $registrar = Registrar::first();
                    $name = $registrar->name;
                    try{
                        $this->sendEmailNotificationToRegistrar($registrar,$app_id, $name, $dean->school->school_name);
                    }catch(Exception $exception)
                    {
                        $request->session()->flash('error','No internet connection, coild not send email to'.' '.$request->email);
                    }
                    $request->session()->flash('success','Feedback sent successfully to'.' '.$name);
                    return redirect()->back();
                }
                else
                {
                    //on failure to submit feedback
                    $request->session()->flash('error','Failed to perform action, try again later');
                    return redirect()->back()->withInput($request->only('comment'));
                }
            }
        }
    }
    /**
     * List all the outgoing applicatins that have been acted upon by the COD
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAllOutgoingApplications(Request $request)
    {
        try{
        $applications = DB::table('comments')
                            ->join('applications','comments.app_id','=','applications.app_id')
                            ->join('cods','comments.user_id','=','cods.id')
                            ->select('comments.*','applications.*','cods.*')
                            ->where('comments.app_type','=','outgoing')
                            ->where('comments.user_type','=','cod')
                            ->where('cods.school_id','=',Auth::user()->school->school_id)
                            ->orderBy('comment_id','DESC')
                            ->paginate(1);
        }catch(Exception $exception)
        {
            $request->session()->flash('error','No incoming applications yet');
            return redirect(route('dean.dashboard'));     
        }
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
            //get the comments
            $application = Applications::where('app_id','=',$app_id)->first();
            $dean = Deans::where('id','=',Auth::user()->id)->first();
            $school = Schools::where('school_id','=',$dean->school_id)->first();
            $programs = Programs::where('name','=',$application->present_program)->first();
            $cods = CODs::where('dep_id','=',$programs->dep_id)->first();
            $department = Departments::where('dep_id','=',$cods->dep_id)->first();
            $comments = Comments::where('user_id','=',$cods->id)
                                    ->where('app_id','=',$app_id)
                                    ->where('app_type','=','outgoing')
                                    ->where('user_type','=','cod')
                                    ->first();
            $dean_comment = Comments::where('user_id','=',$dean->id)
                                        ->where('user_type','=','dean')
                                        ->where('app_id','=',$app_id)
                                        ->where('app_type','=','outgoing')
                                        ->first();
            // $comments = DB::table('comments')
            //                 ->join('applications','comments.app_id','=','applications.app_id')
            //                 ->join('cods','comments.user_id','=','cods.id')
            //                 ->join('departments','cods.dep_id','=','departments.dep_id')
            //                 ->select('comments.*','applications.*','cods.name as cod_name','departments.name as department')
            //                 ->where('comments.app_id','=',$app_id)
            //                 ->where('comments.app_type','=','outgoing')
            //                 ->get();
            if(!$application)
            {
                request()->session()->flash('error','The requested application could not be found');
                return redirect()->back();
            }
            else
            {
                return view('dean.applications.outgoing-single-view',compact('application','school', 'comments','department','cods','dean_comment','dean'));
            }
        }
    }
    /**
     * Dean Aproval/Disapproval of an outgoing application
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $app_id
     * @return \Illuminate\Http\Response
     */
    public function submitFeedbackOnOutgoingApp(Request $request, $app_id = NULL)
    {
        //do something here
        $app_id = $request->app_id;
        if(!$app_id)
        {
            $request->session()->flash('error','Invalid request format');
            return redirect()->back()->withInput($request->only('comment'));
        }
        else
        {
            $validator = Validator::make($request->all(), array('comment'=>'required'));
            if($validator->fails())
            {
                $request->session()->flash('error',$validator->errors());
                return redirect()->back()->withInput($request->all());
            }
            else
            {
                $user = Auth::user();
                $dean = Deans::where('id','=',$user->id)->first();
                $existing_comment = Comments::where('app_id','=',$app_id)
                                            ->where('app_type','=','outgoing')
                                            ->where('user_type','=','dean')
                                            ->where('user_id','=',$dean->id)
                                            ->first();
                if($existing_comment)
                {
                    $request->session()->flash('error','You had submitted feedback to this application earlier on, no action needed');
                    return redirect()->back();
                }
                if(Comments::create(array(
                    'comment'=>$request->comment,
                    'user_id'=>$dean->id,
                    'user_type'=>'dean',
                    'app_id'=>$app_id,
                    'app_type'=>'outgoing'
                ))){
                     //send mail or sms to registrar
                     $registrar = Registrar::first();
                     $name = $registrar->name;
                     try{
                         $this->sendEmailNotificationToRegistrar($registrar,$app_id, $name, $dean->school->school_name);
                     }catch(Exception $exception)
                     {
                         $request->session()->flash('error','No internet connection, coild not send email to'.' '.$request->email);
                     }
                    $request->session()->flash('success','Feedback sent successfully to'.' '.$name);
                    return redirect()->back();
                }
                else
                {
                    //on failure to submit feedback
                    $request->session()->flash('error','Failed to perform action, try again later');
                    return redirect()->back()->withInput($request->only('comment'));
                }
            }
        }
    }
    /******************************** END OF APPLICATIONS MODULE ********************/
    /**
     * Sends an email notification to the Registrar(Academic Affairs) concerning application approval status
     * 
     * @var \App\Registrar $registrar
     * @var int $application
     * @var string $name
     * @var string $school
     * @return \Illuminate\Notifications\Notifiable
     */
    public function sendEmailNotificationToRegistrar(Registrar $registrar,$application, $name, $school)
    {
        $registrar->notify(new DeanToRegistrarNotification($application, $name, $school));
    }
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
