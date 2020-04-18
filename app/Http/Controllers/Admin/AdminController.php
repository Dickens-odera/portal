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
use App\Notifications\newRegistrarAccountCreated;
use App\Student;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use App\Grades;
use App\Services\Admin\AdminService;
use App\Subjects;
use Exception;
use Illuminate\Console\Scheduling\ScheduleFinishCommand;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * show the admin dasboard
     * @return \Illuminate\Http\Response
     */
    public function index(AdminService $adminService)
    {
        return $adminService->data();
    }
    //SETTINGS
    /**************************** Deans Module   ****************************** */
    /**
     * list all the deans on admin page
     * @return \Illuminate\Http\Response
     */
    public function getAllDeans()
    {
        $deans = Deans::latest()->paginate(5);
        return view('admin.settings.deans.all',compact('deans'));
    }
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
     * @param \Illuminate\Http\Request $request
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
            $school = Schools::where('school_id','=',$school_id)->first();
            try{
                $this->sendAccountCreatedNotification($request->email, $request->password,$school->school_name,$request->name);
            } catch(Exception $exception)
            {
                $request->session()->flash('error','No internet access, could not send email to'.' '.$request->email);
            }
            $request->session()->flash('success','Dean Added successfully');
            return redirect()->back();
        }
        else
        {
            $request->session()->flash('error','Something went wrong,try again');
            return redirect()->back()->withInput(array_merge($this->data($request),array('password'=>'','confirm_password'=>'')));
        }
    }
    /********************************** End of Deans Module ***********************/
    /*****************************  Start of CODs Module **************************/
    /**
     * list all the departments heads
     * @return \Illuminate\Http\Response
     */
    public function getAllCODs()
    {
        // $cods = CODs::all();
        $query = DB::table('cods')
                     ->join('departments','cods.dep_id','=','departments.dep_id')
                     ->join('schools','cods.school_id','=','schools.school_id')
                     ->select('cods.*','departments.name as department','schools.school_name as school')
                     ->latest()
                     ->paginate(5);
        return view('admin.settings.cods.all', compact('query'));
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
     *
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
        $cod->school_id = $_dep->school->school_id;
       // dd($dep->school->school_name);
        $sch = Schools::where('dep_id','=','');
        //dd($dep->school->school_id);
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
            Departments::where('dep_id','=',$dep)->update(array('chair'=>$request->name,'cod_id'=>$cod->id));
            try{
                $this->sendNotificationToNewCod($request->email, $request->password, $_dep->name,$request->name);
            }catch(Exception $exception)
            {
                $request->session()->flash('error','No internet conenction, could not send mail to'.' '.$request->email);
            }
            $request->session()->flash('success','COD'.' '.$request->name.' '.'added successfully');
            return redirect()->back();
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
     * list all the schools
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAllSchools(Request $request)
    {
        $_schools = DB::table('schools')
                            ->join('deans','schools.school_id','=','deans.school_id')
                            ->select('schools.*','deans.name as dean')
                            // ->latest()
                            ->paginate(5);
        return view('admin.settings.schools.all', compact('_schools'));
    }
    /**
     * Show the page to add new school
     * @return \Illuminate\Http\Response
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
    /**
     * list all the departments
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAllDepartments(Request $request)
    {
        //$departments = Departments::paginate(5);
        $departments = DB::table('departments')
                        ->join('cods','departments.dep_id','=','cods.dep_id')
                        ->select('departments.*','cods.name as cod')
                        ->paginate(10);
        return view('admin.settings.departments.all', compact('departments'));
    }
    /****************************** END OF DEPARTMENTS MODULE *********************/
    /****************************** Start of Registrar Module *********************/
    /**
     * Show The Form To Add new Registrar (Academic Affairs)
     * @return \Illuminate\Http\Response
     */
    public function ShowRegistrarAAForm()
    {
        return view('admin.settings.registrars.new');
    }
    /**
     * List all the registrars
     * @return \Illuminate\Http\Response
     */
    public function getAllRegistrarsAA()
    {
        $registrars = Registrar::all();
        return view('admin.settings.registrars.all', compact('registrars'));
    }
    /**
     * Add a new Registrar Academic Affairs
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addNewRegistrarAA(Request $request)
    {
        $count = count(Registrar::all());
        if($count > 0)
        {
            //there should be only one registrar academic affairs an any particular instance
            $request->session()->flash('error','Action not allowed as there is already an account, please contact the concerned authority');
            return redirect(route('admin.registrars.view.all'));
        }
        else
        {
            $this->validateData($request);
            $registrar = new Registrar;
            $registrar->name = $request->name;
            $registrar->email = $request->email;
            $pwd = $request->password;
            $pwd_confirmation = $request->confirm_pasword;
            if($pwd !== $pwd_confirmation)
            {
                $request->session()->flash('error','Password Mismatch');
                return redirect()->back()->withInput($request->only('name','email'));
            }
            else
            {
                $registrar->password = Hash::make($pwd);
            }
            if($registrar->save())
            {
                try{
                //send email to the registrar with login url and credentials
                    $this->sendEmailNotificationToNewRegistrarAccount($request,$request->name, $request->email, $request->password);
                }catch(Exception $exception)
                {
                    $request->session()->flash('error','No Internet connection, could not send email to'.' '.$request->email);
                }
                $request->session()->flash('success','Registrar'.' '.$request->name.' '.'added successfully');
                return redirect(route('admin.registrars.view.all'));
            }
            else
            {
                $request->session()->flash('error','something went wrong, try again');
                return redirect()->back()->withInput($request->only('name','email'));
            }
        }
    }
    /****************************** End of Registrar Module ************************/
    /****************************** Gradings Module   ******************************/
    /**
     * list all the grades
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAllGrades(Request $request)
    {
        $grades = Grades::all();
        return view('admin.settings.gradings.all', compact('grades'));
    }
    /**
     * Show the form to add a new grade
     *
     * @return \Illuminate\Http\Response
     */
    public function showGradeNewForm()
    {
        //show the form to add a new grade
        return view('admin.settings.gradings.new');
    }
    /**
     * Add a new grade
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function addNewGrade(Request $request)
    {
        $validator = Validator::make($request->all(),array('name'=>'required'));
        if($validator->fails())
        {
            $request->session()->flash('error',$validator->errors());
            return redirect()->back()->withInput($request->name);
        }
        // $grade_points = $this->grade_programs();
        //dd($grade_points);
        $grades = array('A','A-','B+','B','B-','C+','C','C-','D+','D','D-','E');
        $grade = $request->name;
        $existing_grade = Grades::where('name','=',$grade)->first();
        if($existing_grade)
        {
            $request->session()->flash('error','A similar grade exists');
            return redirect()->back()->withInput($request->only('name'));
        }
        if(!(in_array($grade,$grades)))
        {
            $request->session()->flash('error','The Entered grade is not within the curriculum');
            return redirect()->back()->withInput($request->only('name'));
        }
        switch($grade)
        {
            case 'A':
                $point = 12;
            break;
            case 'A-':
                $point = 11;
            break;
            case 'B+':
                $point = 10;
            break;
            case 'B':
                $point = 9;
            break;
            case 'B-':
                $point = 8;
            break;
            case 'C+':
                $point = 7;
            break;
            case 'C':
                $point = 6;
            break;
            case 'C-':
                $point = 5;
            break;
            case 'D+':
                $point = 4;
            break;
            case 'D':
                $point = 3;
            break;
            case 'D-':
                $point = 2;
            break;
            case 'E':
                $point = 1;
            break;
            default:
                $point = 0;
            break;
        }
        if(Grades::create(array('name'=>$grade, 'points'=>$point)))
        {
            $request->session()->flash('success','Grade'.' '.$grade.' '.'with'.' '.$point.' '.'points addedd successfully');
            return redirect()->back();
        }
        else
        {
            $request->session()->flash('error','Something went wrong, try again');
            return redirect()->back()->withInput($request->only('name'));
        }
    }
    /**
     * Show the form to edit a grade instance
     *
     * @param \Illuminate\Http\Request $request
     * @param int $grade_id
     * @return \Illuminate\Http\Response
     */
    public function showGradeEditForm(Request $request, $grade_id = null)
    {

    }
    /**
     * Update a grade instance
     *
     * @param \Illuminate\Http\Request $request
     * @param int $grade_id
     * @return \Illuminate\Http\Response
     */
    public function updateGrade(Request $request, $grade_id = null)
    {

    }
    /******************************* End of Gradings Modeule ***********************/
    /****************************** Subjects Module ********************************/
    /**
     * Show the form to add a new subject
     *
     * @return \Illuminate\Http\Response
     */
    public function ShowSubjectForm()
    {
        return view('admin.settings.subjects.new');
    }
    /**
     * Add a new subject
     *
     * @param \Illuminate\Http\Request $request
     */
    public function addNewSubject(Request $request)
    {
        $subjects =  array('English','Kiswahili','Mathematics',
        'Geography','Chemistry','Biology',
        'Business Studies','Christian Religious Education',
        'History & Government','Computer Studies',
        'Home Science','Music','Physics','Agriculture','Art', 'French'
        );
        $validator = Validator::make($request->all(), array('name'=>'required'));
        if($validator->fails())
        {
            $request->session()->flash('error',$validator->errors());
            return redirect()->back()->withInput($request->only('name'));
        }
        if(!($this->case_insensitive_in_array($request->name,$subjects)))
        {
            $request->session()->flash('error','The subject'.' '.$request->name .' '.'is not within the curriculum');
            return redirect()->back();
        }
        $existing_subject = Subjects::where('name','=',$request->name)->first();
        if($existing_subject)
        {
            $request->session()->flash('error','Subject not created as there is a similar name');
            return redirect()->back()->withInput($request->name);
        }
        else
        {
            if(Subjects::create(array('name'=>$request->name)))
            {
                $request->session()->flash('success','Subject'.' '.$request->name.' '.'added successfully');
                return redirect()->back();
            }
            else
            {
                $request->session()->flash('error','Something went wrong, try again');
                return redirect()->back()->withInput($request->name);
            }
        }
    }
    /**
     * List all the subjects
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllSubjects()
    {
        $subjects = Subjects::paginate(5);
        return view('admin.settings.subjects.all', compact('subjects'));
    }
    /**
     * Show a single subject
     *
     * @param \Illuminate\Http\Request $request
     * @param int $subject_id
     */
    public function viewASingeSubject(Request $request, $subject_id = NULL)
    {

    }

    /************************* End of Subjets Module *********************/
    /********************************* HELPER FUNCTIONS ****************************/
    /**
     * the user data
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function data(Request $request)
    {
        return $request->only('name','email','school','password','confirm_password');
    }
    /**
     * data validation
     * @param \Illuminate\Http\Request $request
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
     * @param string $school
     * @param string $name
     * @return \Illuminate\Support\Facades\Notification
     */
    protected function sendAccountCreatedNotification($email, $password, $school,$name)
    {
        Notification::route('mail',request()->email)->notify(new DeanNewAccountCreatedNotification($email, $password,$school,$name));
    }
    /**
     *send a mail notification to the new chairperson of the department
     * @param string $email
     * @param string $password
     * @param string $department
     * @param string $name
     * @return \Illuminate\Support\Facades\Notification
     */
    public function sendNotificationToNewCod($email, $password, $department,$name)
    {
        Notification::route('mail',request()->email)->notify(new CODNewAccountCreatedNotification($email, $password, $department,$name));
    }
    /**
     * Send email notifiction with login url and credentials
     *
     * @param \Illuminate\Http\Request $request
     * @param string $name
     * @param string $email
     * @param string $password
     * @return \Illuminate\Support\Facades\Notification
     */
    protected function sendEmailNotificationToNewRegistrarAccount(Request $request,$name, $email, $password)
    {
        Notification::route('mail',$request->email)->notify(new newRegistrarAccountCreated($name, $email, $password));
    }
    /**
     * the cod array
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
    /**
     * An array of grades
     * @return array
     */
    protected function grade_programs()
    {
        $grades = array('A','A-','B+','B','B-','C+','C','C-','D+','D','D-','E');
        $points = array(12,11,10,9,8,7,6,5,4,3,2,1);
        $grade_points['grade']['point'] = array_combine($grades,$points);
        return $grade_points;
    }
    private function case_insensitive_in_array($needle, $haystack)
        {
            return in_array(strtolower($needle), array_map('strtolower',$haystack));
        }

}
