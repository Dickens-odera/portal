<?php
namespace App\Http\Controllers\Auth\Student;

use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    /**
     * @return void
     */
    public function create()
    {
        return view('auth.student.register');
    }
    /**
     * @param Illuminate\Http\Request $request
     * @return void
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), $this->data());
        if($validator->fails())
        {
            request()->session()->flash('error',$validator->errors());
            return redirect()->back()->withInput($request->only('reg_number','email'));
        }
        else
        {
            $student = new Student;
            $student->email = $request->email;
            $student->regNumber = $request->reg_number;
            $pwd = $request->password;
            $confirm_password = $request->confirm_password;
            if($pwd !== $confirm_password)
            {
                request()->session()->flash('error','Password Mismatch');
                return redirect()->back()->withInput($request->only('email','reg_number'));
            }
            else
            {
                $student->password = Hash::make($pwd);
            }
            if($student->save())
            {
                //send mail to comfirm email address in the near future
                request()->session()->flash('success','Account created successfully, please login');
                return redirect(route('student.login'));
            }
            else
            {

            }
        }
    }
    /**
     *@return array
     */
    private function data()
    {
        return [
            'reg_number'=>'required',
            'email'=>'required|email|domain_email',
            'password'=>'required'
        ];
    }
}
?>
