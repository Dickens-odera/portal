<?php

namespace App\Http\Controllers\Auth\Dean;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeanLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:dean')->except(['logout']);
    }
    //show the login page
    public function showLoginForm()
    {
        return view('auth.dean-login');
    }
    public function login(Request $request)
    {
        $this->validateRequest();
        if(Auth::guard('dean')->attempt($this->data(), $request->remember))
        {
            return redirect()->intended(route('dean.dashboard'));
        }
        else
        {
            request()->session()->flash('error','Invalid email or password');
            return redirect()->back()->withInput($request->only('email','password'));
        }
    }
    public function logout()
    {
        Auth::guard('dean')->logout();
        return redirect()->route('dean.login');
    }
      /**
     * @return array
     */
    private function validateRequest()
    {
        return request()->validate(array('email'=>'email|required','password'=>'required'));
    }
    /**
     * @return array
     */
    private function data()
    {
        return array('email'=>request()->email,'password'=>request()->password);
    }
}
