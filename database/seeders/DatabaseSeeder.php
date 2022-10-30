<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            LevelSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            PassportInstallSeeder::class,
        ]);

    }
}
