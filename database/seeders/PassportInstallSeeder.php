<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Artisan;

class PassportInstallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('passport:install');
    }
}
