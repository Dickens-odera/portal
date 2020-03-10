<?php

namespace App\Http\Controllers\COD;

use App\Applications;
use App\CODs;
use App\Departments;
use App\Http\Controllers\Controller;
use App\Programs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
class CODController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:cod');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cod.dashboard');
    }
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function getAllApplications()
    {
        $cod = CODs::where('id','=',Auth::user()->id)->first();
        $school = $cod->school;
        //$school_name = $school->school_name;
        //dd($school_name);
        $department = $cod->department;
        $school_name = $department->school->school_name;
        $department_name = $department->name;
        //dd($department->program);
        $dep = Departments::where('dep_id','=',Auth::user()->department->dep_id)->first();
        $test_programs = DB::select('select name from programs where programs.dep_id = :id',['id'=>Auth::user()->department->dep_id]);
        $p = Programs::where('dep_id','=',Auth::user()->department->dep_id)->pluck('name');
        //dd($p);
        //dd($test_programs);
        //dd($dep->program);

        $applications = Applications::where('preffered_school','=',$school_name)
                                    ->whereIn('preffered_program',$p)
                                    ->latest()
                                    ->paginate(2);

        if(!$applications)
        {
            request()->session()->flash('error','No applications found');
            return redirect()->back();
        }
        else
        {
            return view('cod.applications.index', compact('applications'));
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
