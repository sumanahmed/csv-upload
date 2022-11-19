<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportStudent implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if ($row['roll_no'] && $row['name'] && $row['father_name'] && $row['mother_name'] && $row['subject']) {

            return new Student([
                'roll_no'       => $row['roll_no'],
                'name'          => $row['name'],
                'father_name'   => $row['father_name'],
                'mother_name'   => $row['mother_name'],
                'subject'       => $row['subject'],
            ]);

        }
    }

    public function sheets(): array
    {
        return [
            0 => new ImportStudent(),
        ];
    }
}
