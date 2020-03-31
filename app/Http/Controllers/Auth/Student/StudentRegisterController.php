<?php
namespace App\Http\Controllers\Auth\Student;

use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use App\Notifications\StudentAccountCreatedNotification;
use Illuminate\Support\Facades\Notification;
class StudentRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:student');
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
                //send mail to confirm email address in the near future
                if($this->sendNotificationToNewStudent($request,$request->reg_Number, $request->email, $request->password))
                {
                request()->session()->flash('success','Account created successfully, please check your email and verify your count before login');
                return redirect(route('student.account.verification.message'))->with(['message'=>'Kindly check your email address for a verification link']);
                }
                else
                {
                    $request->session()->flash('error','Something went wrong, please contact your system administrator');
                    return view('student.account.verification.message')->with(['error'=>'Something went wrong, we could not send you the verification link, kindly use a valid email address']);
                }
            }
            else
            {
                request()->session()->flash('error','Something went wrong, please try again');
                return redirect()->back()->withInput($request->only('email','reg_number'));
            }
        }
    }
    /**
     * show the page with message of successful message
     *
     */
    public function showVerificationPage()
    {
        return view('student.account.verification');
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
    /**
     *Send a mail notification to a the new student account with login credentials and login url
     * @param $name
     * @param $emai
     * @param $password
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Facades\Notification
     */
    protected function sendNotificationToNewStudent(Request $request,$name, $email, $password)
    {
        Notification::route('mail',$request->email)->notify(new StudentAccountCreatedNotification($name, $email, $password));
    }
    /**
     * @param $email
     * @param $token
     * @return Illiminate\Http\Response
     */
    private function sendMailToNewStudentAccount()
    {
        require '../../vendor/autoload.php';
        //require 'PHPMailerAutoload.php';
        $mail  = new PHPMailer(true);
        try
        {
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->isSMTP();
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->Charset = 'utf-8';
            $mail->SMTPAuth = true;
            $mail->Host = env('MAIL_HOST');
            $mail->Port = env('MAIL_PORT');
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->From = env('MAIL_FROM_ADDRESS');
            $mail->FromName = config('app.name');
            $mail->Subject = 'ACCOUNT VERIFICATION';
            $mail->MsgHTML("Dear"." ".request()->reg_number ." "
            ."User Thank you for registering with us".
            "<a href='{{ route('student.login') }}' here for login</a>");
            $mail->addAddress(request()->email, request()->reg_number);
            set_time_limit(60);
            if($mail->send())
            {
                request()->session()->flash('success','Verification Email sent to '.' '.request()->email.' '.'Kindly check your inbox');
                return redirect()->back();
            }
            else
            {
                request()->session()->flash('error','Failed to snd email, try again later');
                return redirect()->back();
            }
        }catch(Exception $e)
        {
            dd($e);
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>
