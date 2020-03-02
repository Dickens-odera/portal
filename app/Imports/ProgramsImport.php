<?php

namespace App\Imports;

use App\Programs;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Validation\Rule;
class ProgramsImport implements ToModel, WithStartRow, WithValidation
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Programs([
            'name'=>$row[0],
            'description'=>$row[1],
            'school_id'=>$row[2]
        ]);
    }
    public function startRow(): int
    {
        return 2;
    }
    public function rules(): array
    {
        return [
            '0'=>Rule::unique('programs','name')
        ];
    }
public function customMessage()
{
    return [
        '0.unique'=>'Duplicate Entry'
    ];
}
}
