<?php

namespace App\Http\Controllers\Dean;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Schools;
use App\Programs;
use App\Exports\ProgramsExport;
use App\Imports\ProgramsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:dean');
    }
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function index()
    {
        return view('dean.dashboard');
    }
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function showProgramsForm(Request $request)
    {
        return view('dean.programs.create');
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Facades\Response
     */
    public function addProgram(Request $request)
    {
        $validator = Validator::make($request->all(),$this->validate_data());
        if($validator->fails())
        {
            $request->session()->flash('error',$validator->errors());
            return redirect()->back()->withInput($request->all());
        }
        else
        {
            $program = new Programs;
            $program->name = $request->name;
            $program->description = $request->description;
            $program->school_id = Auth::user()->school_id;
            if($program->save())
            {
                $request->session()->flash('success','Program added successfully');
                return redirect(route('dean.programs'));
            }
            else
            {
                $request->session()->flash('error','Unable to add the specified program, try again later');
                return redirect()->back()->withInput($request->all());
            }
        }
    }
    /**
     *@return \Illuminate\Support\Collection
     */
    public function importPrograms()
    {
        if(Excel::import(new ProgramsImport, request()->file('excel_program_file')))
        {
            request()->session()->flash('success','Programs uploaded successfully via the excel file');
            return back();
        }
        else
        {
            request()->session()->flash('error','Failed to upload excel file, kindly check on the format');
            return redirect()->back();
        }
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function exportPrograms()
    {
        $school = Auth::user()->school;
        //dd($school);
        return Excel::download(new ProgramsExport, 'school-programs.xlsx');
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Facades\Response
     */
    public function viewAllPrograms(Request $request)
    {
        $programs = Programs::where('school_id','=',Auth::user()->school_id)->get();
        return view('dean.programs.index', compact('programs'));
    }
    /**
     * @return array
     */
    private function data()
    {
        return array('name'=>request()->name,'description'=>request()->description);
    }
    /**
     * @return array
     */
    private function validate_data()
    {
        return array('name'=>'required','description'=>'nullable');
    }
    /**
     * @return array
     */
    private function dean_id()
    {
        return  array('school_name'=>Auth::user()->school_id);

    }
}
