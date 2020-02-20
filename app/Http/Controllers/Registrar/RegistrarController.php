<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;

class RegistrarController extends Controller
{
    public function addStudent(Request $request)
    {
        Student::create($this->validateStudentDetails());
    }
    /**
     *@return void
     */
    protected function validateStudentDetails()
    {
        return request()->validate([
            'surname'=>'string|required',
            'firstName'=>'string|nullable',
            'middleName'=>'string|nullable',
            'lastName'=>'string|nullable',
            'regNumber'=>'required',
            'email'=>'email|required|unique:students',
            'idNumber'=>'nullable'
        ]);
    }

}
