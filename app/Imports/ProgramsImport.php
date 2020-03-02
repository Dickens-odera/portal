<?php

namespace App\Imports;

use App\Programs;
use Maatwebsite\Excel\Concerns\ToModel;

class ProgramsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Programs([
            'name'=>$row[0],
            'description'=>$row[1]
        ]);
    }
}
