<?php

namespace App\Http\Controllers\Auth\Student;

use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:student')->except(['logout']);
    }
    //show the login page
    public function showLoginForm()
    {
        return view('auth.student-login');
    }
    public function login(Request $request)
    {
        $this->validateRequest();
        if(Auth::guard('student')->attempt(['email'=>$request->email,'password'=>$request->password], $request->remember))
        {
            //update the student status to active
            //Student::where('id','=',Auth::guard('student')->id)->first()->update(array('status'=>'Active'));
            return redirect()->intended(route('student.dashboard'));
        }
        else
        {
            request()->session()->flash('error','Invalid email or password');
            return redirect()->back()->withInput($request->only('email','password'));
        }
    }
    public function logout()
    {
        Auth::guard('student')->logout();
        return redirect()->route('student.login');
    }
    /**
     * @return array
     */
    private function validateRequest()
    {
        return request()->validate(
            [
                'email'=>'email|required',
                'password'=>'required'
            ]
        );
    }
}
