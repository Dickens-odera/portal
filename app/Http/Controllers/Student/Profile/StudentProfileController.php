<?php 

namespace App\Http\Controllers\Student\Profile;

use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:student');
    }
    /**
     * @return void
     */
    public function index()
    {

    }
    /**
     * @param Illuminate\Support\Facades\Request $request
     * @return void
     */
    public function update(Request $request, $id)
    {
        $id = $request->id;
        if(!$id)
        {
            request()->session()->flash('error','Invalid request format');
            return redirect()->back();
        }
        else
        {
            $validator = Validator::make($request->all(), $this->data());
            if($validator->fails())
            {
                request()->session()->flash('error', $validator->errors());
                return redirect()->back()->withInput($request->only('surname','middleName','lastName','email','regNumber','username','idNumber'));
            }
            else
            {
                if(Student::where('id','=',$id)->first()->update([
                        'surname'=>$request->surname,
                        'middleName'=>$request->middleName,
                        'lastName'=>$request->lastName,
                        'idNumber'=>$request->idNumber,
                        'email'=>$request->email,
                        'regNumber'=>$request->regNumber,
                        'username'=>$request->username
                    ]))
                    {
                        request()->session()->flash('success','Profile updated successfully');
                        return redirect()->back();
                    }
                    else
                    {
                        request()->session()->flash('error','Unable to update your profile, try again');
                        return redirect()->back()->withInput($request->all());
                    }
            }
        }
    }
    /**
     * @return array
     */
    private function data()
    {
        return array(
            [
                'surname'=>'nullable',
                'middleName'=>'nullable',
                'lastName'=>'nullable',
                'idNumber'=>'nullable',
                'email'=>'required',
                'regNumber'=>'required',
                'username'=>'nullable',
                'password'=>'required'
            ]
        );
    }
}
?>