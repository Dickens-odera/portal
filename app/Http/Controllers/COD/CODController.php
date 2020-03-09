<?php

namespace App\Http\Controllers\COD;

use App\Applications;
use App\CODs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $program = "";
        $cod = CODs::where('id','=',Auth::user()->id)->first();
        $school = $cod->school;
        $school_name = $school->school_name;
        //dd($school_name);
        $department = $cod->department;
        $department_name = $department->name;
        dd($department->programs);
        $applications = Applications::where('preffered_school','=',$school_name)
                                    //->where('preffered_program','LIKE','%'.$department->programs.'%')
                                    ->latest()
                                    ->paginate(5);

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
