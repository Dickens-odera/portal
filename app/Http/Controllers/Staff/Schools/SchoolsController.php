<?php

namespace App\Http\Controllers\Staff\Schools;

use App\Http\Controllers\Controller;
use App\Services\School\SchoolService;
use Illuminate\Http\Request;
use App\Schools;
use App\Services\School\SchoolService as SchoolServiceSchoolService;

class SchoolsController extends Controller
{
    // public function __construct(SchoolServiceSchoolService $schoolService)
    // {
    //     $this->schoolService = $schoolService;
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return $schoolService->getAllSchools();
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
        $data =  request()->validate([
            'school_name'=>'required'
        ]);
        Schools::create($data);
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
        Schools::first()->update($this->validate_school_data());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $school_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $school_id)
    {
        $school = Schools::where('school_id','=', $school_id);
        $school->delete();
    }
    /**
     * validation function
     * @return void
     */
    protected function validate_school_data()
    {
        return request()->validate([
            'school_name'=>'required'
        ]);
    }
}
