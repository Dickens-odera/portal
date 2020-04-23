<?php  
namespace App\Services\Registrar;

use App\Applications;
use App\CODs;
use App\Comments;
use App\Deans;
use App\Departments;
use App\Programs;
use App\Schools;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegistrarService
{
    public function incomingApp(Request $request, $app_id = NULL)
    {
        $app_id = $request->app_id;
        if(!$app_id)
        {
            $request->session()->flash('error','Invalid request format');
            return redirect()->back();
        }
        else
        {
            $validator = Validator::make($request->all(), array('app_id'=>'required'));
            if($validator->fails())
            {
                $request->session()->flash('error',$validator->errors()->all());
                return redirect()->back();
            }
            else
            {
                try{
                    $application = Applications::where('app_id','=',$app_id)->first();
                    $programs = Programs::where('name','=',$application->preffered_program)->first();
                    $dean = Deans::where('school_id','=',$programs->school_id)->first();
                    $school = Schools::where('school_id','=',$dean->school_id)->first();
                    $cods = CODs::where('dep_id','=',$programs->dep_id)->first();
                    $department = Departments::where('dep_id','=',$cods->dep_id)->first();
                    $comments = Comments::where('user_id','=',$cods->id)
                                            ->where('app_id','=',$app_id)
                                            ->where('app_type','=','incoming')
                                            // ->orWhere('app_type','=','outgoing')
                                            ->where('user_type','=','cod')
                                            ->first();
                    $dean_comment = Comments::where('user_id','=',$dean->id)
                                                ->where('user_type','=','dean')
                                                ->where('app_id','=',$app_id)
                                                ->where('app_type','=','incoming')
                                                // ->orWhere('app_type','=','outgoing')
                                                ->first();
                    //dd($dean_comment);
                return view('registrar.applications.incoming-single-view', compact('application','school', 'comments','department','cods','dean_comment','dean'));
                }catch(Exception $exception)
                {
                    $request->session()->flash('error','Application not found');
                }
            }
        }
    }

    public function outgoingApp(Request $request, $app_id = NULL)
    {
        $app_id = $request->app_id;
        if(!$app_id)
        {
            $request->session()->flash('error','Invalid request format');
            return redirect()->back();
        }
        else
        {
            $validator = Validator::make($request->all(), array('app_id'=>'required'));
            if($validator->fails())
            {
                $request->session()->flash('error',$validator->errors()->all());
                return redirect()->back();
            }
            else
            {
                try{
                    $application = Applications::where('app_id','=',$app_id)->first();
                    $programs = Programs::where('name','=',$application->present_program)->first();
                    $dean = Deans::where('school_id','=',$programs->school_id)->first();
                    $school = Schools::where('school_id','=',$dean->school_id)->first();
                    $cods = CODs::where('dep_id','=',$programs->dep_id)->first();
                    $department = Departments::where('dep_id','=',$cods->dep_id)->first();
                    $comments = Comments::where('user_id','=',$cods->id)
                                            ->where('app_id','=',$app_id)
                                            ->where('app_type','=','outgoing')
                                            // ->orWhere('app_type','=','incoming')
                                            ->where('user_type','=','cod')
                                            ->first();
                    $dean_comment = Comments::where('user_id','=',$dean->id)
                                                ->where('user_type','=','dean')
                                                ->where('app_id','=',$app_id)
                                                ->where('app_type','=','outgoing')
                                                // ->orWhere('app_type','=','incoming')
                                                ->first();
                    //dd($dean_comment);
                return view('registrar.applications.outgoing-single-view', compact('application','school', 'comments','department','cods','dean_comment','dean'));
                }catch(Exception $exception)
                {
                    $request->session()->flash('error','Application not found');
                }
            }
        } 
    }
    public function incomingApps(Request $request)
    {
        try{
            $applications = DB::table('comments')
                                    ->join('applications','comments.app_id','=','applications.app_id')
                                    ->join('deans','comments.user_id','deans.id')
                                    ->select('comments.*','applications.*','deans.name as dean')
                                    ->where('comments.user_type','=','dean')
                                    ->where('comments.app_type','incoming')
                                    ->orderBy('comments.comment_id','desc')
                                    // ->where('comments.comment','LIKE','%'.'Approved'.'%')
                                    ->paginate(4);
    
            }catch(Exception $exception)
            {
                $request->session()->flash('error','No incoming applications forwarded yet');
                return redirect()->back();
            }
            if($applications)
            {
                return view('registrar.applications.incoming', compact('applications'));
            }
            else
            {
                $request->session()->flash('error','No incoming applications have been forwarded yet');
                return redirect()->back();
            }
        }

        public function outgoingApps(Request $request)
        {
            try{
                $applications = DB::table('comments')
                                        ->join('applications','comments.app_id','=','applications.app_id')
                                        ->join('deans','comments.user_id','deans.id')
                                        ->select('comments.*','applications.*','deans.name as dean')
                                        ->where('comments.user_type','=','dean')
                                        ->where('comments.app_type','outgoing')
                                        ->orderBy('comments.comment_id','desc')
                                        // ->where('comments.comment','LIKE','%'.'Approved'.'%')
                                        ->paginate(4);
        
                }catch(Exception $exception)
                {
                    $request->session()->flash('error','No incoming applications forwarded yet');
                    return redirect()->back();
                }
                if($applications)
                {
                    return view('registrar.applications.outgoing', compact('applications'));
                }
                else
                {
                    $request->session()->flash('error','No incoming applications have been forwarded yet');
                    return redirect()->back();
                }
        
        }

        public function allApps(Request $request)
        {
                    //get approved/ non-apprived applicationsfrom the comments section
        $applications = DB::table('comments')
                            ->join('applications','comments.app_id','=','applications.app_id')
                            ->join('deans','comments.user_id','deans.id')
                            ->select('comments.*','applications.*','deans.name as dean')
                            ->where('comments.user_type','=','dean')
                            ->orderBy('comments.comment_id','desc')
                            // ->where('comments.comment','LIKE','%'.'Approved'.'%')
                            ->paginate(4);

        //$applications = Applications::latest()->paginate(5);
        return view('registrar.applications.index',compact('applications'));
        }

        public function viewApp(Request $request, $application_id = NULL)
        {
                    $applications_id = $request->app_id;
                if(!$applications_id)
                {
                    $request->session()->flash('error','Invalid request format');
                    return redirect()->back();
                }
                else
                {
                    try{
                    //$application = Comments::where('app_id','=',$applications_id)->first();
                    $application = DB::table('comments')
                                    ->join('applications','comments.app_id','=','applications.app_id')
                                    ->select('comments.*','applications.*')
                                    ->where('comments.app_id','=',$applications_id)
                                    // ->where('comments.comment','LIKE','%'.'Approved'.'%')
                                    ->first();
                    }catch(Exception $exception)
                    {
                        $request->session()->flash('error','The specified application could not be found');
                        return redirect()->back();
                    }
                    if(!$application)
                    {
                        $request->session()->flash('error','Application not found');
                        return redirect()->back();
                    }
                    else
                    {
                        return view('registrar.applications.show', compact('application'));
                    }
                }
        }
}
?>