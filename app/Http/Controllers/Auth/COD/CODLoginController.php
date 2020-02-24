<?php

namespace App\Http\Controllers\Auth\COD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CODLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:cod')->except(['logout']);
    }
    //show the login page
    public function showLoginForm()
    {
        return view('auth.cod-login');
    }
    public function login(Request $request)
    {
        $this->validateRequest();
        if(Auth::guard('cod')->attempt(['email'=>$request->email,'password'=>$request->password], $request->remember))
        {
            return redirect()->intended(route('cod.dashboard'));
        }
        else
        {
            request()->session()->flash('error','Invalid email or password');
            return redirect()->back()->withInput($request->only('email','password'));
        }
    }
    public function logout()
    {
        Auth::guard('cod')->logout();
        return redirect()->route('cod.login');
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
