<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Deans;
use App\CODs;
use App\Departments;
use App\Registrar;
use App\Schools;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\DeanNewAccountCreatedNotification;
use App\Notifications\CODNewAccountCreatedNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.dashboard');
    }
    //SETTINGS
    /**************************** Deans Module   ****************************** */
    /**
     * list all the deans on admin page
     * @return \Illuminate\Http\Response
     */
    public function getAllDeans()
    {
        $deans = Deans::latest()->get();
        return view('admin.settings.deans.all',compact('deans'));
    }
    /***************************** End of Deans Module **************************/

    /**************************** CODs Module ********************/
    /**
     * Show the form to add a dean of school
     * @return \Illuminate\Http\Response
     */
    public function ShowNewDeanOfSchoolForm()
    {
        $schools = Schools::all();
        return view('admin.settings.deans.new', compact('schools'));
    }
    /**
     * Add a new dean od school
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function addNewDeanOfSchool(Request $request)
    {
        $this->validateData($request);
        $dean = new Deans;
        $dean->name = $request->name;
        $dean->email = $request->email;
        $pwd = $request->password;
        $confirm_pwd = $request->confirm_password;
        if($confirm_pwd !== $pwd)
        {
            $request->session()->flash('error','Password Mismatch');
            return redirect()->back()->withInput(array_merge($this->data($request),array('password'=>null,'confirm_password'=>null)));
        }
        else
        {
            $dean->password = Hash::make($pwd);
        }
        $school_id = $request->school;
        $existing_school = Deans::where('school_id','=',$school_id)->first();
        if($existing_school)
        {
            $request->session()->flash('error','The specified school already has a dean');
            return redirect()->back()->withInput($request->only('name','email'));
        }
        $dean->school_id = $request->school;

        //$dean->create($this->data($request));
        if($dean->save())
        {
            //send the dean their credentials (email notification)
            $this->sendAccountCreatedNotification($request->email, $request->password);
            $request->session()->flash('success','Dean Added successfully');
            return redirect()->back();
        }
        else
        {
            $request->session()->flash('error','Something went wrong,try again');
            return redirect()->back()->withInput(array_merge($this->data($request),array('password'=>'','confirm_password'=>'')));
        }
    }
    /**
     * list all the schools
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAllSchools(Request $request)
    {
        //$schools = Schools::all();
        $schools = Schools::latest()->paginate(5);
        //dd($schools->first()->school_name);
        /**
        *foreach($schools as $key=>$value)
        *{
        *    dd($value->school_name);
        *}
        */
        //dd($schools->departments->first()->name);
        if(!$schools)
        {
            $request->session()->flash('error','No Schools Found');
            return redirect()->back();
        }
        else
        {
            return view('admin.settings.schools.all', compact('schools'));
        }
    }
    /**
     * list all the departments heads
     * @return \Illuminate\Http\Response
     */
    public function getAllCODs()
    {
        $cods = CODs::all();
        $department = CODs::where('dep_id','=','')->first();
        return view('admin.settings.cods.all', compact('cods'));
    }
    /**
     * Show the form to add a new Chairperson to the departent
     * @param \Illuminate\\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function ShowNewCODForm(Request $request)
    {
        $departments = Departments::all();
        //dd($departments->school->first()->school_name);
        // foreach($departments as $key=>$value)
        // {
        //     dd($value->school->school_name);
        // }
        $schools = Schools::all();
        return view('admin.settings.cods.new',compact(['departments','schools']));
    }
    /**
     * Add new COD
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response
     */
    public function addNewSchoolDepartmentChair(Request $request)
    {
        $this->validateData($request);
        $cod = new CODs;
        $cod->name = $request->name;
        $cod->email = $request->email;
        $dep = $request->department;
        //$_school = DB::select('SELECT school_id FROM departments WHERE dep_id = :dep',['dep'=>$dep]);
        //$_school = DB::table('departments')->select('school_id')->where('dep_id',$dep)->first();
        $_dep = Departments::where('dep_id','=',$dep)->first();
        $existing_cod = CODs::where('dep_id','=',$dep)->first();
        if($existing_cod)
        {
            $request->session()->flash('error','The selected department already has a cod');
            return redirect()->back()->withInput($request->only('name','email'));
        }
        //dd($_dep->school_id);
        //$cod->school_id = $_dep->school->school_id;
        dd($dep->school->school_name);
        $sch = Schools::where('dep_id','=','');
        dd($dep->school->school_id);
        $cod->dep_id = $dep;
        $pwd = $request->password;
        $confirm_pwd = $request->confirm_password;
        if($pwd !== $confirm_pwd)
        {
            $request->session()->flash('error','Password Mismatch');
            return redirect()->back()->withInput($request->only('name','email','department'));
        }
        else
        {
            $cod->password = Hash::make($pwd);
        }
        if($cod->save())
        {
            Departments::where('dep_id','=',$dep)->update(array('chair'=>$request->name));
            $this->sendNotificationToNewCod($request->email, $request->password);
            $request->session()->flash('success','COD'.' '.$request->name.' '.'added successfully');
        }
        else
        {
            $request->session()->flash('error','Something went wrong, try again');
            return redirect()->back()->withInput($request->only('name','email','department'));
        }
    }
    /***************************** End of CODs Module */
    /***************************** SCHOOLS MODULE *************************** */
    /**
     * Show the page to add new school
     * @return \Illuminate\Http\Request
     */
    public function ShowNewAdditionSchoolForm()
    {
        return view('admin.settings.schools.new');
    }
    /**
     * Add a new school
     * @param \Illuminate\Http\Request $request
     * @return \Illuinate\Http\Response
     */
    public function addNewSchool(Request $request)
    {
        $validator = Validator::make($request->all(),['school_name'=>'required']);
        if($validator->fails())
        {
            $request->session()->flash('error',$validator->errors());
            return redirect()->back()->withInput($request->only('school_name'));
        }
        else
        {
            if(Schools::create(array('school_name'=>$request->school_name)))
            {
                $request->session()->flash('success',$request->school_name .' '.'added successfully');
                return redirect()->back();
            }
            else
            {
                $request->session()->flash('error','Failed to add school, try again');
                return redirect()->back()->withInput($request->only('school_name'));
            }
        }
    }
    /**************************** END SCHOOLS MODULE ************************** */
    /***************************** DEPARTMENTS MODULE *************************/
    /**
     * Show the form to add a new department
     * @return \Illuminate\Http\Response
     */
    public function showNewDepartmentForm()
    {
        $schools = Schools::all();
        return view('admin.settings.departments.new', compact('schools'));
    }
    /**
     * add a new department
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addNewDepartment(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'name'=>'required',
            'school'=>'required',
            'chair'=>'nullable'
        ));
        if($validator->fails())
        {
            $request->session()->flash('error',$validator->errors());
            return redirect()->back()->withInput($request->only('name','school','chair'));
        }
        else
        {
            $department = Departments::where('name','=',$request->input('name'))->first();
            if($department)
            {
                $request->session()->flash('error','The department already exists');
                return redirect()->back();
            }
            if(Departments::create(array(
                'name'=>$request->input('name'),
                'school_id'=>$request->input('school'),
                'chair'=>$request->input('chair')
            )))
            {
                //update the school's dep_id
                //Schools::where('school_id','=',$request->input('school'))->first()->update(array('dep_id'=>$request->department->dep_id));
                $request->session()->flash('success','Department added successfully');
                return redirect()->back();
            }
            else
            {
                $request->session()->flash('error','Something went wrong, try again');
                return redirect()->back()->withInput($request->only('name','school','chair'));
            }
        }
    }
    /****************************** END IOF DEPARTMENTS MODULE *********************/
    //helper functions
    /**
     * the user data
     * @return array
     */
    protected function data(Request $request)
    {
        return $request->only('name','email','school','password','confirm_password');
    }
    /**
     * data validation
     * @return array
     */
    protected function validateData(Request $request)
    {
        return $this->validate($request,array('name'=>'required','email'=>'required|email|min:4','password'=>'required','confirm_password'=>'required'));
    }
    /**
     * send email notification with credentials to the new dean
     * @param  string $email
     * @param string $password
     * @return \Illuminate\Support\Facades\Notification
     */
    protected function sendAccountCreatedNotification($email, $password)
    {
        Notification::route('mail',request()->email)->notify(new DeanNewAccountCreatedNotification($email, $password));
    }
    /**
     *send a mail notofication to the new chirperson of the department
     * @param string $email
     * @param string password
     * @return \Illuminate\Support\Facades\Notification
     */
    public function sendNotificationToNewCod($email, $password)
    {
        Notification::route('mail',request()->email)->notify(new CODNewAccountCreatedNotification($email, $password));
    }
    protected function school_dep()
    {
        $schools = Schools::all();
        dd($schools->department->name);
        $departments = Departments::all();
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function codData(Request $request)
    {
        //$department = $request->department;
        $_school = DB::select('SELECT school_id FROM departments WHERE dep_id = :dep LIMIT 1',['dep'=>$request->department]);
        //dd($_school);
        //$school = $request->input('department')->school->first()->school_id;
        return array(
            'name'=>$request->name,
            'email'=>$request->email,
            'dep_id'=>$request->department,
            'school_id'=>$_school,
            'password'=>Hash::make($request->password)
        );
    }
}
