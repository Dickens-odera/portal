<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Deans;
use App\CODs;
use App\Registrar;
use App\Schools;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NewAccountCreatedNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;
class AdminController extends Controller
{
    use Notifiable;
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function index()
    {
        $deans = DB::select('select * from deans LIMIT 10');
        // $cods = CODs::latest()->get();
        // $registrars= Registrar::latest()->get();
        // $schools = Schools::latest()->get();
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
        $schools = Schools::latest()->paginate(2);
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
        $cods = CODs::latest()->paginate(10);
        return view('admin.settings.cods.all', compact('cods'));
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
     * send email notification with credentials
     * @param  string $email
     * @param string $password
     */
    protected function sendAccountCreatedNotification($email, $password)
    {
        return $this->notify(new NewAccountCreatedNotification($email, $password));
    }
}
