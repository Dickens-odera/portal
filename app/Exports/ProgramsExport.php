<?php

namespace App\Exports;

use App\Programs;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProgramsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Programs::all();
    }
}
