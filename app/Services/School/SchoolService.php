<?php

namespace App\Services\School\SchoolService;

use App\Schools;
use Illuminate\Http\Request;

class SchoolService
{
    // public function __construct($schools)
    // {
    //     $this->schools = $schools;
    // }

    public function getAllSchools()
    {
        $schools = Schools::all();
        return $schools;
    }
}

?>
