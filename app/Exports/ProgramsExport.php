<?php

namespace App\Exports;

use App\Programs;
use Maatwebsite\Excel\Concerns\FromCollection;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
class ProgramsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    *Crreta a n
    */
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $programs = DB::table('programs')
                            ->join('schools','programs.school_id','=','schools.school_id')
                            ->join('departments','programs.dep_id','=','departments.dep_id')
                            ->select('programs.program_id as id','programs.name as name','programs.description as description',
                                    'schools.school_name as school','departments.name as department')
                            ->where('programs.dep_id','=',Auth::user()->dep_id)
                            ->get();
        return $programs;
    }
    public function headings(): array
    {
        return array('#','NAME','DESCRIPTION','SCHOOL','DEPARTMENT');
    }
    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event)
            {
                $cellRange = 'A1:W1'; //All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            }
        ];
    }
}
