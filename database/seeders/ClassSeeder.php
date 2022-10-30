<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassSchool;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = [
            [
                'name' => 'XI RPL 1',
                'description' => '-',
                'major_id' => '1',
            ],
            [
                'name' => 'XI RPL 2',
                'description' => '-',
                'major_id' => '1',
            ],
            [
                'name' => 'XI TKJ 1',
                'description' => '-',
                'major_id' => '2',
            ],
            [
                'name' => 'XI TKJ 2',
                'description' => '-',
                'major_id' => '2',
            ],
            [
                'name' => 'XI MM 1',
                'description' => '-',
                'major_id' => '3',
            ],
            [
                'name' => 'XI MM 2',
                'description' => '-',
                'major_id' => '3',
            ],
            [
                'name' => 'XI OTKP 1',
                'description' => '-',
                'major_id' => '4',
            ],
            [
                'name' => 'XI OTKP 2',
                'description' => '-',
                'major_id' => '4',
            ],
            [
                'name' => 'XI OTKP 3',
                'description' => '-',
                'major_id' => '4',
            ],
            [
                'name' => 'XI OTKP 4',
                'description' => '-',
                'major_id' => '4',
            ],
            [
                'name' => 'XI AKL 1',
                'description' => '-',
                'major_id' => '5',
            ],
            [
                'name' => 'XI AKL 2',
                'description' => '-',
                'major_id' => '5',
            ],
        ];

        foreach ($classes as $class) {
            ClassSchool::create($class);
        }
    }
}
