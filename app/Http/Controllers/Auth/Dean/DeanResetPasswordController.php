<?php

namespace App\Http\Controllers\Auth\Dean;

use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DeanResetPasswordController extends Controller
{
    use ResetsPasswords;
    /**
     * The aunthentication guard
     * @var string $guard
     *  */
    protected $guard = 'dean';
    /**
     * Where to redirect the user upon  successfull password change
     * @var string $redirectTo
     */
    protected $redirectTo = '/dean/dashboard';
    /**
     * Instantiate a new StudentPasswordController instance
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:dean');
        //$this->token = $token;
    }
    /**
     *
     * @return \Illuminate\Http\Response
     */
    protected function guard()
    {
        return Auth::guard('dean');
    }
    /**
     * @return \Illuminate\Http\Response
     */
    protected function broker()
    {
        return Password::broker('deans');
    }
    public function showResetForm(Request $request, $token = null)
    {
        //dd($token);
        return view('auth.passwords.dean.reset')->with(['token'=>$token, 'email'=>$request->email]);
    }
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(),$this->rules());
        if($validator->fails())
        {
            $request->session()->flash('error',$validator->errors());
            return redirect()->back();
        }
         // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );
        // $response = Password::reset($this->credentials($request), function ($user, $password) {
        //     $user->password = Hash::make($password);

        //     $user->save();
        // });
        // if($response)
        // {
        //     $request->session()->flash('success','Password changed successfully');
        //     return redirect()->route('student.dashboard');
        // }
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);
    }
    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ];
    }
    /**
     * Get the password reset credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }
    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }
    /**
     * Set the user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function setUserPassword($user, $password)
    {
        $user->password = Hash::make($password);
    }
    /**
     * Get the response for a successful password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        return redirect($this->redirectPath())
                            ->with('status', trans($response));
    }
    /**
     * Get the response for a failed password reset.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans($response)]);
    }
}
