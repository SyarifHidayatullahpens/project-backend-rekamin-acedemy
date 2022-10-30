<?php

namespace App\Imports;

use App\Models\{User,Teacher};
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeachersImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $user = User::updateOrCreate(
                [
                'username'  => $row['username'],
                'email'     => $row['email'],
                ],
                [
                'password'  => bcrypt($row['password']),
                'level_id'  => $row['level_id'],
                ]
            );

            $teacher = Teacher::updateOrCreate(
                [
                'nip'           => $row['nip'],
                ],
                [
                'name'          => $row['name'],
                'major_id'      => $row['major_id'],
                'user_id'       => $user->id,
                ]
            );
        }
    }
}
