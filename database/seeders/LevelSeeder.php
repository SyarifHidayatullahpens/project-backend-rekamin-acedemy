<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    public function run()
    {
        $levels = [
            [
                'name' => 'Admin',
                'description' => '-',
            ],
            [
                'name'  => 'Writter',
                'description' => '-',
            ]
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
