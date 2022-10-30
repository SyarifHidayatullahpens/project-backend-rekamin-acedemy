<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    
    public function run()
    {
      DB::table('categories')->insert([
          [
              'name'    => 'Html',
              'user_id'     => 1,
          ],
          [
              'name'    => 'Sport',
              'status_id'   => 1,
          ]
       ]);
    }
}
