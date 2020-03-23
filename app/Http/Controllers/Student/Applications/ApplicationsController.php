<?php

namespace App\Http\Controllers\Student\Applications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Applications;
use App\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use GuzzleHttp\Client;
//use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\GuzzleException;

class ApplicationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:student');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify','resend');
    }

    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applications = Auth::user()->applications;
        return view('student.applications.index',compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //show the form to open the applications
        return view('student.applications.create');
    }
    /**
     * @return \Illuminate\Http\Response
     */
    public function getKuccpsPrograms()
    {
        /**
        *$client = new \GuzzleHttp\Client();
        *$response = $client->request('GET','https://students.kuccps.net/programmes/');
        *$response->getStatusCode();
        *$contents = $response->getBody()->getContents();
        *dd($contents);
        **/
        return redirect('https://students.kuccps.net/programmes/');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //check if the student had made a previous application
        $app = Applications::where('student_id','=',Auth::user()->id)->first();
        if($app)
        {
            request()->session()->flash('error','You had previously made an application, kindly wait for the response');
            return redirect(route('student.dashboard'));
        }
        //$this->validate_request();
        $validator = Validator::make($request->all(),$this->validate_request());
        if($validator->fails())
        {
            $request->session()->flash('error',$validator->errors());
            return redirect()->back()->withInput($request->all());
        }
        $application = new Applications;
        //dd($grade_points);
        //calculate the clusters
        //map schools to programs
        $schools_program = array(
            'sobe'=>array(),
            'sci'=>array(
                'IT'=>'Bsc Informatuon Technology',
                'COM'=>'Bsc Computer Science',
                'SIK'=>'Bsc Information Systems and Knowledge Management',
                'ETS'=>'Bsc Education Technology Computer Studies'
            ),
            'sebe'=>array(),
            'sedu'=>array(),
            'som'=>array(),
            'sidmha'=>array(),
            'savet'=>array(),
            'sass'=>array(),
            'sonmaps'=>array(),
            'sonas'=>array(),
            'spbh'=>array()
        );
        $subjects =  array('English','Kiswahili','Mathematics',
                    'Geography','Chemistry','Biology',
                    'Business Studies','Christian Religious Education',
                    'History & Government','Computer Studies',
                    'Home Science','Music','Physics','Agriculture','Art'
                    );
        $grades = array('A','A-','B+','B','B-','C+','C','C-','D+','D','D-','E');
        $points = array(12,11,10,9,8,7,6,5,4,3,2,1);
        //$grds = collect(['A','A-','B+','B','B-','C+','C','C-','D+','D','D-','E']);
        $grade_points_arr = array_combine($grades, $points);
        $sub_values = array($request->sub_1,$request->sub_2,$request->sub_3,$request->sub_4,$request->sub_5,$request->sub_6,$request->sub_7,$request->sub_8);
        $grade_values = array($request->grade_1,$request->grade_2,$request->grade_3,$request->grade_4,$request->grade_5,$request->grade_6,$request->grade_7,$request->grade_8);
        $subject_grades_arr = array_combine($sub_values, $grade_values);

        $current_program = $request->current_program;
        $preffered_program = $request->preffered_program;
        $current_school = $request->current_school;
        $preffered_school = $request->preffered_school;
        if($current_program === $preffered_program)
        {
            request()->session()->flash('error','You cannot transfer to the same program, kindly select another program');
            return redirect()->back()->withInput($request->all());
        }

        //determine whether the subjects keyed in by the student are among the array declared above
        for($i = 0; $i < count($sub_values); $i++)
        {
            if(!($this->case_insensitive_in_array($sub_values[$i], $subjects)))
                {
                    request()->session()->flash('error','The subject'.' '.$sub_values[$i].' '.'not within the carriculum');
                    return redirect()->back()->withInput(request()->all());
                }
        }

        //check that the entered mean grade value is valid
        if(!(in_array($request->mean_grade,$grades)))
        {
            request()->session()->flash('error','The mean grade'.' '.$request->mean_grade.' '.'is invalid');
            return redirect()->back()->withInput($request->all());
        }

        $application->student_name = $request->student_name;
        $application->reg_number = $request->reg_number;
        $application->student_phone = $this->validate_phone();
        $application->idNumber = $request->student_id;
        $application->present_program = $current_program;
        $application->present_school = $current_school;
        $application->preffered_program = $preffered_program;
        $application->cluster_no = $request->cluster_no;
        $application->preffered_school = $preffered_school;
        $application->kcse_index = $request->kcse_index;
        $application->kcse_year = $request->kcse_year;
        $application->kuccps_password = (int)$request->kuccps_password;
        $application->mean_grade = $request->mean_grade;
        $application->aggregate_points = (float)$request->aggregate;
        $application->cut_off_points = (float)$request->cut_off_points;
        $application->weighted_clusters = (float)$request->weighted_clusters;
        $application->subject_1 = $request->sub_1;
        $application->subject_2 = $request->sub_2;
        $application->subject_3 = $request->sub_3;
        $application->subject_4 = $request->sub_4;
        $application->subject_5 = $request->sub_5;
        $application->subject_6 = $request->sub_6;
        $application->subject_7 = $request->sub_7;
        $application->subject_8 = $request->sub_8;
        $application->grade_1 = $request->grade_1;
        $application->grade_2 = $request->grade_2;
        $application->grade_3 = $request->grade_3;
        $application->grade_4 = $request->grade_4;
        $application->grade_5 = $request->grade_5;
        $application->grade_6 = $request->grade_6;
        $application->grade_7 = $request->grade_7;
        $application->grade_8 = $request->grade_8;
        $application->transfer_reason = $request->transfer_reason;
        $application->student_id = Auth::user()->id;
        if($request->file('result_slip'))
        {
            $file = $request->file('result_slip');
            $ext = $file->getClientOriginalExtension();
            $file_name = $request->kcse_index.'.'.$ext;
            $path = public_path('uploads/images/applications/result-slips/'.$file_name);
            Image::make($file->getRealPath())->resize(200,200, function($constraint)
            {
                $constraint->aspectRatio();
            })->save($path);
            $application->result_slip = $file_name;
        }
        if($application->save())
        {
            //dd($subject_grades_arr);
            //send an sms to the student with information of a successfull application
            $message = "Hello there ".$request->student_name.' '.'Your application has been a success. You shall be notified soon on the progress';
            $postData = array(
                'username'=>env('USERNAME'),
                'api_key'=>env('APIKEY'),
                'sender'=>env('SENDERID'),
                'to'=>$this->validate_phone(),
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
            request()->session()->flash('success','Application submitted successfully');
            return redirect(route('student.dashboard'));
        }else
        {
            request()->session()->flash('error','Unable to submit application, try again');
            return redirect()->back()->withInput($request->all());
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($app_id = null)
    {
        $app_id = request()->app_id;
        if(!$app_id)
        {
            request()->session()->flash('error','Invalid request format');
            return redirect()->back();
        }
        else
        {
            $validator = Validator::make(request()->all(),['app_id'=>'required']);
            if($validator->fails())
            {
                request()->session()->flash('error',$validator->errors());
                return redirect()->back()->withInput(request()->all());
            }
            else
            {
                $application = Applications::where('app_id','=', $app_id)->first();
                if(!$application)
                {
                    request()->session()->flash('error','Application not found');
                    return redirect()->back()->withInput(request()->all());
                }
                else
                {
                    return view('student.applications.show', compact('application'));
                }
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $app_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$app_id = null)
    {
        $app_id = request()->app_id;
        if(!$app_id)
        {
            request()->session()->flash('error','Invalid Request Format');
            return redirect()->back()->withInput(request()->all());
        }
        else
        {
            $validator = Validator::make(request()->all(),$this->update_validation(), array_merge($this->update_validation(),['app_id'=>'required']));
            if($validator->fails())
            {
                request()->session()->flash('error',$validator->errors());
                return redirect()->back()->withInput(request()->all());
            }
            else
            {
               $application = Applications::where('app_id','=',$app_id)->where('student_id','=',Auth::user()->id);
               $status = $application->first()->status;
               //throw an error if the application procesing has began
               if($status === 'initiated' || $status === 'partialy-complete' || $status === 'complete')
               {
                   request()->session()->flash('error','You cannot update an already'.' '.$status.' '.'application');
                   return redirect()->back();
               }
               $image = $application->first()->result_slip;
               //dd($image);
               if($application->update($this->requestData(request()),array_merge($this->requestData(request()),['result_slip'=>$this->imageUpload(request()->file('result_slip'))])))
               {
                request()->session()->flash('success','Application successfully updated');
                return redirect()->back();
               }
               else
               {
                request()->session()->flash('error','Unable to update application, try again');
                return redirect()->back()->withInput($request->all());
               }
            }
        }
    }
    /**
     * Cancel the application
     * @param int $app_id
     * @return \Illuminate\Http\Response
     */
    public function cancel($app_id = null)
    {
        $app_id = request()->app_id;
        if(!$app_id)
        {
            request()->session()->flash('error','Invalid Reqest Format');
            return redirect()->back();
        }
        else
        {
            $validator = Validator::make(request()->all(),['app_id'=>'required']);
            if($validator->fails())
            {
                request()->session()->flash('error',$validator->errors());
                return redirect()->back();
            }
            else
            {
                $application = Applications::where('app_id','=',$app_id)->where('student_id','=',Auth::user()->id);
                $status = $application->first()->status;
                //dd($status);
                if($status === "initiated" || $status === "partialy-complete" || $status === "complete")
                {
                    request()->session()->flash('error','Action not allowed as the tranfer application status is '.' '.$status);
                    return redirect()->back();
                }
                else
                {
                    if($application->update(['status'=>'cancelled']))
                    {
                        request()->session()->flash('success','Application cancelled successfully');
                        return redirect()->back();
                    }
                    else
                    {
                        request()->session()->flash('error','Application could not be cancelled, try again later');
                        return redirect()->back();
                    }
                }
            }
        }
    }
    /**
    * @return array
    */
    private function update_validation()
    {
        return [
            'student_name'=>'required',
            'reg_number'=>'required',
            'student_phone'=>'required',
            'current_program'=>'required',
            'current_school'=>'required',
            'preffered_program'=>'required',
            'preffered_school'=>'required',
            'kcse_index'=>'required',
            'kcse_year'=>'required',
            'kuccps_password'=>'required',
            'mean_grade'=>'required',
            'aggregate'=>'required',
            'cut_off_points'=>'required',
            'weighted_clusters'=>'required',
            'sub_1'=>'required',
            'sub_2'=>'required',
            'sub_3'=>'required',
            'sub_4'=>'required',
            'sub_5'=>'required',
            'sub_6'=>'required',
            'sub_7'=>'required',
            'sub_8'=>'required',
            'grade_1'=>'required',
            'grade_2'=>'required',
            'grade_3'=>'required',
            'grade_4'=>'required',
            'grade_5'=>'required',
            'grade_6'=>'required',
            'grade_7'=>'required',
            'grade_8'=>'required',
            'transfer_reason'=>'required',
            'result_slip'=>'image|nullable|'
        ];
    }
    /**
     * @return array
     */
    private function validate_request()
    {
        return [
            'student_name'=>'required',
            'reg_number'=>'required|unique:applications',
            'student_phone'=>'required|unique:applications',
            'student_id'=>'required|unique:applications',
            'current_program'=>'required',
            'current_school'=>'required',
            'preffered_program'=>'required',
            'preffered_school'=>'required',
            'kcse_index'=>'required|unique:applications',
            'kcse_year'=>'required',
            'kuccps_password'=>'required|unique:applications',
            'mean_grade'=>'required',
            'aggregate'=>'required',
            'cut_off_points'=>'required',
            'weighted_clusters'=>'required',
            'sub_1'=>'required',
            'sub_2'=>'required',
            'sub_3'=>'required',
            'sub_4'=>'required',
            'sub_5'=>'required',
            'sub_6'=>'required',
            'sub_7'=>'required',
            'sub_8'=>'required',
            'grade_1'=>'required',
            'grade_2'=>'required',
            'grade_3'=>'required',
            'grade_4'=>'required',
            'grade_5'=>'required',
            'grade_6'=>'required',
            'grade_7'=>'required',
            'grade_8'=>'required',
            'result_slip'=>'required|image|max:2048',
            'transfer_reason'=>'required'
        ];
    }
    /**
     * @param Illuminate\Http\Request $request
     * @return array
     */
    private function requestData(Request $request)
    {
       return  [
            'student_name'=>$request->student_name,
            'reg_number'=>$request->reg_number,
            'student_phone'=>$request->student_phone,
            'idNumber'=>$request->student_id,
            'present_program'=>$request->current_program,
            'present_school'=>$request->current_school,
            'preffered_program'=>$request->preffered_program,
            'preffered_school'=>$request->preffered_school,
            'kcse_index'=>$request->kcse_index,
            'kcse_year'=>$request->kcse_year,
            'cluster_no'=>$request->cluster_no,
            'kuccps_password'=>$request->kuccps_password,
            'mean_grade'=>$request->mean_grade,
            'aggregate_points'=>$request->aggregate,
            'cut_off_points'=>(float)$request->cut_off_points,
            'weighted_clusters'=>(float)$request->weighted_clusters,
            'subject_1'=>$request->sub_1,
            'subject_2'=>$request->sub_2,
            'subject_3'=>$request->sub_3,
            'subject_4'=>$request->sub_4,
            'subject_5'=>$request->sub_5,
            'subject_6'=>$request->sub_6,
            'subject_7'=>$request->sub_7,
            'subject_8'=>$request->sub_8,
            'grade_1'=>$request->grade_1,
            'grade_2'=>$request->grade_2,
            'grade_3'=>$request->grade_3,
            'grade_4'=>$request->grade_4,
            'grade_5'=>$request->grade_5,
            'grade_6'=>$request->grade_6,
            'grade_7'=>$request->grade_7,
            'grade_8'=>$request->grade_8,
            'result_slip'=>$request->result_slip,
            'transfer_reason'=>$request->transfer_reason
        ];
    }
     /**
     * @return \Illuminate\Http\Response
     */
    private function validate_phone()
    {
        $pluscode=  substr(request()->student_phone,0,5);
        $pluscode2= substr(request()->student_phone,0,4);
        $pluscode3=  request()->student_phone[0];
    if($pluscode=='+2547'){
        $phonenumber =   substr(request()->student_phone, strpos(request()->student_phone, "+") + 1);
    }
    if($pluscode2=='2547'){
        $phonenumber=request()->student_phone;
    }
    if($pluscode=='+2540'){
        $phonenumber2=substr(request()->student_phone,5);
        $phonenumber='254'.$phonenumber2;
    }
    if($pluscode2=='2540'){
        $phonenumber2=substr(request()->student_phone,4);
        $phonenumber='254'.$phonenumber2;
    }
    if($pluscode3=='0'){
        $phonenumber2=substr(request()->student_phone,1);
        $phonenumber='254'.$phonenumber2;
    }
    return $phonenumber;
    }
    /**
     * @return \Illuminate\Http\Response
     */
    private function imageUpload($file_name = null)
    {
         //determine if an image has been provided
         if(request()->file('result_slip'))
         {
             $file = request()->file('result_slip');
             $ext = $file->getClientOriginalExtension();
             $file_name = request()->kcse_index.'.'.$ext;
             $path = public_path('uploads/images/applications/result-slips/'.$file_name);
             Image::make($file->getRealPath())->resize(200, null, function($constraint)
             {
                 $constraint->aspectRatio();
                 $constraint->upSize();
             })->save($path);
         }
         else
         {
             $file_name = Applications::where('app_id','=',request()->app_id)->pluck('result_slip');
         }
         return  $file_name;
    }
    private function case_insensitive_in_array($needle, $haystack)
        {
            return in_array(strtolower($needle), array_map('strtolower',$haystack));
        }
    private function weightedClusterCalculation()
        {
            //calculate the weighted clusters
        }
    private function cutOffPointsCalculation()
        {
            //calculate the cluster points
        }
}
