<?php

namespace App\Http\Controllers\COD;

use App\Applications;
use App\CODs;
use App\Comments;
use App\Departments;
use App\Http\Controllers\Controller;
use App\Programs;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use App\Exports\ProgramsExport;
use App\Imports\ProgramsImport;
use App\Schools;
use App\Deans;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\CodToDeanNotificationOnOutgoingApplication as CoDDeanResponse;
use Illuminate\Support\Facades\Notification;
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
     * List all the applications specific to the cod's school and department
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
                            ->join('departments','programs.dep_id','=','departments.dep_id')
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
     * Show a single application
     *
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
     * List all the applications from students chosing to opt of the programs in the cod's department
     *
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
        //$p = Programs::where('dep_id','=',Auth::user()->department->dep_id)->pluck('name');
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
     * List all the applications form students whom would wish to transfer to programs available in the cod's particular department
     *
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
     * Show asingle incoming application
     *
     * @param \Illuminate\Http\Request $request
     * @param int $app_id
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
     * List a single outgoing application
     *
     * @param \Illuminate\Http\Request $request
     * @param string $app_id
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
            $user = Auth::user();
            //dd($user->department->name);
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
/************************* PROGRAMS MODULE ****************/
    /**
     * Show the form to add a new program
     *
     * @return \Illuminate\Http\Response
     */
    public function showProgramsForm()
    {
        return view('cod.programs.create');
    }
    /**
     * Add a new program
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addProgram(Request $request)
    {
        $validator = Validator::make($request->all(),$this->validate_data());
        if($validator->fails())
        {
            $request->session()->flash('error',$validator->errors());
            return redirect()->back()->withInput($request->all());
        }
        else
        {
            $program = new Programs;
            $program->name = $request->name;
            $program->description = $request->description;
            $program->school_id = Auth::user()->school->school_id;
            $department = Departments::where('dep_id','=',Auth::user()->dep_id)->first();
            $program->dep_id = $department->dep_id;
            $existing_program = Programs::where('name','=',$request->name)->where('dep_id','=',Auth::user()->dep_id)->first();
            if($existing_program)
            {
                $request->session()->flash('error','The program already exists');
                return redirect()->back()->withInput($request->only('name','description'));
            }
            if($program->save())
            {
                $request->session()->flash('success','Program added successfully');
                return redirect(route('cod.programs'));
            }
            else
            {
                $request->session()->flash('error','Unable to add the specified program, try again later');
                return redirect()->back()->withInput($request->all());
            }
        }
    }
    /**
     * Enable the cod to upload an excel sheet of programs
     *@return \Illuminate\Support\Collection
     */
    public function importPrograms()
    {
        if(Excel::import(new ProgramsImport, request()->file('excel_program_file')))
        {
            request()->session()->flash('success','Programs uploaded successfully via the excel file');
            return redirect()->back();
        }
        else
        {
            request()->session()->flash('error','Failed to upload excel file, kindly check on the format');
            return redirect()->back();
        }
    }
    /**
     * Enable the COD to download an excel sheet of all the programs
     * @return \Illuminate\Support\Collection
     */
    public function exportPrograms()
    {
        return Excel::download(new ProgramsExport, 'school-programs.xlsx');
    }
    /** Enable the cod of the department to view all the available programs
     * .
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function viewAllPrograms(Request $request)
    {
        $programs = Programs::where('school_id','=',Auth::user()->school->school_id)
                                ->where('dep_id','=',Auth::user()->dep_id)
                                ->get();
        return view('cod.programs.index', compact('programs'));
    }
    /****************************** END OF PROGRAMS MODULE *****************/

    //*************************************** APPLICATIONS APPROVAL *********************************/
    /**
     * Approve and Outgoing application
     *
     * @param \Illuminate\Http\Request $request
     * @param int $app_id
     * @return \Illuminate\Http\Response
     */
    public function approveAnOutgoingApplication(Request $request, $app_id = NULL)
    {
        $app_id = $request->app_id;
        if(!$app_id)
        {
            $request->session()->flash('error','Invalid Request Format');
            return redirect()->back()->withInput($request->only('comment'));
        }
        else
        {
            $validator = Validator::make($request->all(),array('comment'=>'required','message_channel'=>'required'));
            if($validator->fails())
            {
                $request->session()->flash('error',$validator->errors());
                return redirect()->back()->withInput($request->only('comment','message_channel'));
            }
            else
            {
                $application = Applications::where('app_id','=',$app_id)->first();
                $channel = $request->message_channel;
                $programs = Programs::where('name','=',$application->present_program)->first();
                $school = Schools::where('school_id','=',$programs->school_id)->first();
                //dd($school->school_name);
                $dean = Deans::where('school_id','=',$school->school_id)->first();
                //dd($dean->email);
                $phone = $dean->phone;
                //dd($phone);
                $name = $dean->name;
                $email = $dean->email;
                //dd($email);
                $user = CODS::where('id','=',Auth::user()->id)->first();
                //dd($user->name);
                $department = Departments::where('dep_id','=',$user->dep_id)->first();
                $dep_name = $department->name;
                //dd($dep_name);
                $comment = new Comments;
                $comment->comment = $request->comment;
                $comment->user_id = $user->id;
                $comment->user_type = 'cod';
                $comment->app_id = $application->app_id;
                $comment->app_type = 'outgoing';
                $message = "Dear"." ".$name." "."you have received a notification from the cod"." ".$dep_name." "."to act on application serial no: ".
                " ".$app_id." "."kindly";
                //dd($message);
                if($comment->save())
                {
                  switch($channel)
                  {
                      case 'sms':
                        $this->sendSmsMessageToDean($message, $phone);
                        // if($this->sendSmsMessageToDean($message, $phone))
                        // {
                        //     $request->session()->flash('success','Message sent successfully to'.' '.$name);
                        //     return redirect()->back();
                        // }
                        // else
                        // {
                        //     $request->session()->flash('error','Failed to send sms, please contact your service provider');
                        //     return redirect()->back()->withInput($request->only('comment','message_channel'));
                        // }
                      break;
                      
                      case 'email':
                        if($this->sendEmailToDean($email, $name, $department,$app_id))
                        {
                            $request->session()->flash('success','Email sent successfully');
                            return redirect()->back();
                        }
                        else
                        {
                            $request->session()->flash('error','Failed to send email notification to'.' '.$name.' '.'please try again later');
                            return redirect()->back()->withInput($request->only('comment','message_channel'));
                        }
                      break;
                      case 'both':
                        if($this->sendSmsMessageToDean($message, $phone) && $this->sendEmailToDean($email, $name, $department,$application))
                            {
                               $request->session()->flash('success',$name.' '.'notified'); 
                               return redirect()->back();
                            }
                            else
                            {
                                $request->session()->flash('error','Failed to send notification to'.' '.$name);
                                return redirect()->back()->withInput($request->only('comment','message_channel'));
                            }
                      break;
                      default:
                        return 0;
                      break;  

                  }
                }
                else
                {

                }
            }
        }
    }
    //*************************************** END OF APPLICATIONS APPROVAL **************************/
    //Helper functions
    /**
     * An array of all the programs data validations
     *
     * @return array
     */
    private function validate_data()
    {
        return array('name'=>'required','description'=>'nullable');
    }
    /**
     * Send sms messae notification to dean to act on the application
     *
     * @param string $phone
     * @return \Illuminate\Http\Response
     */
    private function sendSmsMessageToDean($message, $phone)
    {
        // $message = "Hello there ".$name.' '.'Your application has been a success. You shall be notified soon on the progress';
        $postData = array(
            'username'=>env('USERNAME'),
            'api_key'=>env('APIKEY'),
            'sender'=>env('SENDERID'),
            'to'=>"254".(int)$phone,
            'message'=>$message,
            'msgtype'=>env('MSGTYPE'),
            'dlr'=>env('DLR')
        );
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => env('URL'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
        ));
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        $output = curl_exec($ch);
        if(curl_errno($ch))
        {
            $output = curl_error($ch);
        }
        curl_close($ch);
    }
    protected function sendEmailToDean($name, $email, $department, $application)
    {
        Notification::route('mail',request()->$email)->notify(new CoDDeanResponse($name, $email, $department, $application));
    }
}
