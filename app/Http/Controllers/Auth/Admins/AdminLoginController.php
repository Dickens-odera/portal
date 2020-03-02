<?php

namespace App\Http\Controllers\Auth\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except(['logout']);
    }
    /**
     * @return \Illuminate\Facacades\Response
     */
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }
    /**
     *@param Illuminate\Http\Request $request
     *@return \Illuminate\Support\Facades\Response
     */
    public function login(Request $request)
    {
        $this->_validateRequest();
        if(Auth::guard('admin')->attempt($this->data(),$request->remember))
        {
            return redirect()->intended(route('admin.dashboard'));
        }
        else
        {
            $request->session()->flash('error','Invalid email or password');
            return redirect()->back()->withInput($request->only('email','password'));
        }
    }
    /**
     *@return Illuminate\Http\Response
     */
    public function logout()
    {
        if(Auth::guard('admin')->logout())
        {
            return redirect(route('admin.login'));
        }
    }
    /**
     * @return array
     */
    private function _validateRequest()
    {
        return request()->validate(array('email'=>'required','password'=>'required'));
    }
    /**
     *@return array
     */
    private function data()
    {
        return array('email'=>request()->email,'password'=>request()->password);
    }
}
