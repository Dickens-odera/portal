<?php

namespace App\Http\Controllers\Student\Applications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Applications;
class ApplicationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:student');
    }
    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //show the form to open the applications
        return view('student.applications.create');
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
        $data = request()->validate([
            'student_name'=>'required',
            'student_phone'=>'required',
            'reg_number'=>'required'
        ]);
        Applications::create($data);
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
    public function update(Applications $app_id)
    {
        $app_id->update($this->validate_request());
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
    protected function validate_request()
    {
        return request()->validate([
            'student_name'=>'required',
            'student_phone'=>'required',
            'reg_number'=>'required'
        ]);
    }
}
