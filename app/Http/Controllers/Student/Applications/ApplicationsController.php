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
use Illuminate\Support\Facades\Validator;
//use Intervention\Image as Image;
use Intervention\Image\Facades\Image;
class ApplicationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:student');
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
        //$applications = Applications::where('student_id','=',Auth::user()->id)->latest()->get();
        //$applications = DB::select('select * from applications where student_id = :student_id',['student_id'=>Auth::user()->id]);
        //dd($applications);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$this->validate_request();
        $validator = Validator::make($request->all(),$this->validate_request());
        if($validator->fails())
        {
            $request->session()->flash('error',$validator->errors());
            return redirect()->back()->withInput($request->all());
        }
        $application = new Applications;
        $application->student_name = $request->student_name;
        $application->reg_number = $request->reg_number;
        $application->student_phone = $request->student_phone;
        $application->present_program = $request->current_program;
        $application->present_school = $request->current_school;
        $application->preffered_program = $request->preffered_program;
        $application->preffered_school = $request->preffered_school;
        $application->kcse_index = $request->kcse_index;
        $application->kcse_year = $request->kcse_year;
        $application->kuccps_password = $request->kuccps_password;
        $application->mean_grade = $request->mean_grade;
        $application->aggregate_points = $request->aggregate;
        $application->cut_off_points = $request->cut_off_points;
        $application->weighted_clusters = $request->weighted_clusters;
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
            Image::make($file->getRealPath())->resize(null,200, function($constraint)
            {
                $constraint->aspectRatio();
            })->save($path);
            $application->result_slip = $file_name;
        }
        if($application->save())
        {
            //send and sms to the student with information of a successfull application
            $message = "Hello ".$request->student_name.' '.'Your application has been a success. You shall be notified soon on the progress';
            $postData = array(
                'username'=>env('USERNAME'),
                'api_key'=>env('APIKEY'),
                'sender'=>env('SENDERID'),
                'to'=>$request->student_phone,
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
    public function show($id)
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Applications $app_id)
    {
        $app_id->update($this->validate_request());
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * @return array
     */
    private function validate_request()
    {
        return [
            'student_name'=>'required',
            'reg_number'=>'required|unique:applications',
            'student_phone'=>'required|phone|unique:applications',
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
            'result_slip'=>'required|image|mimes:png,jpg|max:2048',
            'transfer_reason'=>'required'
        ];
    }
    /**
     * @param Illuminate\Http\Request $request
     * @return array
     */
    private function requestData(Request $request)
    {
       return   [
            'student_name'=>$request->name,
            'reg_number'=>$request->reg_number,
            'student_phone'=>$request->phone,
            'current_program'=>$request->current_program,
            'current_school'=>$request->current_school,
            'preffered_program'=>$request->preffered_program,
            'preffered_school'=>$request->preffered_school,
            'kcse_index'=>$request->kcse_index,
            'kcse_year'=>$request->kcse_year,
            'kuccps_password'=>$request->kuccps_password,
            'mean_grade'=>$request->mean_grade,
            'aggregate'=>$request->aggregate,
            'cut_off_points'=>$request->cut_off_points,
            'weighted_clusters'=>$request->weighted_clusters,
            'sub_1'=>$request->sub_1,
            'sub_2'=>$request->sub_2,
            'sub_3'=>$request->sub_3,
            'sub_4'=>$request->sub_4,
            'sub_5'=>$request->sub_5,
            'sub_6'=>$request->sub_6,
            'sub_7'=>$request->sub_7,
            'sub_8'=>$request->sub_8,
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
}
