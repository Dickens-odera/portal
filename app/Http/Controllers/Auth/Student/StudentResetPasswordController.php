<?php

namespace App\Http\Controllers\Auth\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
class StudentResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * The aunthentication guard
     * @var string $guard
     *  */
    protected $guard = 'student';
    /**
     * Where to redirect the user upon  successfull password change
     * @var string $redirectTo
     */
    protected $redirectTo = '/student';
    /**
     * Instantiate a new StudentPasswordController instance
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:student');
    }
    /**
     *
     * @return \Illuminate\Http\Response
     */
    protected function guard()
    {
        return Auth::guard('student');
    }
    /**
     * @return \Illuminate\Http\Response
     */
    protected function broker()
    {
        return Password::broker('students');
    }
    public function showResetForm()
    {

    }
    public function reset()
    {

    }
}
