<?php

namespace App\Imports;

use App\Models\Company;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CompaniesImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Company::updateOrCreate(
                [
                'name' => $row['name'],
                ],
                [
                'address' => $row['address'],
                'phone' => $row['phone'],
                'supervisor' => $row['supervisor'],
                'quota' => $row['quota'],
                'time_in' => $row['time_in'],
                'time_out' => $row['time_out'],
                'latitude' => $row['latitude'],
                'longitude' => $row['longitude'],
                ]
            );
        }
    }
}
