<?php

namespace App\Imports;

use App\Models\{User,Student,ClassSchool,Major};
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToCollection, WithHEadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $class = ClassSchool::where('id', $row['class_id'])->first();
            $major = Major::where('id', $class->major_id)->first();
            $user = User::updateOrCreate(
                [
                'username'  => $row['username'],
                'email'     => $row['email'],
                ],
                [
                'password'  => bcrypt($row['password']),
                'level_id'  => 5,
                ]
            );

            $student = Student::updateOrCreate(
                [
                'nis'           => $row['nis'],
                ],
                [
                'name'          => $row['name'],
                'class_id'      => $row['class_id'],
                'major_id'      => $major->id,
                'entry_year'    => $row['entry_year'],
                'user_id'       => $user->id,
                ]
            );
        }
    }

    public function startRow() : int
    {
        return 2;
    }
}
